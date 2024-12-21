<?php


require_once '..\db\connexion.php';
// require_once '..\auth\auth_inc.php';

//la requete pour recuperer les nouvelles donnees saisits
$newNom=$_POST["newNom"];
$newPrenom=$_POST["newPrenom"];
$newDateNaissance=$_POST["newDateNaissance"];
$newTel=$_POST["newTel"];
$newImage=$_POST["newImage"];
$newEmail=$_POST["newEmail"];

//la requete
$req_modif="UPDATE utilisateur SET NOM=?,PRENOM=?,DATE_NAISSANCE=?,TELEPHONE=?,
EMAIL=?,IMAGE=? where UTILISATEUR_ID=?";
//preaparation de la requete
$stmt_modif = $bdd->prepare($req_modif);
$id=1;
// Lier la valeur au paramètre et exécuter la requête
$stmt_modif->bindValue(1,$newNom,PDO::PARAM_STR);
$stmt_modif->bindValue(2,$newPrenom,PDO::PARAM_STR);
$stmt_modif->bindValue(3,$newDateNaissance,PDO::PARAM_STR);
$stmt_modif->bindValue(4,$newTel,PDO::PARAM_STR);
$stmt_modif->bindValue(5,$newEmail,PDO::PARAM_STR);
$stmt_modif->bindValue(6,$newImage,PDO::PARAM_STR);
$stmt_modif->bindValue(7,$id,PDO::PARAM_INT);
$stmt_modif->execute();
//se rediriger vers la page initiale
header("Location:..\..\Views\admin\admin_profile.php");
?>