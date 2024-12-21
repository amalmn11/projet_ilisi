<?php
//connexion à la base de donnees
session_start();
include '..\..\controllers\db\connexion.php';


//si bouton ajouter est cliqué on recupere les donnees
if(isset($_POST["ajouterCompetence"]))
{

$utilisateur_id=$_SESSION["user_id"]; //$_SESSION["user_id"]; normalement ?
$competence_nom=$_POST["competence_nom"];
$niveau=$_POST["niveau"];
//recherche des ids
//1
$req_id_comp="SELECT COMPETENCE_ID FROM competence where COMPETENCE_NOM=?";
$stmt_id_comp=$bdd->prepare($req_id_comp);
$stmt_id_comp->bindParam(1,$competence_nom,PDO::PARAM_STR);
$stmt_id_comp->execute();
$competence_id=$stmt_id_comp->fetch(PDO::FETCH_ASSOC);
//2
$req_id_niv="SELECT NIVEAU_ID FROM niveau where NIVEAU_TITRE=?";
$stmt_id_niv=$bdd->prepare($req_id_niv);
$stmt_id_niv->bindParam(1,$niveau,PDO::PARAM_STR);
$stmt_id_niv->execute();
$niveau_id=$stmt_id_niv->fetch(PDO::FETCH_ASSOC);
//la requete D'insertion
$req_ajout="INSERT INTO utilisateur_competence(UTILISATEUR_ID,COMPETENCE_ID,NIVEAU_ID)
VALUES(?,?,?)";
//preparer la requete
$stmt_ajout = $bdd->prepare($req_ajout);
// Liaison des valeurs aux paramètres de la requête
$stmt_ajout->bindParam(1, $utilisateur_id,PDO::PARAM_INT);
$stmt_ajout->bindParam(2, $competence_id["COMPETENCE_ID"],PDO::PARAM_INT);
$stmt_ajout->bindParam(3, $niveau_id["NIVEAU_ID"],PDO::PARAM_INT);
// Exécution de la requête
$stmt_ajout->execute();
//
header("Location:..\..\Views\user\profile.php");
}

?>