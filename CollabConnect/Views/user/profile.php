<?php

require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\header_user.php';
include '..\..\controllers\db\connexion.php';

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
                            <input type="text" name="newComp" id="newComp" class="form-control"  required>
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
<!---------------MODAL -------->





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
    <div class="row">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container bootstrap snippets bootdey">
    <div class="row">
        <div class="panel">
            <div class="cover-photo">
              <div class="fb-timeline-img">
                  <img src="https://png.pngtree.com/thumb_back/fh260/background/20230610/pngtree-an-elegant-blue-abstract-wallpaper-image_2912291.jpg" alt="">
              </div>
              <div class="fb-name">
                  <h2><a href="#"></a></h2>
              </div>
            </div>
            <div class="panel-body">
              <div class="profile-thumb">
                  <img src="..\..\storage\images\profile2.jpg" alt="">
              </div>
              <a href="#" class="fb-user-mail"></a>
            </div>
        </div>
    </div>
    
    <!------- CARD 1---->
    <div class="card">
            <div class="card-body pt-3">
                  <div class="row">
                  <h5 class="card-title"><?php echo $_SESSION['auth'];?></h5>
                    <div class="col-lg-9 col-md-8"></div>
                  </div>
                  <div class="row">
                  <p class="small fst-italic">Vous pouvez mettre à jour vos informations à tout moment pour garantir leur exactitude et leur pertinence.<br> Vos données personnelles sont traitées avec la plus grande confidentialité et sont utilisées uniquement dans le cadre<br> de votre rôle administratif</p>
                  </div>
                  <div class="row">
    <div class="col-lg-12 col-md-4 grey-address">
        France, Paris, 123 Rue de la Paix
    </div>
</div>
            </div>
    </section>


    
             
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
              </ul>
           </div>
    </div>
    </div>

    <div class="card">
        <div class="card-body pt-3">
          <div class="tab-content pt-2">
                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                 <table width="100%">
                    <tr>
                        <td width="90%"> <h5 class="card-title">Competences</h5>
                  <p class="small fst-italic"></p></td>
                  <td></td>
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
                                    } elseif ($niveau == "Maîtrise complète") {
                                        $progress_width = 100;
                                    }
                                   
                                ?>
                        <tr style="line-height: 40px;">
                            <td width="3%"><i class="bi bi-bookmark-star orange-bi"></i>
                            <input type="hidden" name="competence_idd" value="<?php echo $competence["COMPETENCE_ID"]; ?>">
                          </td>
                            <td width="20%" name="competence_nom"> 
                            <input type="hidden" name="competence_nomm" value="<?php echo $competence["COMPETENCE_NOM"]; ?>"> <?php echo $competence["COMPETENCE_NOM"]; ?>
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
                  </div>
                </div>
          </div>
     </div>
   </div>
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
</script>
<?php
// require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\footer.php';

?>
