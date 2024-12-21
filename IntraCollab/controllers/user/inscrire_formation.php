<?php

session_start();
include '..\..\controllers\db\connexion.php';

if(isset($_GET["IDD"]))
{
$formation_id=$_GET["IDD"];
$user_id=$_SESSION["user_id"];
// Requête d'insertion préparée
$req_insertion = "INSERT INTO utilisateur_formation (UTILISATEUR_ID, FORMATION_ID) 
VALUES (:user_id, :formation_id)";

// Préparation de la requête
$stmt_insertion = $bdd->prepare($req_insertion);

// Liaison des valeurs
$stmt_insertion->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_insertion->bindParam(':formation_id', $formation_id, PDO::PARAM_INT);

// Exécution de la requête
$stmt_insertion->execute();

// Envoyer notification 
//recuperer l'id de createur de formation
$requete_createur = "SELECT * FROM formation WHERE FORMATION_ID=:formation";
$stmt_createur = $bdd->prepare($requete_createur);
$stmt_createur->bindParam(':formation',$formation_id, PDO::PARAM_INT);
$stmt_createur->execute();
$createur = $stmt_createur->fetch(PDO::FETCH_ASSOC);
//recuperer les informations d'utilisateur inscrit
$requete_inscrit = "SELECT * FROM utilisateur WHERE UTILISATEUR_ID=:user";
$stmt_inscrit = $bdd->prepare($requete_inscrit );
$stmt_inscrit->bindParam(':user',$user_id, PDO::PARAM_INT);
$stmt_inscrit->execute();
$inscrit = $stmt_inscrit->fetch(PDO::FETCH_ASSOC);
//envoyer notification
// Construction du contenu de la notification
$contenu_notification = "Le collaborateur " . $inscrit["NOM"] . " " . $inscrit["PRENOM"] . " s'est inscrit à votre formation ayant pour thème : " . $createur["THEME"];
// Requête d'insertion de la notification
$requete_insert_notification = "INSERT INTO notification (UTILISATEUR_ID, NOTIF_CONTENUE,TYPE) VALUES (:createur_id, :contenu,:typee)";
$stmt_insert_notification = $bdd->prepare($requete_insert_notification);
$stmt_insert_notification->bindParam(':createur_id', $createur["UTILISATEUR_ID"], PDO::PARAM_INT);
$stmt_insert_notification->bindParam(':contenu', $contenu_notification, PDO::PARAM_STR);
$stmt_insert_notification->bindValue(':typee', 'notification', PDO::PARAM_STR); // Utilisation de bindValue pour typee
$stmt_insert_notification->execute();

header("Location:../../Views/user/formation.php");
}


?>