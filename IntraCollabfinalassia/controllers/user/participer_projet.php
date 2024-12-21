<?php

require_once '..\db\connexion.php';
session_start();
//recuperer l'id d'utilisateur concerné
$id_utilisateur=$_SESSION["user_id"];
//recuperer l'id de projet concerné
$id_projet=$_POST["id_projet"];
//recuperer l'id de role choisit
$role_title=$_POST["role_projet"];
$req_role = "SELECT ROLE_PROJET_ID
FROM role_projet
WHERE ROLE_PROJET_TITRE=:role_title";

$stmt_role_projet = $bdd->prepare($req_role);
$stmt_role_projet->bindParam(':role_title', $role_title);
$stmt_role_projet->execute();

$role_projet_id = $stmt_role_projet->fetch(PDO::FETCH_ASSOC);


//la requete d'insertion
$req_participer_projet = "INSERT INTO UTILISATEUR_PROJET (UTILISATEUR_ID, PROJET_ID, ROLE_PROJET_ID) 
                          VALUES (:utilisateur_id, :projet_id, :role_projet_id);";
$stmt_participer_projet = $bdd->prepare($req_participer_projet);
// Liaison des paramètres avec les valeurs
$stmt_participer_projet->bindParam(':utilisateur_id', $id_utilisateur);
$stmt_participer_projet->bindParam(':projet_id', $id_projet);
$stmt_participer_projet->bindParam(':role_projet_id', $role_projet_id["ROLE_PROJET_ID"]);
// Exécution de la requête
$stmt_participer_projet->execute();
header("Location: ..\..\Views\user\details_projet.php");

?>