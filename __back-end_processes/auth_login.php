<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Step 1: Fetch user by email 
    // SECURITY FIX: Using a prepared statement instead of direct variable injection
    $retreive_account = "SELECT * FROM account WHERE email=? LIMIT 1";
    $stmt = mysqli_prepare($conn, $retreive_account);

    if ($stmt) {
        // Bind the $email variable to the "?" as a string ("s")
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Step 2: Verify password
            if (password_verify($password, $user['password'])) {

                // ✅ Store session data    
                $_SESSION['account_id'] = $user['account_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['is_new_client'] = $user['is_new_client']; // ✅ ADD THIS LINE

                // Step 3: Redirect based on role
                if ($user['role'] == 2) {
                    header("Location: ../_admin_interface/admin.php");
                    exit();
                } elseif ($user['role'] == 1) {
                    header("Location: ../_driver_interface/driver_home.php");
                    exit();
                } else {
                    header("Location: ../_user_interface/user_index.php");
                    exit();
                }
            } else {
                // X Wrong password - Sets session error to trigger frontend popup
                $_SESSION['error'] = "Please check your credentials.";
                header("Location: ../_user_interface/user_signup.php");
                exit();
            }
        } else {
            // X Email not found - Sets session error to trigger frontend popup
            $_SESSION['error'] = "Please check your credentials.";
            header("Location: ../_user_interface/user_signup.php");
            exit();
        }
        
        mysqli_stmt_close($stmt);
        
    } else {
        // Fallback if the database connection or query preparation fails
        $_SESSION['error'] = "System error. Please try again later.";
        header("Location: ../_user_interface/user_signup.php");
        exit();
    }
}
?>