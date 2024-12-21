<?php
require_once '..\..\controllers\db\connexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $base_id = $_POST['base_id'];
    $base_titre = $_POST['base_titre'];
    $base_descr = $_POST['base_descr'];
    $categorie = $_POST['categorie'];
    $tag1 = $_POST['tag1'];
    $tag2 = $_POST['tag2'];
    $tag3 = $_POST['tag3'];
   
    // Modification des données de base_connaissance
    $req_base = "UPDATE base_connaissance SET BASE_CONNAISSANCE_TITRE=?, BASE_CONNAISSANCE_DESCR=?, CATEGORIE_ID=? , TAG1 = ? , TAG2 = ? , TAG3 = ? WHERE BASE_CONNAISSANCE_ID=?";
    $stmt_base = $bdd->prepare($req_base);
    $stmt_base->bindValue(1, $base_titre, PDO::PARAM_STR);
    $stmt_base->bindValue(2, $base_descr, PDO::PARAM_STR);
    $stmt_base->bindValue(3, $categorie, PDO::PARAM_INT);
    $stmt_base->bindValue(4, $tag1, PDO::PARAM_STR);
    $stmt_base->bindValue(5, $tag2, PDO::PARAM_STR);
    $stmt_base->bindValue(6, $tag3, PDO::PARAM_STR);
    $stmt_base->bindValue(7, $base_id, PDO::PARAM_INT);
 

    $stmt_base->execute();


    // Redirection vers une page de confirmation ou de gestion des erreurs
    header('Location: ../../views/user/connaissance.php');
    exit;
}
?>
