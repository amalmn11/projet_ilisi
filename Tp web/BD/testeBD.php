<?php
$serveur="localhost";
$login="root";
$pass="";
try
{
$bdd=new PDO("mysql:host=$serveur",$login,$pass);
echo 'connexion réussie<br>';
$bdd->exec("CREATE DATABASE testç");
echo 'base de donnée créée';
}
catch(PDOException $e)
{
echo 'Echec de la connexion:'.$e->getMessage();
}
?>