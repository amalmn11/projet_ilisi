<?php
require_once '..\db\connexion.php';
// require_once '..\auth\auth_inc.php';

$id=$_GET['id'];
$sql="delete from categorie where CATEGORIE_ID=:i";
$stmt=$bdd->prepare($sql);
$stmt->bindValue('i',$id,PDO::PARAM_INT);
$stmt->execute();
header('location:..\..\Views\admin\gestion_categorie.php');
?>
