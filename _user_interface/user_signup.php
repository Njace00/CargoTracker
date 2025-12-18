<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/form.css" />
  <link rel="icon" type="image/x-icon" href="../images/favicon.jpg">
  <title>Login / Sign Up</title>
</head>

<body>


  <a href="user_index.php" class="back-btn">← Back</a>

  <div class="container" id="container">
    <!-- Sign Up -->
    <div class="form-container sign-up-container">
      <form method="POST" action="../__back-end_processes/auth_signup.php">
        <h1>Create Account</h1>
        
        <input type="text" placeholder="Username" name="name" required>
        <input type="text" placeholder="Fullname" name="fname" required>
        <input type="text" placeholder="Company Name" name="cname" required>
        <input type="email" placeholder="Email" name="email" required>
        <input type="password" placeholder="Password" name="password" required>
        <input type="tel" name="number" placeholder="Phone Number (eg, +639123456789)" pattern="\+639\d{9}" title="Please enter a valid Philippine mobile number starting with +639 followed by 9 digits." required
>
        <button type="submit">Sign Up</button>
      </form>
    </div>

    <!-- Sign In -->
    <div class="form-container sign-in-container">
      <form Method="POST" action="../__back-end_processes/auth_login.php">
        <h1>Sign In</h1>
        <div class="social-container">

        </div>
        <span>or use your account</span>
        <p class="error <?php echo isset($_SESSION['error']) ? 'show' : ''; ?>">
          Please check your credentials.
        </p>
        <?php unset($_SESSION['error']); ?>
        <input type="email" placeholder="Email" name="email">
        <input type="password" placeholder="Password" name="password">
        <a href="#" class="text-[#ffffff]">Forgot your password?</a>
        <button type="submit">Sign In</button>

      </form>
    </div>

    <!-- Overlay -->
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h1>Welcome Back!</h1>
          <p>Please login with your personal info</p>
          <button class="ghost yotei" id="signIn">Sign In</button>
        </div>
        <div class="overlay-panel overlay-right">
          <h1></h1>
          <p>Enter your personal details to start your journey with us</p>
          <button class="ghost yotei" id="signUp">Sign Up</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="../js/account.js"></script>
</body>

</html>