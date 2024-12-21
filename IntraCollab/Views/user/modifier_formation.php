<?php

require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\header_user.php';
include '..\..\controllers\db\connexion.php';

if(isset($_GET["IDD"]))
{

$formation_id=$_GET["IDD"];
//recuperer les informations
$req_formation="SELECT * FROM formation where FORMATION_ID=?;";
$stmt_formation = $bdd->prepare($req_formation);
// Liaison des valeurs et exécution de la requête
$stmt_formation->execute([$formation_id]);
$formation = $stmt_formation->fetch(PDO::FETCH_ASSOC);

}
?>

<style>
  #image-selector {
            display: none;
        }
</style>
<main id="main" class="main">
<div class="pagetitle">
      <h1>Modifier Formation</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
          <li class="breadcrumb-item">Forum</li>
          <li class="breadcrumb-item active">Modifier Formation</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Modifier Formation</h5>
              <!-- Custom Styled Validation -->
              <form class="row g-3 needs-validation" action="..\..\controllers\user\modifier_formationAction.php" method="POST" enctype="multipart/form-data"  novalidate>
              <input type="hidden" class="form-control" name="formation_id"  value="<?php echo $formation_id; ?>">
              <input type="hidden" class="form-control" name="formation_etat"  value="<?php echo $formation["ETAT_FORMATION"]; ?>">
                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Titre</label>
                  <input type="text" class="form-control" id="validationCustom01" value="<?php echo $formation["THEME"]; ?>" 
                   placeholder="saisir le Théme" name="theme_formation" required>
                  <div class="invalid-feedback">
                     Veuillez saisir le théme de formation
                  </div>
                </div>


                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Description</label>
                  <input type="text" class="form-control" id="validationCustom01" value="<?php echo $formation["FORMATION_DESCR"]; ?>"
                   placeholder="Entrer la description" name="descr_formation" required>
                  <div class="invalid-feedback">
                     Veuillez saisir la description de la formation
                  </div>
                </div>

                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Formateur</label>
                  <input type="text" class="form-control" id="validationCustom01" value="<?php echo $formation["FORMATEUR"]; ?>"
                   placeholder="Entrer le formateur" name="formateur_formation" required>
                  <div class="invalid-feedback">
                     Veuillez saisir le nom complet de formateur
                  </div>
                </div>

                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Date Debut</label>
                  <input type="date" class="form-control" id="validationCustom01" value="<?php echo $formation["FORMATION_DATE_DEBUT"]; ?>"
                  name="date_deb_formation" required>
                </div>

                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Date Fin</label>
                  <input type="date" class="form-control" id="validationCustom01" value="<?php echo $formation["FORMATION_DATE_FIN"]; ?>"
                   name="date_fin_formation" required>
                </div>
 
                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Date Debut Inscription</label>
                  <input type="date" class="form-control" value="<?php echo $formation["DATE_DEB_INSCRIPTION"]; ?>"
                   name="date_deb_inscr" required>
                </div>

                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Date Fin Inscription</label>
                  <input type="date" class="form-control" value="<?php echo $formation["DATE_FIN_INSCRIPTION"]; ?>"  
                  name="date_fin_inscr" required>
                </div>
                

                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Volume horaire</label>
                  <input type="text" class="form-control" id="validationCustom01" value="<?php echo $formation["VOLUME_HORAIRE"]; ?>"
                  placeholder="entrer la valeur horaire" name="volume_horaire_formation" required>
                  <div class="invalid-feedback">
                  Veuillez saisir le volume horaire
                  </div>
                </div>

                <div class="col-12">
                  <label for="validationCustom01" class="form-label">Lien de Formation:</label>
                  <input type="text" class="form-control" id="validationCustom01" value="<?php echo $formation["FORMATION_LIEN"]; ?>"
                   placeholder="entrer le lien de la formation" name="lien_formation" required>
                  <div class="invalid-feedback">
                  Veuillez passer le lien de la formation
                  </div>
                </div>

                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="annonceFormationCheckbox" name="annonce_formation" >
                        <label class="form-check-label" for="validationCustom01">
                            Associer à une annonce
                        </label>
                    </div>
                </div>

                <div id="image-selector">
                  <label for="image">Choisissez une image à associer à l'annonce :</label>
                  <input type="file" id="image" name="image">
              </div>

                <div class="col-12">
                  <button class="btn btn-primary" type="submit">Sauvegarder</button>
                </div>
              </form>

              
            </div>
          </div>
      </div>
    </section>
   
  </main><!-- End #main -->

  <script>
        document.getElementById('annonceFormationCheckbox').addEventListener('change', function() {
            var imageSelector = document.getElementById('image-selector');
            if (this.checked) {
                imageSelector.style.display = 'block';
            } else {
                imageSelector.style.display = 'none';
            }
        });
    </script>

<!-- ======= Fin de la page ======= -->
<?php

 include '..\headerX\footer.php';

?>
