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
<!DOC

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="icon" type="image/x-icon" href="../images/favicon.jpg">
        <title>Contact</title>
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
        <!-- CONTACT -->
        <section class="contact-section">
            <h1>Contact Us</h1>

            <form class="contact-form" action="">
                <label for="name">Full Name</label>
                <input type="text" name="" id="name" placeholder="Enter your name" required>

                <label for="email">Enter your Email</label>
                <input type="email" name="" id="email" placeholder="Enter your Email" required>

                <label for="message">Message</label>
                <textarea name="" id="message" placeholder="Type your message..." rows="5" required></textarea>

                <button type="submit" class="contact-btn">Send Message</button>
            </form>
        </section>

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