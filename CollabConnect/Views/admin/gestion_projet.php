
<?php
require_once '..\..\controllers\auth\auth_inc_admin.php';
// session_start();

include '..\..\controllers\admin\liste_projet.php';
include '..\headerX\header_admin.php';
?>
  <!-- ======= Le début de la page ======= -->
 
  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Gestion Projet</h1>
      <nav>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
          <li class="breadcrumb-item">Projets</li>
          <li class="breadcrumb-item active">Gestion Projet</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Ajouter un projet</h5>
              <!---message de l'etat de requete---->
              <?php 
             
              if(isset($_SESSION['erreur_form'])){
                if (!empty($_SESSION['erreur_form'])) 
                {
                  echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$_SESSION['erreur_form'].
                  '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                }
                else echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Enregistrement bien effectué.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
              }
              unset($_SESSION['erreur_form']);
            
              ?>
              
               <!---fin message de l'etat de requete---->

              <!-- Custom Styled Validation -->
              <form class="row g-3 needs-validation" action="..\..\controllers\admin\ajouter_projet.php" method="post" novalidate>
                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Titre</label>
                  <input type="text" class="form-control" id="validationCustom01" value="" placeholder="Entrer le titre" name="nom" required>
                  <div class="invalid-feedback">
                     Veuillez saisir le titre du projet.
                  </div>
                </div>
                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Description</label>
                  <input type="text" class="form-control" id="validationCustom01" value="" placeholder="Entrer le description" name="descr" required>
                  <div class="invalid-feedback">
                     Veuillez saisir la description du projet.
                  </div>
                </div>
                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Budget</label>
                  <input type="text" class="form-control" id="validationCustom01" value="" placeholder="Entrer le Budget" name="budget" required>
                  <div class="invalid-feedback">
                     Veuillez saisir le budget du projet.
                  </div>
                </div>
                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Statut</label>
                  <select class="form-select" aria-label="Default select example" name="statut" id="statutSelect" onchange="toggleDateFin()" required>
                      
                    <option selected>-----Choisir un statut------</option>
                    <option value="1">En cours</option>
                    <option value="2">Terminé</option>
                  </select>
                  
                  <div class="invalid-feedback">
                     Veuillez saisir le statut du projet.
                  </div>
                </div>
                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Date début</label>
                  <input type="date" class="form-control"  name="date_d">
                </div>
                <div class="col-12" id="dateFinDiv" style="display: none;">
                  <label for="validationCustom01" class="form-label">Date fin</label>
                  <input type="date" class="form-control"  name="date_f">
                </div>
               
               
                <div class="col-12">
                  <button class="btn btn-primary" type="submit">Ajouter</button>
                </div>
              </form><!-- End Custom Styled Validation -->
              <!-----traitement de date fin------>
              <script>
                function toggleDateFin() {
                    var statutSelect = document.getElementById("statutSelect");
                    var dateFinDiv = document.getElementById("dateFinDiv");

                    // Si "Terminé" est sélectionné, afficher le div, sinon le cacher
                    if (statutSelect.value === "2") {
                        dateFinDiv.style.display = "block";
                    } else {
                        dateFinDiv.style.display = "none";
                    }
                }
              </script>
              <!-----fin de traitement de date fin------->

            </div>
          </div>

         

       
      </div>
    </section>
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Liste des projets</h5>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                  <thead>
                  <tr>
                  <th scope="col">Titre</th>
                    <th scope="col">Description</th>
                    <th scope="col">Budget</th>
                    <th scope="col">Statut</th>
                    <th data-type="date" data-format="YYYY/DD/MM">Date Début</th>
                    <th data-type="date" data-format="YYYY/DD/MM">Date Fin</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($lignes as  $ligne):  ?>
                <tr>
                   
                <td><?php echo $ligne['PROJET_TITRE']?></td>
                <td><?php echo $ligne['PROJET_DESCR']?></td>
                <td><?php echo $ligne['BUDGET']?></td>
                <td><?php echo $ligne['STATUT']?></td>
                <td><?php echo $ligne['PROJET_DATE_DEBUT']?></td>
                <td><?php echo $ligne['PROJET_DATE_FIN']?></td>
                <td>
                <button type="button" class="btn btn-primary"><i class="bi bi-pen"></i></button>
                  <button type="button" class="btn btn-danger">
                    <a style="color:white;" href="..\..\controllers\admin\supprimer_projet.php?IDD=<?php echo $ligne['PROJET_ID']; ?>"><i class="bi bi-trash"></i></a>
                  </button>
                 
                </td>
                </tr>
                    
                <?php endforeach; ?>
                </tbody>
                    
               
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Fin de la page ======= -->
<?php

 include '..\headerX\footer.php';

?>