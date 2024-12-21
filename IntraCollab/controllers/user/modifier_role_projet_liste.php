<?php
//connexion à la base de donnees
session_start();
include '..\..\controllers\db\connexion.php';


//si bouton ajouter est cliqué on recupere les donnees

$utilisateur_id=$_SESSION["user_id"]; //$_SESSION["user_id"]; normalement ?
$new_role_projet=$_POST["new_role_projet"];
$role_projet_id=$_POST["role_projet_id"];
$projet_id=$_POST["projet_id"];


//la requete D'insertion
$req_update="UPDATE utilisateur_projet SET  ROLE_PROJET_ID=? WHERE UTILISATEUR_ID=?
and PROJET_ID=? and ROLE_PROJET_ID=?" ;
//preparer la requete
$stmt_update = $bdd->prepare($req_update);
// Liaison des valeurs aux paramètres de la requête
$stmt_update->bindParam(1, $new_role_projet,PDO::PARAM_INT);
$stmt_update->bindParam(2, $utilisateur_id,PDO::PARAM_INT);
$stmt_update->bindParam(3, $projet_id,PDO::PARAM_INT);
$stmt_update->bindParam(4, $role_projet_id,PDO::PARAM_INT);
// Exécution de la requête
$stmt_update->execute();
//
header("Location:..\..\Views\user\details_projet.php?IDD=$projet_id");


?>