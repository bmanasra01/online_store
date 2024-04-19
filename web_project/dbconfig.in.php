<?php
$host = 'localhost';
$dbname = 'web1193186_web_project';
$username = 'web1193186_dbuser';
$password = '406787531';
//echo " sdfffffffffffffffffffffffff "
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo " fffffffffffffffffffffffffffffffffffffffffff" 

} catch (PDOException $e) {
    die("Connection error: " . $e->getMessage());
}

//echo " fdvdzfvbdfbdfbdsbdfbdsb" 

?>
