#!/usr/bin/env php
<?php
use GuzzleHttp\Client;
use Nette\Utils\FileSystem;

/*
 *---------------------------------------------------------------
 * CHECK SERVER API
 *---------------------------------------------------------------
 */

// Refuse to run when called from php-cgi
if (strpos(PHP_SAPI, 'cgi') === 0) {
    exit("The cli tool is not supported when running php-cgi. It needs php-cli to function!\n\n");
}

/*
 *---------------------------------------------------------------
 * CHECK PHP VERSION
 *---------------------------------------------------------------
 */

$minPhpVersion = '8.1'; // If you update this, don't forget to update `public/index.php`.
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPhpVersion,
        PHP_VERSION
    );

    exit($message);
}

// We want errors to be shown when using it from the CLI.
error_reporting(E_ALL);
ini_set('display_errors', '1');

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', __DIR__ . DS);
define('APP_PATH', ROOT_PATH . 'src' . DS);
define('POST_PATH', APP_PATH . 'lib/posts' . DS);

require_once ROOT_PATH . 'vendor/autoload.php';

$config = parse_ini_file(__DIR__ . '/config.ini', true);

$client = new Client();

$backendUrl = $config['backend']['url'];
$endpoint = "https://public-api.wordpress.com/rest/v1.1/sites/$backendUrl/posts/";

$posts = $client->get($endpoint);
$posts = json_decode($posts->getBody()->getContents(), true);

$posts = $posts['posts'];

foreach ($posts as $post) {
    FileSystem::write(
        POST_PATH . $post['slug'] . '.json',
        str_replace(json_encode('https://pmv.test'),'',json_encode($post))
    );
}
