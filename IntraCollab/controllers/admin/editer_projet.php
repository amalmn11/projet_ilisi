<?php
// connexion a la base de donnee
require_once '..\db\connexion.php';
//recuperation des nouvelles valeurs

$id = $_POST['projet_id'];
$nom=$_POST['newProjetNom'];
$descr=$_POST['newProjetDescr'];
$budget=$_POST['newProjetBudget'];
$date_d=$_POST['newProjetDateD'];
$date_f=$_POST['newProjetDateF'];

if ((isset($_POST['newProjetStatut'])) && ($_POST['newProjetStatut'] == 2)) {
    // Récupérer la valeur de 'statut' sélectionnée
     $statut = 'Terminé';
  } 
  else {
    // Si aucun statut n'est sélectionné, ou le statut == 1 ,le définir à 'En cours'
    $statut = 'En cours';
  }
  

//*******1-preparer la requete
$req = "UPDATE PROJET SET  PROJET_TITRE =? , PROJET_DESCR = ?, BUDGET=?,STATUT=?,PROJET_DATE_DEBUT=?,PROJET_DATE_FIN=?   WHERE PROJET_ID = ?;";
$stmt=   $bdd->prepare($req);


//preparer la requete
//********2-binder les valeur a leur champs
$stmt->bindValue(1,$nom,PDO::PARAM_STR);
$stmt->bindValue(2,$descr,PDO::PARAM_STR);
$stmt->bindValue(3,$budget,PDO::PARAM_STR);
$stmt->bindValue(4,$statut,PDO::PARAM_STR);
$stmt->bindValue(5,$date_d,PDO::PARAM_STR);
$stmt->bindValue(6,$date_f,PDO::PARAM_STR);
$stmt->bindValue(7,$id,PDO::PARAM_INT);

// executer
$stmt->execute();

header("Location:../../Views/admin/gestion_projet.php");


?>