<?php
session_start();

// Dummy session check
if (!isset($_SESSION['account_id']) || $_SESSION['role'] != 2) {
    header("Location: ../_user_interface/user_signup.php");
    exit();
}

// Dummy data
$pending_accounts = [
    ['username' => 'john_doe', 'email' => 'john@example.com', 'created_at' => '2025-12-10'],
    ['username' => 'jane_smith', 'email' => 'jane@example.com', 'created_at' => '2025-12-11'],
    ['username' => 'mike_ross', 'email' => 'mike@example.com', 'created_at' => '2025-12-12']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GNBTL Admin - Verify Accounts</title>
<link rel="icon" type="image/x-icon" href="../images/favicon.jpg">
<link rel="stylesheet" href="../css/admin_style.css">
<style>
/* Header */
.main-content-dashboard h1 {
    color: #111827; /* dark text for white card */
    font-size: 1.8rem;
    margin-bottom: 20px;
}

/* Card styling */
.dashboard-card-dashboard {
    background-color: #ffffff; /* white card */
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

/* Table styling */
.verification-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    color: #111827; /* dark text for table */
}

.verification-table th,
.verification-table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #e5e7eb; /* light gray line */
}

.verification-table th {
    background-color: #f3f4f6; /* light gray header */
    font-weight: 600;
    font-size: 0.95rem;
}

.verification-table tr:hover {
    background-color: #f9fafb; /* light hover */
    transition: 0.2s;
}

/* Buttons */
.approve-btn,
.reject-btn {
    padding: 6px 14px;
    border: none;
    border-radius: 6px;
    font-size: 0.85rem;
    cursor: pointer;
    margin-right: 5px;
    font-weight: 500;
}

.approve-btn {
    background-color: #10b981; /* green */
    color: white;
}

.approve-btn:hover {
    background-color: #059669;
}

.reject-btn {
    background-color: #ef4444; /* red */
    color: white;
}

.reject-btn:hover {
    background-color: #b91c1c;
}

/* Scrollable card */
.card-content-scrollable-dashboard {
    max-height: 400px;
    overflow-y: auto;
}

/* Scrollbar styling */
.card-content-scrollable-dashboard::-webkit-scrollbar {
    width: 8px;
}
.card-content-scrollable-dashboard::-webkit-scrollbar-thumb {
    background-color: #d1d5db;
    border-radius: 4px;
}
.card-content-scrollable-dashboard::-webkit-scrollbar-track {
    background-color: #f9fafb;
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
    <div class="mobile-header-title">GNBTL</div>
</div>

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
        <form action="#" method="post">
            <button class="logout-btn">Log out</button>
        </form>
    </div>
</div>

<div class="main-content-dashboard">
    <h1>Pending Account Verifications</h1>

    <div class="dashboard-card-dashboard">
        <div class="card-content-scrollable-dashboard">
            <?php if (count($pending_accounts) > 0): ?>
                <table class="verification-table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Registered On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pending_accounts as $account): ?>
                            <tr>
                                <td><?= htmlspecialchars($account['username']) ?></td>
                                <td><?= htmlspecialchars($account['email']) ?></td>
                                <td><?= date("F d, Y", strtotime($account['created_at'])) ?></td>
                                <td>
                                    <button class="approve-btn">Approve</button>
                                    <button class="reject-btn">Reject</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No accounts pending verification.</p>
            <?php endif; ?>
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
        if (linkPage === currentPage) link.classList.add('active');
    });
});
</script>
</body>
</html>
