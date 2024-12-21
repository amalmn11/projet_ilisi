
<?php

        include '../../controllers/db/connexion.php';
        session_start();

        $visited_id =$_POST['visited_id'];
        $current_user=  $_SESSION['user_id'];
        $contenu = htmlspecialchars( $_POST['contenu']);
        $date_envoi = date('Y-m-d H:i:s');
        $sql = "INSERT INTO message (AUTEUR_ID, DESTINATAIRE_ID, CONTENU, DATE_ENVOI) VALUES (?, ?, ?, ?)";
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(1, $current_user, PDO::PARAM_INT);
        $stmt->bindParam(2, $visited_id, PDO::PARAM_INT);
        $stmt->bindParam(3, $contenu, PDO::PARAM_STR);
        $stmt->bindParam(4, $date_envoi, PDO::PARAM_STR);
        $stmt->execute();


        // Rediriger vers la page de formulaire
        header('Location:'.$_SESSION['messagerie']);
        exit;
?>
