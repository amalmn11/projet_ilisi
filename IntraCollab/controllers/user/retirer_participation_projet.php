<?php

// connexion a la base de donnee
require_once '..\db\connexion.php';
session_start();
$id_user= $_SESSION['user_id'];
//recuperer id de projet concerné
$id_projet=$_GET["IDD"];
//requete sql
$req_retirer_participation = "DELETE FROM utilisateur_projet
                               WHERE UTILISATEUR_ID = :utilisateur_id AND PROJET_ID = :projet_id";
// Préparation de la requête
$stmt = $bdd->prepare($req_retirer_participation);
// Liaison des paramètres avec les valeurs
$stmt->bindParam(':utilisateur_id', $id_user);
$stmt->bindParam(':projet_id', $id_projet);
// Exécution de la requête
$stmt->execute();
header("Location: ..\..\Views\user\details_projet.php");

?>