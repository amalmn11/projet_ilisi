<?php

require_once '..\..\controllers\auth\auth_inc.php';
require_once '..\..\controllers\db\connexion.php';
include '..\headerX\header_user.php';


//recuperation des données
// session_start();
$user=$_SESSION["user_id"];
$sql="select * from projet p,utilisateur_projet up,role_projet r 
      where up.UTILISATEUR_ID=:ui and up.PROJET_ID=p.PROJET_ID and r.ROLE_PROJET_ID=up.ROLE_PROJET_ID";
$stmt=$bdd->prepare($sql);
$stmt->bindValue('ui',$user,PDO::PARAM_STR);
$stmt->execute();

$projet=$stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .fade {
    transition-duration: 0.3s; /* ajustez la durée au besoin */
}

    </style>

    <link rel="stylesheet" href="..\..\assets\css\projet.css">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- JavaScript Bootstrap 3.3.5 -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="../../assets/js/bootstrap.min.js"></script>
<script src="../../assets/js/main.js"></script>
</head>
<body>
<main id="main" class="main">
    
    <div class="profile-description">
        <i style="font-size: 30px; display: inline-block;"  class="bi bi-laptop"></i>
        <h2 style="display: inline;">Projets</h2>
        <?php  foreach($projet as $ligne): ?>
        <div class="profile-desc-row"> 
            <img src="..\..\assets\img\favicon.png"> 
            <div>
                <h4><?php  echo $ligne['PROJET_TITRE']; ?></h4>
                <div id="info">
                    <div class="formation"><b>Role dans le projet : </b><?php echo $ligne['ROLE_PROJET_TITRE']; ?></div>
                    <div class="date"><b>Date de Debut : </b><?php echo $ligne['PROJET_DATE_DEBUT']; ?></div>
                    <div class="date"><b>Date du Fin : </b><?php echo $ligne['PROJET_DATE_FIN']; ?></div>
                    <div class="descr">
                    <b >Description du Role: </b>
                        <p id="pp"><?php  echo $ligne['ROLE_PROJET_DESCR']; ?></p>
                    
                    </div>
                </div>
                <a href="..\..\controllers\user\retirer_projet.php?id=<?php echo $ligne['PROJET_ID']; ?>&role=<?php echo $ligne['ROLE_PROJET_ID']; ?>"><button type="button" class="btn btn-outline-warning">Retirer la participation</button></a>
                <i id="icon" style="font-size: 25px; display: inline-block; cursor: pointer;" class="bi bi-headset"></i>
                <hr style="height: 1.5px; background-color: rgba(0, 0, 0, 0.8);">
            </div>
        </div>
        <?php  endforeach; ?>
    </div>
    <!-- Small modal
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>

<div class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      ...
    </div>
  </div>
</div> -->

</main>


</body>
</html>

<!-- 
    welcome user
    <button><a href="../../controllers/db/deconnexion.php">decnx</a></button> -->


<?php
// require_once '..\..\controllers\auth\auth_inc.php';
//include '..\headerX\footer.php';

?>