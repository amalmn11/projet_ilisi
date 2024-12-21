
<?php
//session_start();

//require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\header_admin.php';

//connexion avec base de donnees
include '..\..\controllers\db\connexion.php';

//include 'C:\xampp\htdocs\ilisi_php1\projetWeb\projetWeb\NiceAdmin\controllers\auth\auth.php';



/*
// Préparer la requête avec des paramètres
$req_admin = "SELECT * FROM utilisateur WHERE UTILISATEUR_ID=?";
$stmt_admin = $bdd->prepare($req_admin);
// Lier la valeur au paramètre et exécuter la requête
$stmt_admin->bindValue(1, $_SESSION["user_id"], PDO::PARAM_INT);
$stmt_admin->execute();
// Récupérer les résultats
$infos_admin = $stmt_admin->fetchAll(PDO::FETCH_ASSOC);
*/
$id= $_SESSION['user_id'];
$req_admin = "SELECT * FROM utilisateur WHERE UTILISATEUR_ID=$id";
$stmt_admin=$bdd->query($req_admin);
$infos_admin=$stmt_admin->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST["changePWD"]))
{
        if (!empty($_POST["curr_password"]) && !empty($_POST["newPassword"]) && !empty($_POST["renewpassword"])) 
        {
        //recuperation
        $curr_password=$_POST["curr_password"];
        $newPassword=$_POST["newPassword"];
        $renewpassword=$_POST["renewpassword"];
        //la requete
        $hashed_curr_password = password_hash($curr_password, PASSWORD_DEFAULT);
        $req_psw="SELECT * from utilisateur where UTILISATEUR_ID=?";
        //preparer la requete
        $stmt_psw=$bdd->prepare($req_psw);
        $stmt_psw->bindValue(1,1,PDO::PARAM_INT);
        //$stmt_psw->bindValue(2,$hashed_curr_password,PDO::PARAM_STR);
        //executer
        $stmt_psw->execute();
        //parcourir
        $result=$stmt_psw->fetch(PDO::FETCH_ASSOC);

        if($result)
        {
          $hashed_pwd_from_db = $result["PWD"];
          if (password_verify($curr_password, $hashed_pwd_from_db)) 
          {
            if($newPassword!=$renewpassword)
            {
                $_SESSION['error'] = "Les nouveaux mots de passe ne correspondent pas.";
            }
            else
            {
               $req_change="UPDATE utilisateur SET PWD=? where UTILISATEUR_ID=?";
               $hashed_newPassword=password_hash($newPassword, PASSWORD_DEFAULT);;
               //preparer
               $stmt_change=$bdd->prepare($req_change);
               $stmt_change->bindValue(1,$hashed_newPassword,PDO::PARAM_STR);
               $stmt_change->bindValue(2,1,PDO::PARAM_INT);
              // $stmt_change->bindValue(3,$hashed_curr_password,PDO::PARAM_STR);
               //executer
               $stmt_change->execute();
                $_SESSION['success'] = "Mot de passe changé avec succès.";
            }
          }
          else
           {
            $_SESSION['error'] = "Mot de passe actuel incorrect.";
           }
        }
        
        }
    }

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
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">modifier Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Parametres</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">modifier mot de passe</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">A Propos</h5>
                  <p class="small fst-italic">Vous pouvez mettre à jour vos informations à tout moment pour garantir leur exactitude et leur pertinence. Vos données personnelles sont traitées avec la plus grande confidentialité et sont utilisées uniquement dans le cadre de votre rôle administratif</p>

                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Nom</div>
                    <div class="col-lg-9 col-md-8"><?php echo $infos_admin[0]["NOM"]; ?></div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Prenom</div>
                    <div class="col-lg-9 col-md-8"><?php echo $infos_admin[0]["PRENOM"]; ?></div>
                  </div>
                  <!-- <div class="row">
                    <div class="col-lg-3 col-md-4 label">Date Naissance</div>
                    <div class="col-lg-9 col-md-8"><?php echo $infos_admin[0]["DATE_NAISSANCE"]; ?></div>
                  </div> -->

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

                  <!-- Profile Edit Form -->
                  <form action="..\..\controllers\admin\modifier_profile.php" method="POST">
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Image de Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <img src="..\..\storage\images\<?php echo $infos_admin[0]["IMAGE"]; ?>" alt="Profile">
                        <div class="pt-2">
                            <input type="file" name="newImage" id="uploadProfileImage" value="<?php echo $infos_admin[0]["IMAGE"]; ?>" style="display: none;" accept="image/*">
                            <label for="uploadProfileImage" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload text-white"></i></label>
                            <a href="" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
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
                        <label for="company" class="col-md-4 col-lg-3 col-form-label">Date Naissance</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="newDateNaissance" type="date" class="form-control" id="company" value="<?php echo $infos_admin[0]["DATE_NAISSANCE"]; ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Address" class="col-md-4 col-lg-3 col-form-label">Telephone</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newTel" type="text" class="form-control" id="newTel" value="<?php echo $infos_admin[0]["TELEPHONE"]; ?>">
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
                  <form id="" action="" method="post">
                  <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Mot de passe actuel</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="curr_password" type="password"  value="hehe" class="form-control" id="currentPassword">
                      </div>
                      
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Nouveau mot de passe</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newPassword" type="password"  value="" class="form-control" id="newPassword">
                      </div>
                     
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Resaisir mot de passe</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" name="changePWD" class="btn btn-primary">changer mot de passe</button>
                    </div>
                  </form><!-- End Change Password Form -->
                  <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; ?></div>
        <?php unset($_SESSION['error']); // Supprimer le message d'erreur après l'avoir affiché ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; ?></div>
        <?php unset($_SESSION['success']); // Supprimer le message de succès après l'avoir affiché ?>
    <?php endif; ?>
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