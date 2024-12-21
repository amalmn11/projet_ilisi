<?php

require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\header_user.php';
include '..\..\controllers\db\connexion.php';



// pour recuperation des donnees apartir select on utilise query
$req="SELECT * FROM base_connaissance bc,categorie c
      where bc.CATEGORIE_ID=c.CATEGORIE_ID";
$stmt = $bdd->query($req);
$lignes = $stmt->fetchAll(PDO::FETCH_ASSOC);
$nb=count($lignes);

//pour recuperer tous les tags
$reqq="SELECT * FROM categorie";
$stmt2 = $bdd->prepare($reqq);
$stmt2->execute();
$categories = $stmt2->fetchAll(PDO::FETCH_ASSOC);

?>

<style>
  .bg-secondary
  {
    --bs-bg-opacity: 1;
    background-color: rgb(242 128 11) !important;
  }
  #icon
  {
    position: absolute;
    right: 0px;
    padding-left: 30px;
    WIDTH: 4%;
    MARGIN-TOP: 1%;
  }
  #editBtn
  {
    position: absolute;
    right: 20px;
    padding-left: 30px;
    WIDTH: 5%;
    MARGIN-TOP: 1%;
  }
  #recherche_tag {
    display: flex;
    justify-content: flex-end; /* Aligne les éléments enfants à droite */
    align-items: center; /* Aligne les éléments de l'intérieur du conteneur verticalement */
    gap: 10px; /* Espace entre l'input et le bouton */
    padding-right: 10px; /* Optionnel : espace intérieur à droite */
  }

  #recherche_tag input[type="text"] {
      width: 35%; /* Largeur de 30% pour l'input */
      padding: 8px;
      border: 1px solid #ccc; /* Bordure grise */
      border-radius: 4px; /* Bordure arrondie */
      background-color: white; /* Fond transparent */
      color: #333; /* Couleur du texte */
      font-size: 16px;
  }

  #recherche_tag button {
      background: none; /* Pas de couleur de fond pour le bouton */
      border: none; /* Pas de bordure */
      padding: 8px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 2%;
  }

  #recherche_tag button i {
      font-size: 18px; /* Taille de l'icône */
      color: #007bff; /* Couleur de l'icône */
  }

  /* Effet de survol pour le bouton */
  #recherche_tag button:hover i {
      color: #0056b3; /* Couleur de l'icône au survol */
  }






      
</style>


<main id="main" class="main">
    <div class="pagetitle">
      <h1>Base de Connaissance </h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
          <li class="breadcrumb-item active">Base de Connaissance </li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5><strong>Total des Bases de Connaissances :  </strong> <?php echo $nb ?></h5>
        <a href="ajouter_base_connaissance.php" class="btn" style="background-color:#0048ae;color:white">Ajouter Base de Connaissance</a>
        
    </div>
    <div class="search-bar" >
      <form class="search-form d-flex align-items-center" id="recherche_tag" method="GET" action="recherche_resultat_tag.php" >
        <input type="text" name="query" placeholder="Rechercher par un tag ..." title="Entrer les mots-clés">
        <button type="submit" title="Rechercher"><i class="bi bi-search"></i></button>
      </form>
    </div>


    <hr>

    <?php foreach ($lignes as $ligne): ?>

      <div class="card" style=" max-width: 90%; margin-left: auto;margin-right: auto;">
              <!-- new -->
              
                    <div class="card-header">
                        <div class="row g-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <?php
                                      // Fetch user data
                                        $utilisateur_id = $ligne["UTILISATEUR_ID"];
                                        $req_utilisateur = "SELECT * FROM utilisateur WHERE UTILISATEUR_ID = :utilisateur_id";
                                        $stmt_utilisateur = $bdd->prepare($req_utilisateur);
                                        $stmt_utilisateur->bindParam(':utilisateur_id', $utilisateur_id, PDO::PARAM_INT);
                                        $stmt_utilisateur->execute();
                                        $utilisateur = $stmt_utilisateur->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <img src="../../storage/images/<?php echo $utilisateur['IMAGE']; ?>" alt="Profile Picture" class="rounded-circle"  width="40" height="40" style="margin-right:12px">
                                    <span class="username"><a href="details_profil.php?IDD=<?php echo $utilisateur["UTILISATEUR_ID"]; ?>" ><?php echo $utilisateur["NOM"] .' '.  $utilisateur["PRENOM"]; ?></a></span>
                                  
                                    </span>
                                </div>
                              <!-- partie options -->
                                <?php if($ligne['UTILISATEUR_ID'] == $_SESSION['user_id']):?>
                                    <a class="nav-link" href="#" data-bs-toggle="dropdown">
                                    <span>
                                        &#x2022;&#x2022;&#x2022;
                                    </span>
                                    </a><!-- End Three points -->

                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header">
                                    <a  href="modifier_base_connaissance_view.php?id_bc=<?php echo $ligne['BASE_CONNAISSANCE_ID']; ?>">Modifier</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li class="dropdown-header">
                                
                                        <a  href="..\..\controllers\user\supprimer_base_connaissance.php?IDD=<?php echo $ligne['BASE_CONNAISSANCE_ID']; ?>">Supprimer</a>
                                    </li>
                                    </ul>

                                <?php endif;?>
                              <!-- fin partie options -->

                            </div>
                        </div>
                        <!-- <div class="text-muted m-2" style="margin-left:10px">
                        <?php // echo date("F j, Y", strtotime($ligne["DATE_CREATION"])); ?>
                      
                        </div> -->
                    </div> <!--fin header card-->
                    
                    
              <!-- end new -->



              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title"><strong><?php echo ' ' . $ligne['BASE_CONNAISSANCE_TITRE']; ?></strong></h5>
                  <h4 class="card-title mb-2 text-muted" style="padding-top: 0px;"><strong>Categorie :</strong><?php echo ' ' . $ligne['CATEGORIE_LIBELLE']; ?></h4>
                 
             
                  <div>
                      <strong>Tags:</strong>
                     
                          <span class="badge bg-secondary"><?php echo htmlspecialchars($ligne['TAG1']); ?></span>
                          <span class="badge bg-secondary"><?php echo htmlspecialchars($ligne['TAG2']); ?></span>
                          <span class="badge bg-secondary"><?php echo htmlspecialchars($ligne['TAG3']); ?></span>
                     
                  </div>
                  
                  <?php 
                  $description = $ligne['BASE_CONNAISSANCE_DESCR'];
                  $words = explode(' ', $description);
                  if (count($words) > 10) {
                      $shortDesc = implode(' ', array_slice($words, 0, 10)) . '...';
                      echo '<div class="description" style="margin-top: 12px;border: 1px solid #ccc; border-radius: 10px; padding: 10px; width: 152%; height: auto; max-height: 15%; overflow: hidden; position: relative;">';
                      echo '<span class="short-description" style="display: block;">' . htmlspecialchars($shortDesc) . '</span>';
                      echo '<span class="full-description" style="display: none;">' . htmlspecialchars($description) . '</span>';
                      echo '<div style="width: 100%; margin-top:50px; height: 42%;TEXT-ALIGN: CENTER;"><button style=" margin-top: 59px;border-color:#7a7a7a; position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%);" class="btn read-more">Read More</button></div>';
                      echo '</div>';
                  } else {
                      echo '<div class="description" style="border: 1px solid #ccc; border-radius: 10px; padding: 10px; width: 90%; height: auto; max-height: 15%;">';
                      echo htmlspecialchars($description);
                      echo '</div>';
                  }
                  ?>

                </div>
              </div>             
            </div>
          </div>
    <?php endforeach; ?>

    </section>
</main><!-- End #main -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.read-more').forEach(function(readMoreBtn) {
        readMoreBtn.addEventListener('click', function() {
            const shortDescription = this.closest('.description').querySelector('.short-description');
            const fullDescription = this.closest('.description').querySelector('.full-description');
            if (shortDescription.style.display === 'none') {
                shortDescription.style.display = 'inline';
                fullDescription.style.display = 'none';
                this.textContent = 'Read More';
            } else {
                shortDescription.style.display = 'none';
                fullDescription.style.display = 'inline';
                this.textContent = 'Read Less';
            }
        });
    });

    // Script pour ouvrir la modal de modification
    document.querySelectorAll('.editBtn').forEach(function(editBtn) {
        editBtn.addEventListener('click', function() {
            const card = this.closest('.card');
            const baseconId = card.querySelector('input[name="basecon_id"]').value;
            const baseconNom = card.querySelector('.card-title').innerText.trim();
            const baseconDescr = card.querySelector('.short-description').innerText.trim();

            document.querySelector('#basecon_id').value = baseconId;
            document.querySelector('#basecon_nom').value = baseconNom;
            document.querySelector('#basecon_descr').value = baseconDescr;

            // Afficher la modal
            const modal = new bootstrap.Modal(document.getElementById('formModifierBaseconnaissance'));
            modal.show();
        });
    });
});

</script>



<?php
// require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\footer.php';
?>





