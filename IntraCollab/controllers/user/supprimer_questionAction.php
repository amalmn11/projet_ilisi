
<?php

require_once '..\db\connexion.php';
session_start();

/////////////////////////// AJOUTER UNE REPONSE
//recuperation de reponse saisit
        $id=$_GET['id'];
        $sql="delete from question where QUESTION_ID=:question_id";
        $stmt=$bdd->prepare($sql);
        $stmt->bindValue(':question_id',$id,PDO::PARAM_INT);
        $stmt->execute();
        header('Location: ..\..\Views\user\forum.php');


?>