<?php 

session_start();

if(!isset($_SESSION['auth'])) 
{

    header("Location:login.php");
}
else if(isset($_SESSION['admin']))
{
    // header("Location:Views\admin\admin_index.php");
    header("Location:Views\admin\gestion_utilisateur.php");
   
}
// else header("Location:Views\user\user_index.php");
else header("Location:Views\user\profile.php");


?>