<?php


session_start();
include '..\..\controllers\db\connexion.php';

$utilisateur_id=$_SESSION["user_id"];
$comment_id=$_POST["comment_id"];
$comment_contenue=$_POST["newComment"];

// Préparer la requête SQL
$requete_modif = "UPDATE commentaire SET COMMENT_CONTENU = :nouveau_contenu
WHERE UTILISATEUR_ID = :utilisateur_id and COMMENT_ID=:comment_id";
$stmt_modif = $bdd->prepare($requete_modif);
// Liaison des paramètres
$stmt_modif->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
$stmt_modif->bindParam(':nouveau_contenu', $comment_contenue, PDO::PARAM_STR);
$stmt_modif->bindParam(':utilisateur_id', $utilisateur_id, PDO::PARAM_INT);
// Executer la requete
$stmt_modif->execute();

//se rediriger vers la page initiale
header("Location:../../Views/user/details_question.php");

?>