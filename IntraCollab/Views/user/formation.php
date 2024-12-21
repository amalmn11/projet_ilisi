
<!-- ======= NOUVEAU ========================================================================== -->

<?php

require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\header_user.php';
include '..\..\controllers\db\connexion.php';

//session_start();

// Requête d'update pour changer l'état des formations
$req_update_etat ="
UPDATE formation
SET ETAT_FORMATION = CASE
    WHEN NOW() < DATE_DEB_INSCRIPTION THEN 'nouvelle'
    WHEN NOW() BETWEEN DATE_DEB_INSCRIPTION AND DATE_FIN_INSCRIPTION THEN 'Ouverte'
    WHEN NOW() > DATE_FIN_INSCRIPTION AND NOW() < FORMATION_DATE_FIN THEN 'fermee'
    WHEN NOW() > FORMATION_DATE_FIN THEN 'Terminee'
    ELSE ETAT_FORMATION
END
WHERE ETAT_FORMATION != 'Annulee';
";

 // Préparer et exécuter la requête
 $stmt_update = $bdd->prepare($req_update_etat);
 $stmt_update->execute();
///////////////////

//recuperer les formations existantes
$req_formation="SELECT *
FROM formation f
JOIN 
utilisateur u ON f.UTILISATEUR_ID = u.UTILISATEUR_ID";
//preparer la requete
$stmt_formation = $bdd->prepare($req_formation);
$stmt_formation->execute();

// Récupération des résultats
$formations = $stmt_formation->fetchAll();


//recuperer l'utilisateur courrant connecté
$curr_user=$_SESSION["user_id"];



?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../assets/css/details_question.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
        .container2 {
            display: flex;
            align-items: center;
        }
        .title {
            margin-right: 10px;
        }
        .content p {
            margin:0; /* Supprime la marge par défaut du paragraphe pour un meilleur alignement */
        }
     
        .menu-container {
  position: relative;
}

.menu-btn {
  cursor: pointer;
  display: block;
  position: relative;
  z-index: 1;
  height: 30px;
  width: 30px;
}

.menu-btn span {
  background-color: #333;
  display: block;
  height: 2px;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  transition: all 0.3s ease-in-out;
  width: 100%;
}

.menu-btn span:before,
.menu-btn span:after {
  background-color: #333;
  content: '';
  display: block;
  height: 100%;
  position: absolute;
  transition: all 0.3s ease-in-out;
  width: 100%;
}

.menu-btn span:before {
  top: -8px;
}

.menu-btn span:after {
  bottom: -8px;
}

.menu-btn.active span {
  background-color: transparent;
}

.menu-btn.active span:before {
  transform: rotate(45deg);
}

.menu-btn.active span:after {
  transform: rotate(-45deg);
}

.menu {
  background-color: #fff;
  border: 1px solid #ccc;
  display: none;
  list-style: none;
  padding: 10px;
  position: absolute;
  right: 0;
  top: 40px;
  z-index: 0;
}

.menu li {
  margin-bottom: 10px;
}

.menu-container input[type="checkbox"] {
  display: none;
}

.menu-container input[type="checkbox"]:checked + .menu {
  display: block;
}
    </style>
</head>

<body>
<main id="main" class="main">

<div class="pagetitle">
      <h1>Forum</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
          <!-- <li class="breadcrumb-item"></li> -->
          <li class="breadcrumb-item active">Formations</li>
        </ol>
      </nav>
</div><!-- End Page Title -->


<div class="d-flex justify-content-between align-items-center mb-4">
        <h5><strong>Total des Formations :</strong> <?php echo count($formations); ?></h5>
        <a href="planifier_formation.php" class="btn" style="background-color:#0048ae;color:white">Planifier une Formation</a>
</div>
<hr>

<div class="container">

<!------------BEGIN FOREACH------------>
<?php foreach($formations as $formation): ?>
<div class="row" id=<?php echo $formation["FORMATION_ID"]?>>
<div class="col-md-12">
<div id="content" class="content content-full-width">
<section style="padding:0px 30px 0px 30px;" class="section profile">
<div class="box box-widget">
<div class="box-header with-border">
<div class="user-block">
<img class="img-circle" src="..\..\storage\images\<?php echo $formation["IMAGE"]; ?>" alt="User Image">
<span class="username"><a href="#"><?php echo $formation["NOM"]." ".$formation["PRENOM"]; ?></a></span>
<span class="description">
<span class="badge badge-status badge-primary">
<?php
$req_inscrits="SELECT * FROM utilisateur_formation where FORMATION_ID=?;";
// Préparation de la requête
$stmt_inscrits = $bdd->prepare($req_inscrits);
// Liaison des valeurs
$stmt_inscrits->bindParam(1,$formation["FORMATION_ID"], PDO::PARAM_INT);
// Exécution de la requête
$stmt_inscrits->execute();

// Date actuelle
$date_actuelle = time();
//date fine de formation
$date_fin_formation = strtotime($formation["FORMATION_DATE_FIN"]);
$date_deb_inscr = strtotime($formation["DATE_DEB_INSCRIPTION"]);
$date_fin_inscr = strtotime($formation["DATE_FIN_INSCRIPTION"]);
// Récupération des résultats
$resultats_inscrits = $stmt_inscrits->fetchAll(PDO::FETCH_ASSOC);
/*if (count($resultats_inscrits) == 0)
echo "Nouvelle";
else if(($date_actuelle>$date_deb_inscr)&&($date_actuelle<$date_fin_inscr))
echo "Ouverte";
else if(($date_actuelle>$date_fin_inscr)&&($date_actuelle < $date_fin_formation))
echo "Fermée";
else if($date_actuelle > $date_fin_formation)
echo "Terminée";*/
echo $formation["ETAT_FORMATION"];

?>
</span>
</span>
</div>

<div class="box-tools">
<?php if ($formation["UTILISATEUR_ID"] == $curr_user && $formation['ETAT_FORMATION']!= "Annulee"): ?>
  <a class="nav-link" href="#" data-bs-toggle="dropdown">
      <span>
          &#x2022;&#x2022;&#x2022;
      </span>
      </a><!-- End Three points -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
          <li class="dropdown-header">
          <a  href="modifier_formation.php?IDD=<?php echo $formation["FORMATION_ID"]; ?>">Modifier </a></li>
      
          <?php if(count($resultats_inscrits) == 0):?>
              <li>
                  <hr class="dropdown-divider">
              </li>
              <li class="dropdown-header">
              <a href="..\..\controllers\user\supprimer_formationAction.php?IDD=<?php echo $formation["FORMATION_ID"];?>">Supprimer</a>
            </li>
          <?php elseif((count($resultats_inscrits) != 0)&&(($date_actuelle>$date_deb_inscr)&&($date_actuelle<$date_fin_inscr))):?>
              <li>
                  <hr class="dropdown-divider">
              </li>

              <li class="dropdown-header">
              <a href="..\..\controllers\user\annuler_formationAction.php?IDD=<?php echo $formation["FORMATION_ID"];?>">Annuler</a></li>
          <?php endif?>
      </li>
      </ul>
<?php else:?>
<?php 
//tester si l'utilisateur connecté est deja inscrit dans une formation
$req_is_inscrit="SELECT * FROM utilisateur_formation where FORMATION_ID=? and
UTILISATEUR_ID=?;";
// Préparation de la requête
$stmt_is_inscrit = $bdd->prepare($req_is_inscrit);
// Liaison des valeurs
$stmt_is_inscrit->bindParam(1, $formation["FORMATION_ID"],PDO::PARAM_INT);
$stmt_is_inscrit->bindParam(2,$curr_user, PDO::PARAM_INT);
// Exécution de la requête
$stmt_is_inscrit->execute();
// Récupération du résultat
$result_is_inscrit = $stmt_is_inscrit->fetchAll(PDO::FETCH_ASSOC);
$deb_inscription = $formation["DATE_DEB_INSCRIPTION"];
$date_actuelle_timestamp = time();
$date_deb_inscription_timestamp = strtotime($deb_inscription);

  echo '<div class="box-tools">';
  if(($formation["ETAT_FORMATION"] == 'Ouverte'))//Annulée
  {
    if (count($result_is_inscrit) > 0) 
    {
        // Si FORMATION_ID est égal à 10, afficher le bouton non-cliquable avec une couleur d'étiquette orange
        //echo '<button type="button" style="height:30px;" class="btn btn-warning" disabled>Inscrit</button>';
        echo '<a href="..\..\controllers\user\desabonner.php?id='.$formation["FORMATION_ID"].'"><button type="button" class="btn btn-outline-warning">Se désabonner</button></a>';
    } else{
        // Sinon, afficher le bouton cliquable habituel
        echo '<a href="..\..\controllers\user\inscrire_formation.php?IDD='.$formation["FORMATION_ID"].'"><button type="button" style="height:30px;" class="btn btn-primary">S\'inscrire</button></a>';
    }
  }

  echo '</div>';
  ?>
  <?php endif;?>

</div>

</div>
<div class="box-body">
<div class="container2">
        <div class="title">
        <h6>Theme:</h6>
        </div>
        <div class="content">
            <p><?php echo $formation["THEME"]; ?></p>
        </div>
</div>

<div class="container2">
<div class="title">
<h6>Description:</h6>
</div>
<div class="content">
    <p><?php echo $formation["FORMATION_DESCR"]; ?></p>
</div>      
</div>

<div class="container2">
<div class="title">
<h6>Formateur:</h5>
</div>
<div class="content">
    <p><?php echo $formation["FORMATEUR"]; ?></p>
</div>      
</div>

<div class="container2">
<div class="title">
<h6>Volume Horaire :</h6>
</div>
<div class="content">
    <p><?php echo $formation["VOLUME_HORAIRE"]. " heures"; ?></p>
</div>      
</div>

<div class="container2">
<div class="title">
    <h6>Lien de La Formation :</h6>
</div>
<div class="content">
    <p><a href="<?php echo $formation["FORMATION_LIEN"]; ?>"><?php echo $formation["FORMATION_LIEN"]; ?></a></p>
</div>      
</div>


<table width="100%">

<tr>
  <td width="50%"><div class="container2">
<div class="title">
    <h6>Date Début Inscription:</h6>
</div>
<div class="content">
    <p><?php echo $formation["DATE_DEB_INSCRIPTION"]; ?></p>
</div>      
</div></td>

  <td width="50%">
<div class="container2">
<div class="title">
    <h6>Date Fin Inscription:</h6>
</div>
<div class="content">
    <p><?php echo $formation["DATE_FIN_INSCRIPTION"]; ?></p>
</div>      
</div></td>
</tr>

<tr>
  <td><div class="container2">
<div class="title">
    <h6>Date Début Formation:</h6>
</div>
<div class="content">
    <p><?php echo $formation["FORMATION_DATE_DEBUT"]; ?></p>
</div>      
</div></td>


  <td><div class="container2">
<div class="title">
    <h6>Date Fin Formation:</h6>
</div>
<div class="content">
    <p><?php echo $formation["FORMATION_DATE_FIN"]; ?></p>
</div>      
</div></td>
</tr>
</table>



</div>
</section>
</div>
</div>
</div>
<?php endforeach; ?>
<!------------END FOREACH------------>



</div>


</main>


   

<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
  const menuToggle = document.getElementById("menu-toggle");
  const menu = document.querySelector(".menu");

  // Ajoute un écouteur d'événement au changement de la case à cocher
  menuToggle.addEventListener("change", function() {
    // Si la case à cocher est cochée, affiche le menu, sinon le cache
    if (menuToggle.checked) {
      menu.style.display = "block";
    } else {
      menu.style.display = "none";
    }
  });
});
</script>


 <!-- ======= Fin de la page ======= -->
 <?php

include '..\headerX\footer.php';

?>




















