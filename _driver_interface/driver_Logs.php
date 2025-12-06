<?php
session_start();

// If not logged in OR not driver, redirect away
if (!isset($_SESSION['account_id']) || $_SESSION['role'] != 1) {
    header("Location: ../_user_interface/user_signup.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver - Logs</title>
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
        
        /* --- 5. Page-Specific CSS --- */
        
        /* Activity Log Styles */
        .dashboard-card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 20px;
            display: flex;
            flex-direction: column;
            margin-bottom: 20px; /* Added space between cards */
        }
        .dashboard-card h2 {
            font-size: 20px;
            font-weight: 600;
            margin-top: 0;
            margin-bottom: 15px;
            color: #1f2c3d;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .activity-log {
            list-style: none;
        }
        .activity-item {
            display: flex;
            gap: 15px;
            padding: 15px 5px;
            border-bottom: 1px solid #f0f0f0;
        }
        .activity-item:last-child {
            border-bottom: none;
        }
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f4f7fa;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .activity-details {
            flex-grow: 1;
        }
        .activity-description {
            font-size: 15px;
            color: #333;
            margin-bottom: 4px;
        }
        .activity-description strong {
            color: #1f2c3d;
        }
        .activity-timestamp {
            font-size: 13px;
            color: #6c757d;
        }

        /* Delivery Table Styles */
        .delivery-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .filter-btn {
            background-color: #ffffff;
            border: 1px solid #d1d5db;
            color: #374151;
            padding: 8px 14px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
        }
        .table-wrapper {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            overflow-x: auto;
        }
        .delivery-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        .delivery-table th, .delivery-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }
        .delivery-table th {
            background-color: #f9fafb;
            font-weight: 600;
            color: #374151;
        }
        .delivery-table tbody tr:hover {
            background-color: #f4f7fa;
        }
        .delivery-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .delivery-table tbody tr:nth-child(even):hover {
            background-color: #f4f7fa;
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
        <div class="sidebar-header"> GNBTL </div>
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
        
        <h1>My Logs</h1>

        <div class="dashboard-card">
            <h2>Recent Activity</h2>
            <ul class="activity-log">
                <li class="activity-item">
                    <div class="activity-icon"></div>
                    <div class="activity-details">
                        <div class="activity-description">
                            <strong>Trip GNBTL-R5F7GE3</strong> marked as <strong>Completed</strong>.
                        </div>
                        <div class="activity-timestamp">5 hours ago</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon"></div>
                    <div class="activity-details">
                        <div class="activity-description">
                            New issue reported for <strong>truck-1</strong>: "Engine Overheating".
                        </div>
                        <div class="activity-timestamp">1 day ago</div>
                    </div>
                </li>
                 <li class="activity-item">
                    <div class="activity-icon"></div>
                    <div class="activity-details">
                        <div class="activity-description">
                            Logged in.
                        </div>
                        <div class="activity-timestamp">1 day ago</div>
                    </div>
                </li>
            </ul>
        </div>
        
        <div class="delivery-header">
            <h1 style="font-size: 24px; margin-bottom: 0;">Past Delivery Logs</h1>
            <button class="filter-btn">Filter: </button>
        </div>

        <div class="table-wrapper">
            <table class="delivery-table">
                <thead>
                    <tr>
                        <th>Cargo Name</th>
                        <th>Location / Route</th>
                        <th>Weight</th>
                        <th>Cargo Type</th>
                        <th>Date: Start/End</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="row-light">
                        <td>TEST</td>
                        <td>TEST</td>
                        <td>TEST</td>
                        <td>TEST</td>
                        <td>TEST</td>
                    </tr>
                    <tr class="row-dark">
                        <td>TEST</td>
                        <td>TEST</td>
                        <td>TEST</td>
                        <td>TEST</td>
                        <td>TEST</td>
                    </tr>
                    <tr class="row-light">
                        <td>TEST</td>
                        <td>TEST</td>
                        <td>TEST</td>
                        <td>TEST</td>
                        <td>TEST</td>
                    </tr>
                </tbody>
            </table>
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