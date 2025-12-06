<?php
include 'db_connect.php';

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $F_name = $_POST['fullname'] ?? '';
    $name = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $hash_pwd = password_hash($password, PASSWORD_DEFAULT);
    $role = 1;

    // sql
    $insert = "insert into account (fullname, username, email, password, role)
    values ('$F_name','$name', '$email','$hash_pwd', '$role')";

    $query = mysqli_query($conn, $insert);
   

    
    
}





?>