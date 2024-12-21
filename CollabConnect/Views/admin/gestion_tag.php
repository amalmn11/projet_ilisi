
<?php
require_once '..\..\controllers\auth\auth_inc_admin.php';

include '..\headerX\header_admin.php';
require_once '..\..\controllers\db\connexion.php';

$req="select * from tag";
$res=$bdd->query($req);
$result=$res->fetchall(PDO::FETCH_ASSOC);
?>
  <!-- ======= Le début de la page ======= -->
 
  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Gestion Tag</h1>
      <nav>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
          <li class="breadcrumb-item">Base de connaissance</li>
          <li class="breadcrumb-item active">Gestion Tag</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Ajouter un tag</h5>
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
              <form action="..\..\controllers\admin\ajouter_tag.php" method="POST" class="row g-3 needs-validation" novalidate>
                <div class="col-12">
                  <label for="validationCustom01" class="form-label"> Libelle du Tag</label>
                  <input type="text" name="tag" class="form-control" id="validationCustom01" value="" placeholder="Entrez le libelle du tag" required>
                  <div class="invalid-feedback">
                     Veuillez saisir un tag.
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
              <h5 class="card-title">Liste des tags</h5>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>
                      <b>ID</b>
                    </th>
                    <th>
                      <b>L</b>ibelle du tag
                    </th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($result as $ligne): ?>
                  <tr>
                    <td><?php echo $ligne['TAG_ID']; ?></td>
                    <td><?php echo $ligne['TAG_LIBELLE']; ?></td>
                    <td> 
                        <button type="button" class="btn btn-primary"><i class="bi bi-pen"></i></button>
                        <a href="..\..\controllers\admin\supprimer_tag.php?id=<?php echo $ligne['TAG_ID']; ?>"><button type="button" class="btn btn-danger"><i class="bi bi-trash"></i></button></a>
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