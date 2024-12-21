<?php
require_once 'connexion.php';
require_once 'auth.php';

if(isset($_POST['ok']))
{
    $id=$_POST['NCompte'];
    $somme=$_POST['Somme'];

    $sql="select * from comptes where NCompte=:cmpt";
    $st=$bdd->prepare($sql);
    $st->bindValue('cmpt',$id,PDO::PARAM_INT);
    $st->execute();

    $row=$st->rowCount();
    if($row>0)
    {
        $req = "UPDATE comptes SET solde = solde + :somme";
        $statement = $bdd->prepare($req);
        $statement->bindParam(':somme', $somme,PDO::PARAM_INT);
        $statement->execute();

        header('location:result_depot.php');
    }else
    {
        session_start();
        $_SESSION['error']="utilisateur n'existe pas";
        header('location:depot.php');
    }
}else
{
    $mess="les données ne sont pas transférer";
    header('location:login.php');
}

?>
