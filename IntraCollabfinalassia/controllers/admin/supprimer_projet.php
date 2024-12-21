<?php
 // Récupérer les données
$ID = $_GET['IDD'];

// connexion a la base de donnee
require_once '..\db\connexion.php';


$req_annule="UPDATE  annonce SET PROJET_ID =? WHERE PROJET_ID =?  ";
$stmt_annule=$bdd->prepare($req_annule);

$stmt_annule->bindValue(1,NULL,PDO::PARAM_NULL);
$stmt_annule->bindValue(2,$ID,PDO::PARAM_INT);
$stmt_annule->execute();

$errorInfo = $stmt_annule->errorInfo();
if ($errorInfo[0] !== '00000') {
    echo "Erreur lors de l'exécution de la requête : " . $errorInfo[2];
}



$req = "DELETE FROM PROJET WHERE PROJET_ID = $ID";
$bdd->exec($req);
// //apres la suppression retourner a la page pricipal
header("location:../../Views/admin/gestion_projet.php");

?>