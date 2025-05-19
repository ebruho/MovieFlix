 //ne e polzvano
 document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("searchInput");
  const resultsList = document.getElementById("results");

  if (!input) return;

  input.addEventListener("input", async () => {
    const query = input.value.trim();
    if (query.length === 0) {
      resultsList.innerHTML = "";
      return;
    }

    const res = await fetch(`search.php?q=${encodeURIComponent(query)}`);
    const data = await res.json();

    resultsList.innerHTML = "";
    data.forEach(movie => {
      const li = document.createElement("li");
      const a = document.createElement("a");
      a.href = `movie_details.php?id=${movie.movie_id}`;
      a.textContent = `${movie.movie_title} (${movie.movie_year})`;
      li.appendChild(a);
      resultsList.appendChild(li);
    });
  });
});
