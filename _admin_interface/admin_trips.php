<?php
include '../__back-end_processes/db_connect.php';
session_start();




// If not logged in OR not driver, redirect away
if (!isset($_SESSION['account_id']) || $_SESSION['role'] != 2) {
    header("Location: ../_user_interface/user_signup.php");
    exit();
}

$query = "SELECT fullname FROM account WHERE role = 1";
$result = mysqli_query($conn, $query);


$query = "SELECT * FROM vehicles";
$result1 = mysqli_query($conn, $query);


$query = "SELECT * FROM trips";
$result2 = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GNBTL Admin - Trip Management</title>
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

    <div class="main-content-trip">
        
        <h1>Trip Management</h1>

        <div class="dashboard-columns-trip">

            <div class="dashboard-card-trip">
                <h2>Create New Trip</h2>
                <form action="../__back-end_processes/process_add_trips.php" method="POST">
                    <div class="form-group-trip">
                        <label for="trip_driver" class="form-label-trip">Assign Driver</label>
                        <select id="trip_driver" class="form-select-trip" name="assigned_Driver">
                            <option value="">Select a driver...</option>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <option value="<?php echo htmlspecialchars($row['fullname']);?>"><?php echo htmlspecialchars($row['fullname']);?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group-trip">
                        <label for="trip_vehicle" class="form-label-trip">Assign Vehicle</label>
                        <select id="trip_vehicle" class="form-select-trip" name="assigned_Vehicle">
                            <option value="">Select an available vehicle...</option>
                            <?php while ($row = mysqli_fetch_assoc($result1)): ?>
                            <option value="<?php echo htmlspecialchars($row['vehicle_name']);?>"><?php echo htmlspecialchars($row['vehicle_name']);?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group-trip">
                        <label for="trip_client" class="form-label-trip">Assign Client</label>
                        <select id="trip_client" class="form-select-trip" name="Client">
                            <option value="">Select a client...</option>
                            <option value="1">Client A (Manila)</option>
                            <option value="2">Client B (Batangas)</option>
                        </select>
                    </div>

                    <div class="form-group-trip">
                        <label for="trip_driver" class="form-label-trip">Type of Delivery</label>
                        <select id="trip_driver" class="form-select-trip" name="tripType">
                            <option value="">Type of Delivery</option>
                            <option value="call-in">Call-in</option>
                            <option value="reservation">Reservation</option>
                        </select>
                    </div>

                    <div class="form-group-trip">
                        <label for="trip_destination" class="form-label-trip">Destination</label>
                        <input type="text" id="trip_destination" class="form-input-trip" placeholder="e.g., Manila Port" name="delivery_Destination" required>
                    </div>

                    

                    <!-- <div class="form-group-trip">
                        <label for="trip_distance" class="form-label-trip">Distance (km)</label>
                        <input type="number" id="trip_distance" class="form-input-trip" placeholder="e.g., 85">
                    </div> -->
                    
                    <button type="submit" class="form-button-trip">Create Trip</button>
                </form>
            </div>

            <div class="dashboard-card-trip">
                <h2>All Trips</h2>
                <div class="card-content-table-wrapper-trip">
                    <table class="content-table-trip">
                        <thead>
                            <tr>
                                <th>Trip ID</th>
                                <th>Driver</th>
                                <th>Vehicle</th>
                                <th>Client</th>
                                <th>Destination</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result2)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['trip_id']);?></td>
                                <td><?php echo htmlspecialchars($row['driver']);?></td>
                                <td><?php echo htmlspecialchars($row['vehicle']);?></td>
                                <td><?php echo htmlspecialchars($row['client']);?></td>
                                <td><?php echo htmlspecialchars($row['destination']);?></td>
                                <td><?php echo htmlspecialchars($row['trip_type']);?></td>
                                <td><?php echo htmlspecialchars($row['status']);?></td>
                                <td><?php echo htmlspecialchars($row['created_at']);?></td>                    
                                <td><button class="action-btn-trip edit">View/Edit</button></td>
                            <?php endwhile?>
                            </tr>
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