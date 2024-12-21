
<?php
//session_start();
require_once '..\..\controllers\auth\auth_inc_admin.php';
include '..\headerX\header_admin.php';
include '..\..\controllers\admin\liste_niveau.php';

?>

<!---------------MODAL------------------->
<div class="modal fade" id="formModifierNiveau" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier Niveau</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="..\..\controllers\admin\editer_niveau.php" method="post">
                    <div class="mb-3">
                        <input type="hidden" name="niv_id" id="niveau_id"  >
                    </div>
                        <div class="mb-3">
                            <label for="niv_titre" class="form-label">Titre de niveau:</label>
                            <input type="text" name="newNiveauTitre" id="niveau_titre" class="form-control"  required>
                        </div>
                        <div class="mb-3">
                            <label for="niv_descr" class="form-label">Description de Niveau:</label>
                            <textarea name="newNivDescr" id="niveau_descr" class="form-control" rows="5">
                            
                            </textarea>
                        </div>
                        <!-- Autres champs de formulaire ici -->
                        <button type="submit" name="modifierNiveau" class="btn btn-primary">modifier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!---------------MODAL------------------->

  <!-- ======= Le début de la page ======= -->
 
  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Gestion Niveau Maitrise</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
          <li class="breadcrumb-item">Compétences</li>
          <li class="breadcrumb-item active">Gestion Niveau Maitrise</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Ajouter un niveau de maitrise</h5>
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
              <form method="POST" action="..\..\controllers\admin\ajouter_niveau.php" class="row g-3 needs-validation" novalidate>
                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Titre de Niveau</label>
                  <input type="text" name="niv_titre" class="form-control"  value="" placeholder="saisir un titre de niveau" required>
                  <div class="invalid-feedback">
                  Veuillez saisir le titre du niveau.
                  </div>
                </div>
                <div class="col-12">
                  <label for="validationCustom02" class="form-label">Description de Niveau</label>
                  
                    <textarea  placeholder="Text.." name="niv_descr" class="form-control" ></textarea>
                    <!-- <div class="invalid-feedback">
                    Veuillez saisir la description du niveau.
                  </div> -->
                  
                 
                </div>
                
               
                <div class="col-12">
                  <button class="btn btn-primary" type="submit">Ajouter </button>
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
              <h5 class="card-title">Liste des Niveaux</h5>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                   
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                
                    <?php foreach($lignes as $ligne): ?>
                  <tr>
                    <td>
                    <input type="hidden" name="niveau_id" value="<?php echo $ligne["NIVEAU_ID"]; ?>"> 
                    <input type="hidden" name="niveau_titre" value="<?php echo $ligne["NIVEAU_TITRE"];  ?>">  
                    <?php echo $ligne["NIVEAU_TITRE"]; ?>
                  </td>
                    <td>
                    <input type="hidden" name="niveau_descr" value="<?php echo $ligne["NIVEAU_DESCR"];  ?>">
                      <?php echo $ligne["NIVEAU_DESCR"]; ?></td>
                    <td> 
                    <a  type="button" class="btn btn-primary editBtn" data-bs-toggle="modal">
                    <i class="bi bi-pen"></i>
                    </a>
                   
                   <a href="..\..\controllers\admin\supprimer_niveau.php?IDD=<?php echo $ligne["NIVEAU_ID"]; ?>" type="button" class="btn btn-danger"><i class="bi bi-trash"></i></a>
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
                $('#formModifierNiveau').modal('show');
                var niveauId = $(this).closest('tr').find('input[name="niveau_id"]').val();
                 var niveauNom = $(this).closest('tr').find('input[name="niveau_titre"]').val();
                 var niveauDescr = $(this).closest('tr').find('input[name="niveau_descr"]').val();
                $('#niveau_id').val(niveauId);
                $('#niveau_titre').val(niveauNom);
                $('#niveau_descr').val(niveauDescr);
            });
        });
</script>

  <!-- ======= Fin de la page ======= -->
  <?php
// require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\footer.php';

?>