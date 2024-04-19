<?php
$teamName = $_POST['team_name'];
$playerName = $_POST['player_name'];
$stmt = $pdo->prepare("SELECT username, numberofplayers FROM teams WHERE teamName = ?");
$stmt->execute([$teamName]);
$team = $stmt->fetch(PDO::FETCH_ASSOC);

if ($team['username'] !== $_SESSION['username']) {
  exit;
}

if ($team['numberofplayers'] >= 9) {
  exit;
}
$sql = "INSERT INTO players (teamName, player_name) VALUES (?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$teamName, $playerName]);




//********************************* */
include 'connection.php'; 

$product_id = isset($_GET['id']) ? $_GET['id'] : '';

$stmt = $pdo->prepare("SELECT * FROM product WHERE p_id = :id");
$stmt->bindParam(':id', $product_id);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "Product not found";
    exit;
}


/************************************ */

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

    /****************************************** */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Details</title>
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
    <!--  //     if ($team['username'] !== $_SESSION['username']) {
//       echo "Error - You are not authorized to delete this team.";
//       exit;
//     } -->

        <main class = "product-details">
             <img src="<?php echo $product['p_photo']; ?>" alt="<?php echo htmlspecialchars($product['p_name']); ?>" style="float: left;">

            <div class="product-description" style="float: right;">
                <h2><?php echo htmlspecialchars($product['p_name']); ?></h2>
                <p><?php echo htmlspecialchars($product['p_description']); ?></p>
                 <p>Price: $<?php echo htmlspecialchars($product['p_price']); ?></p>
                 <p>Quantity: <?php echo htmlspecialchars($product['p_quantity']); ?></p>
                 <form action="addtoorder.php" method="post">
    <!--  //     if ($team['username'] !== $_SESSION['username']) {
//       echo "Error - You are not authorized to delete this team.";
//       exit;
//     } -->

                    <input type="hidden" name="product_id" value="<?php echo $product['p_id']; ?>">
                     <label for="quantity">Quantity:</label>
                     <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo $product['p_quantity']; ?>" required>
                     <button type="submit" name="add_to_order">Add to order</button>
                </form>
            </div>
        </main>
    </div>

    <!-- //     if ($team['username'] !== $_SESSION['username']) {
//       echo "Error - You are not authorized to delete this team.";
//       exit;
//     }

//     // Add the player to the database
//     $stmt = $pdo->prepare("DELETE FROM teams WHERE teamName = ?");
//     $result = $stmt->execute([$nameT]);

//     header("Location: Dashboard.php"); -->


   
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
