<?php
require_once "connexion.php";

if(isset($_POST['ok']))
{
    $login=$_POST['login'];
    $pass=$_POST['password'];

    $sql="select * from administrateur where login=:l and password=:pass";
    $st=$bdd->prepare($sql);
    $st->bindValue('l',$login,PDO::PARAM_STR);
    $st->bindValue('pass',$pass,PDO::PARAM_STR);
    $st->execute();

    $row=$st->rowCount();
    if($row>0)
    {
        session_start();
        $_SESSION['auth']=$login;
        unset($_SESSION['error']);
        if(isset($_SESSION['page'])) header('location:'.$_SESSION['page']);
        else header('location:menu.html');
    }else
    {
        session_start();
        $_SESSION['error']="utilisateur n'existe pas";
        header('location:login.php');
    }
}else
{
    $mess="les données ne sont pas transférer";
    header('location:login.php');
}

?>