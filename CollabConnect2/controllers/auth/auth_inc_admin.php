<?php 
session_start();

if(!isset($_SESSION['auth'])) 
{

    header("Location:login.php");
}
if(!isset($_SESSION['admin']))
{
    header("Location:user_index.php");
}

?>


