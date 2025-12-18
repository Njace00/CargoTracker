<?php
include '../__back-end_processes/db_connect.php';
session_start();

// If not logged in OR not driver, redirect away
if (!isset($_SESSION['account_id']) || $_SESSION['role'] != 2) {
    header("Location: ../_user_interface/user_signup.php");
    exit();
}

$query = "SELECT COUNT(*) as total_trips from trips";
$total_trips_result = mysqli_query($conn,$query);
$row = mysqli_fetch_assoc($total_trips_result);
$total_trips = $row['total_trips'];

$query1 = "SELECT COUNT(*) as total_active_trips FROM trips WHERE accepted = 1";
$total_active_trips_result = mysqli_query($conn, $query1);
$row1 = mysqli_fetch_assoc($total_active_trips_result);
$total_active_trips = $row1['total_active_trips'];

$query2 = "SELECT COUNT(*) as total_pending_trips FROM trips WHERE accepted = 0";
$total_pending_trips_result = mysqli_query($conn, $query2);
$row2 = mysqli_fetch_assoc($total_pending_trips_result);
$total_pending_trips_result = $row2['total_pending_trips'];


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

    <div class="main-content-dashboard">

        <h1>Dashboard</h1>

        <div class="metrics-grid-dashboard">

            <div class="metric-card-dashboard">
                <div class="icon-dashboard trips">
                    <img src="../images/ongoing.png" alt="Active Trips">
                </div>
                <div class="info-dashboard">
                    <div class="value-dashboard"><?php echo $total_trips; ?></div>
                    <div class="label-dashboard">Active Trips</div>
                </div>
            </div>

            <div class="metric-card-dashboard">
                <div class="icon-dashboard vehicles">
                    <img src="../images/truck.png" alt="Available Vehicles">
                </div>
                <div class="info-dashboard">
                    <div class="value-dashboard"><?php echo $total_active_trips; ?></div>
                    <div class="label-dashboard">Available Vehicles</div>
                </div>
            </div>

            <div class="metric-card-dashboard">
                <div class="icon-dashboard issues">
                    <img src="../images/pending.png" alt="Pending Jobs">
                </div>
                <div class="info-dashboard">
                    <div class="value-dashboard"><?php echo $total_pending_trips_result;?></div>
                    <div class="label-dashboard">Pending Jobs</div>
                </div>
            </div>

        </div>

        <div class="dashboard-columns-dashboard">

            <div class="dashboard-card-dashboard">
                <h2>Real-time Monitoring</h2>
                <div class="card-content-scrollable-dashboard">
                    <ul class="trip-list-dashboard">
                        <li class="trip-item-dashboard">
                            <div>
                                <div class="driver-dashboard">Neil Jason Flores</div>
                                <div class="details-dashboard">TRUCK-001 → Manila Port</div>
                            </div>
                            <span class="status-dashboard">Ongoing</span>
                        </li>
                        <li class="trip-item-dashboard">
                            <div>
                                <div class="driver-dashboard">Driefen Alfonso</div>
                                <div class="details-dashboard">TRUCK-003 → Batangas</div>
                            </div>
                            <span class="status-dashboard">Ongoing</span>
                        </li>
                        <li class="trip-item-dashboard">
                            <div>
                                <div class="driver-dashboard">Edward Ringor</div>
                                <div class="details-dashboard">TRUCK-002 → Quezon City</div>
                            </div>
                            <span class="status-dashboard">Ongoing</span>
                        </li>
                        <li class="trip-item-dashboard">
                            <div>
                                <div class="driver-dashboard">Keon Kazu Capua</div>
                                <div class="details-dashboard">TRUCK-005 → Laguna</div>
                            </div>
                            <span class="status-dashboard">Ongoing</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="dashboard-card-dashboard">
                <h2>Alerts</h2>
                <div class="card-content-scrollable-dashboard">
                    <div class="alert-item-dashboard">
                        <div class="icon-dashboard">
                        </div>
                        <div class="details-dashboard">
                            <div class="vehicle-dashboard">TRUCK-001</div>
                            <div class="issue-dashboard">Report: Engine Overheating</div>
                        </div>
                        <button class="view-btn-dashboard">View</button>
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