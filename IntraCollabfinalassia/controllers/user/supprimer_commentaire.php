<?php
require_once '..\db\connexion.php';
// require_once '..\auth\auth_inc.php';

$id=$_GET['id'];
$sql="delete from commentaire where COMMENT_ID=:id ";
$stmt=$bdd->prepare($sql);
$stmt->bindValue(':id',$id,PDO::PARAM_INT);
$stmt->execute();
header('location:..\..\Views\user\details_question.php');
?>
