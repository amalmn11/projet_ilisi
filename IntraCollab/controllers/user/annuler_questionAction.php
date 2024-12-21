
<?php

require_once '..\db\connexion.php';
session_start();

/////////////////////////// AJOUTER UNE REPONSE
//recuperation de reponse saisit
        $id=$_GET['id'];
        $sql="UPDATE question SET ETAT_ID= :etat WHERE QUESTION_ID=:question_id";
        $stmt=$bdd->prepare($sql);
        $stmt->bindValue(':question_id',$id,PDO::PARAM_INT);
        $stmt->bindValue(':etat',5,PDO::PARAM_INT);
        $stmt->execute();
        header("Location: ..\..\Views\user\details_question.php?IDD=$id");


?>