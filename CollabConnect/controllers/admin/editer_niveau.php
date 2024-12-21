<?php

// connexion a la base de donnee
require_once '..\db\connexion.php';

//recuperation des nouvelles valeurs

$newNiveauTitre=$_POST["newNiveauTitre"];
$newNiveauDescr=$_POST["newNivDescr"];
$iddNiv=$_POST["niv_id"];
$req_update="UPDATE niveau SET NIVEAU_TITRE=?,NIVEAU_DESCR=? where NIVEAU_ID=?;";
//preparer la requete
$stmt_update=$bdd->prepare($req_update);
$stmt_update->bindValue(1,$newNiveauTitre,PDO::PARAM_STR);
$stmt_update->bindValue(2,$newNiveauDescr,PDO::PARAM_STR);
$stmt_update->bindValue(3,$iddNiv,PDO::PARAM_INT);
//executer
$stmt_update->execute();
//se rediriger vers page initial
header("Location:../../Views/admin/gestion_niveau.php");



?>