<?php
try
{
    $bdd=new PDO("mysql:host=localhost;dbname=banque;","root","");
    echo "connexion réussite";
}catch(PDOException $e)
{
    echo 'connexion echoué'.$e->getMessage();
}
?>