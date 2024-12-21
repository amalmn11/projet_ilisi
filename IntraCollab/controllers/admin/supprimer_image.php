<?php

// connexion a la base de donnee
require_once '..\db\connexion.php';


    //suppression de l'image de la base de donnnée
    $id = $_GET['IDD'];
    $img = $_GET['img'];

    $default_img="default_pfp.jpg";
    $req_supp="UPDATE UTILISATEUR  SET IMAGE=?  WHERE UTILISATEUR_ID=?";
    $stmt_supp=$bdd->prepare($req_supp);
    $stmt_supp->bindValue(1,$default_img,PDO::PARAM_STR);
    $stmt_supp->bindValue(2,$id,PDO::PARAM_INT);
    $stmt_supp->execute();

    //suppression de l'image de server
    
    $image_path = "../../storage/images/$img"; // Remplacez par le chemin de votre image sur le serveur

    session_start();
    $_SESSION['modif_erreur'] ="";

    // Vérification si le fichier existe
    if (file_exists($image_path)) {
        // Suppression du fichier
        if (unlink($image_path)) {
            $_SESSION['modif_secces'] =  "Image supprimée avec succès.";
        } 
        else {
            $_SESSION['modif_erreur'] = "Erreur lors de la suppression de l'image du serveur";
        }
    }
    else {
        $_SESSION['modif_erreur'] =  "Le fichier d'image n'existe pas sur le serveur";
    }

    



    //se rediriger vers la page initiale
    header("Location: ..\..\Views\admin\admin_profile.php");
    exit(); // Assurez-vous d'arrêter l'exécution du script après la redirection

?>