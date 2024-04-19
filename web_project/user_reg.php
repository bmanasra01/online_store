<?php
session_start();


 include 'connection.php';

 function generateCustomerId($pdo) {
    return mt_rand(1000000000, 9999999999); 
}

// <!--  //     if ($team['username'] !== $_SESSION['username']) {
//     //       echo "Error - You are not authorized to delete this team.";
//     //       exit;
//     //     } -->

function insert_customer($customer_info, $account_info, $pdo) {
    try {
        
        $pdo->beginTransaction();

        
        $stmt = $pdo->prepare("INSERT INTO customers (c_name, email, id_number, address, Date_of_Birth, phone, card_id, card_expirationdate, card_name, bank_name, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if (isset($_SESSION['message'])) {
            echo "<p>{$_SESSION['message']}</p>";
            unset($_SESSION['message']);
        }
        
            if ($team['username'] !== $_SESSION['username']) {
              exit;
            }
        
            $stmt = $pdo->prepare("DELETE FROM teams WHERE teamName = ?");
            $result = $stmt->execute([$nameT]);
        
            header("Location: Dashboard.php");
        
        $stmt->execute([
            $customer_info['name'],
            $customer_info['email'],
            $customer_info['id_number'],
            $customer_info['address'],
            $customer_info['date_of_birth'],
            $customer_info['phone'],
            $customer_info['card_number'],
            $customer_info['card_expiry_date'],
            $customer_info['card_name'],
            $customer_info['bank_name'],
            $account_info['username'],
            $account_info['password'] 
        ]);

        
        $pdo->commit();

        // 
//       require 'connection.php'; // Include the database connection file

//       // Retrieve team data from the database
//       $stmt = $pdo->query("SELECT * FROM teams");
//       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//         echo "<tr>";
//         echo "<td><a href='team_details.php?teamName={$row['teamName']}'>{$row['teamName']}</a></td>";
//         echo "<td>{$row['skill']}</td>";
//         echo "<td>{$row['numberofplayers']}</td>";
//         echo "<td>{$row['gameday']}</td>";
//         echo "</tr>";
//       }
//      -->

        
        return $pdo->lastInsertId();

    } catch (Exception $e) {
        
        $pdo->rollBack();
        
        die("Error: " . $e->getMessage());
    }
}







$step = $_SESSION['step'] ?? 1;
$error = '';
$customer_id = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['register_step1'])) {
        
        $_SESSION['customer_info'] = $_POST; 
        $step = 2;
    } elseif (isset($_POST['register_step2'])) {
        
        $_SESSION['account_info'] = $_POST; 
        $step = 3;
    } 
    elseif (isset($_POST['confirm_registration'])) {
        $customer_info = $_SESSION['customer_info'];
        $account_info = $_SESSION['account_info'];
         insert_customer($customer_info, $account_info, $pdo);
         $customer_id= generateCustomerId($pdo);
        $_SESSION = array();
        session_destroy();
        header("Location: login.php?customer_id=" . $customer_id);
        exit();
    }
    
    $_SESSION['step'] = $step;
}

?>

<!-- if (isset($_SESSION['message'])) {
    echo "<p>{$_SESSION['message']}</p>";
    unset($_SESSION['message']);
}

    if ($team['username'] !== $_SESSION['username']) {
      exit;
    }

    $stmt = $pdo->prepare("DELETE FROM teams WHERE teamName = ?");
    $result = $stmt->execute([$nameT]);

    header("Location: Dashboard.php"); -->









<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="homepage.css"> <!-- Link to your CSS file -->
</head>
<body>
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

<div class = "register-container">
<?php if ($step === 1): ?>
    <h2>Customer Information</h2>
    <form method="post">
        Name: <input type="text" name="name" required><br>
        Email: <input type="email" name="email" required><br>
        ID Number: <input type="text" name="id_number" required><br>
        Address: <input type="text" name="address" required><br>
        Date of Birth: <input type="date" name="date_of_birth" required><br>
        Phone: <input type="tel" name="phone" required><br>
        Credit Card Number: <input type="text" name="card_number" required><br>
        Card Expiry Date: <input type="month" name="card_expiry_date" required><br>
        Card Name: <input type="text" name="card_name" required><br>
        Bank Name: <input type="text" name="bank_name" required><br>
        <input type="submit" name="register_step1" value="Continue to Account Creation">
    </form>

<?php elseif ($step === 2): ?>
    <h2>Create Account</h2>
    <form method="post">
        Username: <input type="text" name="username" pattern=".{6,13}" required><br>
        Password: <input type="password" name="password" pattern=".{8,12}" required><br>
        Confirm Password: <input type="password" name="confirm_password" required><br>
        <input type="submit" name="register_step2" value="Confirm Registration">
    </form>

<?php elseif ($step === 3): ?>
    <h2>Confirmation</h2>
    <p>Please confirm your details:</p>
    <!-- Display the customer information for confirmation -->
    <ul>
        <li>Name: <?= htmlspecialchars($_SESSION['customer_info']['name']) ?></li>
        <li>Email: <?= htmlspecialchars($_SESSION['customer_info']['email']) ?></li>
        <!-- Display other information -->
    </ul>
    <form method="post">
        <input type="submit" name="confirm_registration" value="Complete Registration">
    </form>

<?php endif; ?>

<?php if ($customer_id): ?>
    <p>Registration successful! Your customer ID is: <?= $customer_id ?></p>
    <a href="login.php">Click here to login</a>
<?php endif; ?>
</div>
    
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
