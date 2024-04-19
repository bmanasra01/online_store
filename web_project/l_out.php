<?php
session_start();
session_unset();
session_destroy();
// here i destroy pages
header("Location: login.php");
exit();
?>
