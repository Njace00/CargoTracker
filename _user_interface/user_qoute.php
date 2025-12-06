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
    <link rel="stylesheet" href="../css/style.css"> <title>Request a Quote | GNBTL</title>
    <link rel="icon" type="image/x-icon" href="../images/favicon.jpg">
    <style>
        /* --- General Page Body --- */
        

        .main-content {
            flex-grow: 1;
            padding-top: 40px;
            padding-bottom: 60px;
        }

        /* --- Main Quote Page Layout --- */
        .quote-page-layout {
            display: flex;
            flex-wrap: wrap; /* Allows stacking on mobile */
            max-width: 1200px;
            margin: 0 auto;
            gap: 40px; /* Space between form and sidebar */
            padding: 0 5%;
        }

        /* --- 1. Form Container (Left Side) --- */
        .quote-form-container {
            flex: 2; /* Form takes 2/3 of the space */
            min-width: 300px; /* Prevents it from getting too small */
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
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

        /* --- Form Styling --- */
        .quote-form fieldset {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .quote-form legend {
            font-size: 20px;
            font-weight: 600;
            color: #009900; /* Brand color */
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
            box-sizing: border-box; /* Important for padding to work */
            transition: border-color 0.3s;
        }
        
        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #009900; /* Highlight on focus */
            outline: none;
            box-shadow: 0 0 5px rgba(0,86,179,0.2);
        }
        
        /* Utility for side-by-side fields */
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .form-row .form-group {
            flex: 1;
            min-width: 200px; /* Fields will stack if space is tight */
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

        /* --- 2. Sidebar (Right Side) --- */
        .quote-sidebar {
            flex: 1; /* Sidebar takes 1/3 of the space */
            min-width: 300px;
        }

        .sidebar-widget {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
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
            content: '✓'; /* Simple icon */
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

        /* --- Responsive Design --- */
        @media (max-width: 900px) {
            .quote-page-layout {
                flex-direction: column-reverse; /* Stacks sidebar on top on mobile */
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
            
            <div class="dropdown">
                <button>Rates&#9660;</button>
                <div class="dropdown-menu">
                    <a href="user_qoute.php">Request a Quote</a>
                    <a href="user_rate.php">Rate Calculator</a>
                </div>  
            </div>
            
            <div class="dropdown">
                <button>Cargo&#9660;</button>
                <div class="dropdown-menu">
                    <a href="user_tracker.php">Track your Delivery</a>
                    <a href="#">Contact Courier</a>
                </div>  
            </div>
            
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
        <div class="quote-page-layout">

            <div class="quote-form-container">
                <h1>Request a Quote</h1>
                <p class="subtitle">Get a free, no-obligation quote for your shipping needs. Fill out the form below, and one of our logistics specialists will contact you shortly.</p>

                <form action="process_quote.php" method="POST" class="quote-form">

                    <fieldset>
                        <legend>1. Contact Information</legend>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first-name">First Name</label>
                                <input type="text" id="first-name" name="first_name" required>
                            </div>
                            <div class="form-group">
                                <label for="last-name">Last Name</label>
                                <input type="text" id="last-name" name="last_name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="company-name">Company Name (Optional)</label>
                            <input type="text" id="company-name" name="company_name">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" required>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>2. Shipment Details</legend>
                        
                        <div class="form-group">
                            <label for="pickup-address">Pickup Address</label>
                            <textarea id="pickup-address" name="pickup_address" rows="3" placeholder="Enter street, city, and zip code" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="destination-address">Destination Address</label>
                            <textarea id="destination-address" name="destination_address" rows="3" placeholder="Enter street, city, and zip code" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="pickup-date">Requested Pickup Date</label>
                            <input type="date" id="pickup-date" name="pickup_date" required>
                        </div>
                    </fieldset>

                    <button type="submit" class="submit-button">Get My Quote</button>

                </form>
            </div>

            <div class="quote-sidebar">
                <div class="sidebar-widget">
                    <h3>Why Ship with GNBTL?</h3>
                    <ul>
                        <li>Reliable, On-Time Delivery</li>
                        <li>Competitive & Transparent Pricing</li>
                        <li>Real-Time GPS Tracking</li>
                        <li>24/7 Customer Support</li>
                        <li>Modern, Well-Maintained Fleet</li>
                    </ul>
                </div>
                
                <div class="sidebar-widget">
                    <h3>What Happens Next?</h3>
                    <p>
                        <strong>1. Submit Your Form:</strong> Once you send your request, our system logs it instantly.
                    </p>
                    <p>
                        <strong>2. We Process Your Request:</strong> Once we receive your requested quote, we will email you within one business hour.
                    </p>
                    <p>
                        <strong>3. We Contact You:</strong> One of our representatives will call or email you within one business hour to discuss your quote and next steps.
                    </p>
                </div>
            </div>

        </div> </div> <footer>
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