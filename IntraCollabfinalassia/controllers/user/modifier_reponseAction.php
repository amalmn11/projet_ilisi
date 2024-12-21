<?php


require_once '..\db\connexion.php';

var_dump($_POST);
//recupere les nouvelle valeurs
$reponse_id=$_POST["reponse_idd"];
$newReponse=$_POST["newReponse"];
// Préparer la requête SQL
$requete_modif = "UPDATE reponse SET REPONSE_CONTENU = :newReponse WHERE REPONSE_ID = :reponse_id";
$stmt_modif = $bdd->prepare($requete_modif);
// Liaison des paramètres
$stmt_modif->bindParam(':newReponse', $newReponse, PDO::PARAM_STR);
$stmt_modif->bindParam(':reponse_id', $reponse_id, PDO::PARAM_INT);

// Exécution de la requête
$stmt_modif->execute();
$errorInfo = $stmt_modif->errorInfo();
if ($errorInfo[0] !== '00000') {
    echo "Erreur lors de l'exécution de la requête : " . $errorInfo[2];
}



//se rediriger vers la page initiale
// header("Location:../../Views/user/details_question.php");





?>