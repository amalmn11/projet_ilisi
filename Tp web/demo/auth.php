<?php
$login = $_POST['login'];
$pass = $_POST['pass'];

session_start();
if($login == 'ilisi' && $pass == '1234')
{
   
    //en general on le donne la valeur de login
    $_SESSION['auth']= $login;
    unset($_SESSION['erreur']);
    if(isset($_SESSION['page'])) header("location:".$_SESSION['page']);
    else header("location:page1.php");
}
else 
{
    //de bien de creer un variable pour ajouter l'erreur commet
    $_SESSION['erreur']="Votre login ou mot de passe incorect";
    header("location:form.php");
}

?>