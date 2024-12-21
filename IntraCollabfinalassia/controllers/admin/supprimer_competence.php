<?php

// connexion a la base de donnee
require_once '..\db\connexion.php';



    $competence_id = $_GET['IDD'];
    
    $req_supp="DELETE FROM competence WHERE COMPETENCE_ID=?";
    $stmt_supp=$bdd->prepare($req_supp);
    $stmt_supp->bindValue(1,$competence_id,PDO::PARAM_INT);
    $stmt_supp->execute();
    //se rediriger vers la page initiale
   header("Location:../../Views/admin/gestion_competence.php");


?>