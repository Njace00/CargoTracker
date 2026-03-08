<?php
session_start();
include '../__back-end_processes/db_connect.php';

// Get logged-in user's information if they are logged in
$logged_in_username = null;
if (isset($_SESSION['account_id'])) {
    $account_id = $_SESSION['account_id'];
    $query = "SELECT username FROM account WHERE account_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $account_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $logged_in_username = $row['username'];
    }
    $stmt->close();
}
// Only allow verified clients (role = 0, is_new_client = 0)
if (!isset($_SESSION['account_id']) || $_SESSION['role'] != 0 || $_SESSION['is_new_client'] != 0) {
    header("Location: ../_user_interface/user_signup.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GNBTL Reservation</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/x-icon" href="../images/favicon.jpg">
    <style>
        @media (max-width: 768px) {
            .calculator-container {
                padding: 2rem 1.5rem;
            }

            .calculator-title {
                font-size: 1.5rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .main-content {
            flex-grow: 1;
            padding-top: 40px;
            padding-bottom: 60px;
        }

        .quote-page-layout {
            display: flex;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto;
            gap: 40px;
            padding: 0 5%;
        }

        .quote-form-container {
            flex: 2;
            min-width: 300px;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .quote-form-container h1 {
            font-size: 36px;
            color: #333;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .quote-form-container .subtitle {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
        }

        .quote-form fieldset {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .quote-form legend {
            font-size: 20px;
            font-weight: 600;
            color: #009900;
            padding: 0 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="tel"],
        .form-group input[type="date"],
        .form-group input[type="number"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #009900;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 86, 179, 0.2);
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .form-row .form-group {
            flex: 1;
            min-width: 200px;
        }

        .submit-button {
            display: block;
            width: 100%;
            padding: 15px;
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            background-color: #009900;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-button:hover {
            background-color: #004a99;
        }

        .quote-sidebar {
            flex: 1;
            min-width: 300px;
        }

        .sidebar-widget {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .sidebar-widget h3 {
            font-size: 22px;
            color: #333;
            margin-top: 0;
            margin-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }

        .sidebar-widget ul {
            list-style: none;
            padding-left: 0;
            margin: 0;
        }

        .sidebar-widget ul li {
            font-size: 16px;
            color: #555;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .sidebar-widget ul li::before {
            content: '✓';
            font-weight: 700;
            color: #009900;
            margin-right: 12px;
            font-size: 18px;
        }

        .sidebar-widget p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }

        @media (max-width: 900px) {
            .quote-page-layout {
                flex-direction: column-reverse;
            }
        }
    </style>
</head>

<body>
    <nav>
        <div class="logo-container">
            <img src="../images/GNBTL logo only.png" alt="Logo">
        </div>

        <div class="navbar-div">
            <a href="user_index.php">Home</a>
            <a href="user_about.php">About Us</a>
            <a href="user_contact.php">Contact</a>
            <a href="user_rate.php">Reservation</a>

            <?php if ($logged_in_username): ?>
                <div class="user-dropdown">
                    <button>
                        <span class="username-display"><?php echo htmlspecialchars($logged_in_username); ?></span> &#9660;
                    </button>
                    <div class="user-dropdown-menu">
                        <form action="../__back-end_processes/auth_logout.php" method="POST">
                            <button type="submit" class="logout-btn">Log Out</button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <a href="../_user_interface/user_signup.php">Sign In</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="main-content">
        <div class="quote-page-layout">

            <div class="quote-form-container">
                <h1>Book Your Shipment</h1>
                <p class="subtitle">Reserve your trucking service with GNBTL. Complete the form below to confirm your booking, and we'll handle the rest.</p>

                <?php if (isset($_SESSION['error'])): ?>
                    <div style="padding: 15px; background: #ffebee; color: #c62828; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #c62828;">
                        <?php 
                        echo htmlspecialchars($_SESSION['error']); 
                        unset($_SESSION['error']);
                        ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div style="padding: 15px; background: #e8f5e9; color: #2e7d32; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #2e7d32;">
                        <?php 
                        echo htmlspecialchars($_SESSION['success']); 
                        unset($_SESSION['success']);
                        ?>
                    </div>
                <?php endif; ?>

                <form action="../__back-end_processes/process_reservation.php" method="POST" class="quote-form">

                    <fieldset>
                        <legend>Reservation Details</legend>

                        <div class="form-group">
                            <label for="reservation-date">Date of Reservation</label>
                            <input type="date" id="reservation-date" name="reservation_date" required>
                        </div>

                        <div class="form-group">
                            <label for="company-name">Name of the Company</label>
                            <input type="text" id="company-name" name="company_name" placeholder="Enter company name" required>
                        </div>

                        <div class="form-group">
                            <label for="contact-number">Contact Number</label>
                            <input type="tel" id="contact-number" name="contact-number" required>
                        </div>

                        <div class="form-group">
                            <label for="email-address">Email Address</label>
                            <input type="email" id="email-address" name="email-address" required>
                        </div>

                        <div class="form-group">
                            <label for="shipment">Shipment</label>
                            <textarea id="shipment" name="shipment" rows="4" placeholder="Describe your shipment (type, quantity, weight, etc.)" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="address-destination">Address/Destination</label>
                            <textarea id="address-destination" name="address_destination" rows="4" placeholder="Enter complete delivery address and destination" required></textarea>
                        </div>
                    </fieldset>

                    <button type="submit" class="submit-button">Confirm Reservation</button>

                </form>
            </div>

            <div class="quote-sidebar">
                <div class="sidebar-widget">
                    <h3>Reservation Benefits</h3>
                    <ul>
                        <li>Guaranteed Pickup Time</li>
                        <li>Priority Scheduling</li>
                        <li>Dedicated Support Team</li>
                        <li>Real-Time Shipment Tracking</li>
                        <li>Flexible Rescheduling Options</li>
                    </ul>
                </div>

                <div class="sidebar-widget">
                    <h3>Reservation Process</h3>
                    <p>
                        <strong>1. Submit Reservation:</strong> Fill out the form with your shipment details and preferred pickup time.
                    </p>
                    <p>
                        <strong>2. Instant Confirmation:</strong> You'll receive an email confirmation with your reservation reference number within minutes.
                    </p>
                    <p>
                        <strong>3. Pickup & Delivery:</strong> Our driver will arrive at your specified time and location to complete your shipment safely.
                    </p>
                </div>

                <div class="sidebar-widget">
                    <h3>Need Help?</h3>
                    <p>
                        Our customer service team is available 24/6 to assist with your reservation. Call us at <strong>(02) 1234-5678</strong> or email <strong>reservations@gnbtl.com</strong>
                    </p>
                </div>
            </div>

        </div>
    </div>

    <footer>
        <div>
            <h1>GNBTL</h1>
        </div>

        <div>
            <p>Trucking Logistics</p>
        </div>

        <div class="footer-grid">
            <p>Providing reliable trucking and logistics services across the nation. Our commitment to excellence
                ensures your cargo arrives safely and on time, every time.</p>
            <p>With modern fleet management and real-time tracking, we offer transparency and efficiency in all
                our operations. Trust us for your transportation needs.</p>
            <p>Our professional team is available 24/7 to assist you with quotes, tracking, and any logistics
                inquiries. Customer satisfaction is our top priority.</p>
            <p>Contact us today to learn more about our competitive rates and comprehensive logistics solutions
                tailored to your business requirements.</p>
        </div>

        <hr>

        <div class="footer-copyright">
            <p>@GNBTL</p>
            <p>All Rights Reserved</p>
        </div>
    </footer>

    <script>
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('reservation-date').setAttribute('min', today);
    </script>

</body>

</html>