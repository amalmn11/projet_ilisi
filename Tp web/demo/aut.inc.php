<?php 
//toujours demarer la session lorsqu'on travail avec les session
session_start();
//verifier si la variable de session auh n'existe pas il faut allez au formulaire
if(!isset($_SESSION['auth'])) 
{
    $_SESSION['page']=$_SERVER['REQUEST_URI'];
    header("location:form.php");
}




?>