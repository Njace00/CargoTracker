<?php
session_start();

include 'db_connect.php'; 



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $V_name = $_POST['vehicle_name'] ?? '';
    $V_type = $_POST['vehicle_type'] ?? '';
    $V_class = $_POST['vehicle_class'] ?? '';


    $Insert_DB = "INSERT INTO vehicles (vehicle_name, vehicle_type, vehicle_class)
    VALUES('$V_name','$V_type','$V_class')";

    $query = mysqli_query($conn, $Insert_DB);

        if($query){
        header("Location: ../_admin_interface/admin_vehicles.php");
        exit();
        }

    
    exit();
    
}
?>