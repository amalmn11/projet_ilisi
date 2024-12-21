<?php
session_start();
unset($_SESSION['auth']);
unset($_SESSION['error']);
session_destroy();
header('location:login.php');
?>