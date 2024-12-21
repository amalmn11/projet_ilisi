<?php

session_start();
include '..\..\controllers\db\connexion.php';

//recuperation des données saisits dans le formulaire
$theme=$_POST["theme_formation"];
$descr=$_POST["descr_formation"];
$formateur=$_POST["formateur_formation"];
$date_deb=$_POST["date_deb_formation"];
$date_fin=$_POST["date_fin_formation"];
$deb_inscr=$_POST["date_deb_inscr"];
$fin_inscr=$_POST["date_fin_inscr"];
$volume_horaire=$_POST["volume_horaire_formation"];
$lien=$_POST["lien_formation"];
$user_id=$_SESSION["user_id"];

// Ajouter la nouvelle formation
// Requête préparée d'insertion
$sql_formation = "INSERT INTO formation (UTILISATEUR_ID, THEME, FORMATION_DESCR, FORMATEUR, VOLUME_HORAIRE, FORMATION_LIEN,
FORMATION_DATE_DEBUT, FORMATION_DATE_FIN,DATE_DEB_INSCRIPTION,DATE_FIN_INSCRIPTION) 
        VALUES (:user_id, :theme, :descr, :formateur, :volume_horaire, :lien, :date_deb, :date_fin, :deb_inscr, :fin_insc);";

// Preparation de la requete
$stmt_formation = $bdd->prepare($sql_formation);
$stmt_formation->bindValue(':user_id', $user_id,PDO::PARAM_INT);
$stmt_formation->bindValue(':theme', $theme,PDO::PARAM_STR);
$stmt_formation->bindValue(':descr', $descr,PDO::PARAM_STR);
$stmt_formation->bindValue(':formateur', $formateur,PDO::PARAM_STR);
$stmt_formation->bindValue(':volume_horaire', $volume_horaire,PDO::PARAM_STR);
$stmt_formation->bindValue(':lien', $lien,PDO::PARAM_STR);
$stmt_formation->bindValue(':date_deb', $date_deb,PDO::PARAM_STR);
$stmt_formation->bindValue(':date_fin', $date_fin,PDO::PARAM_STR);
$stmt_formation->bindValue(':deb_inscr', $deb_inscr,PDO::PARAM_STR);
$stmt_formation->bindValue(':fin_insc', $fin_inscr,PDO::PARAM_STR);
$stmt_formation->execute();
$errorInfo = $stmt_formation->errorInfo();
if ($errorInfo[0] !== '00000') {
    echo "Erreur lors de l'exécution de la requête : " . $errorInfo[2];
}




// Si association à annonce is checked
if (isset($_POST['annonce_formation'])) 
{


//traitement d'image
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



        
// Get the ID of the last inserted formation
$last_formation_id = $bdd->lastInsertId();
// Requête préparée d'insertion
///
$sql = "INSERT INTO annonce (UTILISATEUR_ID,FORMATION_ID,PROJET_ID,ANNONCE_TITRE,ANNONCE_DESCR,TYPE_ANNONCE,DATE_EVENEMENT,LIEN_EVENEMENT,IMAGE,DATE_CREATION) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $bdd->prepare($sql);
$stmt->bindValue(1, $user_id, PDO::PARAM_INT);
$stmt->bindValue(2, $last_formation_id, PDO::PARAM_INT);
$stmt->bindValue(3, NULL, PDO::PARAM_NULL);
$stmt->bindValue(4, $theme, PDO::PARAM_STR);
$stmt->bindValue(5, $descr, PDO::PARAM_STR);
$stmt->bindValue(6, "Formation", PDO::PARAM_STR);
$stmt->bindValue(7, $date_deb, PDO::PARAM_STR);
$stmt->bindValue(8, $lien, PDO::PARAM_STR);

if (empty($file_name)) {
    $stmt->bindValue(9, NULL, PDO::PARAM_NULL);
} 
else {
    $stmt->bindValue(9, $file_name, PDO::PARAM_STR);
}
$stmt->bindValue(10, date('Y-m-d'), PDO::PARAM_STR); // Utilisation correcte de la date actuelle
$stmt->execute();


}

//se rediriger vers la page initiale
header("Location: ../../Views/user/formation.php");


?>