<?php
// Configuration et connexion à la base de données
//connexion à la base de donnees
session_start();
include '..\..\controllers\db\connexion.php';



    $annonceId = $_POST['annonce_id']; // Assurez-vous d'avoir l'ID de l'annonce dans votre formulaire
    $oldImage = $_POST['oldImage'];
    echo 'voila'. $oldImage .'<br>';

    //traitement d'image
    if (isset($_FILES['newImage']) && $_FILES['newImage']['error'] == UPLOAD_ERR_OK) 
    {
        $newImage = $_FILES['newImage'];
        $imageName = time() . '_' . $newImage['name'];
        $uploadDir = '../../storage/images/';
        $uploadFile = $uploadDir . basename($imageName);

        // Déplacer le fichier téléchargé vers le répertoire de stockage
        if (move_uploaded_file($newImage['tmp_name'], $uploadFile)) {
           
            // Mise à jour de l'annonce avec la nouvelle image
            $sql = "UPDATE annonce SET IMAGE = ? WHERE ANNONCE_ID = ?";
            $stmt = $bdd->prepare($sql);
            $stmt->bindParam(1, $imageName,PDO::PARAM_STR);
            $stmt->bindParam(2, $annonceId,PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Suppression de l'ancienne image si elle existe
                if ($oldImage) {
                    
                    $image_path = "../../storage/images/$oldImage";
                    unlink($image_path);
                    echo "Image suuprimer avec succès.";
                }
                echo "Image mise à jour avec succès.";
            } else {
                echo "Erreur lors de la mise à jour de l'image ";
                $errorInfo = $stmt->errorInfo();
                if ($errorInfo[0] !== '00000') {
                    echo "Erreur lors de l'exécution de la requête : " . $errorInfo[2];
                }
            }

        } else {
            echo "Erreur lors du téléchargement du fichier.";
        }
    } else {
        echo "Aucune nouvelle image sélectionnée ou erreur de téléchargement.";
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    //la suite de modification

    
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



$req = "UPDATE annonce SET 
FORMATION_ID = ? ,
PROJET_ID = ? ,
ANNONCE_TITRE=? ,
ANNONCE_DESCR = ?,
TYPE_ANNONCE= ?,
DATE_EVENEMENT =?,
LIEN_EVENEMENT=?
WHERE ANNONCE_ID = ?";
$stmt_annonce = $bdd->prepare($req);


if ($type_annonce == "Formation") 
{
    $stmt_annonce->bindValue(1, $id_formation, PDO::PARAM_INT);
   
} else 
{
    $stmt_annonce->bindValue(1, NULL, PDO::PARAM_NULL);
   
}

if ($option_assoc_projet == "oui" && !empty($id_projet)) 
{
    $stmt_annonce->bindValue(2, $id_projet, PDO::PARAM_INT);
} else 
{
    $stmt_annonce->bindValue(2, NULL, PDO::PARAM_NULL);
  
}
$stmt_annonce->bindValue(3, $titre, PDO::PARAM_STR);
$stmt_annonce->bindValue(4, $descr, PDO::PARAM_STR);
$stmt_annonce->bindValue(5, $type_annonce, PDO::PARAM_STR);
$stmt_annonce->bindValue(6, $date, PDO::PARAM_STR);

if (empty($lien)) {
    $stmt_annonce->bindValue(7, NULL, PDO::PARAM_NULL);
    
} 
else {
    $stmt_annonce->bindValue(7, $lien, PDO::PARAM_STR);

}

$stmt_annonce->bindValue(8,$annonceId, PDO::PARAM_INT); 

$ok=$stmt_annonce->execute();
if(!$ok) {
    $_SESSION['erreur_form'] = "Erreur lors de l'enregistrement de l'annonce.";
}
$errorInfo = $stmt_annonce->errorInfo();
if ($errorInfo[0] !== '00000') {
    echo "Erreur lors de l'exécution de la requête : " . $errorInfo[2];
}


header("Location:../../Views/user/annonce.php");
?>
