
<?php
require_once '..\..\controllers\auth\auth_inc_admin.php';
// session_start();
include '..\..\controllers\admin\liste_role.php';
include '..\headerX\header_admin.php';
?>



<!---------------MODAL------------------->
<div class="modal fade" id="formModifierRoleProjet" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier Role Projet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="..\..\controllers\admin\editer_role.php" method="post">
                    <div class="mb-3">
                        <input type="hidden" name="role_id" id="role_id"  >
                    </div>
                        <div class="mb-3">
                            <label for="role_nom" class="form-label">Nom </label>
                            <input type="text" name="role_nom" id="role_nom" class="form-control"  required>
                        </div>
                        <div class="mb-3">
                            <label for="role_descr" class="form-label">Description </label>
                            <textarea name="role_descr" id="role_descr" class="form-control" rows="5">
                            
                            </textarea>
                        </div>
                        <!-- Autres champs de formulaire ici -->
                        <button type="submit" name="modifierRole" class="btn btn-primary">modifier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!---------------MODAL------------------->
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
                  <input type="text" class="form-control" value=""  placeholder="Entrer la description" name="descr" >
                  <!-- <div class="invalid-feedback">
                    Veuillez saisir une description.
                  </div> -->
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
                <td> 
                  <input type="hidden" name="role_id" value="<?php echo $ligne["ROLE_PROJET_ID"]; ?>">
                  <input type="hidden" name="role_nom" value="<?php echo $ligne["ROLE_PROJET_TITRE"]; ?>">
                  <?php echo $ligne['ROLE_PROJET_TITRE']?></td>
                <td> 
                  <input type="hidden" name="role_descr" value="<?php echo $ligne["ROLE_PROJET_DESCR"]; ?>">
                  <?php echo $ligne['ROLE_PROJET_DESCR']?></td>
                <td>
                  <a  type="button" class="btn btn-primary editBtn" data-bs-toggle="modal">
                    <i class="bi bi-pen"></i>
                  </a>  
                  <a href="..\..\controllers\admin\supprimer_role.php?IDD=<?php echo $ligne["ROLE_PROJET_ID"]; ?>" type="button" class="btn btn-danger"><i class="bi bi-trash"></i></a>        
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
                $('#formModifierRoleProjet').modal('show');
                var role_id = $(this).closest('tr').find('input[name="role_id"]').val();
                 var role_nom = $(this).closest('tr').find('input[name="role_nom"]').val();
                 var role_descr = $(this).closest('tr').find('input[name="role_descr"]').val();
                $('#role_id').val(role_id);
                $('#role_nom').val(role_nom);
                $('#role_descr').val(role_descr);
            });
        });
</script>

  <!-- ======= Fin de la page ======= -->
  <?php
// require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\footer.php';

?>