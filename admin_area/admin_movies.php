<?php
include "../config.php";

// Вземаме всички филми с нужните JOIN-и

$query = "
    SELECT 
        m.movie_id,
        m.movie_title,
        m.movie_img,
        m.budget,
        m.movie_link,
        m.keywords,
        m.duration,
        m.release_year,
        m.movie_description,
        d.director_name,
        ml.language_name,
        STRING_AGG(DISTINCT g.genre_name, ', ') AS genres,
        STRING_AGG(DISTINCT a.actor_name, ', ') AS actors,
        STRING_AGG(DISTINCT mc.character_name, ', ') AS characters
    FROM Movie m
    LEFT JOIN Director d ON m.director_id = d.director_id
    LEFT JOIN MovieGenre mg ON m.movie_id = mg.movie_id
    LEFT JOIN Genre g ON mg.genre_id = g.genre_id
    LEFT JOIN MovieCharacter mc ON m.movie_id = mc.movie_id
    LEFT JOIN Actor a ON mc.actor_id = a.actor_id
    LEFT JOIN MovieLanguage ml ON m.language_id = ml.language_id
    GROUP BY 
        m.movie_id, m.movie_title, m.movie_img, m.budget, 
        m.movie_link, m.keywords, m.duration, m.release_year, m.movie_description,
        d.director_name, ml.language_name
    ORDER BY m.movie_id DESC
";


$stmt = $pdo->query($query);
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Movies - MovieFlix</title>

    <!-- CSS links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../css/admin_movie.css">
    <link rel="stylesheet" href="../css/admin_sidebar.css">

    <style>

/* .dataTables_filter,
.dataTables_paginate {
    display: none !important;
} */

.dataTables_wrapper .dataTables_paginate {
     display: flex;
     justify-content: center;
 }
 

    </style>
</head>

<body class="dark-mode">
    <!-- Sidebar -->
    <div class="admin-sidebar">
        <div class="sidebar-header">
            <!-- <img src="../images/soundVibe3.png" alt="SoundVibe Logo" class="sidebar-logo"> -->
            <button class="theme-toggle sidebar-logo">
                <i class="fas fa-moon"></i>
            </button>
            <h4>MovieFlix Admin</h4>
        </div>

        <nav class="nav-menu">
            <div class="nav-item">
                <a href="admin_dashboard.php" class="nav-link">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </div>
            <div class="nav-item">
                <a href="admmin_movies.php" class="nav-link active">
                    <i class="fa-solid fa-film"></i>
                    Movies
                </a>
            </div>
            <div class="nav-item">
                <a href="admin_users.html" class="nav-link">
                    <i class="fas fa-users"></i>
                    Users
                </a>
            </div>
            <div class="nav-item">
                <a href="reports.html" class="nav-link">
                    <i class="fas fa-chart-bar"></i>
                    Reports
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-envelope"></i>
                    Send Email
                </a>
            </div>
            <!-- <div class="nav-item">
                <a href="#" class="nav-link text-danger">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </div> -->
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="admin-header">
            <h1 class="admin-title">Movie Management</h1>
            <div class="admin-actions">
                <a href="admin_notifications.html" class="btn btn-outline-secondary">
                    <i class="fas fa-bell"></i>
                </a>
                <button class="btn btn-outline-secondary">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="action-bar">
            <div class="search-box">
                <input type="text" class="form-control" id="customSearch" placeholder="Search movies...">
                <i class="fas fa-search"></i>
            </div>


            <button class="add-album-btn" data-bs-toggle="modal" data-bs-target="#addAlbumModal">
                <i class="fas fa-plus"></i>
                Add New Movie
            </button>
        </div>

        <!-- Movies Table -->
        <div class="movies-table">
            <div class="table-responsive">
                <table class="table" id="moviesTable">
                    <thead>
                        <tr>
                            <!-- <th>
                                <input type="checkbox" class="form-check-input">
                            </th> -->
                            <th>Movie ID</th>
                            <th>Movie Title</th>
                            <th>Movie Image</th>
                            <th>Budget</th>
                            <th>Genres</th>
                            <th>Director</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($movies as $movie): ?>
                    <tr>
                        <td>#<?= htmlspecialchars($movie['movie_id']) ?></td>
                        <td><?= htmlspecialchars($movie['movie_title']) ?></td>
                        <td>
                            <img src="./uploads/<?= htmlspecialchars($movie['movie_img']) ?>" alt="Movie Cover" width="60">
                        </td>
                        <td>$<?= number_format($movie['budget'], 2) ?></td>
                        <td><?= htmlspecialchars($movie['genres']) ?></td>
                        <td><?= htmlspecialchars($movie['director_name']) ?></td>
                        <td>
                        <div class="action-btns">
                        <button class="action-btn edit-btn" 
    title="Edit" 
    data-bs-toggle="modal" 
    data-bs-target="#editMovieModal"
    data-id="<?= $movie['movie_id']; ?>"
    data-title="<?= htmlspecialchars($movie['movie_title']); ?>"
    data-budget="<?= $movie['budget']; ?>"
    data-link="<?= isset($movie['movie_link']) ? htmlspecialchars($movie['movie_link']) : ''; ?>"
    data-keywords="<?= isset($movie['keywords']) ? htmlspecialchars($movie['keywords']) : ''; ?>"
    data-duration="<?= isset($movie['duration']) ? htmlspecialchars($movie['duration']) : ''; ?>"
    data-release="<?= isset($movie['release_year']) ? htmlspecialchars($movie['release_year']) : ''; ?>"
    data-description="<?= isset($movie['movie_description']) ? htmlspecialchars($movie['movie_description']) : ''; ?>"
    data-actors="<?= isset($movie['actors']) ? htmlspecialchars($movie['actors']) : ''; ?>"
    data-genres="<?= isset($movie['genres'])? htmlspecialchars($movie['genres']): ''; ?>"
    data-characters="<?= isset($movie['characters'])? htmlspecialchars($movie['characters']): ''; ?>"
data-languages="<?= isset($movie['language_name']) ? htmlspecialchars($movie['language_name']) : ''; ?>"
data-directors="<?= isset($movie['director_name']) ? htmlspecialchars($movie['director_name']) : ''; ?>"
data-cover="<?= isset($movie['movie_img']) ? htmlspecialchars($movie['movie_img']) : ''; ?>"


>
    <i class="fas fa-edit"></i>
</button>

    
    <button class="action-btn delete-btn" title="Delete">
        <i class="fas fa-trash"></i>
    </button>
</div>

                        </td>
                    </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
    
        </div>
    </div>

    <?php 
         $char_query = "
                    SELECT 
                      DISTINCT character_name
                    FROM moviecharacter
                    ORDER BY character_name
                    ";
        $stmt = $pdo->query($char_query);
        $char_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $actor_stmt = $pdo->query("SELECT actor_name FROM actor ORDER BY actor_name");
        $actors = $actor_stmt->fetchAll(PDO::FETCH_ASSOC);

        $genre_stmt = $pdo->query("SELECT genre_name FROM genre ORDER BY genre_name");
        $genres = $genre_stmt->fetchAll(PDO::FETCH_ASSOC);

        $language_stmt = $pdo->query("SELECT language_name FROM movielanguage ORDER BY language_name");
        $languages = $language_stmt->fetchAll(PDO::FETCH_ASSOC);

        $director_stmt = $pdo->query("SELECT director_name FROM director ORDER BY director_name");
        $directors = $director_stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <!-- Add/Edit Movie Modal -->
<div class="modal fade" id="addAlbumModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Movie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="movieForm" method="POST" action="add_movie.php" enctype="multipart/form-data">
                    <div class="row g-3">

                        <!-- Title -->
                        <div class="col-md-6">
                            <label class="form-label" for="title">Movie Title</label>
                            <input type="text" class="form-control" name="title" id="title" required>
                        </div>

                        <!-- Genres (multiple) -->
                        <div class="col-md-6">
                            <label class="form-label" for="genresInput">Genres</label>
                            <input list="genresOptions" id="genresInput" class="form-control">
                            <datalist id="genresOptions">
                                <?php foreach($genres as $genre): ?>
                                    <option value="<?= htmlspecialchars($genre['genre_name']) ?>">
                                <?php endforeach; ?>
                                <!-- <option value="Comedy">
                                <option value="Horror">
                                <option value="Drama">
                                <option value="Musical">
                                <option value="Action"> -->
                            </datalist>
                            <div id="selectedGenres" class="mt-2"></div>
                            <input type="hidden" name="genres" id="genresField">
                        </div>

                        <!-- Actors (multiple) -->
                        <div class="col-md-6">
                            <label class="form-label" for="actorsInput">Actors</label>
                            <input list="actorsOptions" id="actorsInput" class="form-control">
                            <datalist id="actorsOptions">
                                <?php foreach($actors as $actor): ?>
                                <option value="<?= htmlspecialchars($actor['actor_name']) ?>">
                                <?php endforeach; ?>
                                <!-- <option value="Olivia Rodrigo">
                                <option value="Tate McRay">
                                <option value="Sabrina Carpenter">
                                <option value="Ariana Grande"> -->
                            </datalist>
                            <div id="selectedActors" class="mt-2"></div>
                            <input type="hidden" name="actors" id="actorsField">
                        </div>

                        <!-- Roles (multiple) -->
                        <div class="col-md-6">
                            <label class="form-label" for="rolesInput">Roles</label>
                            <input list="rolesOptions" id="rolesInput" class="form-control">
                            <datalist id="rolesOptions">
                                <?php foreach($char_rows as $row): ?>
                                    <option value="<?= htmlspecialchars($row['character_name']) ?>">
                                <?php endforeach; ?>
                                <!-- <option value="Lead">
                                <option value="Supporting">
                                <option value="Villain">
                                <option value="Guest"> -->
                            </datalist>
                            <div id="selectedRoles" class="mt-2"></div>
                            <input type="hidden" name="roles" id="rolesField">
                        </div>

                        <!-- Languages (multiple) -->
                        <div class="col-md-6">
                            <label class="form-label" for="languagesInput">Languages</label>
                            <input list="languagesOptions" id="languagesInput" class="form-control">
                            <datalist id="languagesOptions">
                                <?php foreach($languages as $language): ?>
                                    <option value="<?= htmlspecialchars($language['language_name']);?>">
                                <?php endforeach; ?>

                                <!-- <option value="English">
                                <option value="Spanish">
                                <option value="French">
                                <option value="Bulgarian"> -->
                            </datalist>
                            <div id="selectedLanguages" class="mt-2"></div>
                            <input type="hidden" name="languages" id="languagesField">
                        </div>

                        <!-- Directors (multiple) -->
                        <div class="col-md-6">
                            <label class="form-label" for="directorsInput">Directors</label>
                            <input list="directorsOptions" id="directorsInput" class="form-control">
                            <datalist id="directorsOptions">
                                <?php foreach($directors as $director){ ?>
                                    <option value="<?= htmlspecialchars($director['director_name']);?>">
                                <?php } ?>
                                <!-- <option value="Christopher Nolan">
                                <option value="Greta Gerwig">
                                <option value="Steven Spielberg">
                                <option value="Quentin Tarantino"> -->
                            </datalist>
                            <div id="selectedDirectors" class="mt-2"></div>
                            <input type="hidden" name="directors" id="directorsField">
                        </div>

                        <!-- Other fields -->
                        <div class="col-md-6">
                            <label class="form-label" for="link">Link</label>
                            <input type="text" class="form-control" name="link" id="link" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="keywords">Keywords</label>
                            <input type="text" class="form-control" name="keywords" id="keywords" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="duration">Duration (minutes)</label>
                            <input type="number" class="form-control" name="duration" id="duration" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="budget">Budget</label>
                            <input type="number" class="form-control" name="budget" id="budget" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="release_date">Release Year</label>
                            <input type="number" class="form-control" name="release_date" id="release" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="cover">Movie Cover</label>
                            <input type="file" class="form-control" name="cover" id="cover" accept="images/*" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label" for="description">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn secondary-btn" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn primary-btn" >Save Movie</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>




<div class="modal fade" id="editMovieModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Movie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="movieForm" method="POST" action="edit_movie.php" enctype="multipart/form-data">
                    <input type="hidden" name="edit_movie_id" id="edit_movie_id">

                    <div class="row g-3"> 

                        <!-- Title -->
                        <div class="col-md-6">
                            <label class="form-label" for="edit_title">Movie Title</label>
                            <input type="text" class="form-control" name="edit_title" id="edit_title" required>
                        </div>

                        <!-- Genres (multiple) -->
                        <div class="col-md-6">
                            <label class="form-label" for="editGenresInput">Genres</label>
                            <input list="editGenresOptions" id="editGenresInput" class="form-control">
                            <datalist id="editGenresOptions">
                                <?php foreach($genres as $genre): ?>
                                    <option value="<?= htmlspecialchars($genre['genre_name']) ?>">
                                <?php endforeach; ?>
                                
                            </datalist>
                            <div id="editSelectedGenres" class="mt-2"></div>
                            <input type="hidden" name="edit_genres" id="editGenresField">
                        </div>

                        <!-- Actors (multiple) -->
                        <div class="col-md-6">
                            <label class="form-label" for="editActorsInput">Actors</label>
                            <input list="actorsOptions" id="editActorsInput" class="form-control">
                            <datalist id="actorsOptions">
                                <?php foreach($actors as $actor): ?>
                                <option value="<?= htmlspecialchars($actor['actor_name']) ?>">
                                <?php endforeach; ?>
                                
                            </datalist>
                            <div id="editSelectedActors" class="mt-2"></div>
                            <input type="hidden" name="edit_actors" id="editActorsField">
                        </div>

                        <!-- Roles (multiple) -->
                        <div class="col-md-6">
                            <label class="form-label" for="editRolesInput">Roles</label>
                            <input list="editRolesOptions" id="editRolesInput" class="form-control">
                            <datalist id="editRolesOptions">
                                <?php foreach($char_rows as $row): ?>
                                <option value="<?= htmlspecialchars($row['character_name']) ?>">
                                <?php endforeach; ?>
                                
                            </datalist>
                            <div id="editSelectedRoles" class="mt-2"></div>
                            <input type="hidden" name="edit_roles" id="editRolesField">
                        </div>

                        <!-- Languages (multiple) -->
                        <div class="col-md-6">
                            <label class="form-label" for="editLanguagesInput">Languages</label>
                            <input list="editLanguagesOptions" id="editLanguagesInput" class="form-control">
                            <datalist id="editLanguagesOptions">
                            <?php foreach($languages as $language): ?>
                                    <option value="<?= htmlspecialchars($language['language_name']);?>">
                            <?php endforeach; ?>
                          
                            </datalist>
                            <div id="editSelectedLanguages" class="mt-2"></div>
                            <input type="hidden" name="edit_languages" id="editLanguagesField">
                        </div>

                        <!-- Directors (multiple) -->
                        <div class="col-md-6">
                            <label class="form-label" for="editDirectorsInput">Directors</label>
                            <input list="editDirectorsOptions" id="editDirectorsInput" class="form-control">
                            <datalist id="editDirectorsOptions">
                            <?php foreach($directors as $director){ ?>
                                    <option value="<?= htmlspecialchars($director['director_name']);?>">
                            <?php } ?>
                                
                            </datalist>
                            <div id="editSelectedDirectors" class="mt-2"></div>
                            <input type="hidden" name="edit_directors" id="editDirectorsField">
                        </div>

                        <!-- Other fields -->
                        <div class="col-md-6">
                            <label class="form-label" for="edit_link">Link</label>
                            <input type="text" class="form-control" name="edit_link" id="edit_link" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="edit_keywords">Keywords</label>
                            <input type="text" class="form-control" name="edit_keywords" id="edit_keywords" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="edit_duration">Duration (minutes)</label>
                            <input type="number" class="form-control" name="edit_duration" id="edit_duration" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="edit_budget">Budget</label>
                            <input type="number" class="form-control" name="edit_budget" id="edit_budget" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="edit_release">Release Year</label>
                            <input type="number" class="form-control" name="edit_release_date" id="edit_release" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="edit_cover">Movie Cover</label>
                            <input type="file" class="form-control mb-2" name="edit_cover" id="edit_cover" accept="image/*"  required>
                            <img id="currentCoverPreview" src="" alt="Current Cover" style="max-width: 100%; height: auto; display: none; border: 1px solid #ccc; margin-top: 5px;">
                        </div>


                        <div class="col-12">
                            <label class="form-label" for="edit_description">Description</label>
                            <textarea class="form-control" name="edit_description" id="edit_description" rows="3"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn secondary-btn" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn primary-btn" >Save Movie</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>


<!-- JS -->
<script>
    function setupMultiInput(inputId, displayId, hiddenFieldId) {
        const input = document.getElementById(inputId);
        const display = document.getElementById(displayId);
        const hiddenField = document.getElementById(hiddenFieldId);

        let selectedItems = [];

        function updateDisplay() {
            display.innerHTML = "";
            selectedItems.forEach(item => {
                const span = document.createElement("span");
                span.textContent = item;
                span.classList.add("badge", "bg-secondary", "me-1");

                const btn = document.createElement("button");
                btn.textContent = "x";
                btn.type = "button";
                btn.classList.add("btn", "btn-sm", "btn-danger", "ms-1");
                btn.onclick = () => {
                    selectedItems = selectedItems.filter(i => i !== item);
                    updateDisplay();
                };

                span.appendChild(btn);
                display.appendChild(span);
            });

            hiddenField.value = selectedItems.join(",");
        }

        input.addEventListener("change", () => {
            const value = input.value.trim();
            if (value && !selectedItems.includes(value)) {
                selectedItems.push(value);
                updateDisplay();
            }
            input.value = "";
        });

        input.addEventListener("keydown", (event) => {
            if (event.key === "Enter") {
                event.preventDefault();
                const value = input.value.trim();
                if (value && !selectedItems.includes(value)) {
                    selectedItems.push(value);
                    updateDisplay();
                    input.value = "";
                }
            }
        });
    }

    // Apply the function for each dynamic field
    setupMultiInput("genresInput", "selectedGenres", "genresField");
    setupMultiInput("actorsInput", "selectedActors", "actorsField");
    setupMultiInput("rolesInput", "selectedRoles", "rolesField");
    setupMultiInput("languagesInput", "selectedLanguages", "languagesField");
    setupMultiInput("directorsInput", "selectedDirectors", "directorsField");


</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="../script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (необходим за DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>



$(document).ready(function () {
    const table = $('#moviesTable').DataTable({
        "pageLength": 5,
        "order": [[0, "desc"]],
        paging: true,
        // language: {
        //     url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/bg-BG.json"
        // }
        "dom": '<"top"i>rt<"bottom"p><"clear">', // махаме вградената търсачка ('f') и ни оставя само таблицата (t) и пагинацията (p)
        "pagingType": "simple", // само стрелки наляво и надясно, ако предпочиташ номера — използвай "simple_numbers"
        pagingType: "simple_numbers", // за да имаме номера и стрелки
        language: {
            paginate: {
                previous: '<i class="fas fa-chevron-left"></i>',
                next:     '<i class="fas fa-chevron-right"></i>'
            }
        }
    });

    // Свържи търсачка
    $('#customSearch').on('keyup', function () {
        table.search(this.value).draw();
    });
});

</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit-btn');

    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            const modal = document.getElementById('editMovieModal');

            // Попълваме стандартните полета
            modal.querySelector('#edit_title').value = button.getAttribute('data-title') || '';
            modal.querySelector('#edit_budget').value = button.getAttribute('data-budget') || '';
            modal.querySelector('#edit_link').value = button.getAttribute('data-link') || '';
            modal.querySelector('#edit_keywords').value = button.getAttribute('data-keywords') || '';
            modal.querySelector('#edit_duration').value = button.getAttribute('data-duration') || '';
            modal.querySelector('#edit_release').value = button.getAttribute('data-release') || '';
            modal.querySelector('#edit_description').value = button.getAttribute('data-description') || '';
            //modal.querySelector('#edit_cover').value = button.getAttribute('data-cover') || '';

// Показване на текущото изображение (афиш)
const coverUrl = button.getAttribute('data-cover');
const coverPreview = modal.querySelector('#currentCoverPreview');

if (coverUrl) {
    coverPreview.src = coverUrl;
    coverPreview.style.display = 'block';
} else {
    coverPreview.style.display = 'none';
}



            // movie_id скрито поле
            modal.querySelector('#edit_movie_id').value = button.getAttribute('data-id');

            // Функция за попълване на badge-ове с X
            function populateBadges(containerSelector, hiddenFieldSelector, dataString) {
                const container = modal.querySelector(containerSelector);
                const hiddenField = modal.querySelector(hiddenFieldSelector);

                container.innerHTML = ''; // Изчиства само при първоначално отваряне!

                if (dataString) {
                    const items = dataString.split(',').map(item => item.trim());
                    hiddenField.value = items.join(',');

                    items.forEach(item => {
                        addBadge(container, hiddenField, item);
                    });
                } else {
                    hiddenField.value = '';
                }
            }

            // Функция за създаване на единичен badge
            function addBadge(container, hiddenField, itemText) {
                if (!itemText) return; // За да не добавяме празно

                const badge = document.createElement('span');
                badge.className = 'badge bg-secondary me-1 mb-1';
                badge.style.cursor = 'pointer';
                badge.innerHTML = `${itemText} <span class="ms-1" style="color:red; font-weight:bold;">&times;</span>`;

                // Клик за изтриване
                badge.querySelector('span').addEventListener('click', function (e) {
                    e.stopPropagation();
                    badge.remove();

                    // Обновяване на скритото поле
                    const remainingBadges = [...container.querySelectorAll('.badge')].map(b => 
                        b.childNodes[0].nodeValue.trim()
                    );
                    hiddenField.value = remainingBadges.join(',');
                });

                container.appendChild(badge);

                // Обновяваме скритото поле (добавяме новото)
                const allBadges = [...container.querySelectorAll('.badge')].map(b => 
                    b.childNodes[0].nodeValue.trim()
                );
                hiddenField.value = allBadges.join(',');
            }

            // Попълване на началните данни
            populateBadges('#editSelectedGenres', '#editGenresField', button.getAttribute('data-genres'));
            populateBadges('#editSelectedActors', '#editActorsField', button.getAttribute('data-actors'));
            populateBadges('#editSelectedRoles', '#editRolesField', button.getAttribute('data-characters'));
            populateBadges('#editSelectedLanguages', '#editLanguagesField', button.getAttribute('data-languages'));
            populateBadges('#editSelectedDirectors', '#editDirectorsField', button.getAttribute('data-directors'));

            // ДОБАВЯНЕ НА НОВИ ОТ INPUT ПОЛЕТАТА
            function setupInputAdd(inputSelector, containerSelector, hiddenFieldSelector) {
                const input = modal.querySelector(inputSelector);
                const container = modal.querySelector(containerSelector);
                const hiddenField = modal.querySelector(hiddenFieldSelector);

                input.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const newItem = input.value.trim();
                        if (newItem !== '') {
                            addBadge(container, hiddenField, newItem);
                            input.value = '';
                        }
                    }
                });
            }

            // За всички полета (жанрове, актьори и т.н.)
            setupInputAdd('#editGenresInput', '#editSelectedGenres', '#editGenresField');
            setupInputAdd('#editActorsInput', '#editSelectedActors', '#editActorsField');
            setupInputAdd('#editRolesInput', '#editSelectedRoles', '#editRolesField');
            setupInputAdd('#editLanguagesInput', '#editSelectedLanguages', '#editLanguagesField');
            setupInputAdd('#editDirectorsInput', '#editSelectedDirectors', '#editDirectorsField');
        });
    });
});




</script>

</body>

</html>