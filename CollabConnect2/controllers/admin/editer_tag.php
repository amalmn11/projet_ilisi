<?php

// connexion a la base de donnee
require_once '..\db\connexion.php';

//recuperation des nouvelles valeurs
$nom=$_POST['tag_nom'];
$id=$_POST['tag_id'];
$req_update="UPDATE tag SET TAG_LIBELLE=? where TAG_ID=?;";
//preparer la requete
$stmt_update=$bdd->prepare($req_update);
$stmt_update->bindValue(1,$nom,PDO::PARAM_STR);
$stmt_update->bindValue(2,$id,PDO::PARAM_INT);
//executer
$stmt_update->execute();
// //apres la suppression retourner a la page pricipal
header("location:../../Views/admin/gestion_tag.php");

?>