<?php
include 'db_connect.php';

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $hash_pwd = password_hash($password, PASSWORD_DEFAULT);
    $role = 0;

    // sql

    $insert = "insert into account (username, email, password, role)
    values ('$name', '$email','$hash_pwd', '$role')";

    $query = mysqli_query($conn, $insert);

    header("Location: ../_user_interface/user_signup.php");
   

    
}



?>