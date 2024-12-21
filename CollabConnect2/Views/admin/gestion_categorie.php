
<?php

require_once '..\..\controllers\auth\auth_inc_admin.php';

include '..\headerX\header_admin.php';
require_once '..\..\controllers\db\connexion.php';

$req="select * from categorie";
$res=$bdd->query($req);
$result=$res->fetchall(PDO::FETCH_ASSOC);
?>

<!---------------MODAL------------------->
<div class="modal fade" id="formModifierCategorieProjet" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier Categorie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="..\..\controllers\admin\editer_categorie.php" method="post">
                    <div class="mb-3">
                        <input type="hidden" name="cateorie_id" id="cateorie_id">
                    </div>
                        <div class="mb-3">
                            <label for="cateorie_nom" class="form-label">Libelle Categorie </label>
                            <input type="text" name="cateorie_nom" id="cateorie_nom" class="form-control"  required>
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
      <h1>Gestion Catégorie</h1>
      <nav>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
          <li class="breadcrumb-item">Base de connaissance</li>
          <li class="breadcrumb-item active">Gestion Catégorie</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Ajouter catégorie</h5>
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
              <form action="..\..\controllers\admin\ajouter_categorie.php" method="POST" class="row g-3 needs-validation" novalidate>
                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Catégorie</label>
                  <input type="text" name="categorie" class="form-control" id="validationCustom01" value=""  placeholder="Entrez le libelle de la catégorie" required>
                  <div class="invalid-feedback">
                     Veuillez saisir une catégorie.
                  </div>
                </div>
               
                <div class="col-12">
                  <button class="btn btn-primary" name="click" type="submit">Ajouter</button>
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
              <h5 class="card-title">Liste des catégories</h5>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>
                      <b>ID</b>
                    </th>
                    <th>
                      <b>L</b>ibelle de la catégorie
                    </th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($result as $ligne): ?>
                  <tr>
                    <td>
                      <input type="hidden" name="cateorie_id" value="<?php echo $ligne["CATEGORIE_ID"]; ?>">
                      <?php echo $ligne['CATEGORIE_ID']; ?>
                    </td>
                    <td>
                      <input type="hidden" name="cateorie_nom" value="<?php echo $ligne["CATEGORIE_LIBELLE"]; ?>">
                      <?php echo $ligne['CATEGORIE_LIBELLE']; ?>
                    </td>
                    <td> 
                        <a  type="button" class="btn btn-primary editBtn" data-bs-toggle="modal">
                          <i class="bi bi-pen"></i>
                        </a> 
                        <a href="..\..\controllers\admin\supprimer_categorie.php?id=<?php echo $ligne['CATEGORIE_ID']; ?>"><button type="button" class="btn btn-danger"><i class="bi bi-trash"></i></button></a>
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script>
        $(document).ready(function () {
            $('.editBtn').on('click', function () {
                $('#formModifierCategorieProjet').modal('show');
                var role_id = $(this).closest('tr').find('input[name="cateorie_id"]').val();
                 var role_nom = $(this).closest('tr').find('input[name="cateorie_nom"]').val();
                $('#cateorie_id').val(role_id);
                $('#cateorie_nom').val(role_nom);
            });
        });
</script>


<?php
include '..\headerX\footer.php';
?>