export async function load() {
    const modules = import.meta.glob("$lib/posts/*.json");
    const posts = [];

    for (const path in modules) {
        const slug = path.split("/").pop().replace(".json", "");
        const module = await modules[path]();
        posts.push({ slug, ...module });
    }

    return { posts };
}