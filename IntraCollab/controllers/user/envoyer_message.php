
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


//recuperer les informations de auteur de message
$req_user="SELECT * FROM utilisateur where UTILISATEUR_ID=?";
$stmt = $bdd->prepare($req_user);
$stmt->execute([$current_user]);
$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
// Construction du contenu de la notification
$contenu_notification = "Le collaborateur ".$utilisateur["NOM"]." ".$utilisateur["PRENOM"]." vous a envoyé un nouveau message.";
// Requête d'insertion de la notification
$requete_insert_notification = "INSERT INTO notification (UTILISATEUR_ID, NOTIF_CONTENUE,TYPE) VALUES (:createur_id, :contenu,:typee)";
$stmt_insert_notification = $bdd->prepare($requete_insert_notification);
$stmt_insert_notification->bindParam(':createur_id',$visited_id, PDO::PARAM_INT);
$stmt_insert_notification->bindParam(':contenu', $contenu_notification, PDO::PARAM_STR);
$stmt_insert_notification->bindValue(':typee','message', PDO::PARAM_STR);
$stmt_insert_notification->execute();
$errorInfo =$stmt_insert_notification->errorInfo();
if ($errorInfo[0] !== '00000')
echo "Erreur lors de l'exécution de la requête : " . $errorInfo[2];

// Rediriger vers la page de formulaire
header('Location:'.$_SESSION['messagerie']);
exit;
?>
