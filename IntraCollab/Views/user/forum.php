<?php

require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\header_user.php';
include '..\..\controllers\db\connexion.php';



// pour recuperation des donnees apartir select on utilise query
$req="SELECT * FROM question";
$stmt = $bdd->query($req);
$lignes = $stmt->fetchAll(PDO::FETCH_ASSOC);
$nb_question =count($lignes);


unset( $_SESSION["id_question"]);
?>



<main id="main" class="main">
    <div class="pagetitle">
      <h1>Forum</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
          <!-- <li class="breadcrumb-item"></li> -->
          <li class="breadcrumb-item active">Forum</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    

    <section class="section">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5><strong>Total des Questions :</strong> <?php echo $nb_question?></h5>
        <a href="ajouter_question.php" class="btn" style="background-color:#0048ae;color:white">Poser une Question</a>
    </div>
    <hr>

    <?php foreach ($lignes as $ligne): ?>

<div class="card m-3"  id=<?php echo $ligne["QUESTION_ID"]; ?>>
    <div class="row g-0">
        <div class="col-md-2 d-flex align-items-center justify-content-center">
            <!-- Placeholder for votes, answers count, etc. -->
            <div class="text-left">
                <?php //recuperer nombre de reponses
                    $id_question = $ligne["QUESTION_ID"];
                    $req_nbr_reponses="SELECT COUNT(REPONSE_ID) AS nombre_reponses
                    FROM reponse
                    WHERE QUESTION_ID = :id_question;";
                    // Préparation de la requête
                    $stmt_nbr_reponses = $bdd->prepare($req_nbr_reponses);
                    // Liaison du paramètre
                    $stmt_nbr_reponses->bindParam(':id_question', $id_question, PDO::PARAM_INT);
                    // Exécution de la requête
                    $stmt_nbr_reponses->execute();
                    // Récupération du résultat
                    $result_nbr_reponses = $stmt_nbr_reponses->fetch(PDO::FETCH_ASSOC);
                    ?>
                <div><strong class="text-secondary"><?php echo $result_nbr_reponses['nombre_reponses'];  ?></strong> Réponses</div>
                <?php 
                    $etat_id = $ligne["ETAT_ID"];
                    $req_etat = "SELECT * FROM etat_question WHERE ETAT_ID = :etat_id";
                    $stmt_etat = $bdd->prepare($req_etat);
                    $stmt_etat->bindParam(':etat_id', $etat_id, PDO::PARAM_INT);
                    $stmt_etat->execute();
                    $etat = $stmt_etat->fetch(PDO::FETCH_ASSOC);

                    // Fetch user data
                    $utilisateur_id = $ligne["UTILISATEUR_ID"];
                    $req_utilisateur = "SELECT * FROM utilisateur WHERE UTILISATEUR_ID = :utilisateur_id";
                    $stmt_utilisateur = $bdd->prepare($req_utilisateur);
                    $stmt_utilisateur->bindParam(':utilisateur_id', $utilisateur_id, PDO::PARAM_INT);
                    $stmt_utilisateur->execute();
                    $utilisateur = $stmt_utilisateur->fetch(PDO::FETCH_ASSOC);
                ?>
                <?php
                      
                      if($ligne["ETAT_ID"]==1)//nouvelle
                      echo "<div class='card-subtitle mb-2  mt-2 text-primary' style='border:1px solid grey; border-radius:8px; padding-left:8px;'>Nouvelle</div>";
                      else if($ligne["ETAT_ID"]==5)//annulee
                      echo "<div class='card-subtitle mb-2  mt-2 text-danger' style='border:1px solid grey; border-radius:8px; padding-left:8px;'>Annulée</div>";
                      else if($ligne["ETAT_ID"]==2)//en cours
                      echo "<div class='card-subtitle mb-2  mt-2 text-secondary'  style='border:1px solid grey; border-radius:8px; padding-left:8px;'>En Cours</div>";
                      else if($ligne["ETAT_ID"]==3)//Resolue
                      echo "<div class='card-subtitle mb-2  mt-2 text-success' style='border:1px solid grey; border-radius:8px; padding-left:8px;'>Résolue</div>";
                      else if($ligne["ETAT_ID"] == 4)//Completé
                      echo "<div class='card-subtitle mb-2  mt-2 text-success' style='border:1px solid grey; border-radius:8px; padding-left:8px;'>Complétée</div>";
                      else
                      echo "<div class='card-subtitle mb-2  mt-2 text-warning' style='border:1px solid grey; border-radius:8px; padding-left:8px;'>Relancée</div>";
                  
                ?>
                <!-- <div class="card-subtitle text-danger mt-2  mb-2 "></div> -->
               
            </div>
        </div>
        <div class="col-md-10">
            <div class="card-body">
                <h5 class="card-title">
                    <a href="details_question.php?IDD=<?php echo $ligne["QUESTION_ID"]; ?>">
                        <?php echo htmlspecialchars($ligne["QUESTION_TITRE"]); ?>
                    </a>
                </h5>
                
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <img src="../../storage/images/<?php echo htmlspecialchars($utilisateur['IMAGE']); ?>" alt="Profile Image" class="rounded-circle" width="30" height="30">
                        <span><?php echo htmlspecialchars($utilisateur['NOM'].' '.$utilisateur['PRENOM']); ?></span>
                    </div>

                    <?php 
                    setlocale(LC_TIME, 'fr_FR.UTF-8');
                    $date_fr = strftime('%e %B %Y', strtotime($ligne["DATE_CREATION"]));
                    echo '<span style=" color: #999;  font-size: 14px;">Posé le ' . $date_fr . '</span>';
                    ?>

                    
                </div>
            </div>
        </div>
    </div>
</div>

<?php endforeach; ?>


    </section>
  

  </main><!-- End #main -->



<?php
// require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\footer.php';

?>