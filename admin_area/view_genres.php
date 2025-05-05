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
