<?php
session_start();
include 'connection.php'; 

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$userType = $_POST['user_type'] ?? '';


if (empty($email) || empty($password)) {
    header("Location: login.php?error=emptyfields");
    exit();
}

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Retrieve form data
//     $teamName = $_POST['team_name'];
//     $skillLevel = $_POST['skill_level'];
//     $gameDay = $_POST['game_day'];
//     $username = $_SESSION['username'];
//     $oldname = $_POST['namet'];

//     // Update the team data in the database
//     $stmt = $pdo->prepare("UPDATE teams SET teamName = ?, skill = ?, gameday = ? WHERE teamName = ? And username = ?");
//     $result = $stmt->execute([$teamName, $skillLevel, $gameDay, $oldname,$username]);

//     if ($result) {
//         header("Location: Dashboard.php");
//         exit();
//     } else {
//         echo "Error updating the team.";
//     }
// }

$table = ($userType === 'employee') ? 'employee' : 'customers';

$sql = "SELECT * FROM {$table} WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

<!-- // 
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

if ($user && $password === $user['password']) {
  
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_role'] = $userType; 
    $_SESSION['user_name'] = $user['c_name']; 

    if ($userType == 'customer') {
        $_SESSION['customer_id'] = $user['customer_id']; 

        header('Location: homepage.php');
        exit;
    } elseif ($userType == 'employee') {
        $_SESSION['employee_id'] = $user['employee_id']; 

        header('Location: Employee_page.php');
        exit;
    }
} else {
    
    header("Location: login.php?error=loginfailed");
    exit();
}
?>
<!-- //     if ($result) {
//         header("Location: Dashboard.php");
//         exit();
//     } else {
//         echo "Error updating the team.";
//     }
// } -->