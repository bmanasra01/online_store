<?php
session_start();
include 'connection.php';

//     if ($team['username'] !== $_SESSION['username']) {
//       echo "Error - You are not authorized to delete this team.";
//       exit;
//     }
if (!isset($_SESSION['user_email'], $_POST['add_to_order'])) {
    header('Location: login.php');
    exit;
}
$customer_id = $_SESSION['customer_id'];
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];

//     if ($team['username'] !== $_SESSION['username']) {
//       echo "Error - You are not authorized to delete this team.";
//       exit;
//     }

//     // Add the player to the database
//     $stmt = $pdo->prepare("DELETE FROM teams WHERE teamName = ?");
//     $result = $stmt->execute([$nameT]);

//     header("Location: Dashboard.php");

$stmt = $pdo->prepare("INSERT INTO orders (customer_id, date) VALUES (?, NOW())");
$stmt->execute([$customer_id]);
$order_id = $pdo->lastInsertId();
//     // Add the player to the database
//     $stmt = $pdo->prepare("DELETE FROM teams WHERE teamName = ?");
//     $result = $stmt->execute([$nameT]);
$stmt = $pdo->prepare("INSERT INTO order_items (p_id, quantity, order_id) VALUES (?, ?, ?)");
$stmt->execute([$product_id, $quantity, $order_id]);

$_SESSION['message'] = "Item added to order successfully";
header('Location: product_details.php?id=' . $product_id);
exit;
?>
<!-- // $teamName = $_POST['team_name'];
// $playerName = $_POST['player_name'];
// $stmt = $pdo->prepare("SELECT username, numberofplayers FROM teams WHERE teamName = ?");
// $stmt->execute([$teamName]);
// $team = $stmt->fetch(PDO::FETCH_ASSOC);

// if ($team['username'] !== $_SESSION['username']) {
//   echo "Error - You are not authorized to add a player to this team.";
//   exit;
// }

// if ($team['numberofplayers'] >= 9) {
//   echo "you can not add more then 9 ";
//   exit;
// }
// $sql = "INSERT INTO players (teamName, player_name) VALUES (?, ?)";
// $stmt = $pdo->prepare($sql);
// $stmt->execute([$teamName, $playerName]); -->