<?php
include '../__back-end_processes/db_connect.php';
session_start();

// If not logged in OR not driver, redirect away
if (!isset($_SESSION['account_id']) || $_SESSION['role'] != 2) {
    header("Location: ../_user_interface/user_signup.php");
    exit();
}

$query = "SELECT fullname FROM account WHERE role = 1 AND is_assigned = 0";
$result = mysqli_query($conn, $query);

$query = "SELECT * FROM vehicles WHERE is_assigned = 0";
$result1 = mysqli_query($conn, $query);

$query = "SELECT * FROM trips";
$result2 = mysqli_query($conn, $query);

// QUERY INSIDE THE MODAL
$query = "SELECT fullname FROM account WHERE role = 1 AND is_assigned = 0";
$result00 = mysqli_query($conn, $query);

$query = "SELECT * FROM vehicles WHERE is_assigned = 0";
$result01 = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GNBTL Admin - Trip Management</title>
    <link rel="icon" type="image/x-icon" href="../images/favicon.jpg">
    <link rel="stylesheet" href="../css/admin_style.css">
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 30px;
            border: 1px solid #888;
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 15px;
        }

        .modal-header h2 {
            margin: 0;
            color: #333;
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #000;
        }

        .modal-body {
            margin-bottom: 20px;
        }

        .modal-field {
            margin-bottom: 15px;
        }

        .modal-field label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        .modal-field input,
        .modal-field select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .modal-footer {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 20px;
        }

        .modal-btn {
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s;
        }

        .btn-save {
            background-color: #4CAF50;
            color: white;
            flex: 1;
        }

        .btn-save:hover {
            background-color: #45a049;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
            flex: 1;
        }

        .btn-delete:hover {
            background-color: #da190b;
        }

        .btn-cancel {
            background-color: #757575;
            color: white;
            flex: 1;
        }

        .btn-cancel:hover {
            background-color: #616161;
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
        <div class="sidebar-header"> GNBTL </div>
        <nav>
            <ul class="nav-links">
                <li><a href="../_admin_interface/admin.php">Dashboard</a></li>
                <li><a href="../_admin_interface/admin_verify_account.php">Verify Clients</a></li>
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
                                <option value="<?php echo htmlspecialchars($row['fullname']); ?>"><?php echo htmlspecialchars($row['fullname']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group-trip">
                        <label for="trip_vehicle" class="form-label-trip">Assign Vehicle</label>
                        <select id="trip_vehicle" class="form-select-trip" name="assigned_Vehicle">
                            <option value="">Select an available vehicle...</option>
                            <?php while ($row = mysqli_fetch_assoc($result1)): ?>
                                <option value="<?php echo htmlspecialchars($row['vehicle_name']); ?>"><?php echo htmlspecialchars($row['vehicle_name']); ?></option>
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
                                    <td><?php echo htmlspecialchars($row['trip_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['driver']); ?></td>
                                    <td><?php echo htmlspecialchars($row['vehicle']); ?></td>
                                    <td><?php echo htmlspecialchars($row['client']); ?></td>
                                    <td><?php echo htmlspecialchars($row['destination']); ?></td>
                                    <td><?php echo htmlspecialchars($row['trip_type']); ?></td>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                    <td>
                                        <button class="action-btn-trip edit" onclick="openModal(<?php echo htmlspecialchars(json_encode($row)); ?>)">View/Edit</button>
                                    </td>
                                </tr>
                            <?php endwhile ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

    <!-- Modal -->
    <div id="tripModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Trip Details</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <form id="editTripForm" action="../__back-end_processes/process_edit_trip.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="modal_trip_id" name="trip_id">
                    
                    <div class="modal-field">
                        <label>Trip ID</label>
                        <input type="text" id="modal_trip_id_display" disabled>
                    </div>

                    <div class="modal-field">
                        <label for="trip_driver" class="form-label-trip">Assign Driver</label>
                        <select id="modal_driver" class="form-select-trip" name="driver">
                            <option value="">Select a driver...</option>
                            <?php while ($row = mysqli_fetch_assoc($result00)): ?>
                                <option value="<?php echo htmlspecialchars($row['fullname']); ?>"><?php echo htmlspecialchars($row['fullname']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="modal-field">
                        <label for="trip_vehicle" class="form-label-trip">Assign Vehicle</label>
                        <select id="modal_vehicle" class="form-select-trip" name="vehicle">
                            <option value="">Select an available vehicle...</option>
                            <?php while ($row = mysqli_fetch_assoc($result01)): ?>
                                <option value="<?php echo htmlspecialchars($row['vehicle_name']); ?>"><?php echo htmlspecialchars($row['vehicle_name']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="modal-field">
                        <label for="trip_client" class="form-label-trip">Assign Client</label>
                        <select id="modal_client" class="form-select-trip" name="client">
                            <option value="">Select a client...</option>
                            <option value="1">Client A (Manila)</option>
                            <option value="2">Client B (Batangas)</option>
                        </select>
                    </div>

                    <div class="modal-field">
                        <label for="modal_destination">Destination</label>
                        <input type="text" id="modal_destination" name="destination" required>
                    </div>

                    <div class="modal-field">
                        <label for="modal_trip_type">Type</label>
                        <select id="modal_trip_type" name="trip_type" required>
                            <option value="call-in">Call-in</option>
                            <option value="reservation">Reservation</option>
                        </select>
                    </div>

                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="modal-btn btn-save">Save Changes</button>
                    <button type="button" class="modal-btn btn-delete" onclick="deleteTrip()">Delete Trip</button>
                    <button type="button" class="modal-btn btn-cancel" onclick="closeModal()">Cancel</button>
                </div>
            </form>
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

        // Modal Functions
        function openModal(tripData) {
            document.getElementById('modal_trip_id').value = tripData.trip_id;
            document.getElementById('modal_trip_id_display').value = tripData.trip_id;
            document.getElementById('modal_driver').value = tripData.driver;
            document.getElementById('modal_vehicle').value = tripData.vehicle;
            document.getElementById('modal_client').value = tripData.client;
            document.getElementById('modal_destination').value = tripData.destination;
            document.getElementById('modal_trip_type').value = tripData.trip_type;  
            
            document.getElementById('tripModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('tripModal').style.display = 'none';
        }

        function deleteTrip() {
            const tripId = document.getElementById('modal_trip_id').value;
            window.location.href = '../__back-end_processes/process_delete_trip.php?trip_id=' + tripId;
            
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('tripModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>

</body>

</html>