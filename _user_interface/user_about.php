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
// if (!isset($_SESSION['account_id']) || $_SESSION['role'] != 0 || $_SESSION['is_new_client'] != 0) {
//     header("Location: ../_user_interface/user_signup.php");
//     exit();
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>About Us | GNBTL</title>
    <link rel="icon" type="image/x-icon" href="../images/favicon.jpg">
    <style>
        /* --- General Page Body --- */


        /* Make main content area flexible */
        .main-content {
            flex-grow: 1;
            /* This pushes the footer down */
            background-color: #085508ff;
        }

        /* --- 1. Hero Section --- */
        .hero-section {
            position: relative;
            height: 40vh;
            /* 40% of the viewport height */
            /* Placeholder: Replace with a real image */
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
            background-color: #065706;
        }

        .hero-section::before {
            /* This adds a dark overlay so text is more readable */
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }

        .hero-content {
            position: relative;
            /* Sits on top of the overlay */
            z-index: 1;
        }

        .hero-content h1 {
            font-size: 48px;
            margin: 0;
            font-weight: 700;

        }

        .hero-content p {
            font-size: 20px;
            margin-top: 10px;

        }

        /* --- 2. Two-Column About Section --- */
        .about-layout {
            background-size: cover;
            background-position: center;
            display: flex;
            flex-wrap: wrap;
            /* Allows stacking on mobile */
            align-items: center;
            padding: 60px 5%;
            /* 5% padding on sides */
            max-width: 1200px;
            margin: 0 auto;
            /* Center the layout */
            gap: 40px;
            background-color: #085508ff;
        }

        .about-text {
            flex: 1;
            /* Takes up remaining space */
            min-width: 300px;
            /* Prevents text from getting too squished */
            color: #f9f9f9;
        }

        .about-text h2 {
            font-size: 36px;
            margin-top: 0;
        }

        .about-text p {
            font-size: 18px;
            line-height: 1.6;
            color: #f9f9f9;
        }

        .about-image {
            flex: 1;
            min-width: 300px;
        }

        .about-image img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* --- 3. Trust-Building Section (Values/Why Us) --- */
        .values-section {
            background-color: #f9f9f9;
            /* A light grey background */
            padding: 60px 5%;
            text-align: center;
        }

        .values-section h2 {
            font-size: 36px;
            color: #333;
            margin-bottom: 40px;
        }

        .values-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .value-card {
            flex-basis: 280px;
            /* Each card aims for 280px width */
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .value-card .icon {
            font-size: 48px;
            /* Placeholder for icon */
            color: #009900;
            /* A sample primary color */
            margin-bottom: 15px;
        }

        .value-card h3 {
            font-size: 22px;
            color: #333;
            margin-bottom: 10px;
        }

        .value-card p {
            font-size: 16px;
            line-height: 1.5;
            color: #555;
        }

        /* --- 4. Fleet Showcase Section --- */
        .fleet-showcase {
            padding: 60px 5%;
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }

        .fleet-showcase h2 {
            font-size: 36px;
            color: #f9f9f9;
            margin-bottom: 40px;
        }

        .fleet-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
        }

        .fleet-card {
            flex-basis: 350px;
            /* Each card aims for 350px width */
            border: 1px solid #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            /* Keeps image corners rounded */
            text-align: left;
            background: #ffffff;
        }

        .fleet-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            /* Ensures image covers the area */
        }

        .fleet-card-content {
            padding: 20px;
        }

        .fleet-card-content h3 {
            font-size: 22px;
            color: #333;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .fleet-card-content p {
            font-size: 16px;
            line-height: 1.5;
            color: #555;
        }

        /* --- 5. Call to Action (CTA) Section --- */
        .cta-section {
            /* A strong brand color */
            padding: 60px 5%;
            text-align: center;
            color: #fff;
            background-color: #015a01ff;
        }

        .cta-section h2 {
            font-size: 32px;
            margin-top: 0;
            margin-bottom: 20px;
        }

        .cta-section p {
            font-size: 18px;
            max-width: 600px;
            margin: 0 auto 30px auto;
            line-height: 1.6;
        }

        .cta-button {
            display: inline-block;
            background-color: #fff;
            color: #009900;
            /* Button text color */
            padding: 14px 28px;
            font-size: 18px;
            font-weight: 700;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .cta-button:hover {
            background-color: #f0f0f0;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* --- Your Original Responsive Design --- */
        /* I've adjusted it slightly to work with the new flex layouts */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 32px;
            }

            .hero-content p {
                font-size: 18px;
            }

            /* .about-layout will stack automatically due to flex-wrap */

            .about-text h2,
            .values-section h2,
            .fleet-showcase h2,
            .cta-section h2 {
                font-size: 28px;
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

    <div class="main-content">

        <section class="hero-section">
            <div class="hero-content">
                <h1>About GNBTL</h1>
                <p>Your Partner in Reliable Trucking & Logistics</p>
            </div>
        </section>

        <section class="about-layout">
            <div class="about-text">
                <h2>Who We Are</h2>
                <p>
                    We are a local logistics company providing reliable and efficient delivery services for businesses and individuals. With a dedicated team and well-maintained vehicles, we ensure your goods are transported safely and on time.
                </p>

            </div>
            <div class="about-image">
                <img src="../images/18-wheeler.png" alt="GNBTL Team or Office">
            </div>
        </section>

        <section class="values-section">
            <h2>Why Choose Us?</h2>
            <div class="values-grid">
                <div class="value-card">
                    <div class="icon">✓</div>
                    <h3>Reliability</h3>
                    <p>We deliver on time, every time. Our operations are carefully planned to ensure consistent and dependable service you can trust.</p>
                </div>
                <div class="value-card">
                    <div class="icon">🔒</div>
                    <h3>Safety & Security</h3>
                    <p>Your cargo is our priority. We follow strict handling procedures to keep your goods safe and secure throughout the delivery process.</p>
                </div>
                <div class="value-card">
                    <div class="icon">💬</div>
                    <h3>24/6 Support</h3>
                    <p>We are always ready to assist you. Our support team is available to answer inquiries, provide updates, and ensure smooth coordination whenever you need us.</p>
                </div>
            </div>
        </section>

        <section class="fleet-showcase">
            <h2>Our Modern Fleet</h2>
            <div class="fleet-grid">
                <div class="fleet-card">
                    <img src="../images/18-wheeler.png" alt="18-Wheeler Truck">
                    <div class="fleet-card-content">
                        <h3>Long-Haul Trucks</h3>
                        <p>Equipped for cross-country transport, our 18-wheelers are the backbone of our logistics network.</p>
                    </div>
                </div>
                <div class="fleet-card">
                    <img src="../images/sample_from_online.jpg" alt="">
                    <div class="fleet-card-content">
                        <h3>Professional Team</h3>
                        <p>Our experienced drivers and logistics specialists are committed to delivering excellence in every shipment. We prioritize safety, punctuality, and customer satisfaction.</p>
                    </div>
                </div>
                <div class="fleet-card">
                    <img src="../images/18-wheeler.png" alt="Delivery Van">
                    <div class="fleet-card-content">
                        <h3>Regional Coverage</h3>
                        <p>For last-mile delivery and express cargo</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="cta-section">
            <h2>Ready to Ship With Us?</h2>
            <p>Let's get your cargo moving. Contact us today for a competitive quote and personalized logistics solutions.</p>
            <a href="user_rates.php" class="cta-button">Request a Quote</a>
        </section>

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