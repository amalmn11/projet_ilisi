<?php
 // Récupérer les données
$ID = $_GET['IDD'];


// connexion a la base de donnee
require_once '..\db\connexion.php';


$req = "DELETE FROM UTILISATEUR WHERE UTILISATEUR_ID = $ID";
$bdd->exec($req);
// //apres la suppression retourner a la page pricipal
header("location:../../Views/admin/gestion_utilisateur.php");

?>