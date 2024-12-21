<?php
require_once "..\db\connexion.php";
session_start();
$user_id = $_SESSION['user_id'];
$id=$_GET['id'];
$role=$_GET['role'];
$sql="delete from utilisateur_projet where PROJET_ID=:i and ROLE_PROJET_ID=:r and UTILISATEUR_ID = :u";
$stm=$bdd->prepare($sql);
$stm->bindValue('i',$id,PDO::PARAM_INT);
$stm->bindValue('r',$role,PDO::PARAM_INT);
$stm->bindValue('u',$user_id,PDO::PARAM_INT);
$stm->execute();
header('location:..\..\Views\user\profile.php');

?>