<?php

require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\header_user.php';
include '..\..\controllers\db\connexion.php';
include '..\..\controllers\admin\liste_projet.php';//recupere la liste dans un var lignes
unset( $_SESSION["id_projet"]);

// Requête d'update pour changer l'état des formations
$req_update_etat_projet = "
UPDATE projet
SET STATUT = CASE
    WHEN NOW() >= PROJET_DATE_FIN THEN 'Termine'
    ELSE STATUT
END;
";

 // Préparer et exécuter la requête
 $stmt_update = $bdd->prepare($req_update_etat_projet);
 $stmt_update->execute();

?>


<main id="main" class="main">
    <div class="pagetitle">
      <h1>Projet</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
          <!-- <li class="breadcrumb-item"></li> -->
          <li class="breadcrumb-item active">Projet</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">

    <?php foreach ($lignes as  $ligne):  ?>

      <!-- <div class="row"> -->
         
        <!-- Card with an image on left -->
        <div class="card mb-3" id=<?php echo $ligne["PROJET_ID"]; ?>>
            <div class="row">
              <div class="col-md-3">
                <img src="../../assets/img/work.png" class="img-fluid rounded-start" alt="..." >
              </div>
              <div class="col-md-8">
                <div class="card-body" >
                  <h5 class="card-title"><?php echo $ligne["PROJET_TITRE"]; ?></h5>
                 
                  <?php if($ligne['STATUT']== "En cours"):?>
                    <h6 class="card-subtitle mb-2 text-muted">Projet <?php echo $ligne['STATUT']?> <i class="bi bi-gear-fill" ></i> </h6>
                  <?php else:?>
                    <h6 class="card-subtitle mb-2 text-muted">Projet <?php echo $ligne['STATUT']?> <i class="bi bi-check-circle-fill"></i></h6>
                <?php endif;?>
                    <div class="mt-4">
                    <a href="details_projet.php?IDD=<?php echo $ligne["PROJET_ID"]; ?>" type="button" class="btn btn-dark">Afficher détails <i class="bi bi-arrow-right"></i></a>
                    
                  </div>
              </div>
              </div>             
            </div>
          </div><!-- End Card with an image on left -->
             
      <!-- </div> -->
      <?php endforeach;?>


    </section>
  

  </main><!-- End #main -->

<?php
// require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\footer.php';

?>