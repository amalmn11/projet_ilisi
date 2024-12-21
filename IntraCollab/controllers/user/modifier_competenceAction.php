<?php
//connexion à la base de donnees
session_start();
include '..\..\controllers\db\connexion.php';


//si bouton ajouter est cliqué on recupere les donnees

$utilisateur_id=$_SESSION["user_id"]; //$_SESSION["user_id"]; normalement ?
$competence_id=$_POST["competence_id"];
$newNiv=$_POST["newNiv"];
//recherche des ids
//1

//2
$req_id_niv="SELECT NIVEAU_ID FROM niveau where NIVEAU_TITRE=?";
$stmt_id_niv=$bdd->prepare($req_id_niv);
$stmt_id_niv->bindParam(1,$newNiv,PDO::PARAM_STR);
$stmt_id_niv->execute();
$niveau_id=$stmt_id_niv->fetch(PDO::FETCH_ASSOC);
//la requete D'insertion
$req_update="UPDATE utilisateur_competence SET  NIVEAU_ID=? WHERE UTILISATEUR_ID=?
and COMPETENCE_ID=?";
//preparer la requete
$stmt_update = $bdd->prepare($req_update);
// Liaison des valeurs aux paramètres de la requête
$stmt_update->bindParam(1, $niveau_id["NIVEAU_ID"],PDO::PARAM_INT);
$stmt_update->bindParam(2, $utilisateur_id,PDO::PARAM_INT);
$stmt_update->bindParam(3, $competence_id,PDO::PARAM_INT);
// Exécution de la requête
$stmt_update->execute();
//
header("Location:..\..\Views\user\profile.php");


?>