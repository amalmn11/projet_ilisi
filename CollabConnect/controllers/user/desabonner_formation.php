<?php
require_once "..\db\connexion.php";
$id=$_GET['id'];

$sql="delete from utilisateur_formation where FORMATION_ID=:i";
$stm=$bdd->prepare($sql);
$stm->bindValue('i',$id,PDO::PARAM_INT);
$stm->execute();
header('location:..\..\Views\user\formation_projet.php');
?>