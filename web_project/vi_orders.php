<?php
///////*********************************** view order code ************************************************ */
session_start();
include 'connection.php';

if (!isset($_SESSION['user_email'], $_SESSION['customer_id'])) {
    header('Location: login.php');
    exit;
}

$customer_id = $_SESSION['customer_id'];

$stmt = $pdo->prepare("SELECT order_id, date, is_confirmed FROM orders WHERE customer_id = ? ORDER BY date DESC");
$stmt->execute([$customer_id]);
$all_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);



// if ($order) {
//     $order_id = $order['order_id'];

//     // Fetch order items for the latest order
//     $stmt = $pdo->prepare("SELECT oi.p_id, p.p_name, p.p_price, oi.quantity FROM order_items oi JOIN product p ON oi.p_id = p.p_id WHERE oi.order_id = ?");
//     $stmt->execute([$order_id]);
//     $order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
// } else {
//     echo "No orders found.";
//     exit;
// }

if (isset($_GET['action'], $_GET['p_id'], $_GET['order_id']) && $_GET['action'] == 'remove') {
    $product_id_to_remove = $_GET['p_id'];
    $order_id_to_modify = $_GET['order_id'];

    $stmt = $pdo->prepare("DELETE FROM order_items WHERE order_id = ? AND p_id = ?");
    $stmt->execute([$order_id_to_modify, $product_id_to_remove]);

    header('Location: vieworders.php');
    exit;
}


if (isset($_GET['action']) && $_GET['action'] == 'confirm') {
    echo "Thank you for your purchase! Your order ID is: " . $order_id;
    
    exit;
}

/***************************************** */

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

/********************************************** */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Page</title>
    <link rel="stylesheet" href="homepage.css">
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
<div class="container">
        <nav class="sidebar">
            <form action="homepage.php" method="get" class="search-form">
                <input type="text" name="product_name" placeholder="Enter product name">
                <input type="number" name="min_price" placeholder="Min price" min="0">
                <input type="number" name="max_price" placeholder="Max price" min="0">
                <button type="submit" name="search">Search</button>
            </form>
        </nav>
<main>
<h1>Order Details</h1>

<?php foreach ($all_orders as $order): ?>
    <h2>Order ID: <?= htmlspecialchars($order['order_id']) ?> - Date: <?= htmlspecialchars($order['date']) ?> - Status: <?= $order['is_confirmed'] ? "Confirmed" : "Active" ?></h2>
    <table>
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Title</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teamName = $_POST['team_name'];
    $skillLevel = $_POST['skill_level'];
    $gameDay = $_POST['game_day'];
    $username = $_SESSION['username'];
    $oldname = $_POST['namet'];
            }



            $stmt = $pdo->prepare("SELECT oi.p_id, p.p_name, p.p_price, oi.quantity FROM order_items oi JOIN product p ON oi.p_id = p.p_id WHERE oi.order_id = ?");
            $stmt->execute([$order['order_id']]);
            $order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($order_items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['p_id']) ?></td>
                    <td><?= htmlspecialchars($item['p_name']) ?></td>
                    <td>$<?= htmlspecialchars($item['p_price']) ?></td>
                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                    <td>$<?= htmlspecialchars($item['quantity'] * $item['p_price']) ?></td>
                    <td><a href="vieworders.php?action=remove&p_id=<?= $item['p_id'] ?>&order_id=<?= $order['order_id'] ?>">Remove</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endforeach; ?>


</main>
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


<!-- //     if ($result) {
//         header("Location: Dashboard.php");
//         exit();
//     } else {
//         echo "Error updating the team.";
//     }
// } -->