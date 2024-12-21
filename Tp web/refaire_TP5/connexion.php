<?php

try{
    $bdd=new pdo("mysql:host=localhost;dbname=ecole","root","");
    echo "connexion reussite <br>";
}catch(PDOException $e)
{
    die("connexion echoué $e.getMessage()");
}

?>