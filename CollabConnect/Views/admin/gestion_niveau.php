
<?php
//session_start();
require_once '..\..\controllers\auth\auth_inc_admin.php';
include '..\headerX\header_admin.php';
include '..\..\controllers\admin\liste_niveau.php';

?>
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
                  
                    <textarea  placeholder="Text.." name="niv_descr" class="form-control" required></textarea>
                    <div class="invalid-feedback">
                    Veuillez saisir la description du niveau.
                  </div>
                  
                 
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
                    <th>
                      <b>ID</b>Niveau
                    </th>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                
                    <?php foreach($lignes as $ligne): ?>
                  <tr>
                    <td> <?php echo $ligne["NIVEAU_ID"]; ?></td>
                    <td><?php echo $ligne["NIVEAU_TITRE"]; ?></td>
                    <td><?php echo $ligne["NIVEAU_DESCR"]; ?></td>
                    <td> 
                    <a href="modifier_niveau.php?id=<?php echo $ligne["NIVEAU_ID"]; ?>" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formModifierNiveau">
                    <i class="bi bi-pen"></i>
                    </a>
                    <?php //include "modifier_niveau.php"; ?>
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

  <!-- ======= Fin de la page ======= -->
  <?php
// require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\footer.php';

?>