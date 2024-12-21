<?php
require_once 'connexion.php';

$nom=$_POST['nom'];
$filiere=$_POST['filiere'];
$controle=$_POST['controle'];
$exam=$_POST['exam'];

if(isset($nom) && isset($filiere) && isset($controle) && isset($exam))
{
    $sql="INSERT INTO etudiant(nom,filiere,controle,examen) values(:n,:f,:c,:e)";
    $stmt=$bdd->prepare($sql);
    $stmt->bindValue(':n',$nom,PDO::PARAM_STR);
    $stmt->bindValue(':f',$filiere,PDO::PARAM_STR);
    $stmt->bindValue(':c',$controle,PDO::PARAM_STR);
    $stmt->bindValue(':e',$exam,PDO::PARAM_STR);
    try
    {
        $stmt->execute();
        echo "etudiant ajouter avec succes ";
    }
    catch(PDOException $e)
    {
        die("probleme d'ajout d'etudiant $e.getMessage()");
    }
}
else echo "les données ne seront pas bien transferer";
?>