
<?php
require_once '..\..\controllers\auth\auth_inc_admin.php';
// session_start();
include '..\..\controllers\admin\liste_compte.php';
include '..\headerX\header_admin.php';
?>
  <!-- ======= Le début de la page ======= -->
 
  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Gestion des comptes</h1>
      <nav>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
          <li class="breadcrumb-item active">Comptes</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Créer un compte</h5>
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
                Enregistrement bien effectué et E-mail envoyé avec succès !
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
              }
              unset($_SESSION['erreur_form']);
            
              ?>
              
               <!---fin message de l'etat de requete---->
      

              <!-- Custom Styled Validation -->
              <form class="row g-3 needs-validation" action="..\..\controllers\admin\creer_compte.php" method="post" novalidate>
                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Email</label>
                  <input type="text" class="form-control" id="validationCustom01" value="" name="email" placeholder="Entrez un email" required>
                  <div class="invalid-feedback">
                     Veuillez saisir un E-mail.
                  </div>
                </div>
                <div class="col-12">
                  <label for="validationCustom02" class="form-label">Mot de passe</label>
                  <input type="password" class="form-control" id="validationCustom02" value="" name="password"  placeholder="Entrez le mot de passe" required>
                  <div class="invalid-feedback">
                     Veuillez saisir un mot de passe.
                  </div>
                </div>
                
               
                <div class="col-12">
                  <button class="btn btn-primary" type="submit">Créer le compte</button>
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
              <h5 class="card-title">Liste des comptes</h5>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">Utilisateur</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($lignes as  $ligne):  ?>
                <tr>
                  <td>
                      <img src="..\..\storage\images\<?php echo $ligne['IMAGE']?>" alt="" class="rounded-circle"  style="width: 50px; height: 50px;">
                  </td>
               
                <td><?php echo $ligne['EMAIL']?></td>
                <td>
                  <button type="button" class="btn btn-danger">
                    <a style="color:white;" href="..\..\controllers\admin\supprimer_compte.php?IDD=<?php echo $ligne['UTILISATEUR_ID']; ?>"><i class="bi bi-trash"></i></a>
                  </button>
                  <!-- <button type="button" class="btn btn-primary"><i class="bi bi-pen"></i></button> -->
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