export async function load({ params }) {
    const post = await import(`../../../lib/posts/${params.slug}.json`);
    return {post};
}