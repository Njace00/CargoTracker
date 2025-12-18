<?php
session_start();

// Admin only
if (!isset($_SESSION['account_id']) || $_SESSION['role'] != 2) {
    header("Location: ../_user_interface/user_signup.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GNBTL | Reservations</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Base Admin CSS -->
    <link rel="stylesheet" href="../css/admin_style.css">

    <!-- PAGE-SPECIFIC DESIGN -->
    <style>
        /* ===== CARD ===== */
        .dashboard-card-dashboard {
            background: #ffffff;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.05);
            margin-top: 20px;
        }

        .dashboard-card-dashboard h2 {
            margin-bottom: 16px;
            font-size: 18px;
            font-weight: 600;
            color: #222;
        }

        /* ===== TABLE ===== */
        .table-responsive-dashboard {
            overflow-x: auto;
        }

        .admin-table-dashboard {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
            font-size: 14px;
        }

        .admin-table-dashboard thead {
            background: #f6f8fb;
        }

        .admin-table-dashboard th {
            padding: 14px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 1px solid #e5e7eb;
        }

        .admin-table-dashboard td {
            padding: 14px;
            color: #444;
            border-bottom: 1px solid #f0f0f0;
        }

        .admin-table-dashboard tbody tr:hover {
            background: #f9fafb;
        }

        /* ===== STATUS ===== */
        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-badge.pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-badge.approved {
            background: #d4edda;
            color: #155724;
        }

        /* ===== BUTTONS ===== */
        .btn-dashboard {
            padding: 6px 14px;
            font-size: 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            margin-right: 6px;
            transition: 0.2s ease;
        }

        .btn-dashboard.approve {
            background: #28a745;
            color: #fff;
        }

        .btn-dashboard.reject {
            background: #dc3545;
            color: #fff;
        }

        .btn-dashboard.view {
            background: #007bff;
            color: #fff;
        }

        .btn-dashboard:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }
    </style>
</head>

<body>

<!-- MOBILE HEADER -->
<div class="mobile-header">
    <button id="menu-toggle-btn">
        <span class="menu-icon-line"></span>
        <span class="menu-icon-line"></span>
        <span class="menu-icon-line"></span>
    </button>
    <div class="mobile-header-title">GNBTL</div>
</div>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <button id="sidebar-close-btn">&times;</button>

    <div class="sidebar-header">GNBTL</div>

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
                <li><a href="../_admin_interface/admin_reservation.php">Reservation</a></li>
            </ul>
    </nav>

    <div class="logout-container">
        <form action="../__back-end_processes/auth_logout.php" method="post">
            <button class="logout-btn">Log out</button>
        </form>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="main-content-dashboard">

    <h1>Reservations</h1>

    <div class="dashboard-card-dashboard">
        <h2>Delivery & Cargo Requests</h2>

        <div class="table-responsive-dashboard">
            <table class="admin-table-dashboard">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Company</th>
                        <th>Shipment</th>
                        <th>Address</th>
                        <th>Weight</th>
                        <th>Size</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>2025-03-20</td>
                        <td>ABC Trading Corp</td>
                        <td>Construction Materials</td>
                        <td>Quezon City</td>
                        <td>1200 kg</td>
                        <td>Large</td>
                        <td><span class="status-badge pending">Pending</span></td>
                        <td>
                            <button class="btn-dashboard approve">Approve</button>
                            <button class="btn-dashboard reject">Reject</button>
                        </td>
                    </tr>

                    <tr>
                        <td>2025-03-21</td>
                        <td>Delta Logistics</td>
                        <td>Electronics</td>
                        <td>Laguna</td>
                        <td>450 kg</td>
                        <td>Medium</td>
                        <td><span class="status-badge approved">Approved</span></td>
                        <td>
                            <button class="btn-dashboard view">View</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- JS -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const menuBtn = document.getElementById("menu-toggle-btn");
    const closeBtn = document.getElementById("sidebar-close-btn");
    const sidebar = document.getElementById("sidebar");

    menuBtn.addEventListener("click", () => sidebar.classList.add("open"));
    closeBtn.addEventListener("click", () => sidebar.classList.remove("open"));
});
</script>

</body>
</html>
