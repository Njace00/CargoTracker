<?php
include '../__back-end_processes/db_connect.php';
session_start();

// If not logged in OR not driver, redirect away
if (!isset($_SESSION['account_id']) || $_SESSION['role'] != 1) {
    header("Location: ../_user_interface/user_signup.php");
    exit();
}

$logged_in_username = null;
$logged_in_fullname = null;
if (isset($_SESSION['account_id'])) {
    $account_id = $_SESSION['account_id'];
    $query = "SELECT username, fullname FROM account WHERE account_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $account_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $logged_in_username = $row['username'];
        $logged_in_fullname = $row['fullname'];
    }
    $stmt->close();
}


$query = "SELECT vehicle_name FROM vehicles";
$result = mysqli_query($conn, $query);

$query = "SELECT * FROM trips WHERE driver = '$logged_in_fullname'";
$result_Job = mysqli_query($conn, $query);



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver - Assigned Jobs</title>
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
    
    <h1>Assigned Jobs</h1>
    <form action="#" method="POST">
    <div class="job-list-container">
        <?php while ($row = mysqli_fetch_assoc($result_Job)): ?>
        <div class="job-card-assignedjob">
            <p class="job-label-assignedjob">Trip ID</p>    
            <h1><?php echo htmlspecialchars($row['trip_id']); ?></h1>
            <p class="job-label-assignedjob">Driver</p>
            <h1><?php echo htmlspecialchars($row['driver']); ?></h1>
            <p class="job-label-assignedjob">Assigned_Vehicle</p>
            <h1><?php echo htmlspecialchars($row['vehicle']); ?></h1>
            <p class="job-label-assignedjob">Destination</p>
            <h1><?php echo htmlspecialchars($row['destination']); ?></h1>
            <p class="job-label-assignedjob">Date</p>
            <h1><?php echo htmlspecialchars($row['created_at']); ?></h1>
            <p class="job-label-assignedjob">Status</p>
            <h1><?php echo htmlspecialchars($row['status']); ?></h1>
        </div>
        <?php endwhile; ?>
        <button>Mark as In Progress</button>
    </div>
    </form>

</div>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var menuButton = document.getElementById("menu-toggle-btn");
            var closeButton = document.getElementById("sidebar-close-btn");
            var sidebar = document.getElementById("sidebar");
            menuButton.addEventListener("click", function() { sidebar.classList.add("open"); });
            closeButton.addEventListener("click", function() { sidebar.classList.remove("open"); });

            const currentPage = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('.nav-links a');

            navLinks.forEach(link => {
                const linkPage = link.getAttribute('href').split('/').pop();
                if (linkPage === currentPage) {
                    link.classList.add('active');
                }
            });
        });
    </script>

</body>
</html>