
<?php
require_once '..\..\controllers\auth\auth_inc_admin.php';
// session_start();

include '..\..\controllers\admin\liste_projet.php';
include '..\headerX\header_admin.php';
?>
<!----------------MODAL------------------>
<div class="modal fade" id="formModifierProjet" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier Projet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulaire pour ajouter une compétence -->
                    <form action="..\..\controllers\admin\editer_projet.php" method="POST">
                    <div class="mb-3">
                        <input type="hidden" name="projet_id" id="projet_id">
                    </div>
                      <div class="mb-3">
                          <label for="projet_nom" class="form-label">Titre </label>
                          <input type="text" name="newProjetNom" id="projet_nom" class="form-control" required>
                      </div>
                      <div class="mb-3">
                          <label for="projet_descr" class="form-label">Description </label>
                          <textarea name="newProjetDescr" id="projet_descr" class="form-control" rows="5">
                          </textarea>
                      </div>
                      <div class="mb-3">
                          <label for="projet_budget" class="form-label">Budget </label>
                          <input type="text" name="newProjetBudget" id="projet_budget" class="form-control" required>
                      </div>
                      <div class="mb-3">
                          <label for="projet_statut" class="form-label">Statut </label>
                          <select name="newProjetStatut" id="projet_statut" class="form-select" onchange="toggleDateFinModal()">
                            <option value="1">En cours</option>
                            <option value="2">Terminé</option>
                          </select>
                      </div>
                      <div class="mb-3">
                          <label for="projet_date_d" class="form-label">Date début </label>
                          <input type="date" name="newProjetDateD" id="projet_date_d" class="form-control" required>
                      </div>
                      <div class="mb-3" id="date_f" style="display: none;">
                          <label for="projet_date_f" class="form-label">Date fin </label>
                          <input type="date" name="newProjetDateF" id="projet_date_f" class="form-control" required>
                      </div>
                      <!-- Autres champs de formulaire ici -->
                      <button type="submit" name="modifierProjet" class="btn btn-primary">modifier</button>
                    </form>
                     <!-----traitement de date fin------>
                    <script>
                      function toggleDateFinModal() {
                          var statutSelect = document.getElementById("projet_statut");
                          var dateFinDiv = document.getElementById("date_f");

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
    </div>
<!----------------MODAL------------------>



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
                   
                <td>
                <input type="hidden" name="projet_id" value="<?php echo $ligne["PROJET_ID"]; ?>">
                <input type="hidden" name="projet_nom" value="<?php echo $ligne["PROJET_TITRE"]; ?>">  
                <?php echo $ligne['PROJET_TITRE']?>
              </td>
                <td>
                <input type="hidden" name="projet_descr" value="<?php echo $ligne["PROJET_DESCR"]; ?>">  
                  <?php echo $ligne['PROJET_DESCR']?></td>
                <td>
                <input type="hidden" name="projet_budget" value="<?php echo $ligne["BUDGET"]; ?>">
                  <?php echo $ligne['BUDGET']?></td>
                <td>
                <input type="hidden" name="projet_statut" value="<?php  if($ligne["STATUT"] == "En cours") echo "1"; else echo "2"; ?>">
                  <?php echo $ligne['STATUT']?></td>
                <td>
                <input type="hidden" name="projet_date_d" value="<?php echo $ligne["PROJET_DATE_DEBUT"]; ?>">
                  <?php echo $ligne['PROJET_DATE_DEBUT']?></td>
                <td>
                <input type="hidden" name="projet_date_f" value="<?php echo $ligne["PROJET_DATE_FIN"]; ?>">
                  <?php echo $ligne['PROJET_DATE_FIN']?></td>
                <td>
                <td> 
                    <a  type="button" class="btn btn-primary editBtn" data-bs-toggle="modal">
                    <i class="bi bi-pen"></i>
                    </a>
                  
                   <a href="..\..\controllers\admin\supprimer_projet.php?IDD=<?php echo $ligne['PROJET_ID']; ?>" type="button" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                    </td>    
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

  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script>
        $(document).ready(function () {
            $('.editBtn').on('click', function () {
                $('#formModifierProjet').modal('show');
                var projet_id = $(this).closest('tr').find('input[name="projet_id"]').val();
                 var projet_nom = $(this).closest('tr').find('input[name="projet_nom"]').val();
                 var projet_descr = $(this).closest('tr').find('input[name="projet_descr"]').val();
                 var projet_budget = $(this).closest('tr').find('input[name="projet_budget"]').val();
                 var projet_statut = $(this).closest('tr').find('input[name="projet_statut"]').val();
                 var projet_date_d = $(this).closest('tr').find('input[name="projet_date_d"]').val();
                 var projet_date_f = $(this).closest('tr').find('input[name="projet_date_f"]').val();
                 
                $('#projet_id').val(projet_id);
                $('#projet_nom').val(projet_nom);
                $('#projet_descr').val(projet_descr);
                $('#projet_budget').val(projet_budget);
                $('#projet_statut').val(projet_statut);
                $('#projet_date_d').val(projet_date_d);
                $('#projet_date_f').val(projet_date_f);
                
            });
        });
</script>


  <!-- ======= Fin de la page ======= -->
<?php

 include '..\headerX\footer.php';

?>