<?php
require_once "..\db\connexion.php";
// require_once "..\auth\auth_inc.php";

session_start();

if(isset($_POST['finish']))
{
    $email=$_SESSION['user_email'];
    //preparation des variables 
    $nom=$_POST['nom'];
    $prenom=$_POST['prenom'];
    $telephone=$_POST['telephone'];
    $poste=$_POST['poste'];
    $password=$_POST['password'];


    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql="UPDATE utilisateur SET
    NOM =:n,
    PRENOM=:pr,
    POSTE=:po,
    TELEPHONE=:t,
    PWD=:pass where EMAIL=:e ";
    $stmt=$bdd->prepare($sql);
    $stmt->bindValue('n',$nom,PDO::PARAM_STR);
    $stmt->bindValue('pr',$prenom,PDO::PARAM_STR);
    $stmt->bindValue('po',$poste,PDO::PARAM_STR);
    $stmt->bindValue('t',$telephone,PDO::PARAM_STR);
    $stmt->bindValue('e',$email,PDO::PARAM_STR);
    $stmt->bindValue('pass',$hashed_password,PDO::PARAM_STR);
    $stmt->execute();

    header("Location:..\..\Views\user\profile.php");
}
else
{
    $error="les données ne sont pas bien transmis";
    header('location:..\..\Views\user\completer_profile.php');
}
?>