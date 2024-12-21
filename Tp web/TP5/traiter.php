<?php
require_once 'connexion.php';

$nom=$_POST['nom'];
$filiere=$_POST['filiere'];
$controle=$_POST['controle'];
$examen=$_POST['examen'];
$moyenne=(2*$examen+$controle)/3;

$sql="insert into etudiant(nom,filiere,controle,examen,moyenne) values(:nom,:filiere,:controle,:examen,:moyenne)";

$stmt=$bdd->prepare($sql);

$stmt->bindParam(":nom", $nom);
$stmt->bindParam(":filiere", $filiere);
$stmt->bindParam(":controle", $controle);
$stmt->bindParam(":examen", $examen);
$stmt->bindParam(":moyenne", $moyenne);

try 
{
    $stmt->execute();
    echo "Étudiant ajouté avec succès !";

}catch(PDOException $e) {
    echo "Erreur lors de l'ajout de l'étudiant : " . $e->getMessage();
}

header('location:ecole.php');
?>