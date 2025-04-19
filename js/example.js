
const artistInput = document.getElementById("artistInput");
const selectedArtistsDiv = document.getElementById("selectedArtists");
const artistsField = document.getElementById("artistsField");

let selectedArtists = [];

// Добавяне на артист при избор
artistInput.addEventListener("change", function () {
    const artist = artistInput.value.trim();
    if (artist && !selectedArtists.includes(artist)) {
        selectedArtists.push(artist); // Добавяне на артиста към списъка
        updateArtistsDisplay(); // Актуализация на интерфейса
    }
    artistInput.value = ""; // Изчистване на полето за нов избор
});

artistInput.addEventListener("keydown", function () {
    if (event.key === "Enter") {
        event.preventDefault(); // Предотвратяване на поведението по подразбиране (например submit на форма)
        const artist = artistInput.value.trim();
        if (artist && !selectedArtists.includes(artist)) {
            selectedArtists.push(artist); // Добавяне на артиста към списъка
            updateArtistsDisplay(); // Актуализация на интерфейса
            artistInput.value = ""; // Изчистване на полето за нов избор
        }
    }

});

// Актуализация на интерфейса и скритото поле
function updateArtistsDisplay() {
    selectedArtistsDiv.innerHTML = ""; // Изчистване на контейнера
    selectedArtists.forEach(artist => {
        let span = document.createElement("span");
        span.textContent = artist;
        span.classList.add("artist-tag");

        // Бутон за премахване на артиста
        let removeBtn = document.createElement("button");
        removeBtn.textContent = "x";
        removeBtn.onclick = function () {
            selectedArtists = selectedArtists.filter(a => a !== artist); // Премахване на артиста
            updateArtistsDisplay(); // Актуализация на интерфейса
        };

        span.appendChild(removeBtn);
        selectedArtistsDiv.appendChild(span);
    });

    // Записване на артистите в скритото поле (като CSV)
    artistsField.value = selectedArtists.join(",");
}
