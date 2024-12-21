<?php
require_once '..\..\controllers\db\connexion.php';

    $id_feedback=$_POST['feedback_id'];
    $new_feedback=$_POST['new_feedback'];

    // Modification des données de base_connaissance
    $req = "UPDATE feedback SET COMMENTAIRE=? WHERE ID_FEEDBACK=?";
    $stmt_fb = $bdd->prepare($req);
    $stmt_fb->bindValue(1, $new_feedback, PDO::PARAM_STR);
    $stmt_fb->bindValue(2, $id_feedback, PDO::PARAM_INT);
    $stmt_fb->execute();

    // Redirection vers une page de confirmation ou de gestion des erreurs
    header('Location: ../../views/user/ajouter_feedback.php');
    exit;

?>