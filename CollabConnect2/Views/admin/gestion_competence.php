
<?php
require_once '..\..\controllers\auth\auth_inc_admin.php';

include '..\headerX\header_admin.php';
include '..\..\controllers\admin\liste_competence.php';
?>
<!----------------MODAL------------------>
<div class="modal fade" id="formModifierCompetence" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier Competence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulaire pour ajouter une compétence -->
                    <form action="..\..\controllers\admin\editer_competence.php" method="POST">
                    <div class="mb-3">
                        <input type="hidden" name="competence_id" id="competence_id">
                    </div>
                        <div class="mb-3">
                            <label for="competence_nom" class="form-label">Nom de la Compétence:</label>
                            <input type="text" name="newCompetenceNom" id="competence_nom" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="competence_descr" class="form-label">Description de la Compétence:</label>
                            <textarea name="newCompetenceDescr" id="competence_descr" class="form-control" rows="5">
                              
                            </textarea>
                        </div>
                        <!-- Autres champs de formulaire ici -->
                        <button type="submit" name="modifierComp" class="btn btn-primary">modifier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!----------------MODAL------------------>
  <!-- ======= Le début de la page ======= -->
 
  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Gestion Compétence</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
          <li class="breadcrumb-item">Compétences</li>
          <li class="breadcrumb-item active">Gestion Compétence</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Ajouter une compétence</h5>
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
              <form method="POST" action="..\..\controllers\admin\ajouter_competence.php" class="row g-3 needs-validation" novalidate>
                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Nom de la Compétence</label>
                  <input type="text" name="comp_nom" class="form-control"  value="" placeholder="Saisir une compétence" required>
                  <div class="invalid-feedback">
                  Veuillez saisir une Compétence.
                  </div>
                </div>

                <div class="col-12">
                  <label for="validationCustom02" class="form-label">Description de la Compétence</label>
                  
                    <textarea  placeholder="Saisir une description" name="comp_descr" class="form-control" ></textarea>
                    <!-- <div class="invalid-feedback">
                    Veuillez saisir la description de compétence.
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
              <h5 class="card-title">Liste des compétences</h5>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>
                      <b>ID</b>
                    </th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                
                    <?php foreach($lignes as $ligne): ?>
                  <tr>
                    <td>
                      <input type="hidden" name="competence_id" value="<?php echo $ligne["COMPETENCE_ID"]; ?>">
                       <?php echo $ligne["COMPETENCE_ID"]; ?>
                    </td>
                    <td>
                      <input type="hidden" name="competence_nom" value="<?php echo $ligne["COMPETENCE_NOM"]; ?>">
                      <?php echo $ligne["COMPETENCE_NOM"]; ?>
                    </td>
                    <td>
                      <input type="hidden" name="competence_descr" value="<?php echo $ligne["COMPETENCE_DESCR"]; ?>">
                      <?php echo $ligne["COMPETENCE_DESCR"]; ?>
                    </td>
                    <td> 
                    <a  type="button" class="btn btn-primary editBtn" data-bs-toggle="modal">
                    <i class="bi bi-pen"></i>
                    </a>
                  
                   <a href="..\..\controllers\admin\supprimer_competence.php?IDD=<?php echo $ligne["COMPETENCE_ID"]; ?>" type="button" class="btn btn-danger"><i class="bi bi-trash"></i></a>
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
                $('#formModifierCompetence').modal('show');
                var competenceId = $(this).closest('tr').find('input[name="competence_id"]').val();
                 var competenceNom = $(this).closest('tr').find('input[name="competence_nom"]').val();
                 var competenceDescr = $(this).closest('tr').find('input[name="competence_descr"]').val();
                $('#competence_id').val(competenceId);
                $('#competence_nom').val(competenceNom);
                $('#competence_descr').val(competenceDescr);
            });
        });
</script>

  <!-- ======= Fin de la page ======= -->
  <?php
// require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\footer.php';

?>