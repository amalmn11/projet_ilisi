<?php
require_once "..\db\connexion.php";

var_dump($_POST);
session_start();
$_SESSION['erreur_form']="";

$id_user = $_SESSION["user_id"];

$titre = $_POST["titre"];
$descr = $_POST['descr'];
$date = $_POST['date'];
$lien = $_POST['lien'];
$type_annonce = $_POST['associerFormation'];
$option_assoc_projet = $_POST['associerProjet'];



$id_projet = isset($_POST['project']) ? $_POST['project'] : NULL;

if ($type_annonce == "Formation") {
    $id_formation = $_POST["formation"];
  } 
  else if ($type_annonce == "autre") {
    $type_annonce = $_POST["autre"];
  } 
//   else ra soit meeting soit evenement

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



$sql = "INSERT INTO annonce (UTILISATEUR_ID,FORMATION_ID,PROJET_ID,ANNONCE_TITRE,ANNONCE_DESCR,TYPE_ANNONCE,DATE_EVENEMENT,LIEN_EVENEMENT,IMAGE,DATE_CREATION) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $bdd->prepare($sql);
$stmt->bindValue(1, $id_user, PDO::PARAM_INT);

if ($type_annonce == "Formation") 
{
    $stmt->bindValue(2, $id_formation, PDO::PARAM_INT);
   
} else 
{
    $stmt->bindValue(2, NULL, PDO::PARAM_NULL);
   
}

if ($option_assoc_projet == "oui" && !empty($id_projet)) 
{
    $stmt->bindValue(3, $id_projet, PDO::PARAM_INT);
} else 
{
    $stmt->bindValue(3, NULL, PDO::PARAM_NULL);
  
}
$stmt->bindValue(4, $titre, PDO::PARAM_STR);
$stmt->bindValue(5, $descr, PDO::PARAM_STR);
$stmt->bindValue(6, $type_annonce, PDO::PARAM_STR);
$stmt->bindValue(7, $date, PDO::PARAM_STR);

if (empty($lien)) {
    $stmt->bindValue(8, NULL, PDO::PARAM_NULL);
    
} 
else {
    $stmt->bindValue(8, $lien, PDO::PARAM_STR);

}

if (empty($file_name)) {
    $stmt->bindValue(9, NULL, PDO::PARAM_NULL);
} 
else {
    $stmt->bindValue(9, $file_name, PDO::PARAM_STR);
}


$stmt->bindValue(10, date('Y-m-d'), PDO::PARAM_STR); // Utilisation correcte de la date actuelle

$ok=$stmt->execute();
if(!$ok) {
    $_SESSION['erreur_form'] = "Erreur lors de l'enregistrement de l'annonce.";
}
$errorInfo = $stmt->errorInfo();
if ($errorInfo[0] !== '00000') {
    echo "Erreur lors de l'exécution de la requête : " . $errorInfo[2];
}

//recuperer l'utilisateur qui a partagé l'annonce
$req_user="SELECT * FROM utilisateur where UTILISATEUR_ID=?";
$stmt = $bdd->prepare($req_user);
$stmt->execute([ $id_user]);
$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
//recuperer tous ls utilisateur sauf celui ayant creé l'annonce
$req_other_user_ids = "SELECT UTILISATEUR_ID FROM utilisateur WHERE UTILISATEUR_ID != ? and ROLE_ID!=1";
$stmt = $bdd->prepare($req_other_user_ids);
$stmt->execute([$id_user]);
$autres_utilisateur_ids = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

// Construction du contenu de la notification
$contenu_notification = "Une nouvelle annonce a été partagée par Le collaborateur " . $utilisateur["NOM"] . " " . $utilisateur["PRENOM"];
// Requête d'insertion de la notification
$requete_insert_notification = "INSERT INTO notification (UTILISATEUR_ID, NOTIF_CONTENUE, TYPE) VALUES (:createur_id, :contenu, :typee)";
$stmt_insert_notification = $bdd->prepare($requete_insert_notification);

foreach ($autres_utilisateur_ids as $user_id) 
{
    $stmt_insert_notification->bindValue(':createur_id', $user_id, PDO::PARAM_INT);
    $stmt_insert_notification->bindValue(':contenu', $contenu_notification, PDO::PARAM_STR);
    $stmt_insert_notification->bindValue(':typee', 'notification', PDO::PARAM_STR);
    $stmt_insert_notification->execute();

    $errorInfo = $stmt_insert_notification->errorInfo();
    if ($errorInfo[0] !== '00000') {
        echo "Erreur lors de l'exécution de la requête : " . $errorInfo[2];
    }
}


//se rediriger vers page initiale
header("location:../../Views/user/ajouter_annonce.php");
exit();
?>
