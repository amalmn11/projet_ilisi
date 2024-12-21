<?php

// connexion a la base de donnee
require_once '..\db\connexion.php';
session_start();
$id= $_SESSION['user_id'];
$_SESSION['error_pass'] = "";

if(isset($_POST["changePWD"]))
{
        if (!empty($_POST["curr_password"]) && !empty($_POST["newPassword"]) && !empty($_POST["renewpassword"])) 
        {
        //recuperation
        $curr_password=$_POST["curr_password"];
        $newPassword=$_POST["newPassword"];
        $renewpassword=$_POST["renewpassword"];
        //la requete
      
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
          $hashed_pwd_from_db = $result["PWD"];
          if (password_verify($curr_password, $hashed_pwd_from_db)) 
          {
            if($newPassword!=$renewpassword)
            {
                $_SESSION['error_pass'] = "Mot de passe de confirmation est incorrect.";
            }
            else
            {
               $req_change="UPDATE utilisateur SET PWD=? where UTILISATEUR_ID=?";
               $hashed_newPassword=password_hash($newPassword, PASSWORD_DEFAULT);;
               //preparer
               $stmt_change=$bdd->prepare($req_change);
               $stmt_change->bindValue(1,$hashed_newPassword,PDO::PARAM_STR);
               $stmt_change->bindValue(2,$id,PDO::PARAM_INT);
               $stmt_change->execute();
                $_SESSION['success'] = "Mot de passe changé avec succès.";
            }
          }
          else
           {
            $_SESSION['error_pass'] = "Mot de passe actuel incorrect.";
           }
        }
        
        }
      }


      
    //se rediriger vers la page initiale
    header("Location: ..\..\Views\admin\admin_profile.php");
    exit(); // Assurez-vous d'arrêter l'exécution du script après la redirection
?>