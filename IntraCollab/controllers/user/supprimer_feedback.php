<?php

// connexion a la base de donnee

//require_once '..\..\controllers\auth\auth_inc.php';
include '..\..\controllers\db\connexion.php';
session_start();
//require_once '..\..\controllers\auth\auth.php';

    if(isset($_GET['IDD']))
    {
        $feedback_id = $_GET['IDD'];
        $sup_fb="DELETE FROM feedback WHERE ID_FEEDBACK=?";//NB:BC est base de connaicssance
        $stmt_sup_fb=$bdd->prepare($sup_fb);
        $stmt_sup_fb->bindValue(1,$feedback_id,PDO::PARAM_INT);
        $stmt_sup_fb->execute();
    }
    //se rediriger vers la page initiale
    header("Location:..\..\Views\user\ajouter_feedback.php");
?>