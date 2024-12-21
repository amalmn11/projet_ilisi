<?php
require_once "..\db\connexion.php";
session_start();

$id_user = $_SESSION["user_id"];
$etat_id = 1;//nouvelle
$titre_question = $_POST["titre_question"];
$descr_question = $_POST['descr'];
$option_assoc_projet = $_POST['associerProjet'];
$id_projet = isset($_POST['project']) ? $_POST['project'] : NULL;

$sql = "INSERT INTO question (UTILISATEUR_ID, ETAT_ID, PROJET_ID, QUESTION_TITRE, QUESTION_DESCR, DATE_CREATION) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $bdd->prepare($sql);
$stmt->bindValue(1, $id_user, PDO::PARAM_INT);
$stmt->bindValue(2, $etat_id, PDO::PARAM_INT);
if ($option_assoc_projet == "oui" && !empty($id_projet)) 
{
    $stmt->bindValue(3, $id_projet, PDO::PARAM_INT);
} else 
{
    $stmt->bindValue(3, NULL, PDO::PARAM_NULL);
}
$stmt->bindValue(4, $titre_question, PDO::PARAM_STR);
$stmt->bindValue(5, $descr_question, PDO::PARAM_STR);
$stmt->bindValue(6, date('Y-m-d'), PDO::PARAM_STR); // Utilisation correcte de la date actuelle

$stmt->execute();

header("location:../../Views/user/forum.php");
exit();
?>
