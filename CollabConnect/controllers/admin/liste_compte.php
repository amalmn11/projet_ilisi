<?php
  // Se connecter à la base de données
  require_once '..\..\controllers\db\connexion.php';

 // pour recuperation des donnees apartir select on utilise query
 $req="SELECT * FROM utilisateur WHERE ROLE_ID = 2";
 $stmt = $bdd->query($req);
 $lignes = $stmt->fetchAll(PDO::FETCH_ASSOC);
 $nb_comptes =count($lignes);

?>