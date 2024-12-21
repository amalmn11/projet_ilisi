
<?php
require_once '..\..\controllers\auth\auth_inc_admin.php';//session start se trouve dans ce fichier
include '..\..\controllers\db\connexion.php';//connexion avec base de donnees

$id= $_SESSION['user_id'];
$req_admin = "SELECT * FROM utilisateur WHERE UTILISATEUR_ID=$id";
$stmt_admin=$bdd->query($req_admin);
$infos_admin=$stmt_admin->fetchAll(PDO::FETCH_ASSOC);
$_SESSION["auth"]=$infos_admin[0]["NOM"] . " " . $infos_admin[0]["PRENOM"];
$_SESSION['image']=$infos_admin[0]['IMAGE'];


include '..\headerX\header_admin.php';

?>
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="..\..\storage\images\<?php echo $infos_admin[0]["IMAGE"]; ?>" alt="Profile" class="rounded-circle">
              <h2><?php echo $infos_admin[0]["NOM"]." ".$infos_admin[0]["PRENOM"]; ?></h2>
              <h3>Administrateur</h3>
              
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Aperçu</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Modifier Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Paramétres</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Modifier mot de passe</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">A Propos</h5>
                  <p class="small fst-italic">Vous pouvez mettre à jour vos informations à tout moment pour garantir leur exactitude et leur pertinence. Vos données personnelles sont traitées avec la plus grande confidentialité et sont utilisées uniquement dans le cadre de votre rôle administratif</p>

                  <h5 class="card-title">Profile Détails</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Nom</div>
                    <div class="col-lg-9 col-md-8"><?php echo $infos_admin[0]["NOM"]; ?></div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Prenom</div>
                    <div class="col-lg-9 col-md-8"><?php echo $infos_admin[0]["PRENOM"]; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Role</div>
                    <div class="col-lg-9 col-md-8">Administrateur</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?php echo $infos_admin[0]["EMAIL"]; ?></div>
                  </div>

                </div>
              

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                 <!---message de l'etat de requete---->
                 <?php 
             
                  if(isset($_SESSION['modif_erreur'])){
                    if (!empty($_SESSION['modif_erreur'])) 
                    {
                      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$_SESSION['modif_erreur'].
                      '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    }
                    else echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'
                    .$_SESSION['modif_secces'].'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                  }
                  unset($_SESSION['modif_erreur']);
                  unset($_SESSION['modif_secces']);
                
                  ?>
                  
                    <!---fin message de l'etat de requete---->

                  <!-- Profile Edit Form -->
                  <form action="..\..\controllers\admin\modifier_profile.php" method="POST" enctype="multipart/form-data">
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Image de Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <img src="..\..\storage\images\<?php echo $infos_admin[0]["IMAGE"]; ?>" alt="Profile">
                        <div class="pt-2">
                            <input type="file" name="newImage" id="uploadProfileImage" value="<?php echo $infos_admin[0]["IMAGE"]; ?>" style="display: none;" accept="image/*">
                            <label for="uploadProfileImage" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload text-white"></i></label>
                            <a href="..\..\controllers\admin\supprimer_image.php?IDD=<?php echo $infos_admin[0]["UTILISATEUR_ID"]; ?>&img=<?php echo $infos_admin[0]["IMAGE"];?>" class="btn btn-danger btn-sm" title="Supprimer mon image de profile">
                            <i class="bi bi-trash"></i></a>
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nom</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newNom" type="text" class="form-control" id="newNom" value="<?php echo $infos_admin[0]["NOM"]; ?>">
                      </div>
                    </div>
                    
                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Prenom</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newPrenom" type="text" class="form-control" id="newPrenom" value="<?php echo $infos_admin[0]["PRENOM"]; ?>">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newEmail" type="email" class="form-control" id="newEmail" value="<?php echo $infos_admin[0]["EMAIL"]; ?>">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" name="sauvegarder" class="btn btn-primary">Sauvegarder</button>
                    </div>
                  </form><!-- End Profile Edit Form -->
                </div>

                <div class="tab-pane fade pt-3" id="profile-settings">
                  <!-- Settings Form -->
                  <form>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                      <div class="col-md-8 col-lg-9">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="changesMade" checked>
                          <label class="form-check-label" for="changesMade">
                            Changes made to your account
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="newProducts" checked>
                          <label class="form-check-label" for="newProducts">
                            Information on new products and services
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="proOffers">
                          <label class="form-check-label" for="proOffers">
                            Marketing and promo offers
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                          <label class="form-check-label" for="securityNotify">
                            Security alerts
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End settings Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  
                  <!---message de l'etat de requete---->
                  <?php 
             
             if(isset($_SESSION['error_pass'])){
               if (!empty($_SESSION['error_pass'])) 
               {
                 echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$_SESSION['error_pass'].
                 '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>';
               }
               else echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'
               .$_SESSION['success'].'
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>';
             }
             unset($_SESSION['error_pass']);
             unset($_SESSION['success']);
           
             ?>
            
             <!---fin message de l'etat de requete---->
                
                
                
                
                <form id="" action="..\..\controllers\admin\modifier_pwd.php" method="post">
                  <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Mot de passe actuel</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="curr_password" type="password"  value="" class="form-control" id="currentPassword">
                      </div>
                      
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Nouveau mot de passe</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newPassword" type="password"  value="" class="form-control" id="newPassword">
                      </div>
                     
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Resaisir nouveau mot de passe</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" name="changePWD" class="btn btn-primary">changer mot de passe</button>
                    </div>
                  </form><!-- End Change Password Form -->
                  
                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>
   
        </div>
      </div>
     
    </section>
    <script>
        // Récupérer la zone pour afficher les messages d'erreur
        var errorMessageElement = document.getElementById("errorMessage");

        // Vérifier si une erreur est présente dans la session PHP
        <?php
        session_start();
        if (isset($_SESSION['error'])) {
            echo 'errorMessageElement.style.display = "block";'; // Afficher la zone des messages d'erreur
            echo 'errorMessageElement.textContent = "' . $_SESSION['error'] . '";'; // Afficher le message d'erreur
            unset($_SESSION['error']); // Supprimer le message d'erreur de la session après l'avoir affiché
        }
        ?>
    </script>

  </main><!-- End #main -->

  <?php
// require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\footer.php';

?>