<?php

require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\header_user.php';
include '..\..\controllers\db\connexion.php';

$id_question = $_GET['id'];
$req_question = "SELECT * FROM question WHERE QUESTION_ID = :id_question";
$stmt_question = $bdd->prepare($req_question);
$stmt_question->bindParam(':id_question', $id_question, PDO::PARAM_INT);
$stmt_question->execute();
$question = $stmt_question->fetch(PDO::FETCH_ASSOC);

// Récupération des titres des projets
$sql="SELECT PROJET_ID, PROJET_TITRE FROM projet";
$stmt = $bdd->prepare($sql);
$stmt->execute();
$projets = $stmt->fetchAll(PDO::FETCH_ASSOC);

//--------> recuperation les titres des  niveaux
$req_etat="SELECT * from etat_question";
//executer la requete
$stmt_etat=$bdd->query($req_etat);
//parcourir le resultat
$etats=$stmt_etat->fetchAll(PDO::FETCH_ASSOC);

?>


<main id="main" class="main">
<div class="pagetitle">
      <h1>Modifier Question</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
          <li class="breadcrumb-item">Forum</li>
          <li class="breadcrumb-item active">Modifier Question</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Modification de question</h5>
              <!---message de l'état de requête---->
              <?php 
              if(isset($_SESSION['erreur_form'])){
                if (!empty($_SESSION['erreur_form'])) 
                {
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
              <form class="row g-3 needs-validation" action="..\..\controllers\user\modifier_questionAction.php" method="POST" novalidate>
                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Titre</label>
                  <input type="hidden"  name="question_id" value="<?php echo $question['QUESTION_ID']?>">                  
                  <input type="text" class="form-control" id="validationCustom01" placeholder="Entrer le titre" name="titre_question" value="<?php echo $question['QUESTION_TITRE']?>" required>
                  <div class="invalid-feedback">
                     Veuillez saisir le titre de la question.
                  </div>
                </div>
                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Description</label>
                  <input type="text" class="form-control" id="validationCustom01" placeholder="Entrer la description" name="descr"  value="<?php echo $question['QUESTION_DESCR']?>"  required>
                  <div class="invalid-feedback">
                     Veuillez saisir la description de la question .
                  </div>
                </div>
                <div class="col-12">
                  <label class="form-label">Etat</label>
                  <input type="hidden" name="old_etat" value="<?php echo $question['ETAT_ID']?>">
                  <select name="etat" class="form-select">
                     <option value="">---Choisir une état---</option>  
                      <option value="3">Résolue</option>  
                      <?php if ($question["ETAT_ID"] == 4): ?>
                          <option value="6">Relancée</option>
                      <?php endif; ?>
                  </select>
                </div>
              
                <div class="col-12">
                  <label for="associerProjet" class="form-label">Associer à un projet</label>
                  <select class="form-select" aria-label="Default select example" name="associerProjet" id="associerProjet" onchange="toggleProjectSelect()">
                    <?php if($question['PROJET_ID']!= NULL): ?>
                    <option value="non" >Non</option>
                    <option value="oui" selected>Oui</option>
                    <?php else:?>
                    <option value="non" selected>Non</option>
                    <option value="oui">Oui</option>
                    <?php endif;?>
                  </select>
                </div>

                <?php if($question['PROJET_ID']== NULL): ?>
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
                         <?php if($projet['PROJET_ID'] == $question['PROJET_ID']):?>
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


                


                <div class="col-12">
                  <button class="btn btn-primary" type="submit">Sauvegarder</button>
                  <button class="btn btn-danger" type="reset">Annuler</button>
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
