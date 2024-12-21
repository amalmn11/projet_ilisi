<?php
require_once '..\db\connexion.php';
session_start();

/////////////////////////// AJOUTER UNE REPONSE
//recuperation de reponse saisit
        $user_id= $_SESSION['user_id'];
        $id_question= $_SESSION['id_question'];
        //la requete
        $id=$_GET['id'];
        $sql="delete from reponse where REPONSE_ID=:id AND UTILISATEUR_ID=:user_id AND QUESTION_ID=:question_id";
        $stmt=$bdd->prepare($sql);
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        $stmt->bindValue(':user_id',$user_id,PDO::PARAM_INT);
        $stmt->bindValue(':question_id',$id_question,PDO::PARAM_INT);
        $stmt->execute();


        //recuperer nombre de reponses
        $req_nbr_reponses="SELECT COUNT(REPONSE_ID) AS nombre_reponses
        FROM reponse
        WHERE QUESTION_ID = :id_question;";
        $stmt_nbr_reponses = $bdd->prepare($req_nbr_reponses);
        $stmt_nbr_reponses->bindParam(':id_question', $id_question, PDO::PARAM_INT);
        $stmt_nbr_reponses->execute();
        $result_nbr_reponses = $stmt_nbr_reponses->fetch(PDO::FETCH_ASSOC);

        if($result_nbr_reponses['nombre_reponses'] == 0)   $req_q = "UPDATE question SET ETAT_ID = 1 WHERE QUESTION_ID = :question_id";//nouvelle
        elseif($result_nbr_reponses['nombre_reponses'] >=5)   $req_q = "UPDATE question SET ETAT_ID = 4 WHERE QUESTION_ID = :question_id";//complete
        else  $req_q = "UPDATE question SET ETAT_ID = 2 WHERE QUESTION_ID = :question_id";//en cours
        //modifier l'etat de question 
       
        $stmt = $bdd->prepare($req_q);
        $stmt->bindParam(':question_id', $id_question, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: ..\..\Views\user\details_question.php");

?>