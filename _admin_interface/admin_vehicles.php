<?php
include '../__back-end_processes/db_connect.php';
session_start();

// If not logged in OR not driver, redirect away
if (!isset($_SESSION['account_id']) || $_SESSION['role'] != 2) {
    header("Location: ../_user_interface/user_signup.php");
    exit();
}



$query = "SELECT * FROM vehicles WHERE is_archived = 0";
$result = mysqli_query($conn, $query);
//2nd re-query for the 2nd loop
$result1 = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GNBTL Admin - Vehicle Management</title>
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

    <div class="main-content-vehicle">

        <h1>Vehicle Management</h1>

        <div class="dashboard-columns-vehicle">

            <div class="dashboard-card-vehicle">
                <h2>Add New Vehicle</h2>
                <form method="POST" action="../__back-end_processes\processs_add_vehicle.php">
                    <div class="form-group-vehicle">
                        <label for="vehicle_name" class="form-label-vehicle">Vehicle Name</label>
                        <input name="vehicle_name" type="text" id="vehicle_name" class="form-input-vehicle" placeholder="e.g., truck-1" required>
                    </div>

                    <div class="form-group-vehicle">
                        <label for="vehicle_class" class="form-label-vehicle">Class</label>
                        <select id="vehicle_class" class="form-select-vehicle" name="vehicle_type">
                            <option value="rigid">Rigid</option>
                            <option value="trailer">Trailer</option>
                        </select>
                    </div>

                    <div class="form-group-vehicle">
                        <label for="vehicle_size" class="form-label-vehicle">Size</label>
                        <select id="vehicle_size" class="form-select-vehicle" name="vehicle_class">
                            <option value="2-tonner">2-tonner</option>
                            <option value="5-tonner">5-tonner</option>
                            <option value="10-tonner">10-tonner</option>
                        </select>
                    </div>

                    <button type="submit" class="form-button-vehicle">Add Vehicle</button>
                </form>
            </div>

            <div class="dashboard-card-vehicle">
                <h2>Vehicle Status</h2>
                <div class="card-content-scrollable-vehicle">
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <div class="status-info-vehicle">
                            <span class="status-info-name-vehicle"><?php echo htmlspecialchars($row['vehicle_name']); ?></span>
                            <span class="status-badge-vehicle available"><?php echo htmlspecialchars($row['status']); ?></span>
                        </div>
                    <?php endwhile; ?>

                </div>
            </div>

            <div class="dashboard-card-vehicle" style="grid-column: 1 / -1;">
                <h2>Vehicle List</h2>
                <div class="card-content-table-wrapper-vehicle">
                    <table class="content-table-vehicle">

                        <thead>
                            <tr>
                                <th>Vehicle Name</th>
                                <th>Class</th>
                                <th>Size</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result1)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['vehicle_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['vehicle_type']); ?></td>
                                    <td><?php echo htmlspecialchars($row['vehicle_class']); ?></td>
                                    <td>
                                        <button class="action-btn-vehicle edit">Edit</button>
                                        <form method="POST" action="../__back-end_processes/process_archive-vehicles.php">
                                            <input type="hidden" name="vehicle_name" value="<?php echo htmlspecialchars($row['vehicle_name']); ?>">
                                            <button type="submit" class="action-btn-vehicle archive">Archive</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
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
                if (linkPage === currentPage) {
                    link.classList.add('active');
                }
            });
        });
    </script>

</body>

</html>







CREATE TABLE trips (
trip_id INT PRIMARY KEY AUTO_INCREMENT,
driver_id INT NOT NULL,
vehicle_id INT NOT NULL,
client_id INT NOT NULL,
destination VARCHAR(255) NOT NULL,
trip_type ENUM('reservation', 'call-in') NOT NULL DEFAULT 'call-in',
status ENUM('pending', 'in-progress', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
started_at DATETIME NULL,
completed_at DATETIME NULL,
notes TEXT NULL,
FOREIGN KEY (driver_id) REFERENCES account(account_id),
FOREIGN KEY (vehicle_id) REFERENCES vehicles(vehicle_id),
FOREIGN KEY (client_id) REFERENCES clients(client_id)
);


CREATE TABLE trips (
trip_id INT PRIMARY KEY AUTO_INCREMENT,
driver_id INT NOT NULL,
vehicle_id INT NOT NULL,
client_id INT NOT NULL,
destination VARCHAR(255) NOT NULL,
trip_type ENUM('reservation', 'call-in') NOT NULL DEFAULT 'call-in',
status ENUM('pending', 'in-progress', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
started_at DATETIME NULL,
completed_at DATETIME NULL,
notes TEXT NULL,
FOREIGN KEY (driver_id) REFERENCES account(account_id),
FOREIGN KEY (vehicle_id) REFERENCES vehicles(vehicle_id),
FOREIGN KEY (client_id) REFERENCES clients(client_id)
);