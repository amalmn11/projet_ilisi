
<?php

require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\header_user.php';
include '..\..\controllers\db\connexion.php';

$id= $_SESSION['user_id'];//recuperation de l'id de l'utilisateur

?>








         <!--------------DEBUT STATISTIQUES --------------->
       
<main id="main" class="main">  
         <div class="pagetitle">
            <h1>Statistiques</h1>
            <nav>
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Accueil</a></li>
                <li class="breadcrumb-item active">Statistiques</li>
                </ol>
            </nav>
         </div>
         <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div  class="col-12">
            <div class="row w-100">
            <!--------------- CARD 1 ----------------->
            <div style="width:1000px;" class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">
                <?php
                   $requete_nbr_ques = "SELECT COUNT(*) AS nombre_questions_partagees FROM question WHERE UTILISATEUR_ID = :utilisateur_id AND DAY(DATE_CREATION) = DAY(NOW()) AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW())";
                   $stmt_nbr_ques = $bdd->prepare($requete_nbr_ques);
                   // Liaison du paramètre
                   $stmt_nbr_ques->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                   // Exécution de la requête
                   $stmt_nbr_ques->execute();
                   // Récupération du résultat
                   $resultat = $stmt_nbr_ques->fetch(PDO::FETCH_ASSOC);
                   $nombre_questions_partagees = $resultat['nombre_questions_partagees'];
                  //nombre de question Nouvelle
                  $requete_nbr_ques_etat = "SELECT COUNT(*) AS nombre_questions_etat_1 FROM question WHERE ETAT_ID = 1 and UTILISATEUR_ID = :utilisateur_id;";
                  $stmt_nbr_ques_etat = $bdd->prepare($requete_nbr_ques_etat);
                  $stmt_nbr_ques_etat->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                  $stmt_nbr_ques_etat->execute();
                  $resultat = $stmt_nbr_ques_etat->fetch(PDO::FETCH_ASSOC);
                  $nombre_questions_etat_1 = $resultat['nombre_questions_etat_1'];
                   //nombre de question En cours 
                   $requete_nbr_ques_etat2 = "SELECT COUNT(*) AS nombre_questions_etat_2 FROM question WHERE ETAT_ID = 2 and UTILISATEUR_ID = :utilisateur_id;";
                   $stmt_nbr_ques_etat2 = $bdd->prepare($requete_nbr_ques_etat2);
                   $stmt_nbr_ques_etat2->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                   $stmt_nbr_ques_etat2->execute();
                   $resultat2 = $stmt_nbr_ques_etat2->fetch(PDO::FETCH_ASSOC);
                   $nombre_questions_etat_2 = $resultat2['nombre_questions_etat_2'];
                    //nombre de question Resolue
                    $requete_nbr_ques_etat3 = "SELECT COUNT(*) AS nombre_questions_etat_3 FROM question WHERE ETAT_ID = 3 and UTILISATEUR_ID = :utilisateur_id;";
                    $stmt_nbr_ques_etat3 = $bdd->prepare($requete_nbr_ques_etat3);
                    $stmt_nbr_ques_etat3->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                    $stmt_nbr_ques_etat3->execute();
                    $resultat3 = $stmt_nbr_ques_etat3->fetch(PDO::FETCH_ASSOC);
                    $nombre_questions_etat_3 = $resultat3['nombre_questions_etat_3'];
                    //nombre de question Complete
                    $requete_nbr_ques_etat4 = "SELECT COUNT(*) AS nombre_questions_etat_4 FROM question WHERE ETAT_ID = 4 and UTILISATEUR_ID = :utilisateur_id;";
                    $stmt_nbr_ques_etat4 = $bdd->prepare($requete_nbr_ques_etat4);
                    $stmt_nbr_ques_etat4->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                    $stmt_nbr_ques_etat4->execute();
                    $resultat4 = $stmt_nbr_ques_etat4->fetch(PDO::FETCH_ASSOC);
                    $nombre_questions_etat_4 = $resultat4['nombre_questions_etat_4'];
                     //nombre de question Annulee
                     $requete_nbr_ques_etat5 = "SELECT COUNT(*) AS nombre_questions_etat_5 FROM question WHERE ETAT_ID = 5 and UTILISATEUR_ID = :utilisateur_id;";
                     $stmt_nbr_ques_etat5 = $bdd->prepare($requete_nbr_ques_etat5);
                     $stmt_nbr_ques_etat5->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                     $stmt_nbr_ques_etat5->execute();
                     $resultat5 = $stmt_nbr_ques_etat5->fetch(PDO::FETCH_ASSOC);
                     $nombre_questions_etat_5 = $resultat5['nombre_questions_etat_5'];
                 // Vérifier le filtre
                    if(isset($_GET['filter'])) {
                        $filter = $_GET['filter'];
                        switch($filter) {
                            case 'Aujourd\'hui':
                                $requete_nbr_ques = "SELECT COUNT(*) AS nombre_questions_partagees FROM question WHERE UTILISATEUR_ID = :utilisateur_id AND DAY(DATE_CREATION) = DAY(NOW()) AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW())";
                                $stmt_nbr_ques = $bdd->prepare($requete_nbr_ques);
                                // Liaison du paramètre
                                $stmt_nbr_ques->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                                // Exécution de la requête
                                $stmt_nbr_ques->execute();
                                // Récupération du résultat
                                $resultat = $stmt_nbr_ques->fetch(PDO::FETCH_ASSOC);
                                $nombre_questions_partagees = $resultat['nombre_questions_partagees'];
                                //nombre de question Nouvelle
                                $requete_nbr_ques_etat = "SELECT COUNT(*) AS nombre_questions_etat_1 FROM question WHERE ETAT_ID = 1 and UTILISATEUR_ID = :utilisateur_id AND DAY(DATE_CREATION) = DAY(NOW()) AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                $stmt_nbr_ques_etat = $bdd->prepare($requete_nbr_ques_etat);
                                $stmt_nbr_ques_etat->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                                $stmt_nbr_ques_etat->execute();
                                $resultat = $stmt_nbr_ques_etat->fetch(PDO::FETCH_ASSOC);
                                $nombre_questions_etat_1 = $resultat['nombre_questions_etat_1'];
                                //nombre de question Nouvelle
                                $requete_nbr_ques_etat = "SELECT COUNT(*) AS nombre_questions_etat_1 FROM question WHERE ETAT_ID = 1 and UTILISATEUR_ID = :utilisateur_id AND DAY(DATE_CREATION) = DAY(NOW()) AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                $stmt_nbr_ques_etat = $bdd->prepare($requete_nbr_ques_etat);
                                $stmt_nbr_ques_etat->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                                $stmt_nbr_ques_etat->execute();
                                $resultat = $stmt_nbr_ques_etat->fetch(PDO::FETCH_ASSOC);
                                $nombre_questions_etat_1 = $resultat['nombre_questions_etat_1'];
                                //nombre de question En cours 
                                $requete_nbr_ques_etat2 = "SELECT COUNT(*) AS nombre_questions_etat_2 FROM question WHERE ETAT_ID = 2 and UTILISATEUR_ID = :utilisateur_id AND DAY(DATE_CREATION) = DAY(NOW()) AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                $stmt_nbr_ques_etat2 = $bdd->prepare($requete_nbr_ques_etat2);
                                $stmt_nbr_ques_etat2->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                                $stmt_nbr_ques_etat2->execute();
                                $resultat2 = $stmt_nbr_ques_etat2->fetch(PDO::FETCH_ASSOC);
                                $nombre_questions_etat_2 = $resultat2['nombre_questions_etat_2'];
                                  //nombre de question Resolue
                                  $requete_nbr_ques_etat3 = "SELECT COUNT(*) AS nombre_questions_etat_3 FROM question WHERE ETAT_ID = 3 and UTILISATEUR_ID = :utilisateur_id AND DAY(DATE_CREATION) = DAY(NOW()) AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat3 = $bdd->prepare($requete_nbr_ques_etat3);
                                  $stmt_nbr_ques_etat3->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                                  $stmt_nbr_ques_etat3->execute();
                                  $resultat3 = $stmt_nbr_ques_etat3->fetch(PDO::FETCH_ASSOC);
                                  $nombre_questions_etat_3 = $resultat3['nombre_questions_etat_3'];
                                  //nombre de question Complete
                                  $requete_nbr_ques_etat4 = "SELECT COUNT(*) AS nombre_questions_etat_4 FROM question WHERE ETAT_ID = 4 and UTILISATEUR_ID = :utilisateur_id AND DAY(DATE_CREATION) = DAY(NOW()) AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat4 = $bdd->prepare($requete_nbr_ques_etat4);
                                  $stmt_nbr_ques_etat4->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                                  $stmt_nbr_ques_etat4->execute();
                                  $resultat4 = $stmt_nbr_ques_etat4->fetch(PDO::FETCH_ASSOC);
                                  $nombre_questions_etat_4 = $resultat4['nombre_questions_etat_4'];
                                  //nombre de question Annulee
                                  $requete_nbr_ques_etat5 = "SELECT COUNT(*) AS nombre_questions_etat_5 FROM question WHERE ETAT_ID = 5 and UTILISATEUR_ID = :utilisateur_id AND DAY(DATE_CREATION) = DAY(NOW()) AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat5 = $bdd->prepare($requete_nbr_ques_etat5);
                                  $stmt_nbr_ques_etat5->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                                  $stmt_nbr_ques_etat5->execute();
                                  $resultat5 = $stmt_nbr_ques_etat5->fetch(PDO::FETCH_ASSOC);
                                  $nombre_questions_etat_5 = $resultat5['nombre_questions_etat_5'];
                                break;
                            case 'Ce Mois':
                                $requete_nbr_ques = "SELECT COUNT(*) AS nombre_questions_partagees FROM question WHERE UTILISATEUR_ID = :utilisateur_id AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW())";
                                $stmt_nbr_ques = $bdd->prepare($requete_nbr_ques);
                                // Liaison du paramètre
                                $stmt_nbr_ques->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                                // Exécution de la requête
                                $stmt_nbr_ques->execute();
                                // Récupération du résultat
                                $resultat = $stmt_nbr_ques->fetch(PDO::FETCH_ASSOC);
                                $nombre_questions_partagees = $resultat['nombre_questions_partagees'];
                                //nombre de question Nouvelle
                                $requete_nbr_ques_etat = "SELECT COUNT(*) AS nombre_questions_etat_1 FROM question WHERE ETAT_ID = 1 and UTILISATEUR_ID = :utilisateur_id AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                $stmt_nbr_ques_etat = $bdd->prepare($requete_nbr_ques_etat);
                                $stmt_nbr_ques_etat->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                                $stmt_nbr_ques_etat->execute();
                                $resultat = $stmt_nbr_ques_etat->fetch(PDO::FETCH_ASSOC);
                                $nombre_questions_etat_1 = $resultat['nombre_questions_etat_1'];
                                //nombre de question En cours 
                                $requete_nbr_ques_etat2 = "SELECT COUNT(*) AS nombre_questions_etat_2 FROM question WHERE ETAT_ID = 2 and UTILISATEUR_ID = :utilisateur_id AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                $stmt_nbr_ques_etat2 = $bdd->prepare($requete_nbr_ques_etat2);
                                $stmt_nbr_ques_etat2->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                                $stmt_nbr_ques_etat2->execute();
                                $resultat2 = $stmt_nbr_ques_etat2->fetch(PDO::FETCH_ASSOC);
                                $nombre_questions_etat_2 = $resultat2['nombre_questions_etat_2'];
                                  //nombre de question Resolue
                                  $requete_nbr_ques_etat3 = "SELECT COUNT(*) AS nombre_questions_etat_3 FROM question WHERE ETAT_ID = 3 and UTILISATEUR_ID = :utilisateur_id AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat3 = $bdd->prepare($requete_nbr_ques_etat3);
                                  $stmt_nbr_ques_etat3->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                                  $stmt_nbr_ques_etat3->execute();
                                  $resultat3 = $stmt_nbr_ques_etat3->fetch(PDO::FETCH_ASSOC);
                                  $nombre_questions_etat_3 = $resultat3['nombre_questions_etat_3'];
                                  //nombre de question Complete
                                  $requete_nbr_ques_etat4 = "SELECT COUNT(*) AS nombre_questions_etat_4 FROM question WHERE ETAT_ID = 4 and UTILISATEUR_ID = :utilisateur_id AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat4 = $bdd->prepare($requete_nbr_ques_etat4);
                                  $stmt_nbr_ques_etat4->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                                  $stmt_nbr_ques_etat4->execute();
                                  $resultat4 = $stmt_nbr_ques_etat4->fetch(PDO::FETCH_ASSOC);
                                  $nombre_questions_etat_4 = $resultat4['nombre_questions_etat_4'];
                                  //nombre de question Annulee
                                  $requete_nbr_ques_etat5 = "SELECT COUNT(*) AS nombre_questions_etat_5 FROM question WHERE ETAT_ID = 5 and UTILISATEUR_ID = :utilisateur_id AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat5 = $bdd->prepare($requete_nbr_ques_etat5);
                                  $stmt_nbr_ques_etat5->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                                  $stmt_nbr_ques_etat5->execute();
                                  $resultat5 = $stmt_nbr_ques_etat5->fetch(PDO::FETCH_ASSOC);
                                  $nombre_questions_etat_5 = $resultat5['nombre_questions_etat_5'];
                                break;
                            case 'Cette Année':
                                $requete_nbr_ques = "SELECT COUNT(*) AS nombre_questions_partagees FROM question WHERE UTILISATEUR_ID = :utilisateur_id AND YEAR(DATE_CREATION) = YEAR(NOW())";
                                $stmt_nbr_ques = $bdd->prepare($requete_nbr_ques);
                                // Liaison du paramètre
                                $stmt_nbr_ques->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                                // Exécution de la requête
                                $stmt_nbr_ques->execute();
                                // Récupération du résultat
                                $resultat = $stmt_nbr_ques->fetch(PDO::FETCH_ASSOC);
                                $nombre_questions_partagees = $resultat['nombre_questions_partagees'];
                                //nombre de question Nouvelle
                                $requete_nbr_ques_etat = "SELECT COUNT(*) AS nombre_questions_etat_1 FROM question WHERE ETAT_ID = 1 and UTILISATEUR_ID = :utilisateur_id AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                $stmt_nbr_ques_etat = $bdd->prepare($requete_nbr_ques_etat);
                                $stmt_nbr_ques_etat->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                                $stmt_nbr_ques_etat->execute();
                                $resultat = $stmt_nbr_ques_etat->fetch(PDO::FETCH_ASSOC);
                                $nombre_questions_etat_1 = $resultat['nombre_questions_etat_1'];
                                //nombre de question En cours 
                                $requete_nbr_ques_etat2 = "SELECT COUNT(*) AS nombre_questions_etat_2 FROM question WHERE ETAT_ID = 2 and UTILISATEUR_ID = :utilisateur_id AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                $stmt_nbr_ques_etat2 = $bdd->prepare($requete_nbr_ques_etat2);
                                $stmt_nbr_ques_etat2->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                                $stmt_nbr_ques_etat2->execute();
                                $resultat2 = $stmt_nbr_ques_etat2->fetch(PDO::FETCH_ASSOC);
                                $nombre_questions_etat_2 = $resultat2['nombre_questions_etat_2'];
                                  //nombre de question Resolue
                                  $requete_nbr_ques_etat3 = "SELECT COUNT(*) AS nombre_questions_etat_3 FROM question WHERE ETAT_ID = 3 and UTILISATEUR_ID = :utilisateur_id AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat3 = $bdd->prepare($requete_nbr_ques_etat3);
                                  $stmt_nbr_ques_etat3->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                                  $stmt_nbr_ques_etat3->execute();
                                  $resultat3 = $stmt_nbr_ques_etat3->fetch(PDO::FETCH_ASSOC);
                                  $nombre_questions_etat_3 = $resultat3['nombre_questions_etat_3'];
                                  //nombre de question Complete
                                  $requete_nbr_ques_etat4 = "SELECT COUNT(*) AS nombre_questions_etat_4 FROM question WHERE ETAT_ID = 4 and UTILISATEUR_ID = :utilisateur_id AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat4 = $bdd->prepare($requete_nbr_ques_etat4);
                                  $stmt_nbr_ques_etat4->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                                  $stmt_nbr_ques_etat4->execute();
                                  $resultat4 = $stmt_nbr_ques_etat4->fetch(PDO::FETCH_ASSOC);
                                  $nombre_questions_etat_4 = $resultat4['nombre_questions_etat_4'];
                                  //nombre de question Annulee
                                  $requete_nbr_ques_etat5 = "SELECT COUNT(*) AS nombre_questions_etat_5 FROM question WHERE ETAT_ID = 5 and UTILISATEUR_ID = :utilisateur_id AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat5 = $bdd->prepare($requete_nbr_ques_etat5);
                                  $stmt_nbr_ques_etat5->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                                  $stmt_nbr_ques_etat5->execute();
                                  $resultat5 = $stmt_nbr_ques_etat5->fetch(PDO::FETCH_ASSOC);
                                  $nombre_questions_etat_5 = $resultat5['nombre_questions_etat_5'];
                                break;
                            default:

                        }
                    }

                  
                ?>  
                <div style="margin-left:auto;" class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                        <h6>Filtrer</h6>
                    </li>
                    <li><a class="dropdown-item" href="statistique_profile.php?filter=Aujourd'hui">Aujourd'hui</a></li>
                    <li><a class="dropdown-item" href="statistique_profile.php?filter=Ce Mois">Ce Mois</a></li>
                    <li><a class="dropdown-item" href="statistique_profile.php?filter=Cette Année">Cette Année</a></li>
                </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Nombre de question partagées<span>
                    <?php  if(isset($_GET['filter'])) echo "  |  ".$_GET['filter']; else echo "  | Aujourd'hui"; ?>
                </span></h5>

                <div class="d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center me-3">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-question-circle"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $nombre_questions_partagees; ?></h6>
                      <span class="text-success small pt-1 fw-bold">questions en total</span> <span class="text-muted small pt-2 ps-1"></span>
                    </div>
                  </div>


                  <div class="d-flex align-items-center">
                   
                    <div class="ps-3">
                      <h6><?php echo $nombre_questions_etat_1; ?></h6>
                      <span class="text-success small pt-1 fw-bold">Nouvelles</span> <span class="text-muted small pt-2 ps-1"></span>
                    </div>
                  </div>

                  <div class="d-flex align-items-center">
                    
                    <div class="ps-3">
                      <h6><?php echo $nombre_questions_etat_2; ?></h6>
                      <span class="text-success small pt-1 fw-bold">En cours</span> <span class="text-muted small pt-2 ps-1"></span>
                    </div>
                  </div>

                  <div class="d-flex align-items-center">
                    
                    <div class="ps-3">
                      <h6><?php echo $nombre_questions_etat_3; ?></h6>
                      <span class="text-success small pt-1 fw-bold">Résolues</span> <span class="text-muted small pt-2 ps-1"></span>
                    </div>
                  </div>

                  <div class="d-flex align-items-center">
                   
                    <div class="ps-3">
                      <h6><?php echo $nombre_questions_etat_4; ?></h6>
                      <span class="text-success small pt-1 fw-bold">Complétées</span> <span class="text-muted small pt-2 ps-1"></span>
                    </div>
                  </div>

                  <div class="d-flex align-items-center">
                    
                    <div class="ps-3">
                      <h6><?php echo $nombre_questions_etat_5; ?></h6>
                      <span class="text-success small pt-1 fw-bold">Annulées</span> <span class="text-muted small pt-2 ps-1"></span>
                    </div>
                  </div>

                </div>
                </div>
              </div>
            </div>
             <!--------- End Card1 ----------->
            
              <!--------------- CARD 2 ----------------->
            <div  class="col-xxl-4 col-md-6 col-12">
                        <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Nombre de réponses fournies</h5>
                        <!-- Line Chart -->
                        <canvas id="reponsesChart" width="400" height="200"></canvas>
                        <canvas id="notesChart" width="400" height="200"></canvas>
                        <?php
                        // Requête pour récupérer les données
                        $requete_reponses_par_mois = "SELECT YEAR(REPONSE_DATE_CREATION) AS annee, MONTH(REPONSE_DATE_CREATION) AS mois, COUNT(*) AS nombre_reponses, AVG(NOTE) AS moyenne_notes FROM reponse WHERE UTILISATEUR_ID = :utilisateur_id GROUP BY YEAR(REPONSE_DATE_CREATION), MONTH(REPONSE_DATE_CREATION) ORDER BY annee, mois";
                        $stmt_reponses_par_mois = $bdd->prepare($requete_reponses_par_mois);
                        $stmt_reponses_par_mois->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                        $stmt_reponses_par_mois->execute();
                        $reponses_par_mois = $stmt_reponses_par_mois->fetchAll(PDO::FETCH_ASSOC);
                        // Préparer les données pour Chart.js
                        $mois_labels = [];
                        $nombre_reponses = [];
                        $moyenne_notes = [];

                        foreach ($reponses_par_mois as $row) {
                            $mois_labels[] = $row['annee'] . '-' . str_pad($row['mois'], 2, '0', STR_PAD_LEFT);
                            $nombre_reponses[] = $row['nombre_reponses'];
                            $moyenne_notes[] = $row['moyenne_notes'];
                        }
                        ?>
                        <script>
                        var moisLabels = <?php echo json_encode($mois_labels); ?>;
                        var nombreReponses = <?php echo json_encode($nombre_reponses); ?>;
                        var moyenneNotes = <?php echo json_encode($moyenne_notes); ?>;
                        </script>
                        <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            // Graphique pour le nombre de réponses fournies
                            new Chart(document.querySelector('#reponsesChart'), {
                                type: 'line',
                                data: {
                                    labels: moisLabels,
                                    datasets: [{
                                        label: 'Nombre de Réponses Fournies',
                                        data: nombreReponses,
                                        fill: false,
                                        borderColor: 'rgb(75, 192, 192)',
                                        tension: 0.1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });

                            // Graphique pour la moyenne des notes des réponses
                            new Chart(document.querySelector('#notesChart'), {
                                type: 'line',
                                data: {
                                    labels: moisLabels,
                                    datasets: [{
                                        label: 'Moyenne des Notes',
                                        data: moyenneNotes,
                                        fill: false,
                                        borderColor: 'rgb(153, 102, 255)',
                                        tension: 0.1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            max: 5 // Supposant que les notes vont de 0 à 5
                                        }
                                    }
                                }
                            });
                        });
                        </script>
                        <!-- End Line CHart -->
                      </div>
              </div>
            </div>
             <!--------- End Card2 ----------->





              
            <!---------  Debut Card 3 ----------->
            <div  class="col-12">
            <div class="row w-100">
            <div style="width:1000px;" class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Engagement des Utilisateurs sur les Questions Posées<span>
                </span></h5>
                
                <?php
                   // Requête SQL pour calculer la moyenne des likes pour les réponses posées par un utilisateur ayant UTILISATEUR_ID = $id
                  $requete_moyenne_likes = "SELECT AVG(NB_LIKE) AS moyenne_likes
                  FROM reponse
                  WHERE UTILISATEUR_ID = :utilisateur_id AND NB_LIKE > 0;";
                  $stmt_moyenne_likes = $bdd->prepare($requete_moyenne_likes);
                  $stmt_moyenne_likes->bindParam(':utilisateur_id', $id, PDO::PARAM_INT); // Remplacer $id par l'ID de l'utilisateur concerné
                  $stmt_moyenne_likes->execute();
                  $resultat_moyenne_likes = $stmt_moyenne_likes->fetch(PDO::FETCH_ASSOC);
                  $moyenne_likes = $resultat_moyenne_likes['moyenne_likes'];
                  // Requête SQL pour calculer la moyenne des likes pour les réponses posées par un utilisateur ayant UTILISATEUR_ID = $id
                  $requete_moyenne_likes = "SELECT AVG(NB_DISLIKE) AS moyenne_dislikes
                  FROM reponse
                  WHERE UTILISATEUR_ID = :utilisateur_id AND NB_DISLIKE > 0;";
                  $stmt_moyenne_likes = $bdd->prepare($requete_moyenne_likes);
                  $stmt_moyenne_likes->bindParam(':utilisateur_id', $id, PDO::PARAM_INT); // Remplacer $id par l'ID de l'utilisateur concerné
                  $stmt_moyenne_likes->execute();
                  $resultat_moyenne_likes = $stmt_moyenne_likes->fetch(PDO::FETCH_ASSOC);
                  $moyenne_dislikes = $resultat_moyenne_likes['moyenne_dislikes'];
                  // Requête SQL pour calculer le nombre moyen de réponses par question
                  $requete_moyenne_reponses_par_question = "SELECT AVG(nb_reponses) AS moyenne_reponses_par_question
                                                            FROM (
                                                                SELECT COUNT(*) AS nb_reponses
                                                                FROM reponse AS r
                                                                INNER JOIN question AS q ON r.QUESTION_ID = q.QUESTION_ID
                                                                WHERE q.UTILISATEUR_ID = :utilisateur_id
                                                                GROUP BY r.QUESTION_ID
                                                            ) AS sous_requetes;";
                  $stmt_moyenne_reponses_par_question = $bdd->prepare($requete_moyenne_reponses_par_question);
                  $stmt_moyenne_reponses_par_question->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                  $stmt_moyenne_reponses_par_question->execute();
                  $resultat_moyenne_reponses_par_question = $stmt_moyenne_reponses_par_question->fetch(PDO::FETCH_ASSOC);
                  $moyenne_reponses = $resultat_moyenne_reponses_par_question['moyenne_reponses_par_question'];

                  //$moyenne_reponses=2;
                  ?>
                  
                  <div id="barChart"></div>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    new ApexCharts(document.querySelector("#barChart"), {
      series: [{
        data: [<?php echo $moyenne_reponses; ?>, <?php echo $moyenne_likes; ?>, <?php echo $moyenne_dislikes; ?>]
      }],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '30%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      xaxis: {
        categories: ['Nombre moyen de réponses par question', 'Nombre moyen de likes par reponse', 'Nombre moyen de dislikes par reponse']
      },
      yaxis: {
        title: {
          text: 'Moyenne'
        }
      },
      colors: ['#007bff']
    }).render();
  });
</script>
                </div>
              </div>
            </div>
            <!--------- FIN Card 3 ----------->
            
                        
            <!----------------DEBUT CARD 4------------------->

            <div style="width:1000px;" class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">
                <?php
                   // Requête pour le nombre total de projets
                  $stmt_total = $bdd->prepare("SELECT COUNT(*) AS nombre_projets_total
                  FROM utilisateur_projet
                  WHERE UTILISATEUR_ID = :id_utilisateur");
                  $stmt_total->execute(['id_utilisateur' => $id]);
                  $result_total = $stmt_total->fetch(PDO::FETCH_ASSOC);
                  $nombre_projets_total = $result_total['nombre_projets_total'];
                  // Requête pour le nombre de projets en cours
                  $stmt_en_cours = $bdd->prepare("SELECT COUNT(*) AS nombre_projets_en_cours
                  FROM projet p
                  JOIN utilisateur_projet up ON p.PROJET_ID = up.PROJET_ID
                  WHERE up.UTILISATEUR_ID = :id_utilisateur AND p.STATUT = 'En cours'");
                  $stmt_en_cours->execute(['id_utilisateur' => $id]);
                  $result_en_cours = $stmt_en_cours->fetch(PDO::FETCH_ASSOC);
                  $nombre_projets_en_cours = $result_en_cours['nombre_projets_en_cours'];
                  // Requête pour le nombre de projets terminés
                  $stmt_termine =  $bdd->prepare("SELECT COUNT(*) AS nombre_projets_termine
                  FROM projet p
                  JOIN utilisateur_projet up ON p.PROJET_ID = up.PROJET_ID
                  WHERE up.UTILISATEUR_ID = :id_utilisateur AND p.STATUT = 'Termine'");
                  $stmt_termine->execute(['id_utilisateur' => $id]);
                  $result_termine = $stmt_termine->fetch(PDO::FETCH_ASSOC);
                  $nombre_projets_termine = $result_termine['nombre_projets_termine'];

                ?>  
                
                <div class="card-body">
                  <h5 class="card-title">Nombre de Projets auxquels participe le collaborateur<span>
                </span></h5>

                <div class="d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center me-3">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-briefcase"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $nombre_projets_total; ?></h6>
                      <span class="text-success small pt-1 fw-bold">Projets en total</span> <span class="text-muted small pt-2 ps-1"></span>
                    </div>
                  </div>

                  <div class="d-flex align-items-center">
                   
                    <div class="ps-3">
                      <h6><?php echo $nombre_projets_en_cours; ?></h6>
                      <span class="text-success small pt-1 fw-bold">En Cours</span> <span class="text-muted small pt-2 ps-1"></span>
                    </div>
                  </div>

                  <div class="d-flex align-items-center">
                    
                    <div class="ps-3">
                      <h6><?php echo $nombre_projets_termine; ?></h6>
                      <span class="text-success small pt-1 fw-bold">Terminés</span> <span class="text-muted small pt-2 ps-1"></span>
                    </div>
                  </div>

                </div>
                </div>
              </div>
            <!--------------------FIN CARD 4-------------------------->

            </div>
            </div>
            </div>
            </div>
        </section>
        </div>
         <!------------- FIN STATISTIQUES ---------------->


         <?php
// require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\footer.php';

?>
