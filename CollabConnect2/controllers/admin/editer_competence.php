<?php
// connexion a la base de donnee
require_once '..\db\connexion.php';
//recuperation des nouvelles valeurs
$newCompetenceNom=$_POST["newCompetenceNom"];
$newCompetenceDescr=$_POST["newCompetenceDescr"];
$iddComp=$_POST["competence_id"];
$req_update="UPDATE competence SET COMPETENCE_NOM=?,COMPETENCE_DESCR=? WHERE COMPETENCE_ID=?;";
//preparer la requete
$stmt_update=$bdd->prepare($req_update);
$stmt_update->bindValue(1,$newCompetenceNom,PDO::PARAM_STR);
$stmt_update->bindValue(2,$newCompetenceDescr,PDO::PARAM_STR);
$stmt_update->bindValue(3,$iddComp,PDO::PARAM_INT);
//executer
$stmt_update->execute();
header("Location:../../Views/admin/gestion_competence.php");


?>