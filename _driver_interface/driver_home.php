<?php
include '../__back-end_processes/db_connect.php';
session_start();

// If not logged in OR not driver, redirect away
if (!isset($_SESSION['account_id']) || $_SESSION['role'] != 1) {
    header("Location: ../_user_interface/user_signup.php");
    exit();
}

$logged_in_username = null;
if (isset($_SESSION['account_id'])) {
    $account_id = $_SESSION['account_id'];
    $query = "SELECT username FROM account WHERE account_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $account_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $logged_in_username = $row['username'];
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver - Dashboard</title>
    <link rel="icon" type="image/x-icon" href="../images/favicon.jpg">
    <link rel="stylesheet" href="../css/driver_style.css">
</head>

<body>

    <div class="mobile-header">
        <button id="menu-toggle-btn">
            <span class="menu-icon-line"></span>
            <span class="menu-icon-line"></span>
            <span class="menu-icon-line"></span>
        </button>
        <div class="mobile-header-title">Driver Panel</div>
    </div>

    <div class="sidebar" id="sidebar">
        <button id="sidebar-close-btn">&times;</button>
        <div class="sidebar-header">
            GNBTL
            <?php if ($logged_in_username): ?>
                <div class="username-display">
                    User: <?php echo htmlspecialchars($logged_in_username); ?>
                </div>
            <?php endif; ?>
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="../_driver_interface/driver_home.php">Dashboard</a></li>
                <li><a href="../_driver_interface/driver_Announcement.php">Announcement</a></li>
                <li><a href="../_driver_interface/driver_Delivery.php">Delivery</a></li>
                <li><a href="../_driver_interface/driver_Assigned_Job.php">Assigned Job</a></li>
            </ul>
        </nav>
        <div class="logout-container">
            <form action="../__back-end_processes/auth_logout.php" method="post">
                <button class="logout-btn">Log out</button>
            </form>
        </div>
    </div>

    <div class="main-content">

        <h1>Dashboard</h1>

        <div class="dashboard-columns">

            <div class="dashboard-card job-card-content">
                <h2>Current Assigned Job</h2>
                <p class="job-label">Tracking ID</p>
                <h3>No Job assigned yet...</h3>

                <p class="job-label">Destination</p>
                <h3>No Job assigned yet...</h3>

                <p class="job-label">Date</p>
                <h3>No Job assigned yet...</h3>
                <a href="driver_Assigned_Job.php">
                <button class="anchor_Job_page">Go to Job Page</button>
                </a>
            </div>

            <div class="dashboard-card">
                <h2>ANO PWEDE ILAGAY</h2>
                <ul class="stat-list">
                    <li><span>ANO PWEDE ILAGAY</span> <strong>ANO PWEDE ILAGAY</strong></li>
                    <li><span>ANO PWEDE ILAGAY</span> <strong>ANO PWEDE ILAGAY</strong></li>
                    <li><span>ANO PWEDE ILAGAY</span> <strong>ANO PWEDE ILAGAY</strong></li>
                    <li><span>ANO PWEDE ILAGAY</span> <strong>ANO PWEDE ILAGAY</strong></li>
                </ul>
            </div>

            <div class="dashboard-card">
                <h2>Latest Announcement</h2>
                <div class="notification red">
                    <h1>URGENT: System Maintenance</h1>
                    <p>The system will be down for 1 hour starting at 5:00 PM today for urgent updates.</p>
                </div>
            </div>

            <div class="dashboard-card">
                <h2>Quick Actions</h2>
                <button class="quick-btn">Report</button>
            </div>

        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var menuButton = document.getElementById("menu-toggle-btn");
            var closeButton = document.getElementById("sidebar-close-btn");
            var sidebar = document.getElementById("sidebar");
            menuButton.addEventListener("click", function() {
                sidebar.classList.add("open");
            });
            closeButton.addEventListener("click", function() {
                sidebar.classList.remove("open");
            });

            const currentPage = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('.nav-links a');

            navLinks.forEach(link => {
                const linkPage = link.getAttribute('href').split('/').pop();
                if (linkPage === currentPage || (currentPage === '' && linkPage === 'driver_home.html')) {
                    link.classList.add('active');
                }
            });
        });
    </script>

</body>

</html>