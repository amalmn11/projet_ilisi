<?php
 // Récupérer les données
$ID = $_GET['IDD'];

// connexion a la base de donnee
require_once '..\db\connexion.php';

$req = "DELETE FROM PROJET WHERE PROJET_ID = $ID";
$bdd->exec($req);
// //apres la suppression retourner a la page pricipal
header("location:../../Views/admin/gestion_projet.php");

?>