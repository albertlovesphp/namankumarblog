<script>
  export let data;
</script>

<main>
  <h1>Blog Posts</h1>
  <ul>
    {#each data.posts as post}
      <li><a href={`/blog/${post.slug}`}>{post.title}</a></li>
    {/each}
  </ul>
</main>
