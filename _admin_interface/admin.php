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
    <title>GNBTL Admin Dashboard (Responsive)</title>
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

        <div class="sidebar-header">
            GNBTL
        </div>
        
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

    <div class="main-content">
        
        <h1>Dashboard</h1>

        <div class="metrics-grid">
            
            <div class="metric-card">
                <div class="icon trips">
                    <img src="../images/ongoing.png" alt="Active Trips">
                </div>
                <div class="info">
                    <div class="value">5</div>
                    <div class="label">Active Trips</div>
                </div>
            </div>

            <div class="metric-card">
                <div class="icon vehicles">
                    <img src="../images/truck.png" alt="Available Vehicles">
                </div>
                <div class="info">
                    <div class="value">6</div>
                    <div class="label">Available Vehicles</div>
                </div>
            </div>

            <div class="metric-card">
                <div class="icon issues">
                    <img src="../images/pending.png" alt="Pending Jobs">
                </div>
                <div class="info">
                    <div class="value">0</div>
                    <div class="label">Pending Jobs</div>
                </div>
            </div>

        </div>

        <div class="dashboard-columns">

            <div class="dashboard-card">
                <h2>Real-time Monitoring</h2>
                <div class="card-content-scrollable">
                    <ul class="trip-list">
                        <li class="trip-item">
                            <div>
                                <div class="driver">Neil Jason Flores</div>
                                <div class="details">TRUCK-001 → Manila Port</div>
                            </div>
                            <span class="status">Ongoing</span>
                        </li>
                        <li class="trip-item">
                            <div>
                                <div class="driver">Driefen Alfonso</div>
                                <div class="details">TRUCK-003 → Batangas</div>
                            </div>
                            <span class="status">Ongoing</span>
                        </li>
                        <li class="trip-item">
                            <div>
                                <div class="driver">Edward Ringor</div>
                                <div class="details">TRUCK-002 → Quezon City</div>
                            </div>
                            <span class="status">Ongoing</span>
                        </li>
                        <li class="trip-item">
                            <div>
                                <div class="driver">Keon Kazu Capua</div>
                                <div class="details">TRUCK-005 → Laguna</div>
                            </div>
                            <span class="status">Ongoing</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="dashboard-card">
                <h2>Alerts</h2>
                <div class="card-content-scrollable">
                    <div class="alert-item">
                        <div class="icon">
                        </div>
                        <div class="details">
                            <div class="vehicle">TRUCK-001</div>
                            <div class="issue">Report: Engine Overheating</div>
                        </div>
                        <button class="view-btn">View</button>
                    </div>
                    
                </div>
            </div>
            
        </div>
        
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            
            // --- Sidebar Logic ---
            var menuButton = document.getElementById("menu-toggle-btn");
            var closeButton = document.getElementById("sidebar-close-btn");
            var sidebar = document.getElementById("sidebar");

            menuButton.addEventListener("click", function() {
                sidebar.classList.add("open");
            });

            closeButton.addEventListener("click", function() {
                sidebar.classList.remove("open");
            });
            
            // --- Active Nav Link Logic ---
            const currentPage = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('.nav-links a');

            navLinks.forEach(link => {
                const linkPage = link.getAttribute('href').split('/').pop();
                if (linkPage === currentPage || (currentPage === '' && linkPage === 'admin.html')) {
                    link.classList.add('active');
                }
            });
            
        });
    </script>

</body>
</html>