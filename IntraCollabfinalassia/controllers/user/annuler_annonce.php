<?php
require_once '..\db\connexion.php';
// require_once '..\auth\auth_inc.php';

$id=$_GET['IDD'];
$sql="UPDATE annonce SET ANNULE = 1 WHERE ANNONCE_ID =:id ";
$stmt=$bdd->prepare($sql);
$stmt->bindValue(':id',$id,PDO::PARAM_INT);
$stmt->execute();



//!!! supprimer l'image de storage si il existe une
header('location:..\..\Views\user\annonce.php');
?>
