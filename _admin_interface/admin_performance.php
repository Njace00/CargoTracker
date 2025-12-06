<?php
session_start();

// If not logged in OR not driver, redirect away
if (!isset($_SESSION['account_id']) || $_SESSION['role'] != 2) {
    header("Location: ../_user_interface/user_signup.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GNBTL Admin - Performance Analytics</title>
    <link rel="icon" type="image/x-icon" href="../images/favicon.jpg">
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

    <div class="mobile-header">
        <button id="menu-toggle-btn">
            <span class="menu-icon-line"></span>
            <span class="menu-icon-line"></span>
            <span class="menu-icon-line"></span>
        </button>
        <div class="mobile-header-title">GNBTL</div>
    </div>

    <div class="sidebar" id="sidebar">
        <button id="sidebar-close-btn">&times;</button>
        <div class="sidebar-header"> GNBTL </div>
        <nav>
            <ul class="nav-links">
                <li><a href="../_admin_interface/admin.php">Dashboard</a></li>
                <li><a href="../_admin_interface/admin_overview.php">Overview Metrics</a></li>
                <li><a href="../_admin_interface/admin_trips.php">Trips</a></li>
                <li><a href="../_admin_interface/admin_vehicles.php">Vehicles</a></li>
                <li><a href="../_admin_interface/admin_performance.php">Performance</a></li>
                <li><a href="../_admin_interface/admin_activity.php">Recent Activity</a></li>
                <li><a href="../_admin_interface/admin_accounts.php">Driver Accounts</a></li>
                <li><a href="../_admin_interface/admin_announcement.php">Announcement</a></li>
            </ul>
        </nav>
        <div class="logout-container">
            <form action="../__back-end_processes/auth_logout.php" method="post">
                <button class="logout-btn">Log out</button>
            </form>
        </div>
    </div>

    <div class="main-content-performance">
        
        <h1>Performance Analytics</h1>

        <div class="dashboard-card-performance">
            <h2>Driver Performance</h2>
            <div class="card-content-table-wrapper-performance">
                <table class="content-table-performance">
                    <thead>
                        <tr>
                            <th>Driver Name</th>
                            <th>Trips Completed</th>                  
                            <th>Issues Reported</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Neil Jason Flores</td>
                            <td>32</td>                           
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>Driefen Alfonso</td>
                            <td>28</td>                            
                            <td>3</td>
                        </tr>
                        <tr>
                            <td>Edward Ringor</td>
                            <td>30</td>                           
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>Keon Kazu Capua</td>
                            <td>25</td>                           
                            <td>2</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="dashboard-card-performance">
            <h2>Vehicle Performance</h2>
            <div class="card-content-table-wrapper-performance">
                <table class="content-table-performance">
                    <thead>
                        <tr>
                            <th>Vehicle (Plate)</th>
                            <th>Total Trips</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>TRUCK-001 (ABC 123)</td>
                            <td>45</td>
                            <td>Available</td>
                        </tr>
                        <tr>
                            <td>TRUCK-002 (DEF 456)</td>
                            <td>51</td>
                            <td>Available</td>
                        </tr>
                        <tr>
                            <td>TRUCK-003 (GHI 789)</td>
                            <td>42</td>
                            <td>Maintenance</td>
                        </tr>
                    </tbody>
                </table>
            </div>
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