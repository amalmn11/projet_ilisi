<?php

require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\header_user.php';
include '..\..\controllers\db\connexion.php';



// pour recuperation des donnees apartir select on utilise query
$req="SELECT * FROM annonce";
$stmt = $bdd->query($req);
$lignes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$nb_annonces =count($lignes);

?>



<main id="main" class="main">
    <div class="pagetitle">
      <h1>Annonce</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
          <!-- <li class="breadcrumb-item"></li> -->
          <li class="breadcrumb-item active">Annonce</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    

    <section class="section">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5><strong>Total des Annonces :</strong> <?php echo $nb_annonces?></h5>
        <a href="ajouter_annonce.php" class="btn" style="background-color:#0048ae;color:white">Ajouter une Annonce</a>
    </div>
    <hr>
    <?php foreach ($lignes as $ligne): ?>

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
                    <span class="username"><a href="details_profil.php?IDD=<?php echo $utilisateur["UTILISATEUR_ID"]; ?>" ><?php echo $utilisateur["NOM"] .' '.  $utilisateur["PRENOM"].' ,'; ?></a></span>
                    <?php 
                    setlocale(LC_TIME, 'fr_FR.UTF-8');
                    $date_fr = strftime('%e %B %Y', strtotime($ligne["DATE_CREATION"]));
                    echo '<span style=" color: #999;  font-size: 13px;">Publié le ' . $date_fr . '</span>';
                    ?>
                    
                    <span class="badge bg-info text-dark m-2"><?php echo htmlspecialchars($ligne["TYPE_ANNONCE"]);?></span>

                    <?php if($ligne['ANNULE'] == 1):?>
                        <span class="badge bg-danger text-light m-2">Annulée</span>
                    <?php endif;?>
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
                    <?php if($ligne['ANNULE'] == 0):?>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-header">

                            <a  href="..\..\controllers\user\annuler_annonce.php?IDD=<?php echo $ligne["ANNONCE_ID"]; ?>">Annuler</a>
                        </li>
                    <?php endif;?>

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
            <strong>Formation : </strong><a  href="formation.php#<?php echo htmlspecialchars($formation["FORMATION_ID"]); ?>"><?php echo htmlspecialchars($formation["THEME"]); ?></a>
        <p>
        <?php endif;?>
        </div> <!--fin style margin left-->
        <!-- Optional image or media -->
        <?php if($ligne['IMAGE'] != NULL):?>
            <div style="display: flex; justify-content: center; align-items: center;">
            <img src="../../storage/images/<?php echo htmlspecialchars($ligne['IMAGE']); ?>" class="img-fluid" alt="Post Image" style="width: auto; height:50%; margin: auto;">
            </div>
        <?php endif;?>
        
        
        
    
    </div>
           
      
    </div>
    <!-- fin liste des annonce -->




    <?php endforeach; ?>
    </section>
  </main><!-- End #main -->



<?php
// require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\footer.php';

?>