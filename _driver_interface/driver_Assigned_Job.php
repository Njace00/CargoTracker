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
    <style>
        /* --- 1. Basic Setup (from Admin) --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f4f7fa; }

        /* --- 2. Mobile Header (from Admin) --- */
        .mobile-header { display: flex; align-items: center; padding: 15px 20px; background-color: #1f2c3d; color: white; position: sticky; top: 0; z-index: 500; }
        #menu-toggle-btn { background-color: transparent; border: none; cursor: pointer; padding: 10px; }
        .menu-icon-line { display: block; width: 22px; height: 2px; background-color: white; margin: 5px 0; }
        .mobile-header-title { font-size: 20px; font-weight: bold; margin-left: 15px; }

        /* --- 3. Sidebar (from Admin) --- */
        .sidebar { width: 260px; height: 100vh; position: fixed; top: 0; left: 0; transform: translateX(-100%); background-color: #1f2c3d; color: white; z-index: 1000; display: flex; flex-direction: column; transition: transform 0.3s ease-in-out; }
        .sidebar.open { transform: translateX(0%); }
        #sidebar-close-btn { position: absolute; top: 15px; right: 15px; background-color: transparent; border: none; color: white; font-size: 24px; font-weight: bold; cursor: pointer; }
        .sidebar-header { padding: 24px 30px; font-size: 28px; font-weight: bold; }
        .nav-links { list-style: none; padding: 0 15px; margin: 0; flex-grow: 1; }
        .nav-links li { margin-bottom: 8px; }
        .nav-links a { display: block; text-decoration: none; color: #dbe2ea; font-size: 16px; font-weight: 500; padding: 14px 15px; border-radius: 8px; transition: background-color 0.3s ease; }
        .nav-links a:hover { background-color: #2a3a4e; }
        .nav-links a.active { background-color: #3e4d61; color: #ffffff; font-weight: 600; }
        .logout-container { padding: 15px 30px 30px 30px; }
        .logout-btn { display: block; width: 100%; padding: 14px; font-size: 16px; font-weight: 600; color: white; background-color: #d9534f; border: none; border-radius: 8px; cursor: pointer; text-align: center; }

        /* --- 4. Main Content (from Admin) --- */
        .main-content { padding: 20px; color: #333; }
        .main-content h1 { font-size: 32px; font-weight: 700; margin-bottom: 20px; color: #1f2c3d; }
        
        @media (min-width: 768px) {
            .mobile-header { display: none; }
            #sidebar-close-btn { display: none; }
            .sidebar { transform: translateX(0%); }
            .main-content { margin-left: 260px; padding: 30px; }
        }
        
        /* --- 5. Page-Specific CSS (from driver_Assigned_Job.html) --- */
        .job-card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 20px; /* Added margin for list */
        }
        .job-card h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1f2c3d;
            margin-bottom: 20px;
        }
        .job-card .job-label {
            font-size: 14px;
            color: #6c757d;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .username-display{
            font-size: 1rem;
        }

    </style>
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
                <li><a href="../_driver_interface/driver_Records.php">Weekly Records</a></li>
                <li><a href="../_driver_interface/driver_Logs.php">Logs</a></li>
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
        <div class="job-list-container">
            <?php while ($row = mysqli_fetch_assoc($result_Job)): ?>
            <div class="job-card">
                <p class="job-label">Trip ID</p>
                <h1><?php echo htmlspecialchars($row['trip_id']); ?></h1>
                <p class="job-label">Driver</p>
                <h1><?php echo htmlspecialchars($row['driver']); ?></h1>
                <p class="job-label">Assigned_Vehicle</p>
                <h1><?php echo htmlspecialchars($row['vehicle']); ?></h1>
                <p class="job-label">Destination</p>
                <h1><?php echo htmlspecialchars($row['destination']); ?></h1>
                <p class="job-label">Date</p>
                <h1><?php echo htmlspecialchars($row['created_at']); ?></h1>
                <p class="job-label">Status</p>
                <h1><?php echo htmlspecialchars($row['status']); ?></h1>
            </div>
            <?php endwhile; ?>
        </div>

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