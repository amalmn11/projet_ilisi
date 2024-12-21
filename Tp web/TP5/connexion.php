<?php

try{
    $bdd= new PDO("mysql:host=localhost;dbname=ecole;","root","");
    echo "connexion reussite";
}
catch(PDOException $e)
{
    echo "connexion n'est pas reussite".$e->getMessage();
}

?>
