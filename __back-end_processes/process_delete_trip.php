<?php
include 'db_connect.php';
session_start();

if (isset($_GET['trip_id'])) {
    $trip_id = $_GET['trip_id'];
    
    $query = "DELETE FROM trips WHERE trip_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $trip_id);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../_admin_interface/admin_trips.php?success=deleted");
    } else {
        header("Location: ../_admin_interface/admin_trips.php?error=delete_failed");
    }
    exit();
}
?>