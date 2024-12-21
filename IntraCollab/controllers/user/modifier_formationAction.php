<?php
//connexion à la base de donnees
session_start();
include '..\..\controllers\db\connexion.php';


//si bouton ajouter est cliqué on recupere les donnees

$utilisateur_id=$_SESSION["user_id"]; //$_SESSION["user_id"]; normalement ?
$formation_id=$_POST["formation_id"];

//recuperation des nouvelle donnees
$theme_formation=$_POST["theme_formation"];
$descr_formation=$_POST["descr_formation"];
$formateur_formation=$_POST["formateur_formation"];
$date_deb_formation=$_POST["date_deb_formation"];
$date_fin_formation=$_POST["date_fin_formation"];
$date_deb_inscription=$_POST["date_deb_inscr"];
$date_fin_inscription=$_POST["date_fin_inscr"];
$volume_horaire_formation=$_POST["volume_horaire_formation"];
$lien_formation=$_POST["lien_formation"];
$etat_formation=$_POST["formation_etat"];


//insertion dans la table formation
$req_modif="UPDATE formation 
SET 
    THEME = :theme_formation,
    FORMATION_DESCR = :descr_formation,
    FORMATEUR = :formateur_formation,
    VOLUME_HORAIRE = :volume_horaire_formation,
    FORMATION_LIEN = :lien_formation,
    FORMATION_DATE_DEBUT = :date_deb_formation,
    FORMATION_DATE_FIN = :date_fin_formation,
    DATE_DEB_INSCRIPTION=:date_deb_inscr,
    DATE_FIN_INSCRIPTION=:date_fin_inscr,
    ETAT_FORMATION =:etat_formation
WHERE 
    FORMATION_ID = :formation_id
    AND UTILISATEUR_ID = :utilisateur_id;";

// Préparation de la requête
$stmt_modif = $bdd->prepare($req_modif);

// Liaison des valeurs
$stmt_modif->bindValue(':theme_formation', $theme_formation);
$stmt_modif->bindValue(':descr_formation', $descr_formation);
$stmt_modif->bindValue(':formateur_formation', $formateur_formation);
$stmt_modif->bindValue(':volume_horaire_formation', $volume_horaire_formation);
$stmt_modif->bindValue(':lien_formation', $lien_formation);
$stmt_modif->bindValue(':date_deb_formation', $date_deb_formation);
$stmt_modif->bindValue(':date_fin_formation', $date_fin_formation);
$stmt_modif->bindValue(':date_deb_inscr',$date_deb_inscription);
$stmt_modif->bindValue(':date_fin_inscr',$date_fin_inscription);
$stmt_modif->bindValue(':etat_formation', $etat_formation);
$stmt_modif->bindValue(':formation_id', $formation_id);
$stmt_modif->bindValue(':utilisateur_id', $utilisateur_id);


// Exécution de la requête de modification
$stmt_modif->execute();

$errorInfo = $stmt_modif->errorInfo();
if ($errorInfo[0] !== '00000') {
    echo "Erreur lors de l'exécution de la requête : " . $errorInfo[2];
}

///////////////// update etat formation
// Requête d'update pour changer l'état des formations
$req_update_etat = "
UPDATE formation
SET ETAT_FORMATION = CASE
    WHEN NOW() < DATE_DEB_INSCRIPTION THEN 'nouvelle'
    WHEN NOW() BETWEEN DATE_DEB_INSCRIPTION AND DATE_FIN_INSCRIPTION THEN 'Ouverte'
    WHEN NOW() > DATE_FIN_INSCRIPTION AND NOW() < FORMATION_DATE_FIN THEN 'fermée'
    WHEN NOW() > FORMATION_DATE_FIN THEN 'Terminée'
    ELSE ETAT_FORMATION
END;
";
 // Préparer et exécuter la requête
 $stmt_update = $bdd->prepare($req_update_etat);
 $stmt_update->execute();
///////////////////


//si on veut l'associer à une annonce
// Si association à annonce is checked
if (isset($_POST['annonce_formation'])) 
{

//traitement d'image pou inserre dans storage
if(isset($_FILES['image'])) 
{   
    if(!empty($_FILES['image']['name']))
    {
         // Un fichier a été téléchargé avec succès
        $file_name=$_FILES['image']['name'];
        $tmpname=$_FILES['image']['tmp_name'];
        $folder = '../../storage/images/'.$file_name;
        //--->uploading the image to the folder
        if(!move_uploaded_file($tmpname, $folder))
        {
            //puisque l'image n'a pas ete telecharger correctement on laisse image par default
            $_SESSION['erreur_form']="Error lors de telechargement d'image. ";
            $file_name ="";
        }
    }
    else  $file_name ="";

}
else  $file_name ="";

//fin traitement d'image

// Requête préparée d'insertion
$sql = "INSERT INTO annonce (UTILISATEUR_ID, FORMATION_ID, TYPE_ANNONCE, PROJET_ID, ANNONCE_TITRE, ANNONCE_DESCR, DATE_EVENEMENT, LIEN_EVENEMENT, IMAGE,DATE_CREATION)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
$stmt = $bdd->prepare($sql);
$stmt->bindValue(1,$utilisateur_id, PDO::PARAM_INT);
$stmt->bindValue(2,$formation_id,PDO::PARAM_INT);
$stmt->bindValue(3,"Formation",PDO::PARAM_STR);
$stmt->bindValue(4,NULL,PDO::PARAM_NULL);
$stmt->bindValue(5,$theme_formation, PDO::PARAM_STR);
$stmt->bindValue(6,$descr_formation, PDO::PARAM_STR);
$stmt->bindValue(7,$date_deb_formation,PDO::PARAM_STR);
$stmt->bindValue(8,$date_fin_formation, PDO::PARAM_STR);
$stmt->bindValue(9,$file_name, PDO::PARAM_STR);
$stmt->bindValue(10, date('Y-m-d'), PDO::PARAM_STR); 

$stmt->execute();

$errorInfo = $stmt->errorInfo();
if ($errorInfo[0] !== '00000') {
    echo "Erreur lors de l'exécution de la requête : " . $errorInfo[2];
}
}
//se rediriger vers la page principale
header("Location:../../Views/user/formation.php");

?>