<div class="section-header">
                <h2 class="section-title">Recent Orders</h2>
                <a href="#" class="view-all">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#ORD-001</td>
                            <td>John Doe</td>
                            <td>SOUR - Olivia Rodrigo</td>
                            <td>$19.99</td>
                            <td><span class="status-badge status-completed">Completed</span></td>
                            <td>2024-03-15</td>
                        </tr>
                        <tr>
                            <td>#ORD-002</td>
                            <td>Jane Smith</td>
                            <td>Midnights - Taylor Swift</td>
                            <td>$24.99</td>
                            <td><span class="status-badge status-pending">Pending</span></td>
                            <td>2024-03-14</td>
                        </tr>
                        <tr>
                            <td>#ORD-003</td>
                            <td>Mike Johnson</td>
                            <td>= (Equals) - Ed Sheeran</td>
                            <td>$18.99</td>
                            <td><span class="status-badge status-cancelled">Cancelled</span></td>
                            <td>2024-03-14</td>
                        </tr>
                    </tbody>
                </table>
            </div>

<!-- 
            .user-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
} -->
 
<!-- <ul class="nav-links">
    <?php if (isset($_SESSION['user_id'])): ?>
        <li class="user-info">
            <?php if (!empty($_SESSION['user_img'])): ?>
                <img src="<?php echo htmlspecialchars($_SESSION['user_img']); ?>" alt="Avatar" class="user-avatar">
            <?php else: ?>
                <img src="default-avatar.png" alt="Default Avatar" class="user-avatar">
            <?php endif; ?>
            <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
        </li>
        <li><a href="logout.php">Logout</a></li>
    <?php else: ?>
        <li><a href="user_area/login.php" class="active">Login</a></li>
    <?php endif; ?>
</ul> -->

  <!-- Custom Video Controls -->
                <!-- <div class="video-controls">
                    <div class="progress-container">
                        <div class="progress-bar">
                            <div class="progress"></div>
                        </div>
                        <div class="time-display">
                            <span class="current-time">0:00</span>
                            <span>/</span>
                            <span class="total-time">2:30:00</span>
                        </div>
                    </div>
                    <div class="controls-main">
                        <div class="controls-left">
                            <button class="play-pause">
                                <i class="fas fa-play"></i>
                            </button>
                            <button class="volume">
                                <i class="fas fa-volume-up"></i>
                            </button>
                            <input type="range" class="volume-slider" min="0" max="100" value="100">
                        </div>
                        <div class="controls-right">
                            <button class="quality">
                                <span>1080p</span>
                                <i class="fas fa-cog"></i>
                            </button>
                            <button class="fullscreen">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>
                </div> -->

                  <!-- <div class="next-up">
            <h3>Next Up</h3>
            <div class="next-episodes">
                <div class="episode-card">
                    <img src="https://via.placeholder.com/160x90" alt="Next Episode">
                    <div class="episode-info">
                        <h4>Next Movie Title</h4>
                        <p>Brief description of the next movie</p>
                    </div>
                </div>
            </div>
        </div> -->

                    <div class="watchlist-item">
                <div class="watchlist-item-poster">
                    <img src="./images/gundi.jpeg" alt="Movie Title">
                    <div class="watchlist-item-actions">
                        <button class="btn-watch"><i class="fas fa-play"></i></button>
                        <button class="btn-remove"><i class="fas fa-trash"></i></button>
                        <button class="btn-mark-watched"><i class="fas fa-check"></i></button>
                    </div>
                </div>
                <div class="watchlist-item-info">
                    <h3>Movie Title</h3>
                    <div class="movie-meta">
                        <span class="rating"><i class="fas fa-star"></i> 4.5</span>
                        <span class="year">2024</span>
                    </div>
                    <!-- <div class="progress-bar">
                        <div class="progress" style="width: 78%"></div>
                    </div>
                    <span class="progress-text">45 minutes left</span> -->
                </div>
            </div>

            <!-- More watchlist items (repeat structure) -->
            <!-- You can duplicate the watchlist-item div for more movies -->
        </div>