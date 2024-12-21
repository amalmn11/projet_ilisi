<?php

include '../../controllers/db/connexion.php';
session_start();

// Récupérer les données du formulaire
$titre = $_POST['titre_question'];
$id_user = $_SESSION['user_id'];
$description = $_POST['descr'];
$categorieId = $_POST['categorie'];
$tag1 = $_POST['tag1'];
$tag2 = $_POST['tag2'];
$tag3 = $_POST['tag3'];

$selectedTags = explode(',', $_POST['selected_tags']);

// Insérer dans la table base_connaissance
$stmt = $bdd->prepare("INSERT INTO base_connaissance (UTILISATEUR_ID, BASE_CONNAISSANCE_TITRE, CATEGORIE_ID, BASE_CONNAISSANCE_DESCR, TAG1,TAG2,TAG3) VALUES (:user, :titre, :categorie_id, :description,:tag1,:tag2,:tag3)");
$stmt->bindValue(':user', $id_user, PDO::PARAM_INT);
$stmt->bindValue(':titre', $titre, PDO::PARAM_STR);
$stmt->bindValue(':categorie_id', $categorieId, PDO::PARAM_INT);
$stmt->bindValue(':description', $description, PDO::PARAM_STR);
$stmt->bindValue(':tag1', $tag1, PDO::PARAM_STR);
$stmt->bindValue(':tag2', $tag2, PDO::PARAM_STR);
$stmt->bindValue(':tag3', $tag3, PDO::PARAM_STR);

$stmt->execute();
$errorInfo = $stmt->errorInfo();
if ($errorInfo[0] !== '00000') {
    echo "Erreur lors de l'exécution de la requête : " . $errorInfo[2];
}

$_SESSION['erreur_form'] = '';

// Rediriger vers la page de formulaire
header('Location: ../../views/user/connaissance.php');
exit;
?>
