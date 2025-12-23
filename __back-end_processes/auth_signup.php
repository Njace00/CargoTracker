<?php
include 'db_connect.php';

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $fname = $_POST['fname'] ?? '';
    $cname = $_POST['cname'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $hash_pwd = password_hash($password, PASSWORD_DEFAULT);
    $role = 0;
    $is_new_client = 1;

    //sql

    $insert = "insert into account (username, fullname, company_name, email, password, role, is_new_client)
    values ('$name', '$fname', '$cname','$email','$hash_pwd', '$role', '$is_new_client')";

    $query = mysqli_query($conn, $insert);

    header("Location: ../_user_interface/user_signup.php");
     
}



?>