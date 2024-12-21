<?php

require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\header_user.php';
include '..\..\controllers\db\connexion.php';

//---------->PARTIE ASSIA

$id= $_SESSION['user_id'];//recuperation de l'id de l'utilisateur
$req = "SELECT * FROM utilisateur WHERE UTILISATEUR_ID=$id";
$stmt=$bdd->query($req);
$infos=$stmt->fetchAll(PDO::FETCH_ASSOC);

$_SESSION["auth"]=$infos[0]["NOM"] . " " . $infos[0]["PRENOM"];
$_SESSION['image']=$infos[0]['IMAGE'];


//----------->FIN PARTIE ASSIA




//--------> recuperation des competences à partir de la base de donneees
//l'id de l'utilisateur
//session_start();
$utilisateur_id = $_SESSION["user_id"];
// Requête SQL
$sql = "SELECT *
        FROM competence c
        JOIN utilisateur_competence uc ON uc.COMPETENCE_ID = c.COMPETENCE_ID
        JOIN niveau n ON uc.NIVEAU_ID = n.NIVEAU_ID
        WHERE uc.UTILISATEUR_ID = :utilisateur_id";

// Préparation de la requête
$stmtt = $bdd->prepare($sql);

// Liaison du paramètre
$stmtt->bindParam(':utilisateur_id', $utilisateur_id, PDO::PARAM_INT);

// Exécution de la requête
$stmtt->execute();

// Récupération des résultats
$competences = $stmtt->fetchAll(PDO::FETCH_ASSOC);

//--------> recuperation les titres des  niveaux
$req_niveau="SELECT NIVEAU_TITRE from niveau";
//executer la requete
$stmt_niveau=$bdd->query($req_niveau);
//parcourir le resultat
$niveaux=$stmt_niveau->fetchAll(PDO::FETCH_ASSOC);



//--------> recuperer l'id de la competence à modifier
/////////////////////////partie salma
$user=$_SESSION["user_id"];
$sql="select * from formation f,utilisateur_formation uf 
      where uf.UTILISATEUR_ID=:ui and uf.FORMATION_ID=f.FORMATION_ID";
$stmt=$bdd->prepare($sql);
$stmt->bindValue('ui',$user,PDO::PARAM_STR);
$stmt->execute();

$formation=$stmt->fetchAll(PDO::FETCH_ASSOC);


$user=$_SESSION["user_id"];
$sql="select * from projet p,utilisateur_projet up,role_projet r 
      where up.UTILISATEUR_ID=:ui and up.PROJET_ID=p.PROJET_ID and r.ROLE_PROJET_ID=up.ROLE_PROJET_ID";
$stmt=$bdd->prepare($sql);
$stmt->bindValue('ui',$user,PDO::PARAM_STR);
$stmt->execute();

$projet=$stmt->fetchAll(PDO::FETCH_ASSOC);
////////////////////////fin partie salme




?>


<!--------------MODAL-------------->
<div class="modal fade" id="formModifierCompetence" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier Competence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulaire pour ajouter une compétence -->
                    <form action="..\..\controllers\user\modifier_competenceAction.php" method="POST">
                    <div class="mb-3">
                        <input type="hidden" name="competence_id"  id="competence_id">
                    </div>
                        <div class="mb-3">
                            <label for="newComp" class="form-label">Nom de la Compétence:</label>
                            <input type="text" name="newComp" id="newComp" class="form-control"  disabled>
                        </div>
                        <div class="mb-3">
                            <label for="newNiv" class="form-label">Niveau de la Compétence:</label>
                            <select id="newNiv" name="newNiv" class="form-select">
                                    <?php foreach($niveaux as $niveau): ?>
                                        <option value="<?php echo $niveau["NIVEAU_TITRE"];  ?>">
                                        <?php echo $niveau["NIVEAU_TITRE"];  ?></option>
                                    <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Autres champs de formulaire ici -->
                        <button type="submit" id="modifier_competence" name="modifierComp" class="btn btn-primary">modifier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!---------------MODAL ---->

<!-----------MODAL MODIFICATION ROLE DANS LE PROJET------------------>
 <!-- Modal -->
 <div class="modal fade" id="formModifierroleprojet" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Indiquer Votre Role dans le Projet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulaire pour ajouter une compétence -->
                    <form action="..\..\controllers\user\modifier_role_projet.php" method="post">
                        <div  for="projet_id" class="mb-3">
                            <input type="hidden" name="projet_id"  id="projet_id">
                            <input type="hidden" name="role_projet_id"  id="role_projet_id">
                        </div>
                        <div class="mb-3">
                            <label for="role_projet_titre" class="form-label">Role Projet</label>
                            <input type="text" id="role_projet_titre" name="role_projet_titre" class="form-control" disabled>
                        </div>
                        <div class="mb-3">
                           
                           <label for="new_role_projet" class="form-label">Nouveau Role Projet</label>
                           <?php $req_roles="SELECT * from role_projet";
                                $stmt_roles=$bdd->query($req_roles);
                                $roles = $stmt_roles->fetchAll(PDO::FETCH_ASSOC);?>

                           <select name="new_role_projet" id="new_role_projet" class="form-select">
                           <?php foreach($roles as $role): ?>
                               <option value="<?php echo $role["ROLE_PROJET_ID"]; ?>"><?php echo $role["ROLE_PROJET_TITRE"]; ?></option>
                            <?php endforeach; ?>
                           </select>
                           
                        </div>
                        <!-- Autres champs de formulaire ici -->
                        <button type="submit" name="modifierRoleProjet" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
</div>

<!----------- FIN MODAL MODIFICATION ROLE DANS LE PROJET------------------>




<main id="main" class="main">
<style>
    .custom-progress {
        background-color: #274FA6; /* Your custom color */
    }
    .orange-bi
    {
        color:#E97736;
    }
    .my-btn {
        border: none;
        background: none;
        padding: 0;
        color:#2348BF;
        margin-right:10px;
    }

    .my-btn i {
        font-size: 17px; /* Adjust the size of the icon */
    }
    .my-plus {
        font-weight: bold; /* Make the icon bold */
        font-size: 24px; /* Adjust the size of the icon */
        color:#012970;
    }
</style>

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
    <div class="card section profile">
    <div class="row">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    


    <div class="container bootstrap snippets bootdey">
    <div class="row">
        <div class="panel">
            <div class="cover-photo">
              <div class="fb-timeline-img">
                  <img src="..\..\storage\images\back.jpg" alt="">
              </div>
              <div class="fb-name">
                  <h2><a href="#"></a></h2>
              </div>
            </div>
            <div class="panel-body">
              <div class="profile-thumb">
                  <img src="..\..\storage\images\<?php echo $_SESSION['image']?>" alt="">
              </div>
              <a href="#" class="fb-user-mail"></a>
            </div>
        </div>
    </div>
    
    <!------- CARD 1---->
   
    <div class="card-body pt-3">
                  <div class="row">
                  <div class="col-lg-9 col-md-8">
                   <h4 class="card-title"><?php echo $_SESSION['auth'];?><br> <small><?php echo $infos[0]['POSTE'];?></small></h4>
                 
                    </div>
                  </div>
                  <!-- <div class="row"> -->
                  <!-- <p class="small fst-italic">Vous pouvez mettre à jour vos informations à tout moment pour garantir leur exactitude et leur pertinence.<br> Vos données personnelles sont traitées avec la plus grande confidentialité et sont utilisées uniquement dans le cadre<br> de votre rôle administratif</p> -->
                  <!-- </div> -->
                  <!-- <div class="row"> -->
                  <!-- <div class="col-lg-12 col-md-4 grey-address">
                        France, Paris, 123 Rue de la Paix
                  </div> -->
                  <!-- </div> -->
     </div>
    </section>
    <!-------------end section--->


    
             
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
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Paramétres</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Modifier mot de passe</button>
                </li>
              

              </ul>
           </div>
    </div>
    <!-----fin entete -------->
  
          <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <div class="card">
                <div class="card-body pt-3">
                 <table width="100%">
                    <tr>
                        <td width="90%"> 
                        <h5 class="card-title">Compétences</h5>
                        <p class="small fst-italic"></p>
                    </td>
                  
                    <td width="10%">
                        <?php include "ajouter_competence.php"; ?>
                        <a  href="ajouter_competence.php" type="button" class="my-plus" data-bs-toggle="modal" data-bs-target="#ajouterCompetence">
                            <i class="bi bi-plus-lg"></i>
                        </a>
                    </td>
                    </tr>
                 </table>
                <div class="row">
                    <table style="margin-left:10px;" width="100%"> 
                    <?php
                                // Votre code PHP pour récupérer les informations de compétence et de niveau de l'utilisateur
                                // Supposons que vous avez les informations dans un tableau $competences avec chaque élément contenant le titre de la compétence et son niveau
                                foreach ($competences as $competence):
                                    $niveau = $competence["NIVEAU_TITRE"]; // Supposons que vous avez récupéré le niveau de compétence pour chaque compétence
                                    $progress_width = 0; // Initialiser la largeur de la barre de progression
 
                                    // Calculer la largeur de la barre de progression en fonction du niveau de compétence
                                    if ($niveau == "Debutant") {
                                        $progress_width = 20;
                                    } elseif ($niveau == "Intermediaire") {
                                        $progress_width = 40;
                                    } elseif ($niveau == "Avance") {
                                        $progress_width = 60;
                                    } elseif ($niveau == "Expert") {
                                        $progress_width = 80;
                                    } elseif ($niveau == "Maitrise complete") {
                                        $progress_width = 100;
                                    }
                                   
                                ?>
                        <tr style="line-height: 40px;">
                            <td width="3%"><i class="bi bi-bookmark-star orange-bi"></i>
                            <input type="hidden" name="competence_idd" value="<?php echo $competence["COMPETENCE_ID"]; ?>">
                            </td>
                            <td width="20%" name="competence_nom"> 
                               <input type="hidden" name="competence_nomm" value="<?php echo $competence["COMPETENCE_NOM"]; ?>"> 
                               <?php echo $competence["COMPETENCE_NOM"]; ?>
                            </td>
                            <td width="50%">
                            <div class="prog-row row">
                                    <div class="col-sm-6">
                                        <div style="margin-top:7px;width:500px;height:15px;" class="progress">
                                        <input type="hidden" name="competence_nivv" value="<?php echo $competence["NIVEAU_TITRE"]; ?>">
                                            <div class="progress-bar custom-progress" role="progressbar" style="width: <?php echo $progress_width; ?>%" aria-valuenow="<?php echo $progress_width; ?>" aria-valuemin="0" aria-valuemax="100"><p style="margin-top:14px;"><?php echo $competence["NIVEAU_TITRE"]; ?></p></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            <td width="15%">
                            
                            <a id="editBtn" type="button" class="my-btn editBtn" data-bs-toggle="modal">
                            <i class="bi bi-pen-fill"></i>
                            </a>
                            <a  href="..\..\controllers\user\supprimer_competence.php?IDD=<?php echo $competence["COMPETENCE_ID"]; ?>" type="button" class="my-btn">
                            <i class="bi bi-trash"></i>
                            </a>
                            </td>
                           
                        </tr>
                        <?php endforeach; ?>
                    
                    </table>
                  </div><!--fin row-->
                </div><!--fin card-body-->
                </div><!--fin card-->


          <!-------dangerous-->
          <?php if (!empty($formation)): ?>
          <div class="card">
                <div class="card-body pt-3" >
                
                    <h5 class="card-title" >Formations</h5>  
                <div class="row">
                   
                    <?php  foreach($formation as $ligne): ?>
                      <table style="margin:20px;" width="100%">
                        <tr>
                          <td> <h5 style="color:#700129"><?php  echo $ligne['THEME']; ?></h5></td>
                        <td>
                          <a href="..\..\controllers\user\desabonner_formation.php?id=<?php  echo $ligne['FORMATION_ID']; ?>"><button type="button" class="btn btn-outline-warning">Se désabonner</button></a>
                          </td>

                        </tr>
                        <tr style="line-height: 40px;"> 
                        <td > 
                           <div id="info">
                          <div class="formation"><b>Formateur : </b><?php echo $ligne['FORMATEUR']; ?></div>
                          <div class="date"><b>Date de debut : </b><?php echo $ligne['FORMATION_DATE_DEBUT']; ?></div>
                          <div class="disc"><b>Description : </b><?php  echo $ligne['FORMATION_DESCR']; ?></p></div>
                          <div class="lieen"><b>Lien de la formation : </b><a href="<?php echo $ligne['FORMATION_LIEN'];?>" ><?php  echo $ligne['FORMATION_LIEN']; ?></a></div>
                        </div>
                       
                           </td>
                        </tr>
                        </table>
                        <hr style="height: 1.5px; background-color: rgba(0, 0, 0, 0.8);">
                        <?php endforeach; ?>
                    
                   
                  </div>
                </div>
          </div>
          <?php endif; ?>
          <!---------fin dangerous-------->

             <!-------dangerous22-->
             <?php if (!empty($projet)): ?>
             <div class="card">
                <div class="card-body pt-3">
                
                       <h5 class="card-title">Projets</h5>  
                <div class="row">
                   
                     <?php  foreach($projet as $ligne): ?>
                      <table style="margin:20px;" width="100%">
                        <tr>
                          <td  width="70%">  <h5 style="color:#700129"><?php  echo $ligne['PROJET_TITRE']; ?></h4></td>
                        <td style="text-align:left; ">
                        <input type="hidden" name="role_projet_id" value="<?php echo $ligne["ROLE_PROJET_ID"]; ?>">
                        <input type="hidden" name="projet_id" value="<?php echo $ligne["PROJET_ID"]; ?>">
                        <input type="hidden" name="role_projet_titre" value="<?php echo $ligne["ROLE_PROJET_TITRE"]; ?>">

                        <a style="margin:3px;" id="editBtn2" type="button" class="my-btn editBtn2" data-bs-toggle="modal">                         
                         <button type="button" class="btn btn-outline-primary"> <i class="bi bi-pen-fill"></i></button>
                        </a>
                        <a href="..\..\controllers\user\retirer_projet.php?id=<?php echo $ligne['PROJET_ID']; ?>&role=<?php echo $ligne['ROLE_PROJET_ID']; ?>"><button type="button" class="btn btn-outline-warning">Retirer la participation</button></a>
                       
                        </td>

                        </tr>
                        <tr style="line-height: 40px;"> 
                        <td colspan="2"> 
                        <div id="info">
                          <div  class="formation"><b>Role dans le projet : </b><?php echo $ligne['ROLE_PROJET_TITRE']; ?></div>
                          <div class="date"><b>Date de Debut : </b><?php echo $ligne['PROJET_DATE_DEBUT']; ?></div>
                          <div class="date"><b>Date du Fin : </b><?php echo $ligne['PROJET_DATE_FIN']; ?></div>
                          <div class="descr"><b >Description du Role: </b><?php  echo $ligne['ROLE_PROJET_DESCR']; ?></div>
                      </div>
                       
                           </td>
                        </tr>
                        </table>
                        <hr style="height: 1.5px; background-color: rgba(0, 0, 0, 0.8);">
                        <?php endforeach; ?>
                    
                   
                  </div>
                </div>
          </div>
          <?php endif; ?>
          <!---------fin dangerous22-------->
         </div><!--fin profile overview--->

        <!---//////////PARTIE ASSIA------------------------------>
        <div class="tab-pane fade profile-edit" id="profile-edit">
        <div class="card">
            <div class="card-body pt-3"> 
            
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
            <form action="..\..\controllers\user\modifier_profile.php" method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                <label for="profileImage" class="col-md-3 col-lg-3 col-form-label">Image de Profile</label>
                <div class="col-md-8 col-lg-9">
                    <img src="..\..\storage\images\<?php echo $infos[0]["IMAGE"]; ?>" alt="Profile" width="25%">
                    <div class="pt-2">
                        <input type="file" name="newImage" id="uploadProfileImage" value="<?php echo $infos[0]["IMAGE"]; ?>" style="display: none;" accept="image/*">
                        <label for="uploadProfileImage" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload text-white"></i></label>
                        <a href="..\..\controllers\user\supprimer_image.php?IDD=<?php echo $infos[0]["UTILISATEUR_ID"]; ?>&img=<?php echo $infos[0]["IMAGE"];?>" class="btn btn-danger btn-sm" title="Supprimer mon image de profile">

                        <i class="bi bi-trash"></i></a>
                    </div>
                </div>
                </div>

                <div class="row mb-3">
                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nom</label>
                <div class="col-md-8 col-lg-9">
                    <input name="newNom" type="text" class="form-control" id="newNom" value="<?php echo $infos[0]["NOM"]; ?>">
                </div>
                </div>
                
                <div class="row mb-3">
                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Prénom</label>
                <div class="col-md-8 col-lg-9">
                    <input name="newPrenom" type="text" class="form-control" id="newPrenom" value="<?php echo $infos[0]["PRENOM"]; ?>">
                </div>
                </div>
                
            
                <div class="row mb-3">
                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Poste</label>
                <div class="col-md-8 col-lg-9">
                    <input name="newPoste" type="text" class="form-control" id="newPoste" value="<?php echo $infos[0]["POSTE"]; ?>">
                </div>
                </div>
           
                

                <div class="row mb-3">
                <label for="Address" class="col-md-4 col-lg-3 col-form-label">Téléphone</label>
                <div class="col-md-8 col-lg-9">
                    <input name="newTel" type="text" class="form-control" id="newTel" value="<?php echo $infos[0]["TELEPHONE"]; ?>">
                </div>
                </div> 

                <div class="row mb-3">
                <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                <div class="col-md-8 col-lg-9">
                    <input name="newEmail" type="email" class="form-control" id="newEmail" value="<?php echo $infos[0]["EMAIL"]; ?>">
                </div>
                </div>

                <div class="text-center">
                <button type="submit" name="sauvegarder" class="btn btn-primary">Sauvegarder</button>
                <button type="reset" name="" class="btn btn-danger">Annuler</button>
                </div>
            </form><!-- End Profile Edit Form -->
            </div></div></div><!--fin edit profile-->

            <div class="tab-pane fade" id="profile-settings">
                 <!-- fin de partie de settings -->
            <div class="card">
            <div class="card-body pt-3"> 
            <!-- Settings Form -->
            <h4 class="card-title">Paramétre de notification</h4>
            <form>

                <div class="row mb-3">
                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Par e-mail</label>
                <div class="col-md-8 col-lg-9">
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="changesMade">
                    <label class="form-check-label" for="changesMade">
                      Début de la formation qui vous intéresse
                    </label>
                    </div>
                 
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="proOffers">
                    <label class="form-check-label" for="proOffers">
                        Messages 
                    </label>
                    </div>
                    
                </div>
                </div>

                <div class="text-center">
                <button type="submit" class="btn btn-primary">Enregistrer</button>

                </div>
            </form><!-- End settings Form -->

            </div></div>
            <!-- fin de partie de settings -->
          
        </div><!--fin edit settings-->

            <div class="tab-pane fade" id="profile-change-password">
            <div class="card">
            <div class="card-body pt-3"> 

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



            <form id="" action="..\..\controllers\user\modifier_pwd.php" method="post">
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
            
            </div></div></div><!--fin edit password-->

        <!---//////////FIN PARTIE ASSIA------------------------------>
         

   </div><!--tous--->
  </main>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script>
        $(document).ready(function () {
            $('.editBtn').on('click', function () {
                $('#formModifierCompetence').modal('show');
                 var competenceId = $(this).closest('tr').find('input[name="competence_idd"]').val();
                 var competenceNom = $(this).closest('tr').find('input[name="competence_nomm"]').val();
                 var nivTitre = $(this).closest('tr').find('input[name="competence_nivv"]').val();
                $('#competence_id').val(competenceId);
                $('#newComp').val(competenceNom);
                $('#newNiv').val(nivTitre);
            });
        });

        $(document).ready(function () {
            $('.editBtn2').on('click', function () {
                $('#formModifierroleprojet').modal('show');
                 var projetId = $(this).closest('tr').find('input[name="projet_id"]').val();
                 var roleprojetId = $(this).closest('tr').find('input[name="role_projet_id"]').val();
                 var roleprojetTitre = $(this).closest('tr').find('input[name="role_projet_titre"]').val();
                
                $('#projet_id').val(projetId);
                $('#role_projet_id').val(roleprojetId);
                $('#role_projet_titre').val(roleprojetTitre);
                
            });
        });

</script>
<?php
// require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\footer.php';

?>