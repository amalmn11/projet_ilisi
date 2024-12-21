<?php

require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\header_user.php';
include '..\..\controllers\db\connexion.php';

//chercher un personne
// Récupération du terme de recherche
$terms = isset($_GET['query']) ? $_GET['query'] : '';
if(empty($terms)) {
  
  echo '<main id="main" class="main">
  <div class="pagetitle">
    <h1>Résultats de la recherche</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
        <!-- <li class="breadcrumb-item"></li> -->
        <li class="breadcrumb-item active">Résultats de la recherche</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">

  <div class="text-center">
  <img src="../../assets/img/search.png" alt="" class="m-3" width="200px">
  <p><b>Nous n\'avons trouvé aucun résultat </b><br>
    Vérifiez que vous avez bien tout orthographié ou essayez avec d\'autres mots-clés.</p>
</div>

</section>
  

</main><!-- End #main -->
';
include '..\headerX\footer.php';    
exit;
}
// Séparation des termes de recherche
$termsArray = explode(' ', $terms);//0=> fatiha , 1=>assoukh , 2=>test 

// Construction de la clause WHERE dynamiquement
$whereClausesPersonnes = [];
$whereClausesProjets = [];
$whereClausesAnnonces = [];
$whereClausesConnaissances = [];
$whereClausesFormations = [];

$params = [];
//fatiha assoukh test
//0=>"NOM LIKE fatiha OR PRENOM LIKE fatiha" =====>   NOM LIKE fatiha OR PRENOM LIKE fatiha OR NOM LIKE assoukh OR PRENOM LIKE assoukh OR  NOM LIKE test OR PRENOM LIKE test
//1=>"NOM LIKE assoukh OR PRENOM LIKE assoukh"
//2=>"NOM LIKE test OR PRENOM LIKE test"
foreach ($termsArray as $index => $term) {
    $paramName = ":term$index"; 
    $whereClausesPersonnes[] = "(NOM LIKE $paramName OR PRENOM LIKE $paramName)";//Pour rechercher dans utilisateurs
    $whereClausesProjets[] = "(PROJET_TITRE LIKE $paramName)";//Pour rechercher dans projets
    $whereClausesAnnonces[] = "(ANNONCE_TITRE LIKE $paramName)";//Pour rechercher dans annonce
    $whereClausesConnaissances[] =  "(BASE_CONNAISSANCE_TITRE LIKE $paramName)";//Pour rechercher dans annonce
    $whereClausesFormations[]="(THEME LIKE $paramName OR FORMATION_DESCR LIKE $paramName OR FORMATEUR LIKE $paramName)";
    $params[$paramName] = "%$term%";

    //:term0 => fatiha
    //:term1 => assoukh
    //:term2 => test
    
}

// Requête SQL pour rechercher des profils par nom ou prénom
$req_personne = "SELECT * FROM utilisateur WHERE ROLE_ID=2 AND " . implode(' OR ', $whereClausesPersonnes);
//=>NOM LIKE fatiha OR PRENOM LIKE fatiha OR NOM LIKE assoukh OR PRENOM LIKE assoukh OR  NOM LIKE test OR PRENOM LIKE test
$req_projet = "SELECT * FROM projet WHERE " . implode(' OR ', $whereClausesProjets);
//req de annonce
$req_annonce = "SELECT * FROM annonce WHERE " . implode(' OR ', $whereClausesAnnonces);
//req de annonce
$req_connaissance = "SELECT * FROM base_connaissance bc,categorie c WHERE bc.CATEGORIE_ID=c.CATEGORIE_ID AND " . implode(' OR ', $whereClausesConnaissances);
// Requête SQL pour rechercher des formations par thème ou description
$req_formation = "SELECT * FROM formation WHERE " . implode(' OR ', $whereClausesFormations);


// Préparation de la requête
$stmt = $bdd->prepare($req_personne);
$stmt1 = $bdd->prepare($req_projet);
$stmt_annonce = $bdd->prepare($req_annonce);
$stmt_connaissance = $bdd->prepare($req_connaissance);
$stmt_formation = $bdd->prepare($req_formation);
// Liaison des paramètres
foreach ($params as $paramName => $paramValue) 
{
    $stmt->bindValue($paramName, $paramValue, PDO::PARAM_STR);
    $stmt1->bindValue($paramName, $paramValue, PDO::PARAM_STR);
    $stmt_annonce->bindValue($paramName, $paramValue, PDO::PARAM_STR);
    $stmt_connaissance->bindValue($paramName, $paramValue, PDO::PARAM_STR);
    $stmt_formation->bindValue($paramName, $paramValue, PDO::PARAM_STR);
}
// Exécution de la requête
$stmt->execute();
$stmt1->execute();
$stmt_annonce->execute();
$stmt_connaissance->execute();
$stmt_formation->execute();
// Récupération des résultats
$personnes = $stmt->fetchAll(PDO::FETCH_ASSOC);
$projets = $stmt1->fetchAll(PDO::FETCH_ASSOC);
$annonces = $stmt_annonce->fetchAll(PDO::FETCH_ASSOC);
$bases = $stmt_connaissance->fetchAll(PDO::FETCH_ASSOC);
$formations= $stmt_formation->fetchAll(PDO::FETCH_ASSOC);
//fin chercher personne et projets




?>


<main id="main" class="main">
    <div class="pagetitle">
      <h1>Résultats de la recherche</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
          <!-- <li class="breadcrumb-item"></li> -->
          <li class="breadcrumb-item active">Résultats de la recherche</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
    <?php if(!empty($projets) || !empty($personnes) || !empty($annonces) || !empty($bases) || !empty($formations)):?>

      <!-- entete -->
               
    <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#personne">Personne</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#projet">Projet</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#annonce">Annonce</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#formation">Formation</button>
                </li>
                 
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#connaissance">Base de connaissance</button>
                </li>

              </ul>
           </div>
    </div>
    <div class="tab-content pt-2">
    <!-----fin entete -------->


    <!-- Resultat de personnes -->
    <div class="tab-pane fade show active personne" id="personne">
    <?php if(!empty($personnes)):?>
      <?php foreach ($personnes as  $ligne):  ?>
        <div class="card mb-3">
            <div class="row">
              <div class="col-md-1 m-3" >
              <img src="..\..\storage\images\<?php echo $ligne['IMAGE']?>" alt="" class="rounded-circle" style="width: 90px; height: 90px;">
              </div>
              <div class="col-md-7">
                <div class="card-body" >
                  <h5 class="card-title"><?php echo $ligne['NOM'].' '. $ligne['PRENOM']?></h5>
                 
                  <?php if($ligne['POSTE']!= ""):?>
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo $ligne['POSTE']?> <i class="bi bi-briefcase-fill" ></i> </h6>
                  <?php endif;?>
                   
              </div>
              </div>
              <div class="col-md-2  m-4">
              <a href="details_profil.php?IDD=<?php echo $ligne["UTILISATEUR_ID"]; ?>" type="button" class="btn btn-dark">Visiter le profil</a>
              </div>    

            </div>
          </div><!-- End Card with an image on left -->
      <?php endforeach;?>
      <?php else:?>
      <div class="text-center">
        <img src="../../assets/img/search.png" alt="" class="m-3" width="200px">
        <p><b>Nous n'avons trouvé aucun résultat </b><br>
          Vérifiez que vous avez bien tout orthographié ou essayez avec d'autres mots-clés.</p>
      </div>
    <?php endif;?>

      </div>
    <!-- Fin Resultat de personnes -->

    <!-- Resultat de projet -->
    <div class="tab-pane fade" id="projet">
      <?php if(!empty($projets)):?>
        <?php foreach ($projets as  $ligne):  ?>
    <div class="card mb-3">
      <div class="row">
        <div class="col-md-3">
          <img src="../../assets/img/work.png" class="img-fluid rounded-start" alt="...">
        </div>
        <div class="col-md-8">
          <div class="card-body" >
            <h5 class="card-title"><?php echo $ligne["PROJET_TITRE"]; ?></h5>
           
            <?php if($ligne['STATUT']== "En cours"):?>
              <h6 class="card-subtitle mb-2 text-muted">Projet <?php echo $ligne['STATUT']?> <i class="bi bi-gear-fill" ></i> </h6>
            <?php else:?>
              <h6 class="card-subtitle mb-2 text-muted">Projet <?php echo $ligne['STATUT']?> <i class="bi bi-check-circle-fill"></i></h6>
          <?php endif;?>
          <div class="mt-4">
          <a href="details_projet.php?IDD=<?php echo $ligne["PROJET_ID"]; ?>" type="button" class="btn btn-dark">Afficher détails <i class="bi bi-arrow-right"></i></a>
          </div>

        </div>
        </div>             
      </div>
    </div><!-- End Card with an image on left -->
       
    <?php endforeach;?>
    <?php else:?>
      <div class="text-center">
        <img src="../../assets/img/search.png" alt="" class="m-3" width="200px">
        <p><b>Nous n'avons trouvé aucun résultat </b><br>
          Vérifiez que vous avez bien tout orthographié ou essayez avec d'autres mots-clés.</p>
       
      </div>
    
    <?php endif;?>
      </div>
  <!-- Fin Resultat de projet -->

      <!-- resultat de recherche des annonce -->
      <div class="tab-pane fade" id="annonce">
      <?php if(!empty($annonces)):?>
      <?php foreach ($annonces as $ligne): ?>

        <!-- liste des annonce -->
        <div class="card" style=" max-width: 80%; margin-left: auto;margin-right: auto;">
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
                        <span class="card-title"><?php echo $utilisateur['NOM'].' '.$utilisateur['PRENOM'].', '; ?>
                        <span  class="text-muted m-2" ><?php  echo date("F j, Y", strtotime($ligne["DATE_CREATION"])); ?></span>
                        <span class="badge bg-info text-dark"><?php echo htmlspecialchars($ligne["TYPE_ANNONCE"]);?></span>
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
                        <a  href="modifier_annonce.php?IDD=<?php echo $ligne["ANNONCE_ID"]; ?>">Modifier</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-header">
                    
                            <a  href="..\..\controllers\user\supprimer_annonce.php?IDD=<?php echo $ligne["ANNONCE_ID"]; ?>">Supprimer</a>
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

                        
        <div class="card-body" style="margin: 16px 16px 0 16px;">
            
            <h1>
            <?php echo htmlspecialchars($ligne["ANNONCE_TITRE"]); ?>
            </h1>
          <div style="margin-left: 20px">
          <p class="card-text">
            <?php echo htmlspecialchars($ligne["ANNONCE_DESCR"]); ?>
            </p>
            <p>
          <strong>Date :</strong> <?php echo htmlspecialchars($ligne["DATE_EVENEMENT"]); ?>
            </p>

            <?php if($ligne['LIEN_EVENEMENT'] != NULL):?>
                <p>
                  <strong>Lien : </strong><a href="<?php echo htmlspecialchars($ligne["LIEN_EVENEMENT"]); ?>" target="_blank">LIEN</a>
                <p>
            <?php endif;?>
            <!-- projet cncerne -->
            <?php if($ligne['PROJET_ID'] != NULL):?>
                <?php
                          // Fetch user data
                            $projet_id = $ligne["PROJET_ID"];
                            $req_projet = "SELECT * FROM projet WHERE PROJET_ID = :projet_id";
                            $stmt_projet = $bdd->prepare($req_projet);
                            $stmt_projet->bindParam(':projet_id', $projet_id, PDO::PARAM_INT);
                            $stmt_projet->execute();
                            $projet = $stmt_projet->fetch(PDO::FETCH_ASSOC);
                ?>
            <p>
                <strong>Projet : </strong><a  href="details_projet.php?IDD=<?php echo htmlspecialchars($projet["PROJET_ID"]); ?>"><?php echo htmlspecialchars($projet["PROJET_TITRE"]); ?></a>
            <p>
            <?php endif;?>
            <!-- formation cncerne -->
            <?php if($ligne['FORMATION_ID'] != NULL):?>
                <?php
                          // Fetch user data
                            $formation_id = $ligne["FORMATION_ID"];
                            $req_formation = "SELECT * FROM formation WHERE FORMATION_ID = :formation_id";
                            $stmt_formation = $bdd->prepare($req_formation);
                            $stmt_formation->bindParam(':formation_id', $formation_id, PDO::PARAM_INT);
                            $stmt_formation->execute();
                            $formation = $stmt_formation->fetch(PDO::FETCH_ASSOC);
                ?>
            <p>
                <strong>Formation : </strong><a  href="#"><?php echo htmlspecialchars($formation["THEME"]); ?></a>
            <p>
            <?php endif;?>
            </div> <!--fin style margin left-->
            <!-- Optional image or media -->
            <?php if($ligne['IMAGE'] != NULL):?>
                <img src="../../storage/images/<?php echo htmlspecialchars($ligne['IMAGE']); ?>" class="img-fluid" alt="Post Image" style="width:100%">
            <?php endif;?>
            
            
            

        </div>
              
          
        </div>
        <!-- fin liste des annonce -->
        <?php endforeach; ?>
        <?php else:?>
      <div class="text-center">
        <img src="../../assets/img/search.png" alt="" class="m-3" width="200px">
        <p><b>Nous n'avons trouvé aucun résultat </b><br>
          Vérifiez que vous avez bien tout orthographié ou essayez avec d'autres mots-clés.</p>
       
      </div>
    
    <?php endif;?>
        </div>
      <!-- fin recherche annonce -->
      <!-- Resultat de recherche de base de connaissance  -->
      <div class="tab-pane fade" id="connaissance">
      <?php if(!empty($bases)):?>
      <?php foreach ($bases as $ligne): ?>
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
                                    <span class="card-title"><?php echo $utilisateur['NOM'].' '.$utilisateur['PRENOM'].', '; ?>
                                  
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
                  <h5 class="card-title"><strong>Titre de la base de connaissance :</strong><?php echo ' ' . $ligne['BASE_CONNAISSANCE_TITRE']; ?></h5>
                  <h4 class="card-title mb-2 text-muted" style="padding-top: 0px;"><strong>Categorie :</strong><?php echo ' ' . $ligne['CATEGORIE_LIBELLE']; ?></h4>
                  
                  <?php 
                  // Requête pour obtenir les tags associés à la base de connaissances actuelle
                  $req = "SELECT t.TAG_LIBELLE 
                          FROM se_compose s
                          JOIN tag t ON s.TAG_ID = t.TAG_ID
                          WHERE s.BASE_CONNAISSANCE_ID = :base_connaissance_id";
                  $statement = $bdd->prepare($req);
                  $statement->bindParam(':base_connaissance_id', $ligne['BASE_CONNAISSANCE_ID'], PDO::PARAM_INT);
                  $statement->execute();
                  $tags = $statement->fetchAll(PDO::FETCH_ASSOC);
                  ?>
                  
                  <div>
                      <strong>Tags:</strong>
                      <?php foreach ($tags as $tag): ?>
                          <span class="badge bg-secondary"><?php echo htmlspecialchars($tag['TAG_LIBELLE']); ?></span>
                      <?php endforeach; ?>
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
        <?php else:?>
      <div class="text-center">
        <img src="../../assets/img/search.png" alt="" class="m-3" width="200px">
        <p><b>Nous n'avons trouvé aucun résultat </b><br>
          Vérifiez que vous avez bien tout orthographié ou essayez avec d'autres mots-clés.</p>
      </div>
    <?php endif;?>
      </div>
      <!-- fin partie bases -->

      <!-- partie formation -->
      <div class="tab-pane fade" id="formation">  
    <!--------------------------------------FORMATION-------------------------------------------->
    <?php if(!empty($formations)):?>
    <div class="container">

<!------------BEGIN FOREACH------------>

<?php foreach($formations as $formation): ?>
<div class="row my-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="user-block">
                    <h5 class="card-title d-inline-block">
                        Formation: <?php echo $formation["THEME"]; ?>
                    </h5>
                    <span style="background-color:#4169E1;" class="badge badge-status badge-primary"><?php echo $formation["ETAT_FORMATION"]; ?></span>
                </div>
              
            </div>
            <div class="card-body">
                <div class="container2 mb-2">
                    <h6 class="d-inline">Theme: </h6>
                    <p class="d-inline"><?php echo $formation["THEME"]; ?></p>
                </div>
                <div class="container2 mb-2">
                    <h6 class="d-inline">Description: </h6>
                    <p class="d-inline"><?php echo $formation["FORMATION_DESCR"]; ?></p>
                </div>
                <div class="container2 mb-2">
                    <h6 class="d-inline">Formateur: </h6>
                    <p class="d-inline"><?php echo $formation["FORMATEUR"]; ?></p>
                </div>
                <div class="container2 mb-2">
                    <h6 class="d-inline">Volume Horaire: </h6>
                    <p class="d-inline"><?php echo $formation["VOLUME_HORAIRE"]. " heures"; ?></p>
                </div>
                <div class="container2 mb-2">
                    <h6 class="d-inline">Lien de La Formation: </h6>
                    <p class="d-inline"><a href="<?php echo $formation["FORMATION_LIEN"]; ?>"><?php echo $formation["FORMATION_LIEN"]; ?></a></p>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <div class="container2">
                            <h6 class="d-inline">Date Début Inscription: </h6>
                            <p class="d-inline"><?php echo $formation["DATE_DEB_INSCRIPTION"]; ?></p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="container2">
                            <h6 class="d-inline">Date Fin Inscription: </h6>
                            <p class="d-inline"><?php echo $formation["DATE_FIN_INSCRIPTION"]; ?></p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="container2">
                            <h6 class="d-inline">Date Début Formation: </h6>
                            <p class="d-inline"><?php echo $formation["FORMATION_DATE_DEBUT"]; ?></p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="container2">
                            <h6 class="d-inline">Date Fin Formation: </h6>
                            <p class="d-inline"><?php echo $formation["FORMATION_DATE_FIN"]; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<!------------END FOREACH------------>
</div>
<?php else:?>
      <div class="text-center">
        <img src="../../assets/img/search.png" alt="" class="m-3" width="200px">
        <p><b>Nous n'avons trouvé aucun résultat </b><br>
          Vérifiez que vous avez bien tout orthographié ou essayez avec d'autres mots-clés.</p>
       
      </div>
    
    <?php endif;?>
</div>
      <!-- fin partie formation -->
    <!-- Fin Resultat, pas de resulat -->
    <?php else:?>
      <div class="text-center">
        <img src="../../assets/img/search.png" alt="" class="m-3" width="200px">
        <p><b>Nous n'avons trouvé aucun résultat </b><br>
          Vérifiez que vous avez bien tout orthographié ou essayez avec d'autres mots-clés.</p>
      </div>
    <?php endif;?>
    </div> 
    <!-- fin  "tab-content pt-2" -->
    </section>
  

  </main><!-- End #main -->

<?php
// require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\footer.php';

?>