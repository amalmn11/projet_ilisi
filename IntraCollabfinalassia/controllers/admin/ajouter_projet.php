<?php
  // Récupérer les données du formulaire
$nom=$_POST['nom'];
$descr=$_POST['descr'];
$budget=$_POST['budget'];
$date_d=$_POST['date_d'];
$date_f=$_POST['date_f'];
if ((isset($_POST['statut'])) && ($_POST['statut'] == 2)) {
  // Récupérer la valeur de 'statut' sélectionnée
   $statut = 'Terminé';
} 
else {
  // Si aucun statut n'est sélectionné, ou le statut == 1 ,le définir à 'En cours'
  $statut = 'En cours';
}




// connexion a la base de donnee
require_once '..\db\connexion.php';

session_start();
$_SESSION['erreur_form']="";

//*******1-preparer la requete
$req = "INSERT INTO PROJET VALUES (NULL,?,?,?,?,?,?);";
$stmt=   $bdd->prepare($req);

//********2-binder les valeur a leur champs
$stmt->bindValue(1,$nom,PDO::PARAM_STR);
$stmt->bindValue(2,$descr,PDO::PARAM_STR);
$stmt->bindValue(3,$budget,PDO::PARAM_STR);
$stmt->bindValue(4,$statut,PDO::PARAM_STR);
$stmt->bindValue(5,$date_d,PDO::PARAM_STR);
$stmt->bindValue(6,$date_f,PDO::PARAM_STR);


//*********3-executer la req
$ok = $stmt->execute();
if (!$ok) {
  // La requête n'a pas été exécutée correctement
  $_SESSION['erreur_form'] = "Erreur lors de l'enregistrement du projet.";
}


header("location:../../Views/admin/gestion_projet.php");

?>