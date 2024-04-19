<?php
session_start();
include 'connection.php'; 

$confirmationMessage = '';
$productID = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $p_name = $_POST['p_name'];
    $p_description = $_POST['p_description'];
    $p_category = $_POST['p_category'] ?? 'normal'; 
    $p_price = $_POST['p_price'];
    $p_quantity = $_POST['p_quantity'];
    $p_remarks = $_POST['p_remarks'] ?? ''; 

    
    $target_directory = "uploads/";
    $target_file = $target_directory . basename($_FILES["p_photo"]["name"]);
    $uploadOk = move_uploaded_file($_FILES["p_photo"]["tmp_name"], $target_file);


/*************************************************** */
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $teamName = $_POST['team_name'];
        $skillLevel = $_POST['skill_level'];
        $gameDay = $_POST['game_day'];
        $numberOfPlayers = 0;
        $username = $_SESSION['username'];
    
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM teams WHERE teamName = ?");
        $stmt->execute([$teamName]);
        $count = $stmt->fetchColumn();
    
        if ($count > 0) {
            exit();
        }

    }

    /***************************************************************** */

    if ($uploadOk) {
        
        $stmt = $pdo->prepare("INSERT INTO product (p_name,
         p_description, p_category, p_price, p_quantity, p_remarks, p_photo) VALUES 
         (:p_name, :p_description, :p_category, :p_price, :p_quantity, :p_remarks, :p_photo)");
        $stmt->bindParam(':p_name', $p_name);
        $stmt->bindParam(':p_description', $p_description);
        $stmt->bindParam(':p_category', $p_category);
        $stmt->bindParam(':p_price', $p_price);
        $stmt->bindParam(':p_quantity', $p_quantity);
        $stmt->bindParam(':p_remarks', $p_remarks);
        $stmt->bindParam(':p_photo', $target_file);

        
        $stmt->execute();

        $productID = $pdo->lastInsertId();

        $confirmationMessage = "Product has been successfully added to the database with Product ID: " . $productID;
    } else {
        $confirmationMessage = "Sorry, there was an error uploading your file.";
    }
}
?>
<!-- /*******************************************************************/ */ -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
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
        <a class="button" href="logout.php">Logout</a>
    </div>
</header>

    <div class="add-product-container"> 
        <h1>Add Product</h1>

        <?php
        if (!empty($confirmationMessage)) {
            
            echo "<p class='confirmation-message'>" . $confirmationMessage . "</p>";
        }
        ?>


<!-- require 'connection.php'; // Include the database connection file

      $stmt = $pdo->query("SELECT * FROM teams");     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
       echo "<tr>";
//         echo "<td><a href='team_details.php?teamName={$row['teamName']}'>{$row['teamName']}</a></td>";
//         echo "<td>{$row['skill']}</td>";
//         echo "<td>{$row['numberofplayers']}</td>";
//         echo "<td>{$row['gameday']}</td>";
//         echo "</tr>";
//       }
//      -->

        <form action="add_product.php" method="post" enctype="multipart/form-data">
            <label for="p_name">Product Name:</label>
            <input type="text" id="p_name" name="p_name" required>

            <label for="p_description">Product Description:</label>
            <textarea id="p_description" name="p_description" required></textarea>

            <label for="p_category">Product Category:</label>
            <select id="p_category" name="p_category">
                <option value="new arrival">New Arrival</option>
                <option value="on sale">On Sale</option>
                <option value="featured">Featured</option>
                <option value="high demand">High Demand</option>
                <option value="normal" selected>Normal</option>
            </select>

            <label for="p_price">Price:</label>
            <input type="number" id="p_price" name="p_price" required>

            <label for="p_quantity">Quantity:</label>
            <input type="number" id="p_quantity" name="p_quantity" required>

            <label for="p_remarks">Remarks:</label>
            <input type="text" id="p_remarks" name="p_remarks">

            <label for="p_photo">Product Photo:</label>
            <input type="file" id="p_photo" name="p_photo" required>

            <button type="submit">Add Product</button>

        </form>
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


<!-- // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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