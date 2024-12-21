
<?php
require_once '..\..\controllers\auth\auth_inc_admin.php';
// session_start();
include '..\..\controllers\admin\liste_role.php';
include '..\headerX\header_admin.php';
?>
  <!-- ======= Le début de la page ======= -->
 
  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Gestion Role Projet</h1>
      <nav>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
          <li class="breadcrumb-item">Projects</li>
          <li class="breadcrumb-item active">Gestion Role Projet</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Ajouter un role projet</h5>
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
              <form class="row g-3 needs-validation" action="..\..\controllers\admin\ajouter_role.php" method="post" novalidate>
                <div class="col-12">
                  <label class="form-label">Nom</label>
                  <input type="text" class="form-control" value=""  placeholder="Entrer le role" name="nom" required>
                  <div class="invalid-feedback">
                     Veuillez saisir un role.
                  </div>
                </div>
                <div class="col-12">
                  <label class="form-label">Description</label>
                  <input type="text" class="form-control" value=""  placeholder="Entrer la description" name="descr" required>
                  <div class="invalid-feedback">
                    Veuillez saisir une description.
                  </div>
                </div>
                
                
               
                <div class="col-12">
                  <button class="btn btn-primary" type="submit">Ajouter</button>
                </div>
              </form><!-- End Custom Styled Validation -->

            </div>
          </div>

         

       
      </div>
    </section>
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Liste des niveaux de maitrise</h5>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">Role</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($lignes as  $ligne):  ?>
                <tr>
                <td><?php echo $ligne['ROLE_PROJET_TITRE']?></td>
                <td><?php echo $ligne['ROLE_PROJET_DESCR']?></td>
                <td>
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largeModal">
                  <i class="bi bi-pen"></i>
                  </button>
                  <button type="button" class="btn btn-danger">
                    <a style="color:white;" href="..\..\controllers\admin\supprimer_role.php?IDD=<?php echo $ligne['ROLE_PROJET_ID']; ?>"><i class="bi bi-trash"></i></a>
                  </button>
                  
                   <!------debut de large modal----->
                        <!-- Large Modal -->
                        <div class="modal fade" id="largeModal" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Large Modal</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="..\..\controllers\admin\editer_role.php">
                                <div class="mb-3">
                                    <input type="hidden" name="id"  value="<?php echo $ligne["ROLE_PROJET_ID"]; ?>">
                                </div>
                                    <div class="mb-3">
                                        <label for="competence_nom" class="form-label">Nom du role:</label>
                                        <input type="text" name="nom"  class="form-control" value="<?php echo $ligne["ROLE_PROJET_TITRE"]; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="competence_descr" class="form-label">Description du role:</label>
                                        <input name="descr"  class="form-control" value="<?php echo $ligne["ROLE_PROJET_DESCR"]; ?>" required>
                                    </div>
                                    <!-- Autres champs de formulaire ici -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                        <input type="submit"  class="btn btn-primary" value="Modifier">
                                    </div>
                                    
                                </form>
                            </div>
                            
                            </div>
                        </div>
                        </div><!-- End Large Modal-->
                   <!-----fin de large modal------>     
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
// require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\footer.php';

?>