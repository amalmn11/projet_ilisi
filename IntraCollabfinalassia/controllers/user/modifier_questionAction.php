<?php
require_once "..\db\connexion.php";
session_start();

$question_id = $_POST["question_id"];
$etat_id = $_POST["etat"];
$titre_question = $_POST["titre_question"];
$descr_question = $_POST['descr'];
$option_assoc_projet = $_POST['associerProjet'];
$id_projet = isset($_POST['project']) ? $_POST['project'] : NULL;

$sql = "UPDATE question  SET
ETAT_ID = ?,
PROJET_ID = ?,
QUESTION_TITRE =?,
QUESTION_DESCR =?
 WHERE QUESTION_ID = ?";
$stmt = $bdd->prepare($sql);

$stmt->bindValue(1, $etat_id, PDO::PARAM_INT);
if ($option_assoc_projet == "oui" && !empty($id_projet)) 
{
    $stmt->bindValue(2, $id_projet, PDO::PARAM_INT);
} 
else 
{
    $stmt->bindValue(2, NULL, PDO::PARAM_NULL);
}

$stmt->bindValue(3, $titre_question, PDO::PARAM_STR);
$stmt->bindValue(4, $descr_question, PDO::PARAM_STR);
$stmt->bindValue(5, $question_id, PDO::PARAM_INT);

$stmt->execute();

header("location:../../Views/user/details_question.php?IDD=$question_id");
exit();
?>
