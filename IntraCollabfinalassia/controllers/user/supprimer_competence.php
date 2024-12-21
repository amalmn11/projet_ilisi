<?php

// connexion a la base de donnee

//require_once '..\..\controllers\auth\auth_inc.php';
include '..\..\controllers\db\connexion.php';
session_start();
//require_once '..\..\controllers\auth\auth.php';

    if(isset($_GET['IDD']))
    {
        $competence_id = $_GET['IDD'];
        $utilisateur_id=$_SESSION["user_id"]; //normalement $_SESSION["user_id"]; ?
        $req_supp="DELETE FROM utilisateur_competence WHERE COMPETENCE_ID=? and UTILISATEUR_ID=?;";
        $stmt_supp=$bdd->prepare($req_supp);
        $stmt_supp->bindValue(1,$competence_id,PDO::PARAM_INT);
        $stmt_supp->bindValue(2,$utilisateur_id,PDO::PARAM_INT);
        $stmt_supp->execute();
    }
    //se rediriger vers la page initiale
    header("Location:..\..\Views\user\profile.php");
?>