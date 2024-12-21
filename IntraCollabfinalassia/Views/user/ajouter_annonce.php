<?php

require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\header_user.php';
include '..\..\controllers\db\connexion.php';



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
              <form class="row g-3 needs-validation" action="..\..\controllers\user\ajouter_annonceAction.php" method="POST" enctype="multipart/form-data" novalidate>
                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Titre</label>
                  <input type="text" class="form-control" id="validationCustom01" placeholder="Entrer le titre" name="titre" required>
                  <div class="invalid-feedback">
                     Veuillez saisir le titre de l'annonce.
                  </div>
                </div>
                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Description</label>
                  <textarea class="form-control" id="validationCustom01" placeholder="Entrer la description" name="descr" required></textarea>
                  <div class="invalid-feedback">
                     Veuillez saisir la description de l'annonce.
                  </div>
                </div>
                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Date</label>
                  <input type="date" class="form-control" id="validationCustom01" name="date" required>
                  <div class="invalid-feedback">
                     Veuillez saisir la date de l'annonce.
                  </div>
                </div>

                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Lien</label>
                  <input type="text" class="form-control" id="validationCustom01" placeholder="Entrer le lien" name="lien">
                </div>
                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Image</label>
                  <input type="file" class="form-control" name="image">
                </div>

                <!-- partie projet -->
              
                <div class="col-12">
                  <label for="associerProjet" class="form-label">Associer à un projet</label>
                  <select class="form-select" aria-label="Default select example" name="associerProjet" id="associerProjet" onchange="toggleProjectSelect()">
                    <option value="non" selected>Non</option>
                    <option value="oui">Oui</option>
                  </select>
                </div>

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

                <!-- partie formation -->
                <div class="col-12">
                  <label for="associerFormation" class="form-label">Type annonce</label>
                  <select class="form-select" aria-label="Default select example" name="associerFormation" id="associerFormation" onchange="toggleFormationSelect()">
                    <option value="Evenement" selected>Evenement</option>
                    <option value="Meeting">Meeting</option>
                    <option value="Formation">Formation</option>
                    <option value="Autre">Autre</option>
                  </select>
                </div>
                
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
                <div class="col-12" id="autreSelectDiv" style="display: none;">
                <input type="text" class="form-control" id="validationCustom01" placeholder="Entrer le type d'annonce " name="autre">
                </div>


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
