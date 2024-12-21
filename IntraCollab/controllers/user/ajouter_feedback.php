
<?php
include '..\..\controllers\db\connexion.php';
session_start();
// moi
// Récupérer les données du formulaire
$feedback = $_POST['feedback'];
$id_utilisateur=$_SESSION['user_id'];

if(!empty($feedback))
{
    $sql='INSERT INTO feedback(UTILISATEUR_ID, COMMENTAIRE, DATE_FEEDBACK) VALUES (:id_utilisateur, :commentaire, NOW())';
    $stmt_feedback = $bdd->prepare($sql);
    $stmt_feedback->bindValue('id_utilisateur', $id_utilisateur,PDO::PARAM_INT);
    $stmt_feedback->bindValue('commentaire', $feedback,PDO::PARAM_STR);

    // Exécution de la requête
    $stmt_feedback->execute();
}

//
header("Location:..\..\Views\user\ajouter_feedback.php");
?>
