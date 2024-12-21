<?php
require_once '../../controllers/db/connexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reponseId = intval($_POST['reponse_id']);
    $action = $_POST['action'];
    $utilisateurId = $_SESSION['user_id'];

    try {
        $bdd->beginTransaction();

        // Vérifier si une réaction existe déjà
        $queryCheck = "SELECT * FROM ajouter_reaction WHERE REPONSE_ID = :reponseId AND UTILISATEUR_ID = :utilisateurId";
        $stmtCheck = $bdd->prepare($queryCheck);
        $stmtCheck->bindParam(':reponseId', $reponseId, PDO::PARAM_INT);
        $stmtCheck->bindParam(':utilisateurId', $utilisateurId, PDO::PARAM_INT);
        $stmtCheck->execute();
        $existingReaction = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($existingReaction) {
            // Mise à jour d'une réaction existante
            if ($existingReaction['TYPE'] == 1 && $action == 'dislike') {
                $queryUpdate = "UPDATE ajouter_reaction SET TYPE = 2 WHERE REPONSE_ID = :reponseId AND UTILISATEUR_ID = :utilisateurId";
            } elseif ($existingReaction['TYPE'] == 2 && $action == 'like') {
                $queryUpdate = "UPDATE ajouter_reaction SET TYPE = 1 WHERE REPONSE_ID = :reponseId AND UTILISATEUR_ID = :utilisateurId";
            } else {
                // Pas de changement nécessaire si l'action est identique à la réaction existante
                $bdd->commit();
                echo json_encode(['status' => 'no_change']);
                exit;
            }

            $stmtUpdate = $bdd->prepare($queryUpdate);
            $stmtUpdate->bindParam(':reponseId', $reponseId, PDO::PARAM_INT);
            $stmtUpdate->bindParam(':utilisateurId', $utilisateurId, PDO::PARAM_INT);
            $stmtUpdate->execute();
        } else {
            // Insertion d'une nouvelle réaction
            $type = ($action == 'like') ? 1 : 2;
            $queryInsert = "INSERT INTO ajouter_reaction (TYPE, REPONSE_ID, UTILISATEUR_ID) VALUES (:type, :reponseId, :utilisateurId)";
            $stmtInsert = $bdd->prepare($queryInsert);
            $stmtInsert->bindParam(':type', $type, PDO::PARAM_INT);
            $stmtInsert->bindParam(':reponseId', $reponseId, PDO::PARAM_INT);
            $stmtInsert->bindParam(':utilisateurId', $utilisateurId, PDO::PARAM_INT);
            $stmtInsert->execute();
        }

        // Obtenir les nouveaux compteurs
        $queryCounts = "SELECT 
            (SELECT COUNT(*) FROM ajouter_reaction WHERE REPONSE_ID = :reponseId AND TYPE = 1) AS NB_LIKE,
            (SELECT COUNT(*) FROM ajouter_reaction WHERE REPONSE_ID = :reponseId AND TYPE = 2) AS NB_DISLIKE";
        $stmtCounts = $bdd->prepare($queryCounts);
        $stmtCounts->bindParam(':reponseId', $reponseId, PDO::PARAM_INT);
        $stmtCounts->execute();
        $counts = $stmtCounts->fetch(PDO::FETCH_ASSOC);

        // Mettre à jour les compteurs dans la table reponse
        $queryUpdateReponse = "UPDATE reponse SET NB_LIKE = :nb_like, NB_DISLIKE = :nb_dislike WHERE REPONSE_ID = :reponseId";
        $stmtUpdateReponse = $bdd->prepare($queryUpdateReponse);
        $stmtUpdateReponse->bindParam(':nb_like', $counts['NB_LIKE'], PDO::PARAM_INT);
        $stmtUpdateReponse->bindParam(':nb_dislike', $counts['NB_DISLIKE'], PDO::PARAM_INT);
        $stmtUpdateReponse->bindParam(':reponseId', $reponseId, PDO::PARAM_INT);
        $stmtUpdateReponse->execute();

        // Commit de la transaction
        $bdd->commit();
        echo json_encode(['status' => 'success', 'likes' => $counts['NB_LIKE'], 'dislikes' => $counts['NB_DISLIKE']]);
    } catch (Exception $e) {
        // En cas d'erreur, annuler la transaction
        $bdd->rollBack();
        error_log('Error: ' . $e->getMessage()); // Journaliser l'erreur
        echo json_encode(['status' => 'error', 'message' => 'Error processing your request. Please try again later.']);
    }
}
?>
