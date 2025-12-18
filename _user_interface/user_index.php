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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/x-icon" href="../images/favicon.jpg">
    <title>Home</title>
    <style>
        /* User dropdown styling */
        .user-dropdown {
            position: relative;
            display: inline-block;
            padding: 0.4rem;
        }

        .user-dropdown button {
            background-color: transparent;
            color: inherit;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
        }

        .user-dropdown button:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        .user-dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 180px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            z-index: 1000;
            margin-top: 5px;
        }

        .user-dropdown:hover .user-dropdown-menu {
            display: block;
        }

        .user-dropdown-menu a,
        .user-dropdown-menu form {
            display: block;
            width: 100%;
        }

        .user-dropdown-menu a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .user-dropdown-menu a:hover {
            background-color: #f1f1f1;
        }

        .user-dropdown-menu .logout-btn {
            width: 100%;
            padding: 12px 16px;
            background-color: transparent;
            border: none;
            text-align: left;
            cursor: pointer;
            color: #d9534f;
            font-size: 16px;
        }

        .user-dropdown-menu .logout-btn:hover {
            background-color: #f1f1f1;
        }

        .username-display {
            margin: 0;
            font-weight: 600;
            color: #009900;
        }
    </style>
</head>

<body>
    <div class="hero">
        <video autoplay muted loop playsinline class="hero-video">
            <source src="../test-vid.mp4" type="video/mp4">
        </video>

        <div class="overlay"></div>

        <h1>GNBTL LOGISTICS</h1>
        <h2>Corporation</h2>
    </div>

    <nav>
        <div class="logo-container">
            <img src="../images/GNBTL logo only.png" alt="Logo">
        </div>

        <div class="navbar-div">
            <a href="user_index.php">Home</a>
            <a href="user_about.php">About Us</a>
            <a href="user_contact.php">Contact</a>
            <a href="user_rate.php">Quote</a>

            <?php if ($logged_in_username): ?>
                <!-- Show username dropdown if logged in -->
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
                <!-- Show Sign In link if not logged in -->
                <a href="../_user_interface/user_signup.php">Sign In</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="content-wrapper">
        <div class="content-overlay">
            <!-- Section 1 -->
            <div class="image-text-section">
                <div class="image-container">
                    <img src="../images/test.png" alt="Truck">
                </div>
                <div class="text-container text-with-title">
                    <h2>Reliable Transportation Services</h2>
                    <p>
                        We provide comprehensive trucking logistics solutions tailored to meet your business needs.
                        Our fleet of modern vehicles ensures safe and timely delivery of your cargo across the nation.
                    </p>
                    <p>
                        With years of experience in the logistics industry, we understand the importance of
                        reliability and efficiency in transportation services.
                    </p>
                </div>
            </div>

            <!-- Section 2 -->
            <div class="image-text-section">
                <div class="text-container text-with-title">
                    <h2>Real-Time Tracking</h2>
                    <p>
                        Stay informed about your shipment's location with our advanced GPS tracking system.
                        Monitor your cargo in real-time and receive instant updates throughout the delivery process.
                    </p>
                    <p>
                        Our technology integration provides complete transparency and peace of mind for all your
                        logistics operations.
                    </p>
                </div>
                <div class="image-container">
                    <img src="../images/highway.png" alt="Warehouse">
                </div>
            </div>

            <!-- Section 3 -->
            <div class="image-text-section">
                <div class="image-container">
                    <img src="../images/sample_from_online.jpg" alt="Team">
                </div>
                <div class="text-container text-with-title">
                    <h2>Professional Team</h2>
                    <p>
                        Our experienced drivers and logistics specialists are committed to delivering excellence
                        in every shipment. We prioritize safety, punctuality, and customer satisfaction.
                    </p>
                    <p>
                        With 24/6 customer support, our team is always ready to assist you with any questions
                        or concerns about your deliveries.
                    </p>
                </div>
            </div>

            <!-- Section 4 -->
            <div class="image-text-section">
                <div class="text-container text-with-title">
                    <h2>Regional Coverage</h2>
                    <p>
                        We operate across regions of region III, VI, and NCR. ensuring your cargo reaches its destination
                        efficiently. Our extensive network allows for flexible routing and competitive pricing.
                    </p>
                    <p>
                        From full truckload to less-than-truckload shipments, we have the capacity and expertise
                        to handle all your transportation needs.
                    </p>
                </div>
                <div class="image-container">
                    <img src="../images/18-wheeler.png" alt="Logistics">
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
</body>

</html>