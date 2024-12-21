<?php
  // Récupérer les données du formulaire
$nom=$_POST['nom'];
$descr=$_POST['descr'];

// connexion a la base de donnee
require_once '..\db\connexion.php';
session_start();
$_SESSION['erreur_form']="";


//*******1-preparer la requete
$req = "INSERT INTO ROLE_PROJET  VALUES (NULL,?, ?);";
$stmt=   $bdd->prepare($req);

//********2-binder les valeur a leur champs
$stmt->bindValue(1,$nom,PDO::PARAM_STR);
$stmt->bindValue(2,$descr,PDO::PARAM_STR);


//*********3-executer la req
$ok = $stmt->execute();
if (!$ok) {
  // La requête n'a pas été exécutée correctement
  $_SESSION['erreur_form'] = "Erreur lors de l'enregistrement du role de projet.";
}

header("location:../../Views/admin/gestion_role.php");

?>