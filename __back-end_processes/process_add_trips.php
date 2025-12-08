<?php
include '../__back-end_processes/db_connect.php';
$Driver = $_POST['assigned_Driver'] ?? '';
$Vehicle = $_POST['assigned_Vehicle'] ?? '';
$Client = $_POST['Client'] ?? '';
$Destination = $_POST['delivery_Destination'] ?? '';
$trip_Type = $_POST['tripType'] ?? '';


$Insert_DB = "INSERT INTO trips (driver, vehicle, client, destination, trip_type)
Values ('$Driver', '$Vehicle', '$Client', '$Destination', 'trip_Type')";

$query = mysqli_query($conn, $Insert_DB);

if($query){
    header("Location: ../_admin_interface/admin_trips.php");
    exit();
}


?>