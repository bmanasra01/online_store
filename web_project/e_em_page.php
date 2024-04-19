
<?php  
include 'connection.php'; 

session_start();


if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

//     require 'connection.php'; 

//     session_start();
//     if (isset($_SESSION['username'])) { 
//       $username = $_SESSION['username'];
//     }

// // Retrieve team information from the form data
//     $nameT = $_POST['name_team'];

//     $stmt = $pdo->prepare("SELECT username FROM teams WHERE teamName = ?");
//     $stmt->execute([$nameT]);
//     $team = $stmt->fetch(PDO::FETCH_ASSOC);



//     if ($team['username'] !== $_SESSION['username']) {
//       echo "Error - You are not authorized to delete this team.";
//       exit;
//     }

//     // Add the player to the database
//     $stmt = $pdo->prepare("DELETE FROM teams WHERE teamName = ?");
//     $result = $stmt->execute([$nameT]);

//     header("Location: Dashboard.php");



$userRole = $_SESSION['user_role'] ?? 'guest'; 


$product_name = '';
$min_price = 0;
$max_price = PHP_INT_MAX;
$results = [];
$searchPerformed = false;

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $searchPerformed = true;
    $product_name = isset($_GET['product_name']) ? $_GET['product_name'] : '';
    $min_price = isset($_GET['min_price']) && $_GET['min_price'] !== '' ? (float)$_GET['min_price'] : 0;
    $max_price = isset($_GET['max_price']) && $_GET['max_price'] !== '' ? (float)$_GET['max_price'] : PHP_INT_MAX;

    $sql = "SELECT * FROM product WHERE p_price >= :min_price AND p_price <= :max_price";
    if (!empty($product_name)) {
        $sql .= " AND p_name LIKE :product_name";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':min_price', $min_price);
    $stmt->bindParam(':max_price', $max_price);
    if (!empty($product_name)) {
        $product_name = "%{$product_name}%";
        $stmt->bindParam(':product_name', $product_name);
    }
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

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
// $stmt->execute([$teamName, $playerName]);

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



<!-- Employee Page  -->
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
    <a class="button" href="Employee_page.php">Home</a>
        <a class="button" href="about.php">About Us</a>
        <a class="button" href="basket.php">Shopping Basket</a>
        <a class="button" href="logout.php">logout</a>
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

                <a class="button" href="add_product.php">Add New Product</a>
                <a class="button" href="edit_product.php">Edit Product </a>
                <a class="button" href="view_order.php">View an order</a>

        </nav>

        <main>
        <section class="products">
            <?php
            if ($searchPerformed) {
                if (empty($results)) {
                    echo "<p>No products found matching your criteria.</p>";
                } else {
                    foreach ($results as $row) {
                        echo "<div class='product'>";
                       echo "<img src='" . $row["p_photo"] . "' alt='" . htmlspecialchars($row["p_name"]) . "' />";
                        echo "<h3>" . htmlspecialchars($row["p_name"]) . "</h3>";
                        echo "<p>" . htmlspecialchars($row["p_description"]) . "</p>";
                        echo "<p>Price: $" . htmlspecialchars($row["p_price"]) . "</p>";
                        echo "</div>";


                    }
                }
            } 


            // if ($_SERVER['REQUEST_METHOD'] === 'POST') 
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
            
            
            
            else {
                // Display all products
                $stmt = $pdo->query("SELECT * FROM product");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='product'>";
                    echo "<a href='product_details.php?id=" . $row["p_id"] . "'>"; // Assuming 'id' is your product ID
                    echo "<img src='" . $row["p_photo"] . "' alt='" . htmlspecialchars($row["p_name"]) . "' />";
                    echo "</a>";
                    echo "<h3>" . htmlspecialchars($row["p_name"]) . "</h3>";
                    echo "<p>" . htmlspecialchars($row["p_description"]) . "</p>";
                    echo "<p>Price: $" . htmlspecialchars($row["p_price"]) . "</p>";
                    echo "</div>";

                }
            }
            ?>
        </section>
    </main>
    </div>
    <footer>     
        <div class="footer-contact">
            <p>Address: Palestine</p>
            <p>Email: palestine_store@gmail.com</p>
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