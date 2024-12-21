<?php


require_once '..\db\connexion.php';
// require_once '..\auth\auth_inc.php';


//user id 
session_start();
$id=$_SESSION['user_id'];
//erreur
$_SESSION['modif_erreur'] ="";

//traitement d'image
$file_name=$_FILES['newImage']['name'];
$tmpname=$_FILES['newImage']['tmp_name'];
$folder = '../../storage/images/'.$file_name;
//--->uploading the image to the folder
if(move_uploaded_file($tmpname, $folder))
{
    $_SESSION['modif_secces'] = "Modification bien effectué.";
}
else
{
     //puisque l'image n'a pas ete telecharger correctement on laisse image par default
    $file_name="default_pfp.jpg";
}


//la requete pour recuperer les nouvelles donnees saisits
$newNom=$_POST["newNom"];
$newPrenom=$_POST["newPrenom"];
$newEmail=$_POST["newEmail"];

//la requete
$req_modif="UPDATE utilisateur SET NOM=?,PRENOM=?,EMAIL=?,IMAGE=? where UTILISATEUR_ID=?";
//preaparation de la requete
$stmt_modif = $bdd->prepare($req_modif);

// Lier la valeur au paramètre et exécuter la requête
$stmt_modif->bindValue(1,$newNom,PDO::PARAM_STR);
$stmt_modif->bindValue(2,$newPrenom,PDO::PARAM_STR);

$stmt_modif->bindValue(3,$newEmail,PDO::PARAM_STR);
$stmt_modif->bindValue(4,$file_name,PDO::PARAM_STR);
$stmt_modif->bindValue(5,$id,PDO::PARAM_INT);

$ok=$stmt_modif->execute();
if(!$ok) $_SESSION['modif_erreur'] += "Erreur lors de l'enregistrement des modifications.";
else  $_SESSION['modif_secces'] = "Modification bien effectué.";
//se rediriger vers la page initiale
header("Location:..\..\Views\admin\admin_profile.php");
?>