<?php


include '..\..\controllers\db\connexion.php';
session_start();
if(isset($_GET['IDD']))
{
    $formation_id = $_GET['IDD'];
    $utilisateur_id=$_SESSION["user_id"];

    $req_annule="UPDATE  annonce SET ANNULE = 1 ,FORMATION_ID=? WHERE FORMATION_ID=?  ";
    $stmt_annule=$bdd->prepare($req_annule);
    
    $stmt_annule->bindValue(1,NULL,PDO::PARAM_NULL);
    $stmt_annule->bindValue(2,$formation_id,PDO::PARAM_INT);
    $stmt_annule->execute();
    $errorInfo = $stmt_annule->errorInfo();
    if ($errorInfo[0] !== '00000') {
        echo "Erreur lors de l'exécution de la requête : " . $errorInfo[2];
    }


    $req_supp="DELETE FROM formation WHERE FORMATION_ID=? and UTILISATEUR_ID=?;";
    $stmt_supp=$bdd->prepare($req_supp);
    $stmt_supp->bindValue(1,$formation_id,PDO::PARAM_INT);
    $stmt_supp->bindValue(2,$utilisateur_id,PDO::PARAM_INT);
    $stmt_supp->execute();
    $errorInfo = $stmt_supp->errorInfo();
    if ($errorInfo[0] !== '00000') {
        echo "Erreur lors de l'exécution de la requête : " . $errorInfo[2];
    }


   
}
//se rediriger vers la page initiale
header("Location:../../Views/user/formation.php");

?>