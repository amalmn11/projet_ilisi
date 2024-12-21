<?php

 // Se connecter à la base de données
 require_once '..\db\connexion.php';
 echo 'tst';

 session_start();

 if(isset($_SESSION['erreur'])) unset($_SESSION['erreur']);
 //recuperation des donnees saisits

 $email=$_POST['email'];
 $password=$_POST['password'];
 //la requete pour tester si login et mot de passe existe
 $req_auth="SELECT * FROM utilisateur WHERE  EMAIL=?";
 //preparer la requete
 $stmt_auth=$bdd->prepare($req_auth);
 $stmt_auth->bindValue(1,$email,PDO::PARAM_STR);
 //executer la requete
 $stmt_auth->execute();
 
 //fetch the result
 $resultat=$stmt_auth->fetchAll(PDO::FETCH_ASSOC);
 if(count($resultat) > 0) {
    echo 'count';
      $hashed_password=$resultat[0]['PWD'];
      if (password_verify($password, $hashed_password)) //si le mot de passe est correct
      {
        echo 'verify';
            //creation de session de login
            $_SESSION["auth"]=$resultat[0]["NOM"] . " " . $resultat[0]["PRENOM"];
            $_SESSION['user_email'] = $resultat[0]["EMAIL"];
            $_SESSION["image"]=$resultat[0]["IMAGE"];
            $_SESSION["user_id"]=$resultat[0]["UTILISATEUR_ID"];//user id c'est l'id d'utilisateur dans la base de données soit admin soit collab
            unset($_SESSION['erreur']);
            // Rediriger vers une autre page si l'authentification réussit
            $role = $resultat[0]["ROLE_ID"];
            if($role == 1) 
            {  echo 'role = 1';
                $_SESSION["admin"]=1;
                header('Location:..\..\Views\admin\admin_index.php');
                
            }
            else 
            {
                echo 'role=2';
                //si le nom est vide cela veut dire qu'il s'uathentifier pour la premiere fois
                if($resultat[0]['NOM']=="") header('location:..\..\Views\user\completer_profile.php');
                
                else header('location:..\..\Views\user\user_index.php');
            }
     }
     else  $_SESSION['erreur']="Mot de passe incorrect";
    
 } 
 else {
    echo 'else';
   $_SESSION['erreur']="Email incorrect";
 }
 




?>