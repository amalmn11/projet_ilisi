<?php
      // Vérifier si la connexion a réussi
    try{
        
    $bdd = new PDO('mysql:host=localhost;dbname=projet_web2024','root','');
    
    // echo "Connexion reussi";
    }
    catch(PDOException $e){
      //  echo "Connexion échouée :" .$e->getMessage();
    }    
?>