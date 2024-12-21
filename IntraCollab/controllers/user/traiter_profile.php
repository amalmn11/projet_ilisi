<?php
require_once "..\db\connexion.php";
// require_once "..\auth\auth_inc.php";

session_start();
$id= $_SESSION['user_id'];
if(isset($_POST['finish']))
{
    $email=$_SESSION['user_email'];
    //preparation des variables 
    $nom=$_POST['nom'];
    $prenom=$_POST['prenom'];
    $telephone=$_POST['telephone'];
    $poste=$_POST['poste'];
    $password=$_POST['password'];

    $_SESSION["auth"]= $nom. " " . $prenom;
    

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



    //verification de password
    if (!empty($_POST["password"]) && !empty($_POST["password_c"])) 
    {
        $newPassword=$_POST["password"];
        $renewpassword=$_POST["password_c"];

        $req_psw="SELECT * from utilisateur where UTILISATEUR_ID=?";
        //preparer la requete
        $stmt_psw=$bdd->prepare($req_psw);
        $stmt_psw->bindValue(1,$id,PDO::PARAM_INT);
      
        //executer
        $stmt_psw->execute();
        //parcourir
        $result=$stmt_psw->fetch(PDO::FETCH_ASSOC);

        if($result)
        {
            if($newPassword!=$renewpassword)
            {
                $_SESSION['error_pass'] = "Mot de passe de confirmation est incorrect.";
            }else
            {
               $req_change="UPDATE utilisateur SET PWD=? where UTILISATEUR_ID=?";
               $hashed_newPassword=password_hash($newPassword, PASSWORD_DEFAULT);;
               //preparer
               $stmt_change=$bdd->prepare($req_change);
               $stmt_change->bindValue(1,$hashed_newPassword,PDO::PARAM_STR);
               $stmt_change->bindValue(2,$id,PDO::PARAM_INT);
               $stmt_change->execute();
                $_SESSION['success'] = "Mot de passe changé avec succès.";
                //se rediriger vers la page initiale
                header("Location:..\..\Views\user\profile.php");
                // exit(); // Assurez-vous d'arrêter l'exécution du script après la redirection
            }
        }
    }

    // header("Location:..\..\Views\user\profile.php");
}
else
{
    $error="les données ne sont pas bien transmis";
    header('location:..\..\Views\user\completer_profile.php');
}
?>