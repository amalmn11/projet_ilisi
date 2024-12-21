<?php


require_once '..\db\connexion.php';

if(isset($_GET['IDD']))
{


$formation_id=$_GET['IDD'];

$req_annule="UPDATE  annonce SET ANNULE = 1  WHERE FORMATION_ID=?  ";
$stmt_annule=$bdd->prepare($req_annule);
$stmt_annule->bindValue(1,$formation_id,PDO::PARAM_INT);
$stmt_annule->execute();

$errorInfo = $stmt_annule->errorInfo();
if ($errorInfo[0] !== '00000'){
    echo "Erreur lors de l'exécution de la requête : " . $errorInfo[2];
}



$req_formation="UPDATE formation SET ETAT_FORMATION = :etat WHERE FORMATION_ID = :formation_id";
$stmt_formation = $bdd->prepare($req_formation);
$etat= "Annulee";
$stmt_formation->bindParam(':etat',$etat, PDO::PARAM_STR);
$stmt_formation->bindParam(':formation_id', $formation_id, PDO::PARAM_INT);
$stmt_formation->execute();
$errorInfo = $stmt_formation->errorInfo();
if ($errorInfo[0] !== '00000') {
    echo "Erreur lors de l'exécution de la requête : " . $errorInfo[2];
}
}
//se rediriger vers la page intiale
//se rediriger vers la page initiale
header("Location:../../Views/user/formation.php");

?>