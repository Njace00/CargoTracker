<?php
session_start();
include 'db_connect.php';
include 'send_email.php';

// Check if driver is logged in
if (!isset($_SESSION['account_id']) || $_SESSION['role'] != 1) {
    header("Location: ../_user_interface/user_signup.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trip_id = $_POST['trip_id'];
    $driver_name = $_POST['driver_name'];
    $vehicle_name = $_POST['vehicle_name'];

    // Get trip details including contacts (email)
    $trip_query = $conn->prepare("SELECT * FROM trips WHERE trip_id = ?");
    $trip_query->bind_param("i", $trip_id);
    $trip_query->execute();
    $trip_result = $trip_query->get_result();
    $trip_data = $trip_result->fetch_assoc();
    $trip_query->close();

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // 1. Update trip status to "completed"
        $stmt1 = $conn->prepare("UPDATE trips SET status = 'completed' WHERE trip_id = ?");
        $stmt1->bind_param("i", $trip_id);
        $stmt1->execute();
        $stmt1->close();

        // 2. Update ng account is_assigned to 0 and increment trips_completed for the driver
        $stmt2 = $conn->prepare("UPDATE account SET is_assigned = 0, trips_completed = trips_completed + 1 WHERE fullname = ? AND role = 1");
        $stmt2->bind_param("s", $driver_name);
        $stmt2->execute();
        $stmt2->close();

        //Update ng vehicles is_assigned to 0 and increment total_trips for the vehicle
        $stmt3 = $conn->prepare("UPDATE vehicles SET is_assigned = 0, total_trips = total_trips + 1 WHERE vehicle_name = ?");
        $stmt3->bind_param("s", $vehicle_name);
        $stmt3->execute();
        $stmt3->close();

        // Commit transaction
        mysqli_commit($conn);

        // 4. Send email receipt to client using contacts column
        if (!empty($trip_data['contacts'])) {
            $client_email = $trip_data['contacts'];
            $client_name = $trip_data['client']; // Using client field as name

            $subject = "Delivery Completed - Trip #{$trip_id}";

            $body = "
            <p>Hello {$client_name},</p>

            <p>
            We are pleased to inform you that your delivery has been successfully completed.
            </p>

            <p>
            <strong>Trip ID:</strong> {$trip_id}<br>
            <strong>Vehicle:</strong> {$vehicle_name}<br>
            <strong>Driver:</strong> {$driver_name}
            </p>

            <p>
            Your cargo has been safely dropped off at its destination.
            </p>

            <p>
            Thank you for choosing our logistics service.<br>
            If you have any questions or concerns, feel free to contact us.
            </p>

            <p>
            Best regards,<br>
            GNBTL Logistics
            </p>
            ";


            // Send the email
            sendEmail($client_email, $client_name, $subject, $body);
        }

        $conn->close();
        header("Location: ../_driver_interface/driver_Assigned_Job.php?success=marked_complete");
    } catch (Exception $e) {
        // Rollback on error
        mysqli_rollback($conn);
        $conn->close();
        header("Location: ../_driver_interface/driver_Assigned_Job.php?error=update_failed");
    }
    exit();
}
