<?php

// connexion a la base de donnee

//require_once '..\..\controllers\auth\auth_inc.php';
include '..\..\controllers\db\connexion.php';
session_start();
//require_once '..\..\controllers\auth\auth.php';

    if(isset($_GET['IDD']))
    {
        $base_connaissance_id = $_GET['IDD'];
        $sup_from_BC="DELETE FROM base_connaissance WHERE BASE_CONNAISSANCE_ID=?";//NB:BC est base de connaicssance
        $sup_from_se_compose="DELETE FROM se_compose WHERE BASE_CONNAISSANCE_ID=?";
        $stmt_sup_from_BC=$bdd->prepare($sup_from_BC);
        $stmt_sup_from_se_compose=$bdd->prepare($sup_from_se_compose);
        $stmt_sup_from_BC->bindValue(1,$base_connaissance_id,PDO::PARAM_INT);
        $stmt_sup_from_se_compose->bindValue(1,$base_connaissance_id,PDO::PARAM_INT);
        $stmt_sup_from_BC->execute();
        $stmt_sup_from_se_compose->execute();
    }
    //se rediriger vers la page initiale
    header("Location:..\..\Views\user\connaissance.php");
?>