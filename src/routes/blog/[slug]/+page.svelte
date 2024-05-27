<script>
  export let data;
</script>

<main>

    <a href="/blog">&larr; back</a>

  <h1>
    {data.post.title}
  </h1>

  <article>
    {@html data.post.content}
  </article>
</main>
