<?php 
include 'connection.php'; 

session_start();
$welcomeMessage = '';
if (isset($_SESSION['user_email'], $_SESSION['user_role'], $_SESSION['user_name']) && $_SESSION['user_role'] == 'customer') {
    $welcomeMessage = "Welcome, " . htmlspecialchars($_SESSION['user_name']);
}

// <?php
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
//     

$product_name = '';
$min_price = 0;
$max_price = PHP_INT_MAX;
$results = [];
$searchPerformed = false;

$stmt = $pdo->query("SELECT * FROM product");
$all_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $searchPerformed = true;
    $product_name = $_GET['product_name'] ?? '';
    $min_price = $_GET['min_price'] !== '' ? (float)$_GET['min_price'] : 0;
    $max_price = $_GET['max_price'] !== '' ? (float)$_GET['max_price'] : PHP_INT_MAX;

    $sql = "SELECT * FROM product WHERE p_price BETWEEN :min_price AND :max_price";
    if ($product_name !== '') {
        $sql .= " AND p_name LIKE :product_name";
        $product_name = "%{$product_name}%";
    }

    // <?php
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
//     

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':min_price', $min_price);
    $stmt->bindParam(':max_price', $max_price);
    if ($product_name !== '') {
        $stmt->bindParam(':product_name', $product_name);
    }
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // <?php
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
//     

} elseif (isset($_GET['action']) && $_GET['action'] == 'filter' && !empty($_GET['shortlist'])) {
    $searchPerformed = true;
    $selectedIds = $_GET['shortlist'];
    $placeholders = implode(',', array_fill(0, count($selectedIds), '?'));
    $sql = "SELECT * FROM product WHERE p_id IN ($placeholders)";
    $stmt = $pdo->prepare($sql);
    foreach ($selectedIds as $k => $id) {
        $stmt->bindValue(($k+1), (int) $id, PDO::PARAM_INT);
    }
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $results = $all_products;
}

// $teamName = $_POST['team_name'];
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
// $stmt->execute([$teamName, $playerName]);

// <?php
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
//     
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
        <a class="button" href="vieworders.php">Shopping Basket</a>
        <?php if ($welcomeMessage): ?>
            <a class="button" href="logout.php">logout</a>
            <span class="welcome-message"><?= $welcomeMessage ?></span>
        <?php else: ?>
            <a class="button" href="login.php">Login/Register</a>
        <?php endif; ?>
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
        <section class="products">
            <?php if ($searchPerformed): ?>
                <form action="homepage.php" method="get" class="filter-form">
                    <input type="hidden" name="action" value="filter">
                    <table class="product-table">

                        <thead>
                            <tr>
                                <th><button type="submit" id="shortlist-btn">Filter</button></th>
                                <th>Product ID</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($results as $row):?>

<!-- // if ($_SERVER['REQUEST_METHOD'] === 'POST') 
//     // Retrieve form data
//     $teamName = $_POST['team_name'];
//     $skillLevel = $_POST['skill_level'];
//     $gameDay = $_POST['game_day'];
//     $numberOfPlayers = 0;
//     $username = $_SESSION['username'];

//     $stmt = $pdo->prepare("SELECT COUNT(*) FROM teams WHERE teamName = ?");
//     $stmt->execute([$teamName]);
//     $count = $stmt->fetchColumn();

//     if ($count > 0) {
//         echo "cant add team ,team name already exists.";
//         exit();
//     } -->
                                
                                
                                
                                <tr class="<?= htmlspecialchars($row["p_category"]) ?>">
                                    <td><input type="checkbox" name="shortlist[]" value="<?= $row["p_id"] ?>"></td>
                                    <td><a href="product_details.php?id=<?= $row["p_id"] ?>"><?= $row["p_id"] ?></a></td>
                                    <td><?= $row["p_price"] ?></td>
                                    <td><?= $row["p_category"] ?></td>
                                    <td><?= $row["p_quantity"] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
            <?php else: ?>
                <?php
                foreach ($results as $row): ?>
                    <div class='product'>
                        <a href='product_details.php?id=<?= $row["p_id"] ?>'>
                            <img src='<?= $row["p_photo"] ?>' alt='<?= htmlspecialchars($row["p_name"]) ?>' />
                        </a>
                        <h3><?= htmlspecialchars($row["p_name"]) ?></h3>
                        <p><?= htmlspecialchars($row["p_description"]) ?></p>
                        <p>Price: $<?= htmlspecialchars($row["p_price"]) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

        </main>

    </div>


    <!-- //       require 'connection.php'; 

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


<!-- //       require 'connection.php'; 

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
