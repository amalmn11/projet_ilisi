<?php

include '..\..\controllers\db\connexion.php';
session_start();
$user_id=$_SESSION["user_id"];

$requete_maj = "UPDATE notification SET EST_LU = 1 WHERE UTILISATEUR_ID = :user_id";
$stmt_maj = $bdd->prepare($requete_maj);
$stmt_maj->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_maj->execute();


echo $_SESSION['page'];

header('location:'.$_SESSION['page']);

?>