<?php
session_start();

unset($_SESSION['userName']);
unset($_SESSION['role']);
unset($_SESSION['user_id']);
unset($_SESSION['status']);

header("Location: login.php"); 
exit();
?>