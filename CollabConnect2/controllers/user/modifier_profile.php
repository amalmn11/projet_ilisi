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

$_SESSION['image']=$file_name;



//la requete pour recuperer les nouvelles donnees saisits
$newNom=$_POST["newNom"];
$newPrenom=$_POST["newPrenom"];
$newDateNaissance=$_POST["newDateNaissance"];
$newTel=$_POST["newTel"];
$newEmail=$_POST["newEmail"];
$newAdresse=$_POST['newAdresse'];
$newVille=$_POST['newVille'];
$newCodePostal=$_POST['newCodePostal'];
$newPays=$_POST['newPays'];
$newPoste=$_POST['newPoste'];

//la requete
$req_modif="UPDATE utilisateur SET NOM=?,PRENOM=?,DATE_NAISSANCE=?,ADRESSE=?,VILLE=?,CODE_POSTAL=?,PAYS=?,TELEPHONE=?,
EMAIL=?,IMAGE=?,POSTE=? where UTILISATEUR_ID=?";
//preaparation de la requete
$stmt_modif = $bdd->prepare($req_modif);

// Lier la valeur au paramètre et exécuter la requête
$stmt_modif->bindValue(1,$newNom,PDO::PARAM_STR);
$stmt_modif->bindValue(2,$newPrenom,PDO::PARAM_STR);
$stmt_modif->bindValue(3,$newDateNaissance,PDO::PARAM_STR);

$stmt_modif->bindValue(4,$newAdresse,PDO::PARAM_STR);
$stmt_modif->bindValue(5,$newVille,PDO::PARAM_STR);
$stmt_modif->bindValue(6,$newCodePostal,PDO::PARAM_STR);
$stmt_modif->bindValue(7,$newPays,PDO::PARAM_STR);



$stmt_modif->bindValue(8,$newTel,PDO::PARAM_STR);
$stmt_modif->bindValue(9,$newEmail,PDO::PARAM_STR);
$stmt_modif->bindValue(10,$file_name,PDO::PARAM_STR);//traitement d'image , on va met e nom d'image dans la bd
$stmt_modif->bindValue(11,$newPoste,PDO::PARAM_STR);
$stmt_modif->bindValue(12,$id,PDO::PARAM_INT);

$ok=$stmt_modif->execute();
if(!$ok) $_SESSION['modif_erreur'] += "Erreur lors de l'enregistrement des modifications.";
else  $_SESSION['modif_secces'] = "Modification bien effectué.";
//se rediriger vers la page initiale
header("Location:..\..\Views\user\profile.php");
?>