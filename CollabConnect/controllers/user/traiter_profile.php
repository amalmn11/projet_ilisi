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
    $date=$_POST['datenaissance'];
    $adresse=$_POST['adresse'];
    $codepostal=$_POST['codepostal'];
    $ville=$_POST['ville'];
    $pays=$_POST['pays'];
    $password=$_POST['password'];


    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql="UPDATE utilisateur SET
    NOM =:n,
    PRENOM=:pr,
    DATE_NAISSANCE=:da,
    TELEPHONE=:t,
    VILLE=:v,
    ADRESSE=:a,
    CODE_POSTAL=:cp,
    PAYS =:pays,
    PWD=:pass where EMAIL=:e ";
    $stmt=$bdd->prepare($sql);
    $stmt->bindValue('n',$nom,PDO::PARAM_STR);
    $stmt->bindValue('pr',$prenom,PDO::PARAM_STR);
    $stmt->bindValue('da',$date,PDO::PARAM_STR);
    $stmt->bindValue('t',$telephone,PDO::PARAM_STR);
    $stmt->bindValue('v',$ville,PDO::PARAM_STR);
    $stmt->bindValue('a',$adresse,PDO::PARAM_STR);
    $stmt->bindValue('cp',$codepostal,PDO::PARAM_STR);
    $stmt->bindValue('pays',$pays,PDO::PARAM_STR);
    $stmt->bindValue('e',$email,PDO::PARAM_STR);
    $stmt->bindValue('pass',$hashed_password,PDO::PARAM_STR);
    $stmt->execute();

    // header('location:user_index.php');
    header('location:..\db\deconnexion.php');
}
else
{
    $error="les données ne sont pas bien transmis";
    header('location:..\..\Views\user\completer_profile.php');
}
?>