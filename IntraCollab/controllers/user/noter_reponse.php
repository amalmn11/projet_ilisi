<?php

session_start();
include '..\..\controllers\db\connexion.php';

//recuperer les donnees
$utilisateur_id=$_SESSION["user_id"];
if (isset($_POST['note']) && !empty($_POST['note'])) 
{
    // Récupérer la valeur sélectionnée
    $note = $_POST['note'];
    $reponse_id = $_POST['reponse_id'];
    // inserer la nouvelle note recupérée
    $req_insert_note = "
    INSERT INTO ajouter_reaction (TYPE, NOTE, UTILISATEUR_ID, REPONSE_ID)
    VALUES (0, :note, :utilisateur_id, :reponse_id);
    ";
    $stmt_insert_note = $bdd->prepare($req_insert_note);
    $stmt_insert_note->bindParam(':note', $note, PDO::PARAM_STR);
    $stmt_insert_note->bindParam(':utilisateur_id', $utilisateur_id, PDO::PARAM_INT);
    $stmt_insert_note->bindParam(':reponse_id', $reponse_id, PDO::PARAM_INT);
    $stmt_insert_note->execute();
    // Calculer la moyenne des notes
    $req_avg_note = "
    SELECT AVG(NOTE) AS moyenne_note
    FROM ajouter_reaction
    WHERE REPONSE_ID = :reponse_id AND TYPE = 0;
    ";
    $stmt_avg_note = $bdd->prepare($req_avg_note);
    $stmt_avg_note->bindParam(':reponse_id',$reponse_id, PDO::PARAM_INT);
    $stmt_avg_note->execute();
    $result_avg = $stmt_avg_note->fetch(PDO::FETCH_ASSOC);
    $moyenne_note = $result_avg['moyenne_note'];
    if($moyenne_note>5)
    $moyenne_note=5;
    //inserer dans la table reponse dans le champs NOTE
    $req_update_note = "
    UPDATE reponse
    SET NOTE = :moyenne_note
    WHERE REPONSE_ID = :reponse_id;
    ";
    $stmt_update_note = $bdd->prepare($req_update_note);
    $stmt_update_note->bindParam(':moyenne_note', $moyenne_note, PDO::PARAM_STR);
    $stmt_update_note->bindParam(':reponse_id', $reponse_id, PDO::PARAM_INT);
    $stmt_update_note->execute();

} else  echo "Aucune note n'a été sélectionnée.";

//se rediriger vers la page principale
header("location:../../Views/user/details_question.php");

?>