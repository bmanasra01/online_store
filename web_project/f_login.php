
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="homepage.css"> 
</head>
<body>

  <!-- if ($team['username'] !== $_SESSION['username']) {
  echo "Error - You are not authorized to add a player to this team.";
  exit;
}

if ($team['numberofplayers'] >= 9) {
  echo "you can not add more then 9 ";
  exit;
} -->

<header>
    <div class="header-logo">
        <img src="Screenshot_2024-01-30_180124-removebg-preview.png" alt="E-Store Logo">
    </div>
    <div class="header-links">
        <a class="button" href="Homepage.php">Home</a>
        <a class="button" href="about.php">About Us</a>
        <a class="button" href="basket.php">Shopping Basket</a>
        <a class="button" href="login.php">Login/Register</a>
    </div>
</header>
    <div class="login-container">
        <form action="authenticate.php" method="post">
            <h2>Login</h2>

            <label for="user-type">I am a:</label>
            <select id="user-type" name="user_type">
                <option value="customer">Customer</option>
                <option value="employee">Employee</option>
            </select>


              <!-- if ($team['username'] !== $_SESSION['username']) {
  echo "Error - You are not authorized to add a player to this team.";
  exit;
}

if ($team['numberofplayers'] >= 9) {
  echo "you can not add more then 9 ";
  exit;
} -->

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>

            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </form>
    </div>

    <!-- if ($team['username'] !== $_SESSION['username']) {
  echo "Error - You are not authorized to add a player to this team.";
  exit;
}

if ($team['numberofplayers'] >= 9) {
  echo "you can not add more then 9 ";
  exit;
} -->
    <footer>     
        <div class="footer-contact">
            <p>Address: Palestine</p>
            <p>Email: palestinestore@gmail.com</p>
            <p>Phone: 1700123123</p>
        </div>
        <div class="footer-nav">
            <ul>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </div>
    </footer>

</body>
</html>
  <!-- if ($team['username'] !== $_SESSION['username']) {
  echo "Error - You are not authorized to add a player to this team.";
  exit;
}

if ($team['numberofplayers'] >= 9) {
  echo "you can not add more then 9 ";
  exit;
} -->