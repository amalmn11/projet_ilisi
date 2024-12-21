<?php

require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\header_user.php';
include '..\..\controllers\db\connexion.php';

//Récuperation de les valeurs de champs de l'annonce a modifier
$id = $_GET['IDD'];
$sql="SELECT * FROM annonce where ANNONCE_ID = ?";
$stmt = $bdd->prepare($sql);
$stmt->bindValue(1,$id,PDO::PARAM_INT);
$stmt->execute();
$annonce = $stmt->fetch(PDO::FETCH_ASSOC);


// Récupération des titres des projets
$sql="SELECT PROJET_ID, PROJET_TITRE FROM projet";
$stmt = $bdd->prepare($sql);
$stmt->execute();
$projets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des titres des titres des formations
$req="SELECT FORMATION_ID , THEME FROM formation";
$stmt_formation = $bdd->prepare($req);
$stmt_formation->execute();
$formations = $stmt_formation->fetchAll(PDO::FETCH_ASSOC);


?>


<main id="main" class="main">
<div class="pagetitle">
      <h1>Ajouter Annonce</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
          <li class="breadcrumb-item">Annonce</li>
          <li class="breadcrumb-item active">Ajouter Annonce</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Ajouter Annonce</h5>
              <!---message de l'état de requête---->
              <?php 
              if(isset($_SESSION['erreur_form'])){
                if (!empty($_SESSION['erreur_form'])) {
                  echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$_SESSION['erreur_form'].
                  '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                } else {
                  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Enregistrement bien effectué.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                }
              }
              unset($_SESSION['erreur_form']);
              ?>
              <!---fin message de l'état de requête---->

              <!-- Custom Styled Validation -->
              <form class="row g-3 needs-validation" action="..\..\controllers\user\modifier_annonceAction.php" method="POST" enctype="multipart/form-data" novalidate>
                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Titre</label>
                  <input type="hidden" name="annonce_id"  value="<?php echo $annonce['ANNONCE_ID']?>">
                  <input type="text" class="form-control" id="validationCustom01" placeholder="Entrer le titre" name="titre" value="<?php echo $annonce['ANNONCE_TITRE']?>" required>
                  <div class="invalid-feedback">
                     Veuillez saisir le titre de l'annonce.
                  </div>
                </div>
                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Description</label>
                  <textarea class="form-control" id="validationCustom01" placeholder="Entrer la description" name="descr" required><?php echo $annonce['ANNONCE_DESCR']?></textarea>
                  <div class="invalid-feedback">
                     Veuillez saisir la description de l'annonce.
                  </div>
                </div>
                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Date</label>
                  <input type="date" class="form-control" id="validationCustom01" name="date" value="<?php echo $annonce['DATE_EVENEMENT']?>" required>
                  <div class="invalid-feedback">
                     Veuillez saisir la date de l'annonce.
                  </div>
                </div>

                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Lien</label>
                  <input type="text" class="form-control" id="validationCustom01" placeholder="Entrer le lien" name="lien" value="<?php echo $annonce['LIEN_EVENEMENT']?>">
                </div>

                <div class="col-12">
                 <label for="validationCustom01" class="form-label">Image</label>
                   <!-- image -->  
                   <?php if($annonce['IMAGE'] != NULL):?>
                      <div class="d-flex justify-content-between align-items-center mb-4">
                            <input type="hidden" name="oldImage" class="form-control" value="<?php echo $annonce['IMAGE'];?>">
                            <input type="text" name="img_path" class="form-control" value="<?php echo $annonce['IMAGE'];?>"  readonly>
                            <input type="file" name="newImage" id="uploadProfileImage" style="display: none;" accept="image/*">
                            <label for="uploadProfileImage" class="btn btn-primary btn-sm" title="Upload new profile image" style="margin-left:5px"><i class="bi bi-upload text-white"></i></label>
                    </div>
                   <?php else:?>
                    <input type="file" class="form-control" name="newImage">
                   <?php endif;?>
                  <!-- fin image -->
                </div>


                <!-- partie projet -->
                <div class="col-12">
                  <label for="associerProjet" class="form-label">Associer à un projet</label>
                  <select class="form-select" aria-label="Default select example" name="associerProjet" id="associerProjet" onchange="toggleProjectSelect()">
                  <?php if($annonce['PROJET_ID']!= NULL): ?>
                    <option value="non" >Non</option>
                    <option value="oui" selected>Oui</option>
                 <?php else:?>
                    <option value="non" selected>Non</option>
                    <option value="oui">Oui</option>
                <?php endif;?>
                  </select>
                </div>

                <?php if($annonce['PROJET_ID'] == NULL): ?>
                <div class="col-12" id="projectSelectDiv" style="display: none;">
                <label for="project" class="form-label">Projet</label>
                  <select class="form-select" name="project" id="project">
                    <?php foreach ($projets as $projet): ?>
                      <option value="<?php echo htmlspecialchars($projet['PROJET_ID']); ?>">
                          <?php echo htmlspecialchars($projet['PROJET_TITRE']); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              
                <?php else: ?>
                <div class="col-12" id="projectSelectDiv" style="display: block;">
                <label for="project" class="form-label">Projet</label>
                  <select class="form-select" name="project" id="project">
                    <?php foreach ($projets as $projet): ?>
                         <!-- partie select de projet -->
                         <?php if($projet['PROJET_ID'] == $annonce['PROJET_ID']):?>
                            <option value="<?php echo htmlspecialchars($projet['PROJET_ID']); ?>" selected>
                                <?php echo htmlspecialchars($projet['PROJET_TITRE']); ?>
                            </option>
                          <?php else :?>
                            <option value="<?php echo htmlspecialchars($projet['PROJET_ID']); ?>">
                                <?php echo htmlspecialchars($projet['PROJET_TITRE']); ?>
                            </option>
                            <?php endif;?>
                         <!-- fin partie select projet -->
                    <?php endforeach; ?>
                  </select>
                </div>
                <?php endif;?>

                  

                <!-- partie formation -->
                <div class="col-12">
                  <label for="associerFormation" class="form-label">Type annonce</label>
                  <select class="form-select" aria-label="Default select example" name="associerFormation" id="associerFormation" onchange="toggleFormationSelect()">
                    <?php if($annonce['TYPE_ANNONCE']== "Evenement"):?>
                    <option value="Evenement" selected>Evenement</option>
                    <option value="Meeting">Meeting</option>
                    <option value="Formation">Formation</option>
                    <option value="Autre">Autre</option>
                    <?php elseif($annonce['TYPE_ANNONCE']== "Meeting"):?>
                    <option value="Evenement">Evenement</option>
                    <option value="Meeting" selected>Meeting</option>
                    <option value="Formation">Formation</option>
                    <option value="Autre">Autre</option>
                    <?php elseif($annonce['TYPE_ANNONCE']== "Formation"):?>
                    <option value="Evenement">Evenement</option>
                    <option value="Meeting" >Meeting</option>
                    <option value="Formation" selected>Formation</option>
                    <option value="Autre">Autre</option>
                    <?php else:?>
                    <option value="Evenement">Evenement</option>
                    <option value="Meeting" >Meeting</option>
                    <option value="Formation">Formation</option>
                    <option value="Autre" selected>Autre</option>
                    <?php endif;?>
                  </select>
                </div>
                
                <?php if($annonce['TYPE_ANNONCE'] != "Formation") :?>
               
                    <div class="col-12" id="formationSelectDiv" style="display: none;">
                    <label for="formation" class="form-label">Formation</label>
                  <select class="form-select" name="formation" id="formation">
                    <?php foreach ($formations as $formation): ?>
                      <option value="<?php echo htmlspecialchars($formation['FORMATION_ID']); ?>">
                          <?php echo htmlspecialchars($formation['THEME']); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
               
                <?php else :?>
               
               <div class="col-12" id="formationSelectDiv" style="display: block;">
               <label for="formation" class="form-label">Formation</label>
             <select class="form-select" name="formation" id="formation">
               <?php foreach ($formations as $formation): ?>
                    <!-- select de formation -->
                    <?php if($formation['FORMATION_ID']==$annonce['FORMATION_IDE']):?>
                  <option value="<?php echo htmlspecialchars($formation['FORMATION_ID']); ?>" selected>
                     <?php echo htmlspecialchars($formation['THEME']); ?>
                 </option>
                 <?php else:?>
                  <option value="<?php echo htmlspecialchars($formation['FORMATION_ID']); ?>">
                     <?php echo htmlspecialchars($formation['THEME']); ?>
                 </option>
                 <?php endif;?>
                    <!-- fin select de formation -->
               <?php endforeach; ?>
             </select>
           </div>
           <?php endif;?>
                  
                
                <?php if($annonce['TYPE_ANNONCE'] == "Formation" || $annonce['TYPE_ANNONCE'] == "Evenement" || $annonce['TYPE_ANNONCE'] == "Meeting") :?>
                
                    <div class="col-12" id="autreSelectDiv" style="display: none;">
                      <?php if($annonce['TYPE_ANNONCE'] == "Formation" || $annonce['TYPE_ANNONCE'] == "Evenement" || $annonce['TYPE_ANNONCE'] == "Meeting") :?>
                      <input type="text" class="form-control" id="validationCustom01" placeholder="Entrer le type d'annonce " name="autre">
                      <?php else:?>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="Entrer le type d'annonce " name="autre" value="<?php echo $annonce['TYPE_ANNONCE']?>">
                      <?php endif;?>
                  </div>
                <?php endif;?>

               


                <div class="col-12">
                  <button class="btn btn-primary" type="submit">Ajouter</button>
                </div>
              </form><!-- End Custom Styled Validation -->

              <script>
                function toggleProjectSelect() {
                    var associerProjet = document.getElementById("associerProjet").value;
                    var projectSelectDiv = document.getElementById("projectSelectDiv");
                    if (associerProjet === "oui") {
                        projectSelectDiv.style.display = "block";
                    } else {
                        projectSelectDiv.style.display = "none";
                    }
                }


                function toggleFormationSelect() {
                    var associerFormation = document.getElementById("associerFormation").value;
                    var formationSelectDiv = document.getElementById("formationSelectDiv");
                    if (associerFormation === "Formation") {
                      formationSelectDiv.style.display = "block";
                      autreSelectDiv.style.display = "none";
                    } 
                    else if (associerFormation === "Autre") {
                      autreSelectDiv.style.display = "block";
                      formationSelectDiv.style.display = "none";
                    } 
                    else {
                      formationSelectDiv.style.display = "none";
                      autreSelectDiv.style.display = "none";
                    }
                }
              </script>

            </div>
          </div>
      </div>
    </section>
   
  </main><!-- End #main -->


<!-- ======= Fin de la page ======= -->
<?php

 include '..\headerX\footer.php';

?>
