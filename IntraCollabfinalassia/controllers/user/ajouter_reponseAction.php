<?php

require_once '..\db\connexion.php';
session_start();

/////////////////////////// AJOUTER UNE REPONSE
//recuperation de reponse saisit
        $user_id= $_SESSION['user_id'];
        
        $id_question= $_POST['question_id'];
        $reponse=$_POST["reponsee"];
        //la requete
        $req_reponse="INSERT INTO reponse VALUES (NULL, :user_id, :question_id, :reponse, :reponse_date_creation,:nb_like_default,:nb_dislike_default,:note_default)";
       
        // Définir les valeurs par défaut
        $nb_like_default = 0;
        $nb_dislike_default = 0;
        $note_default = 0;
      
        $reponse_date_creation=date('Y-m-d H:i:s');
   
        // Préparation de la requête avec PDO
        $stmt_reponse = $bdd->prepare($req_reponse);
        // Liaison des valeurs aux paramètres
        $stmt_reponse->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt_reponse->bindParam(':question_id', $id_question, PDO::PARAM_INT);
        $stmt_reponse->bindParam(':reponse', $reponse, PDO::PARAM_STR);
        $stmt_reponse->bindParam(':reponse_date_creation', $reponse_date_creation, PDO::PARAM_STR);

        $stmt_reponse->bindParam(':nb_like_default', $nb_like_default, PDO::PARAM_INT);
        $stmt_reponse->bindParam(':nb_dislike_default', $nb_dislike_default, PDO::PARAM_INT);
        $stmt_reponse->bindParam(':note_default', $note_default, PDO::PARAM_INT);
        // Exécution de la requête
        $stmt_reponse->execute();


        //recuperer nombre de reponses
        $req_nbr_reponses="SELECT COUNT(REPONSE_ID) AS nombre_reponses
        FROM reponse
        WHERE QUESTION_ID = :id_question;";
        $stmt_nbr_reponses = $bdd->prepare($req_nbr_reponses);
        $stmt_nbr_reponses->bindParam(':id_question', $id_question, PDO::PARAM_INT);
        $stmt_nbr_reponses->execute();
        $result_nbr_reponses = $stmt_nbr_reponses->fetch(PDO::FETCH_ASSOC);
        if($result_nbr_reponses['nombre_reponses'] >=5)   $req_q = "UPDATE question SET ETAT_ID = 4 WHERE QUESTION_ID = :question_id";//complete
        else  $req_q = "UPDATE question SET ETAT_ID = 2 WHERE QUESTION_ID = :question_id";//en cours
        //modifier l'etat de question 
       
        $stmt = $bdd->prepare($req_q);
        $stmt->bindParam(':question_id', $id_question, PDO::PARAM_INT);
        $stmt->execute();


        //recuperer l'id de createur de question
        $requete_createur = "SELECT * FROM question WHERE QUESTION_ID=:question_id";
        $stmt_createur = $bdd->prepare($requete_createur);
        $stmt_createur->bindParam(':question_id',$id_question, PDO::PARAM_INT);
        $stmt_createur->execute();
        $createur = $stmt_createur->fetch(PDO::FETCH_ASSOC);
        if($result_nbr_reponses['nombre_reponses'] == 5 )// != 4 c'est diff de complete
        {   
                 //envoyer notification
                // Construction du contenu de la notification
                $contenu_notification = 'Votre question intitulée'. $createur['QUESTION_TITRE'].' a été marquée comme complète par le système car elle a reçu cinq réponses.';
                // Requête d'insertion de la notification
                $requete_insert_notification = "INSERT INTO notification (UTILISATEUR_ID, NOTIF_CONTENUE) VALUES (:createur_id, :contenu)";
                $stmt_insert_notification = $bdd->prepare($requete_insert_notification);
                $stmt_insert_notification->bindParam(':createur_id', $createur["UTILISATEUR_ID"], PDO::PARAM_INT);
                $stmt_insert_notification->bindParam(':contenu', $contenu_notification, PDO::PARAM_STR);
                $stmt_insert_notification->execute();

        }




    
    
 

header("Location: ..\..\Views\user\details_question.php");

?>