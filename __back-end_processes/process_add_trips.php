<?php
include '../__back-end_processes/db_connect.php';
$Driver = $_POST['assigned_Driver'] ?? '';
$Vehicle = $_POST['assign_Driver'] ?? '';
$Client = $_POST['Client'] ?? '';
$Destination = $_POST['delivery_Destination'] ?? '';


$Insert_DB = "INSERT INTO trips (driver, vehicle, client, destination)
Values ('$Driver', '$Vehicle', '$Client', '$Destination')";

$query = mysqli_query($conn, $Insert_DB);

if($query){
    header("Location: ../_admin_interface/admin_trips.php");
    exit();
}


?>