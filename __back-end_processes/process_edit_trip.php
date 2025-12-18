<?php
include 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $trip_id = $_POST['trip_id'];
    $driver = $_POST['driver'];
    $vehicle = $_POST['vehicle'];
    $client = $_POST['client'];
    $destination = $_POST['destination'];
    $trip_type = $_POST['trip_type'];
    $status = $_POST['status'];

    $query = "UPDATE trips SET 
              driver = ?, 
              vehicle = ?, 
              client = ?, 
              destination = ?, 
              trip_type = ?
              WHERE trip_id = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssssi", $driver, $vehicle, $client, $destination, $trip_type, $status, $trip_id);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../_admin_interface/admin_trips.php?success=updated");
    } else {
        header("Location: ../_admin_interface/admin_trips.php?error=update_failed");
    }
    exit();
}
?>