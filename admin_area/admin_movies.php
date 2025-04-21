<?php
include "../config.php";

// Вземаме всички филми с нужните JOIN-и
$query = "
    SELECT 
        m.movie_id,
        m.movie_title,
        m.movie_img,
        m.budget,
        d.director_name,
        STRING_AGG(g.genre_name, ', ') AS genres
    FROM Movie m
    LEFT JOIN Director d ON m.director_id = d.director_id
    LEFT JOIN MovieGenre mg ON m.movie_id = mg.movie_id
    LEFT JOIN Genre g ON mg.genre_id = g.genre_id
    GROUP BY m.movie_id, m.movie_title, m.movie_img, m.budget, d.director_name
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
    <link rel="shortcut icon" href="../images/soundVibe3.png" type="image/x-icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../css/admin_movie.css">
    <link rel="stylesheet" href="../css/admin_sidebar.css">

    <style>

        
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
                <a href="admin_dashboard.html" class="nav-link">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </div>
            <div class="nav-item">
                <a href="albums.html" class="nav-link active">
                    <i class="fa-solid fa-film"></i>
                    Movies
                </a>
            </div>
            <div class="nav-item">
                <a href="users.html" class="nav-link">
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
                <input type="text" class="form-control" placeholder="Search albums...">
                <i class="fas fa-search"></i>
            </div>
            <!-- <div class="bulk-actions">
                <select class="form-select bulk-select">
                    <option>Bulk Actions</option>
                    <option>Delete Selected</option>
                    <option>Update Stock</option>
                </select>
                <button class="btn btn-primary">Apply</button>
            </div> -->
            <button class="add-album-btn" data-bs-toggle="modal" data-bs-target="#addAlbumModal">
                <i class="fas fa-plus"></i>
                Add New Album
            </button>
        </div>

        <!-- Albums Table -->
        <div class="movies-table">
            <div class="table-responsive">
                <table class="table">
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
                                <button class="action-btn edit-btn" title="Edit" data-bs-toggle="modal" data-bs-target="#addAlbumModal">
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
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

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
                                <option value="Comedy">
                                <option value="Horror">
                                <option value="Drama">
                                <option value="Musical">
                                <option value="Action">
                            </datalist>
                            <div id="selectedGenres" class="mt-2"></div>
                            <input type="hidden" name="genres" id="genresField">
                        </div>

                        <!-- Actors (multiple) -->
                        <div class="col-md-6">
                            <label class="form-label" for="actorsInput">Actors</label>
                            <input list="actorsOptions" id="actorsInput" class="form-control">
                            <datalist id="actorsOptions">
                                <option value="Olivia Rodrigo">
                                <option value="Tate McRay">
                                <option value="Sabrina Carpenter">
                                <option value="Ariana Grande">
                            </datalist>
                            <div id="selectedActors" class="mt-2"></div>
                            <input type="hidden" name="actors" id="actorsField">
                        </div>

                        <!-- Roles (multiple) -->
                        <div class="col-md-6">
                            <label class="form-label" for="rolesInput">Roles</label>
                            <input list="rolesOptions" id="rolesInput" class="form-control">
                            <datalist id="rolesOptions">
                                <option value="Lead">
                                <option value="Supporting">
                                <option value="Villain">
                                <option value="Guest">
                            </datalist>
                            <div id="selectedRoles" class="mt-2"></div>
                            <input type="hidden" name="roles" id="rolesField">
                        </div>

                        <!-- Languages (multiple) -->
                        <div class="col-md-6">
                            <label class="form-label" for="languagesInput">Languages</label>
                            <input list="languagesOptions" id="languagesInput" class="form-control">
                            <datalist id="languagesOptions">
                                <option value="English">
                                <option value="Spanish">
                                <option value="French">
                                <option value="Bulgarian">
                            </datalist>
                            <div id="selectedLanguages" class="mt-2"></div>
                            <input type="hidden" name="languages" id="languagesField">
                        </div>

                        <!-- Directors (multiple) -->
                        <div class="col-md-6">
                            <label class="form-label" for="directorsInput">Directors</label>
                            <input list="directorsOptions" id="directorsInput" class="form-control">
                            <datalist id="directorsOptions">
                                <option value="Christopher Nolan">
                                <option value="Greta Gerwig">
                                <option value="Steven Spielberg">
                                <option value="Quentin Tarantino">
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
                            <label class="form-label" for="release_date">Release Date</label>
                            <input type="date" class="form-control" name="release_date" id="release" required>
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
</body>

</html>