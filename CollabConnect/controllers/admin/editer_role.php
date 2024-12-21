<?php

// connexion a la base de donnee
require_once '..\db\connexion.php';

//recuperation des nouvelles valeurs
$nom=$_POST['nom'];
$descr=$_POST['descr'];
$id=$_POST['id'];
$req_update="UPDATE ROLE_PROJET SET ROLE_PROJET_TITRE=?,ROLE_PROJET_DESCR=? where ROLE_PROJET_ID=?;";
//preparer la requete
$stmt_update=$bdd->prepare($req_update);
$stmt_update->bindValue(1,$nom,PDO::PARAM_STR);
$stmt_update->bindValue(2,$descr,PDO::PARAM_STR);
$stmt_update->bindValue(3,$id,PDO::PARAM_INT);
//executer
$stmt_update->execute();
// //apres la suppression retourner a la page pricipal
header("location:../../Views/admin/gestion_role.php");

?>