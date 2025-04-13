<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - MovieFlix</title>

    <!-- CSS links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/soundVibe3.png" type="image/x-icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../css/admin_dashboard.css">
    <link rel="stylesheet" href="../css/admin_sidebar.css">

    <style>

a.btn {
    background: linear-gradient(#e50914, #c62828);
    color: white;
    width: 8em;
    /* outline: #e50914 3px 0  solid; */
    border: #e50914 3px 0 solid;
    padding: 10px 7px;
    font-size: medium;
    font-weight: 400;
}

a.btn:hover{
    background: transparent;
    color: #e50914;
    border: 2px solid #c62828;
    
}

a.btn:focus{
    box-shadow: 0 0 0 0.2rem rgba(255, 82, 140, 0.15);

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
                <a href="admin_dashboard.html" class="nav-link active">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </div>
            <div class="nav-item">
                <a href="albums.html" class="nav-link">
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
            <h1 class="admin-title">Dashboard</h1>
            <div class="admin-actions">
                <a href="admin_notifications.html" class="btn btn-outline-secondary">
                    <i class="fas fa-bell"></i>
                </a>
                <button class="btn btn-outline-secondary">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stat-cards">
            <div class="stat-card">
                <!-- <div class="stat-icon" style="background: linear-gradient(45deg, #4CAF50, #8BC34A);"> -->
                <div class="stat-icon" style="background: linear-gradient(45deg, #e50914, #c62828);">
                    <i class="fa-solid fa-eye"></i>
                </div>
                <div class="stat-info">
                    <h3>2,150</h3>
                    <p>Total Watched</p>
                </div>
            </div>
            <div class="stat-card">
                <!-- <div class="stat-icon" style="background: linear-gradient(45deg, #2196F3, #03A9F4);"> -->
                <div class="stat-icon" style="background: linear-gradient(45deg, #e50914, #c62828);">

                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>1,840</h3>
                    <p>Total Users</p>
                </div>
            </div>
            <div class="stat-card">
                <!-- <div class="stat-icon" style="background: linear-gradient(45deg, #9C27B0, #E91E63);"> -->
                <div class="stat-icon" style="background: linear-gradient(45deg, #e50914, #c62828);">

                    <i class="fa-solid fa-film"></i>
                </div>
                <div class="stat-info">
                    <h3>450</h3>
                    <p>Total Movies</p>
                </div>
            </div>
            <div class="stat-card">
                <!-- <div class="stat-icon" style="background: linear-gradient(45deg, #FF9800, #F44336);"> -->
                <div class="stat-icon" style="background: linear-gradient(45deg, #e50914, #c62828);">

                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-info">
                    <h3>$32,580</h3>
                    <p>Total Revenue</p>
                </div>
            </div>
        </div>
        <!-- Operation buttons -->
        <div class="recent-section">
            <div class="section-header">
                <h2 class="section-title">Operation buttons</h2>
                <!-- <a href="#" class="view-all">View All</a> -->
            </div>
            <div class="d-flex justify-content-center align-item-center">
                <div class="mx-1">
                    <a href="admin_dashboard.php?add_genres" class="btn mx-1">Add Genres</a>
                </div>
                <div class="mx-1">
                    <a href="#" class="btn mx-1">Genres</a>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="recent-section">
            <?php 
                if(isset($_GET['add_genres'])){
                    include('add_genres.php');
                }
            ?>
        </div>
    </div>

    <script src="../script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>