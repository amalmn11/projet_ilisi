<?php
require_once 'conn.php';
// $req=NULL;
// $log=$_POST['login'];
// $pass=$_POST['pass'];

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    if(!empty($_POST['login']) && !empty($_POST['pass']))
    {
        $req="select * from comptes where login=:log and passord=:pass";
        $stmt=$bdd->prepare($req);
        $stmt->bindValue("log",$_POST['login']);
        $stmt->bindValue("pass",$_POST['pass']);
        $stmt->execute();
        $result=$stmt->fetch();
        if($result)
        
    }
}
?>