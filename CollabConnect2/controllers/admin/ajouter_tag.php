<?php
require_once '..\db\connexion.php';
session_start();
$_SESSION['erreur_form']="";
// require_once '..\auth\auth_inc.php';

if(isset($_POST['click']))
{
    $cat=$_POST['tag'];
    $sql="insert into tag(TAG_LIBELLE) values(:t)";
    $stmt=$bdd->prepare($sql);
    $stmt->bindValue('t',$cat,PDO::PARAM_STR);
    $ok = $stmt->execute();
    if (!$ok) {
    // La requête n'a pas été exécutée correctement
    $_SESSION['erreur_form'] = "Erreur lors de l'enregistrement du role de projet.";
    }
    header('location:..\..\Views\admin\gestion_tag.php');
}
?>
