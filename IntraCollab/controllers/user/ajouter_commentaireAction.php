<?php

require_once '..\db\connexion.php';
session_start();

/////////////////////////// AJOUTER UNE REPONSE
//recuperation de reponse saisit
        $user_id= $_SESSION['user_id'];
        
        $id_reponse= $_POST['id_reponse'];

        $comment=$_POST["comment"];
        //la requete
        $req_comment="INSERT INTO commentaire VALUES (NULL, :user_id, :id_reponse, :comment, :comment_date_creation)";
       
    
      
        $comment_date_creation=date('Y-m-d H:i:s');
   
        // Préparation de la requête avec PDO
        $stmt_comment = $bdd->prepare($req_comment);
        // Liaison des valeurs aux paramètres
        $stmt_comment->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt_comment->bindParam(':id_reponse', $id_reponse, PDO::PARAM_INT);
        $stmt_comment->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt_comment->bindParam(':comment_date_creation', $comment_date_creation, PDO::PARAM_STR);
       
        // Exécution de la requête
        $stmt_comment->execute();

    
    
 

header("Location: ..\..\Views\user\details_question.php");

?>