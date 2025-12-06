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
    <title>GNBTL Rate Calculator</title>
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
                    <div class="user-dropdown-menu"
                        <form action="../_admin_interface/auth_logout.php" method="post">
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

    <div class="calculator-container">
        <h2 class="calculator-title">Calculate Your Shipping Rate</h2>
        
        <form class="calculator-form" id="rateForm">
            
            <!-- Point A -->
            <div class="location-section point-a">
                <div class="section-title">Point A - Pickup Location</div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="regionA">Region</label>
                        <select name="regionA" id="regionA" required>
                            <option value="">Select Region</option>
                            <option value="NCR">NCR (National Capital Region)</option>
                            <option value="Region3">Region 3 (Central Luzon)</option>
                            <option value="Region4">Region 4 (CALABARZON)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cityA">City/Area</label>
                        <select name="cityA" id="cityA" required disabled>
                            <option value="">Select Region First</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Point B -->
            <div class="location-section point-b">
                <div class="section-title">Point B - Delivery Location</div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="regionB">Region</label>
                        <select name="regionB" id="regionB" required>
                            <option value="">Select Region</option>
                            <option value="NCR">NCR (National Capital Region)</option>
                            <option value="Region3">Region 3 (Central Luzon)</option>
                            <option value="Region4">Region 4 (CALABARZON)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cityB">City/Area</label>
                        <select name="cityB" id="cityB" required disabled>
                            <option value="">Select Region First</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Truck Section -->
            <div class="truck-section">
                <div class="form-row">
                    <div class="form-group">
                        <label for="load_size">Load Size</label>
                        <select name="load_size" id="load_size" required>
                            <option value="">Select Size</option>
                            <option value="2">2-tonner</option>
                            <option value="5">5-tonner</option>
                            <option value="10">10-tonner</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="truck_count">Truck(s) Needed</label>
                        <select name="truck_count" id="truck_count" required>
                            <option value="">Select Number</option>
                            <option value="1">1 Truck</option>
                            <option value="multiple">Multiple Trucks (Contact Us)</option>
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="calculate-btn">Calculate Rate</button>
        </form>

        <!-- Results Section -->
        <div class="result-section" id="resultSection">
            <h3 class="result-title">Estimated Price Breakdown</h3>
            <div class="breakdown-item">
                <span>Route</span>
                <span id="routeDisplay">-</span>
            </div>
            <div class="breakdown-item">
                <span>Distance</span>
                <span id="distanceDisplay">0 km</span>
            </div>
            <div class="breakdown-item">
                <span>Base Rate (per km)</span>
                <span id="baseRateDisplay">₱ 0.00</span>
            </div>
            <div class="breakdown-item">
                <span>Truck Size Fee</span>
                <span id="truckFeeDisplay">₱ 0.00</span>
            </div>
            <div class="breakdown-item">
                <span>Area Surcharge</span>
                <span id="surchargeDisplay">₱ 0.00</span>
            </div>
            <div class="breakdown-item total">
                <span>Total Estimated Cost</span>
                <span id="totalDisplay">₱ 0.00</span>
            </div>
            <p class="disclaimer">*Final price may vary based on actual road conditions and additional services</p>
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
        // Location data with cities per region
        const locations = {
            NCR: [
                'Manila', 'Quezon City', 'Makati', 'Pasig', 'Taguig', 
                'Mandaluyong', 'Pasay', 'Caloocan', 'Las Piñas', 
                'Muntinlupa', 'Parañaque', 'Valenzuela', 'Malabon', 
                'Navotas', 'San Juan', 'Marikina', 'Pateros'
            ],
            Region3: [
                'Angeles City', 'San Fernando (Pampanga)', 'Mabalacat', 
                'Olongapo', 'Tarlac City', 'Cabanatuan', 'San Jose (Nueva Ecija)',
                'Balanga', 'Gapan', 'Meycauayan', 'San Jose del Monte', 
                'Malolos', 'Baliuag'
            ],
            Region4: [
                'Calamba', 'Batangas City', 'Lipa', 'San Pablo', 
                'Lucena', 'Antipolo', 'Bacoor', 'Dasmariñas', 
                'Imus', 'Cavite City', 'Santa Rosa', 'Biñan', 
                'Tagaytay', 'Tanauan', 'Calapan'
            ]
        };

        // Comprehensive distance matrix (in km) - based on actual road distances
    

        // Pricing structure
        const baseRatePerKm = 30; // ₱30 per km
        
        // Truck size fees (base fee + per km multiplier)
        const truckPricing = {
            '2': { baseFee: 800, multiplier: 1.0 },    // 2-tonner: base pricing
            '5': { baseFee: 1500, multiplier: 1.3 },   // 5-tonner: +30% per km
            '10': { baseFee: 2500, multiplier: 1.6 }   // 10-tonner: +60% per km
        };
        
       

        // Populate city dropdown based on region selection
        function populateCities(regionSelect, citySelect) {
            regionSelect.addEventListener('change', function() {
                const region = this.value;
                citySelect.innerHTML = '<option value="">Select City/Area</option>';
                
                if (region && locations[region]) {
                    citySelect.disabled = false;
                    locations[region].forEach(city => {
                        const option = document.createElement('option');
                        option.value = city;
                        option.textContent = city;
                        citySelect.appendChild(option);
                    });
                } else {
                    citySelect.disabled = true;
                }
            });
        }

        // Initialize dropdowns
        populateCities(document.getElementById('regionA'), document.getElementById('cityA'));
        populateCities(document.getElementById('regionB'), document.getElementById('cityB'));


        
        

    </script>

</body>
</html>