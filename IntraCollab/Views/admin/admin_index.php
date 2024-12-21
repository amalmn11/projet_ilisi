<?php

require_once '..\..\controllers\auth\auth_inc_admin.php';

include '..\..\controllers\db\connexion.php';
include '..\headerX\header_admin.php';


?>


<!-- Inclure la bibliothèque Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<main id="main" class="main">
<!--------------DEBUT STATISTIQUES --------------->
<div >
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
            <?php
                   $requete_nbr_ques = "SELECT COUNT(*) AS nombre_questions_partagees FROM question WHERE DAY(DATE_CREATION) = DAY(NOW()) AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW())";
                   $stmt_nbr_ques = $bdd->prepare($requete_nbr_ques);
                   // Exécution de la requête
                   $stmt_nbr_ques->execute();
                   // Récupération du résultat
                   $resultat = $stmt_nbr_ques->fetch(PDO::FETCH_ASSOC);
                   $nombre_questions_partagees = $resultat['nombre_questions_partagees'];
                  //nombre de question Nouvelle
                  $requete_nbr_ques_etat = "SELECT COUNT(*) AS nombre_questions_etat_1 FROM question WHERE ETAT_ID = 1 ";
                  $stmt_nbr_ques_etat = $bdd->prepare($requete_nbr_ques_etat);
                  $stmt_nbr_ques_etat->execute();
                  $resultat = $stmt_nbr_ques_etat->fetch(PDO::FETCH_ASSOC);
                  $nombre_questions_etat_1 = $resultat['nombre_questions_etat_1'];
                   //nombre de question En cours 
                   $requete_nbr_ques_etat2 = "SELECT COUNT(*) AS nombre_questions_etat_2 FROM question WHERE ETAT_ID = 2";
                   $stmt_nbr_ques_etat2 = $bdd->prepare($requete_nbr_ques_etat2);
                   $stmt_nbr_ques_etat2->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                   $stmt_nbr_ques_etat2->execute();
                   $resultat2 = $stmt_nbr_ques_etat2->fetch(PDO::FETCH_ASSOC);
                   $nombre_questions_etat_2 = $resultat2['nombre_questions_etat_2'];
                    //nombre de question Resolue
                    $requete_nbr_ques_etat3 = "SELECT COUNT(*) AS nombre_questions_etat_3 FROM question WHERE ETAT_ID = 3";
                    $stmt_nbr_ques_etat3 = $bdd->prepare($requete_nbr_ques_etat3);
                    $stmt_nbr_ques_etat3->execute();
                    $resultat3 = $stmt_nbr_ques_etat3->fetch(PDO::FETCH_ASSOC);
                    $nombre_questions_etat_3 = $resultat3['nombre_questions_etat_3'];
                    //nombre de question Complete
                    $requete_nbr_ques_etat4 = "SELECT COUNT(*) AS nombre_questions_etat_4 FROM question WHERE ETAT_ID = 4";
                    $stmt_nbr_ques_etat4 = $bdd->prepare($requete_nbr_ques_etat4);
                    $stmt_nbr_ques_etat4->execute();
                    $resultat4 = $stmt_nbr_ques_etat4->fetch(PDO::FETCH_ASSOC);
                    $nombre_questions_etat_4 = $resultat4['nombre_questions_etat_4'];
                     //nombre de question Annulee
                     $requete_nbr_ques_etat5 = "SELECT COUNT(*) AS nombre_questions_etat_5 FROM question WHERE ETAT_ID = 5";
                     $stmt_nbr_ques_etat5 = $bdd->prepare($requete_nbr_ques_etat5);
                     $stmt_nbr_ques_etat5->execute();
                     $resultat5 = $stmt_nbr_ques_etat5->fetch(PDO::FETCH_ASSOC);
                     $nombre_questions_etat_5 = $resultat5['nombre_questions_etat_5'];
                 // Vérifier le filtre
                    if(isset($_GET['filter'])) {
                        $filter = $_GET['filter'];
                        switch($filter) {
                            case 'Aujourd\'hui':
                                $requete_nbr_ques = "SELECT COUNT(*) AS nombre_questions_partagees FROM question WHERE  DAY(DATE_CREATION) = DAY(NOW()) AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW())";
                                $stmt_nbr_ques = $bdd->prepare($requete_nbr_ques);
                                $stmt_nbr_ques->execute();
                                $resultat = $stmt_nbr_ques->fetch(PDO::FETCH_ASSOC);
                                $nombre_questions_partagees = $resultat['nombre_questions_partagees'];
                                //nombre de question Nouvelle
                                $requete_nbr_ques_etat = "SELECT COUNT(*) AS nombre_questions_etat_1 FROM question WHERE ETAT_ID = 1 and  DAY(DATE_CREATION) = DAY(NOW()) AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                $stmt_nbr_ques_etat = $bdd->prepare($requete_nbr_ques_etat);
                                $stmt_nbr_ques_etat->execute();
                                $resultat = $stmt_nbr_ques_etat->fetch(PDO::FETCH_ASSOC);
                                $nombre_questions_etat_1 = $resultat['nombre_questions_etat_1'];
                                //nombre de question Nouvelle
                                $requete_nbr_ques_etat = "SELECT COUNT(*) AS nombre_questions_etat_1 FROM question WHERE ETAT_ID = 1  AND DAY(DATE_CREATION) = DAY(NOW()) AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                $stmt_nbr_ques_etat = $bdd->prepare($requete_nbr_ques_etat);
                                $stmt_nbr_ques_etat->execute();
                                $resultat = $stmt_nbr_ques_etat->fetch(PDO::FETCH_ASSOC);
                                $nombre_questions_etat_1 = $resultat['nombre_questions_etat_1'];
                                //nombre de question En cours 
                                $requete_nbr_ques_etat2 = "SELECT COUNT(*) AS nombre_questions_etat_2 FROM question WHERE ETAT_ID = 2  AND DAY(DATE_CREATION) = DAY(NOW()) AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                $stmt_nbr_ques_etat2 = $bdd->prepare($requete_nbr_ques_etat2);
                                $stmt_nbr_ques_etat2->execute();
                                $resultat2 = $stmt_nbr_ques_etat2->fetch(PDO::FETCH_ASSOC);
                                $nombre_questions_etat_2 = $resultat2['nombre_questions_etat_2'];
                                  //nombre de question Resolue
                                  $requete_nbr_ques_etat3 = "SELECT COUNT(*) AS nombre_questions_etat_3 FROM question WHERE ETAT_ID = 3  AND DAY(DATE_CREATION) = DAY(NOW()) AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat3 = $bdd->prepare($requete_nbr_ques_etat3);
                                  $stmt_nbr_ques_etat3->execute();
                                  $resultat3 = $stmt_nbr_ques_etat3->fetch(PDO::FETCH_ASSOC);
                                  $nombre_questions_etat_3 = $resultat3['nombre_questions_etat_3'];
                                  //nombre de question Complete
                                  $requete_nbr_ques_etat4 = "SELECT COUNT(*) AS nombre_questions_etat_4 FROM question WHERE ETAT_ID = 4 AND DAY(DATE_CREATION) = DAY(NOW()) AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat4 = $bdd->prepare($requete_nbr_ques_etat4);
                                  $stmt_nbr_ques_etat4->execute();
                                  $resultat4 = $stmt_nbr_ques_etat4->fetch(PDO::FETCH_ASSOC);
                                  $nombre_questions_etat_4 = $resultat4['nombre_questions_etat_4'];
                                  //nombre de question Annulee
                                  $requete_nbr_ques_etat5 = "SELECT COUNT(*) AS nombre_questions_etat_5 FROM question WHERE ETAT_ID = 5 AND DAY(DATE_CREATION) = DAY(NOW()) AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat5 = $bdd->prepare($requete_nbr_ques_etat5);
                                  $stmt_nbr_ques_etat5->execute();
                                  $resultat5 = $stmt_nbr_ques_etat5->fetch(PDO::FETCH_ASSOC);
                                  $nombre_questions_etat_5 = $resultat5['nombre_questions_etat_5'];
                                break;
                            case 'Ce Mois':
                                $requete_nbr_ques = "SELECT COUNT(*) AS nombre_questions_partagees FROM question WHERE  MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW())";
                                $stmt_nbr_ques = $bdd->prepare($requete_nbr_ques);
                                $stmt_nbr_ques->execute();
                                $resultat = $stmt_nbr_ques->fetch(PDO::FETCH_ASSOC);
                                $nombre_questions_partagees = $resultat['nombre_questions_partagees'];
                                //nombre de question Nouvelle
                                $requete_nbr_ques_etat = "SELECT COUNT(*) AS nombre_questions_etat_1 FROM question WHERE ETAT_ID = 1  AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                $stmt_nbr_ques_etat = $bdd->prepare($requete_nbr_ques_etat);
                                $stmt_nbr_ques_etat->execute();
                                $resultat = $stmt_nbr_ques_etat->fetch(PDO::FETCH_ASSOC);
                                $nombre_questions_etat_1 = $resultat['nombre_questions_etat_1'];
                                //nombre de question En cours 
                                $requete_nbr_ques_etat2 = "SELECT COUNT(*) AS nombre_questions_etat_2 FROM question WHERE ETAT_ID = 2  AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                $stmt_nbr_ques_etat2 = $bdd->prepare($requete_nbr_ques_etat2);
                                $stmt_nbr_ques_etat2->execute();
                                $resultat2 = $stmt_nbr_ques_etat2->fetch(PDO::FETCH_ASSOC);
                                $nombre_questions_etat_2 = $resultat2['nombre_questions_etat_2'];
                                  //nombre de question Resolue
                                  $requete_nbr_ques_etat3 = "SELECT COUNT(*) AS nombre_questions_etat_3 FROM question WHERE ETAT_ID = 3 AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat3 = $bdd->prepare($requete_nbr_ques_etat3);
                                  $stmt_nbr_ques_etat3->execute();
                                  $resultat3 = $stmt_nbr_ques_etat3->fetch(PDO::FETCH_ASSOC);
                                  $nombre_questions_etat_3 = $resultat3['nombre_questions_etat_3'];
                                  //nombre de question Complete
                                  $requete_nbr_ques_etat4 = "SELECT COUNT(*) AS nombre_questions_etat_4 FROM question WHERE ETAT_ID = 4  AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat4 = $bdd->prepare($requete_nbr_ques_etat4);
                                  $stmt_nbr_ques_etat4->execute();
                                  $resultat4 = $stmt_nbr_ques_etat4->fetch(PDO::FETCH_ASSOC);
                                  $nombre_questions_etat_4 = $resultat4['nombre_questions_etat_4'];
                                  //nombre de question Annulee
                                  $requete_nbr_ques_etat5 = "SELECT COUNT(*) AS nombre_questions_etat_5 FROM question WHERE ETAT_ID = 5  AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat5 = $bdd->prepare($requete_nbr_ques_etat5);
                                  $stmt_nbr_ques_etat5->execute();
                                  $resultat5 = $stmt_nbr_ques_etat5->fetch(PDO::FETCH_ASSOC);
                                  $nombre_questions_etat_5 = $resultat5['nombre_questions_etat_5'];
                                break;
                            case 'Cette Année':
                                $requete_nbr_ques = "SELECT COUNT(*) AS nombre_questions_partagees FROM question WHERE  YEAR(DATE_CREATION) = YEAR(NOW())";
                                $stmt_nbr_ques = $bdd->prepare($requete_nbr_ques);
                                $stmt_nbr_ques->execute();
                                // Récupération du résultat
                                $resultat = $stmt_nbr_ques->fetch(PDO::FETCH_ASSOC);
                                $nombre_questions_partagees = $resultat['nombre_questions_partagees'];
                                //nombre de question Nouvelle
                                $requete_nbr_ques_etat = "SELECT COUNT(*) AS nombre_questions_etat_1 FROM question WHERE ETAT_ID = 1  AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                $stmt_nbr_ques_etat = $bdd->prepare($requete_nbr_ques_etat);
                                $stmt_nbr_ques_etat->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                                $stmt_nbr_ques_etat->execute();
                                $resultat = $stmt_nbr_ques_etat->fetch(PDO::FETCH_ASSOC);
                                $nombre_questions_etat_1 = $resultat['nombre_questions_etat_1'];
                                //nombre de question En cours 
                                $requete_nbr_ques_etat2 = "SELECT COUNT(*) AS nombre_questions_etat_2 FROM question WHERE ETAT_ID = 2 AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                $stmt_nbr_ques_etat2 = $bdd->prepare($requete_nbr_ques_etat2);
                                $stmt_nbr_ques_etat2->execute();
                                $resultat2 = $stmt_nbr_ques_etat2->fetch(PDO::FETCH_ASSOC);
                                $nombre_questions_etat_2 = $resultat2['nombre_questions_etat_2'];
                                  //nombre de question Resolue
                                  $requete_nbr_ques_etat3 = "SELECT COUNT(*) AS nombre_questions_etat_3 FROM question WHERE ETAT_ID = 3  AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat3 = $bdd->prepare($requete_nbr_ques_etat3);
                                  $stmt_nbr_ques_etat3->execute();
                                  $resultat3 = $stmt_nbr_ques_etat3->fetch(PDO::FETCH_ASSOC);
                                  $nombre_questions_etat_3 = $resultat3['nombre_questions_etat_3'];
                                  //nombre de question Complete
                                  $requete_nbr_ques_etat4 = "SELECT COUNT(*) AS nombre_questions_etat_4 FROM question WHERE ETAT_ID = 4 AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat4 = $bdd->prepare($requete_nbr_ques_etat4);
                                  $stmt_nbr_ques_etat4->execute();
                                  $resultat4 = $stmt_nbr_ques_etat4->fetch(PDO::FETCH_ASSOC);
                                  $nombre_questions_etat_4 = $resultat4['nombre_questions_etat_4'];
                                  //nombre de question Annulee
                                  $requete_nbr_ques_etat5 = "SELECT COUNT(*) AS nombre_questions_etat_5 FROM question WHERE ETAT_ID = 5 AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat5 = $bdd->prepare($requete_nbr_ques_etat5);
                                  $stmt_nbr_ques_etat5->execute();
                                  $resultat5 = $stmt_nbr_ques_etat5->fetch(PDO::FETCH_ASSOC);
                                  $nombre_questions_etat_5 = $resultat5['nombre_questions_etat_5'];
                                break;
                            default:

                        }
                    }
                ?>  
            <!--------------- CARD 1 ----------------->
            <div style="width:1000px;" class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">
                
                <div style="margin-left:auto;" class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                        <h6>Filtrer</h6>
                    </li>
                    <li><a class="dropdown-item" href="admin_index.php?filter=Aujourd'hui">Aujourd'hui</a></li>
                    <li><a class="dropdown-item" href="admin_index.php?filter=Ce Mois">Ce Mois</a></li>
                    <li><a class="dropdown-item" href="admin_index.php?filter=Cette Année">Cette Année</a></li>
                </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Nombre de Questions partagées<span>
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
            
             <!---------  Debut Card 3 ----------->
             <div  class="col-12">
            <div class="row w-100">
            <div style="width:1000px;" class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Nombre d'annonces crées de chaque type<span>
                </span></h5>
                <?php
    // Requête SQL pour compter le nombre d'annonces de chaque type
    $requete_repartition_type_annonce = "SELECT 
                                            TYPE_ANNONCE,
                                            COUNT(*) AS nombre_annonce_par_type
                                        FROM 
                                            annonce
                                        GROUP BY 
                                            TYPE_ANNONCE;";
        
    $stmt_repartition_type_annonce = $bdd->prepare($requete_repartition_type_annonce);
    $stmt_repartition_type_annonce->execute();
    $resultats_repartition_type_annonce = $stmt_repartition_type_annonce->fetchAll(PDO::FETCH_ASSOC);
    // Initialisation des tableaux pour les catégories et les données
    $categories = array();
    $donnees = array();

    // Parcours des résultats de la requête et remplissage des tableaux
    foreach ($resultats_repartition_type_annonce as $resultat) {
        $categories[] = $resultat['TYPE_ANNONCE'];
        $donnees[] = $resultat['nombre_annonce_par_type'];       
    }
?>


<!-- Div où le graphique sera rendu -->
<div id="barChart"></div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Récupérer les données PHP et les stocker dans des variables JavaScript
            var categories = <?php echo json_encode($categories); ?>;
            var donnees = <?php echo json_encode($donnees); ?>;

            new ApexCharts(document.querySelector("#barChart"), {
                series: [{
                    data: donnees
                }],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '20%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: categories
                },
                yaxis: {
                    title: {
                        text: 'Nombre d\'annonces'
                    }
                },
                colors: ['#007bff']
            }).render();
        });
    </script>

                </div>
              </div>
            </div>
   <!--------------------- FIN Card 3 ---------------------->



   <!-------------------------DEBUT CARDDD----------------------------------->
   <div  class="col-12">
            <div class="row w-100">
            <div style="width:1000px;" class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Répartition des projets par budget<span>
                </span></h5>
                <?php
                // Requête SQL pour calculer la répartition des projets par budget
              $requete_repartition_projet_budget = "
              SELECT 
                  CASE
                      WHEN BUDGET <= 1000 THEN 'Petit'
                      WHEN BUDGET > 1000 AND BUDGET <= 5000 THEN 'Moyen'
                      WHEN BUDGET > 5000 AND BUDGET <= 10000 THEN 'Grand'
                      ELSE 'Très grand'
                  END AS categorie_budget,
                  COUNT(*) AS nombre_projets
              FROM 
                  projet
              GROUP BY 
                  CASE
                      WHEN BUDGET <= 1000 THEN 'Petit'
                      WHEN BUDGET > 1000 AND BUDGET <= 5000 THEN 'Moyen'
                      WHEN BUDGET > 5000 AND BUDGET <= 10000 THEN 'Grand'
                      ELSE 'Très grand'
                  END;
              ";
              $stmt_repartition_projet_budget = $bdd->prepare($requete_repartition_projet_budget);
              $stmt_repartition_projet_budget->execute();
              $resultats_repartition_projet_budget = $stmt_repartition_projet_budget->fetchAll(PDO::FETCH_ASSOC);
                ?>


<canvas id="pieChart" style="max-height: 300px;"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        var ctx = document.getElementById('pieChart').getContext('2d');

        // Récupération des données depuis PHP
        var categories = <?php echo json_encode(array_column($resultats_repartition_projet_budget, 'categorie_budget')); ?>;
        var data = <?php echo json_encode(array_column($resultats_repartition_projet_budget, 'nombre_projets')); ?>;

        var chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: categories,
                datasets: [{
                    label: 'Répartition des projets par budget',
                    data: data,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        '#F28C28',
                        'rgb(75, 192, 192)'
                    ],
                    hoverOffset: 4
                }]
            }
        });
    });
</script>

  
                </div>
              </div>
            </div>
   <!-------------------------FIN CARDDD --------------------------------------------->


   <!------------------------DEBUT CARDDDD -------------------------------->
   <div  class="col-12">
            <div class="row w-100">
            <div style="width:1000px;" class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Nombre de Reponses Fournis par Mois<span>
                </span></h5>
                <?php
                // Requête SQL pour obtenir le nombre de réponses par mois
                $requete_reponses_par_mois = "
                    SELECT 
                        DATE_FORMAT(REPONSE_DATE_CREATION, '%Y-%m') AS mois,
                        COUNT(*) AS nombre_reponses
                    FROM 
                        reponse
                    GROUP BY 
                        DATE_FORMAT(REPONSE_DATE_CREATION, '%Y-%m')
                    ORDER BY 
                        DATE_FORMAT(REPONSE_DATE_CREATION, '%Y-%m');
                ";
                $stmt_reponses_par_mois = $bdd->prepare($requete_reponses_par_mois);
                $stmt_reponses_par_mois->execute();
                $resultats_reponses_par_mois = $stmt_reponses_par_mois->fetchAll(PDO::FETCH_ASSOC);

                // Initialisation des tableaux pour les mois et les données
                $mois = array();
                $nombre_reponses = array();

                // Parcours des résultats de la requête et remplissage des tableaux
                foreach ($resultats_reponses_par_mois as $resultat) {
                    $mois[] = $resultat['mois'];
                    $nombre_reponses[] = $resultat['nombre_reponses'];
                }
                ?>

<canvas id="lineChart" style="max-height: 400px;"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        var ctx = document.getElementById('lineChart').getContext('2d');

        // Récupération des données depuis PHP
        var mois = <?php echo json_encode($mois); ?>;
        var nombre_reponses = <?php echo json_encode($nombre_reponses); ?>;

        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: mois,
                datasets: [{
                    label: 'Nombre de réponses par mois',
                    data: nombre_reponses,
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
    });
</script>

                </div>
              </div>
            </div>

   <!-------------------------FIN CARDDD --------------------------------------------->





<!------------------------DEBUT CARDDDD -------------------------------->
<!-- Left side columns -->
  <div  class="col-12">
    <div class="row w-100">
            <?php
                   $requete_nbr_ques = "SELECT COUNT(*) AS nombre_formations_partagees FROM formation WHERE DAY(DATE_CREATION) = DAY(NOW()) AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW())";
                   $stmt_nbr_ques = $bdd->prepare($requete_nbr_ques);
                   $stmt_nbr_ques->execute();
                   $resultat = $stmt_nbr_ques->fetch(PDO::FETCH_ASSOC);
                   $nombre_formations_partagees = $resultat['nombre_formations_partagees'];
                  //nombre de question Nouvelle
                  $requete_nbr_ques_etat = "SELECT COUNT(*) AS nombre_formations_etat_1 FROM formation WHERE ETAT_FORMATION = 'nouvelle';";
                  $stmt_nbr_ques_etat = $bdd->prepare($requete_nbr_ques_etat);
                  $stmt_nbr_ques_etat->execute();
                  $resultat = $stmt_nbr_ques_etat->fetch(PDO::FETCH_ASSOC);
                  $nombre_formations_etat_1 = $resultat['nombre_formations_etat_1'];
                   //nombre de question En cours 
                   $requete_nbr_ques_etat2 = "SELECT COUNT(*) AS nombre_formations_etat_2 FROM formation WHERE ETAT_FORMATION = 'Ouverte'";
                   $stmt_nbr_ques_etat2 = $bdd->prepare($requete_nbr_ques_etat2);
                   $stmt_nbr_ques_etat2->execute();
                   $resultat2 = $stmt_nbr_ques_etat2->fetch(PDO::FETCH_ASSOC);
                   $nombre_formations_etat_2 = $resultat2['nombre_formations_etat_2'];
                    //nombre de question Resolue
                    $requete_nbr_ques_etat3 = "SELECT COUNT(*) AS nombre_formations_etat_3 FROM formation WHERE ETAT_FORMATION = 'fermee';";
                    $stmt_nbr_ques_etat3 = $bdd->prepare($requete_nbr_ques_etat3);
                    $stmt_nbr_ques_etat3->execute();
                    $resultat3 = $stmt_nbr_ques_etat3->fetch(PDO::FETCH_ASSOC);
                    $nombre_formations_etat_3 = $resultat3['nombre_formations_etat_3'];
                    //nombre de question Complete
                    $requete_nbr_ques_etat4 = "SELECT COUNT(*) AS nombre_formations_etat_4 FROM formation WHERE ETAT_FORMATION = 'Terminee';";
                    $stmt_nbr_ques_etat4 = $bdd->prepare($requete_nbr_ques_etat4);
                    $stmt_nbr_ques_etat4->execute();
                    $resultat4 = $stmt_nbr_ques_etat4->fetch(PDO::FETCH_ASSOC);
                    $nombre_formations_etat_4 = $resultat4['nombre_formations_etat_4'];
                     //nombre de question Annulee
                     $requete_nbr_ques_etat5 = "SELECT COUNT(*) AS nombre_formations_etat_5 FROM formation WHERE ETAT_FORMATION = 'Annulee';";
                     $stmt_nbr_ques_etat5 = $bdd->prepare($requete_nbr_ques_etat5);
                     $stmt_nbr_ques_etat5->execute();
                     $resultat5 = $stmt_nbr_ques_etat5->fetch(PDO::FETCH_ASSOC);
                     $nombre_formations_etat_5 = $resultat5['nombre_formations_etat_5'];
                 // Vérifier le filtre
                    if(isset($_GET['filter'])) {
                        $filter = $_GET['filter'];
                        switch($filter) {
                            case 'Aujourd\'hui':
                                $requete_nbr_ques = "SELECT COUNT(*) AS nombre_formations_partagees FROM formation WHERE  DAY(DATE_CREATION) = DAY(NOW()) AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW())";
                                $stmt_nbr_ques = $bdd->prepare($requete_nbr_ques);
                                $stmt_nbr_ques->execute();
                                $resultat = $stmt_nbr_ques->fetch(PDO::FETCH_ASSOC);
                                $nombre_formations_partagees = $resultat['nombre_formations_partagees'];
                                //nombre de question Nouvelle
                                $requete_nbr_ques_etat = "SELECT COUNT(*) AS nombre_formations_etat_1 FROM formation WHERE ETAT_FORMATION = 'nouvelle'  AND DAY(DATE_CREATION) = DAY(NOW()) AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                $stmt_nbr_ques_etat = $bdd->prepare($requete_nbr_ques_etat);
                                $stmt_nbr_ques_etat->execute();
                                $resultat = $stmt_nbr_ques_etat->fetch(PDO::FETCH_ASSOC);
                                $nombre_formations_etat_1 = $resultat['nombre_formations_etat_1'];
                                //nombre de question En cours 
                                $requete_nbr_ques_etat2 = "SELECT COUNT(*) AS nombre_formations_etat_2 FROM formation WHERE ETAT_FORMATION = 'Ouverte'  AND DAY(DATE_CREATION) = DAY(NOW()) AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                $stmt_nbr_ques_etat2 = $bdd->prepare($requete_nbr_ques_etat2);
                                $stmt_nbr_ques_etat2->execute();
                                $resultat2 = $stmt_nbr_ques_etat2->fetch(PDO::FETCH_ASSOC);
                                $nombre_formations_etat_2 = $resultat2['nombre_formations_etat_2'];
                                  //nombre de question Resolue
                                  $requete_nbr_ques_etat3 = "SELECT COUNT(*) AS nombre_formations_etat_3 FROM formation WHERE ETAT_FORMATION = 'fermee'  AND DAY(DATE_CREATION) = DAY(NOW()) AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat3 = $bdd->prepare($requete_nbr_ques_etat3);
                                  $stmt_nbr_ques_etat3->execute();
                                  $resultat3 = $stmt_nbr_ques_etat3->fetch(PDO::FETCH_ASSOC);
                                  $nombre_formations_etat_3 = $resultat3['nombre_formations_etat_3'];
                                  //nombre de question Complete
                                  $requete_nbr_ques_etat4 = "SELECT COUNT(*) AS nombre_formations_etat_4 FROM formation WHERE ETAT_FORMATION = 'Terminee' AND DAY(DATE_CREATION) = DAY(NOW()) AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat4 = $bdd->prepare($requete_nbr_ques_etat4);
                                  $stmt_nbr_ques_etat4->execute();
                                  $resultat4 = $stmt_nbr_ques_etat4->fetch(PDO::FETCH_ASSOC);
                                  $nombre_formations_etat_4 = $resultat4['nombre_formations_etat_4'];
                                  //nombre de question Annulee
                                  $requete_nbr_ques_etat5 = "SELECT COUNT(*) AS nombre_formations_etat_5 FROM formation WHERE ETAT_FORMATION = 'Annulee' AND DAY(DATE_CREATION) = DAY(NOW()) AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat5 = $bdd->prepare($requete_nbr_ques_etat5);
                                  $stmt_nbr_ques_etat5->execute();
                                  $resultat5 = $stmt_nbr_ques_etat5->fetch(PDO::FETCH_ASSOC);
                                  $nombre_formations_etat_5 = $resultat5['nombre_formations_etat_5'];
                                break;
                            case 'Ce Mois':
                                $requete_nbr_ques = "SELECT COUNT(*) AS nombre_formations_partagees FROM formation WHERE  MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW())";
                                $stmt_nbr_ques = $bdd->prepare($requete_nbr_ques);
                                $stmt_nbr_ques->execute();
                                $resultat = $stmt_nbr_ques->fetch(PDO::FETCH_ASSOC);
                                $nombre_formations_partagees = $resultat['nombre_formations_partagees'];
                                //nombre de question Nouvelle
                                $requete_nbr_ques_etat = "SELECT COUNT(*) AS nombre_formations_etat_1 FROM formation WHERE ETAT_FORMATION = 'nouvelle'  AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                $stmt_nbr_ques_etat = $bdd->prepare($requete_nbr_ques_etat);
                                $stmt_nbr_ques_etat->execute();
                                $resultat = $stmt_nbr_ques_etat->fetch(PDO::FETCH_ASSOC);
                                $nombre_formations_etat_1 = $resultat['nombre_formations_etat_1'];
                                //nombre de question En cours 
                                $requete_nbr_ques_etat2 = "SELECT COUNT(*) AS nombre_formations_etat_2 FROM formation WHERE ETAT_FORMATION = 'Ouverte'  AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                $stmt_nbr_ques_etat2 = $bdd->prepare($requete_nbr_ques_etat2);
                                $stmt_nbr_ques_etat2->execute();
                                $resultat2 = $stmt_nbr_ques_etat2->fetch(PDO::FETCH_ASSOC);
                                $nombre_formations_etat_2 = $resultat2['nombre_formations_etat_2'];
                                  //nombre de question Resolue
                                  $requete_nbr_ques_etat3 = "SELECT COUNT(*) AS nombre_formations_etat_3 FROM formation WHERE ETAT_FORMATION = 'fermee' AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat3 = $bdd->prepare($requete_nbr_ques_etat3);
                                  $stmt_nbr_ques_etat3->execute();
                                  $resultat3 = $stmt_nbr_ques_etat3->fetch(PDO::FETCH_ASSOC);
                                  $nombre_formations_etat_3 = $resultat3['nombre_formations_etat_3'];
                                  //nombre de question Complete
                                  $requete_nbr_ques_etat4 = "SELECT COUNT(*) AS nombre_formations_etat_4 FROM formation WHERE ETAT_FORMATION = 'Terminee'  AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat4 = $bdd->prepare($requete_nbr_ques_etat4);
                                  $stmt_nbr_ques_etat4->execute();
                                  $resultat4 = $stmt_nbr_ques_etat4->fetch(PDO::FETCH_ASSOC);
                                  $nombre_formations_etat_4 = $resultat4['nombre_formations_etat_4'];
                                  //nombre de question Annulee
                                  $requete_nbr_ques_etat5 = "SELECT COUNT(*) AS nombre_formations_etat_5 FROM formation WHERE ETAT_FORMATION = 'Annulee'  AND MONTH(DATE_CREATION) = MONTH(NOW()) AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat5 = $bdd->prepare($requete_nbr_ques_etat5);
                                  $stmt_nbr_ques_etat5->execute();
                                  $resultat5 = $stmt_nbr_ques_etat5->fetch(PDO::FETCH_ASSOC);
                                  $nombre_formations_etat_5 = $resultat5['nombre_formations_etat_5'];
                                break;
                            case 'Cette Année':
                                $requete_nbr_ques = "SELECT COUNT(*) AS nombre_formations_partagees FROM formation WHERE  YEAR(DATE_CREATION) = YEAR(NOW())";
                                $stmt_nbr_ques = $bdd->prepare($requete_nbr_ques);
                                $stmt_nbr_ques->execute();
                                // Récupération du résultat
                                $resultat = $stmt_nbr_ques->fetch(PDO::FETCH_ASSOC);
                                $nombre_formations_partagees = $resultat['nombre_formations_partagees'];
                                //nombre de question Nouvelle
                                $requete_nbr_ques_etat = "SELECT COUNT(*) AS nombre_formations_etat_1 FROM formation WHERE ETAT_FORMATION = 'nouvelle'  AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                $stmt_nbr_ques_etat = $bdd->prepare($requete_nbr_ques_etat);
                                $stmt_nbr_ques_etat->bindParam(':utilisateur_id', $id, PDO::PARAM_INT);
                                $stmt_nbr_ques_etat->execute();
                                $resultat = $stmt_nbr_ques_etat->fetch(PDO::FETCH_ASSOC);
                                $nombre_formations_etat_1 = $resultat['nombre_formations_etat_1'];
                                //nombre de question En cours 
                                $requete_nbr_ques_etat2 = "SELECT COUNT(*) AS nombre_formations_etat_2 FROM formation WHERE ETAT_FORMATION = 'Ouverte' AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                $stmt_nbr_ques_etat2 = $bdd->prepare($requete_nbr_ques_etat2);
                                $stmt_nbr_ques_etat2->execute();
                                $resultat2 = $stmt_nbr_ques_etat2->fetch(PDO::FETCH_ASSOC);
                                $nombre_formations_etat_2 = $resultat2['nombre_formations_etat_2'];
                                  //nombre de question Resolue
                                  $requete_nbr_ques_etat3 = "SELECT COUNT(*) AS nombre_formations_etat_3 FROM formation WHERE ETAT_FORMATION = 'fermee'  AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat3 = $bdd->prepare($requete_nbr_ques_etat3);
                                  $stmt_nbr_ques_etat3->execute();
                                  $resultat3 = $stmt_nbr_ques_etat3->fetch(PDO::FETCH_ASSOC);
                                  $nombre_formations_etat_3 = $resultat3['nombre_formations_etat_3'];
                                  //nombre de question Complete
                                  $requete_nbr_ques_etat4 = "SELECT COUNT(*) AS nombre_formations_etat_4 FROM formation WHERE ETAT_FORMATION = 'Terminee' AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat4 = $bdd->prepare($requete_nbr_ques_etat4);
                                  $stmt_nbr_ques_etat4->execute();
                                  $resultat4 = $stmt_nbr_ques_etat4->fetch(PDO::FETCH_ASSOC);
                                  $nombre_formations_etat_4 = $resultat4['nombre_formations_etat_4'];
                                  //nombre de question Annulee
                                  $requete_nbr_ques_etat5 = "SELECT COUNT(*) AS nombre_formations_etat_5 FROM formation WHERE ETAT_FORMATION = 'Annulee' AND YEAR(DATE_CREATION) = YEAR(NOW());";
                                  $stmt_nbr_ques_etat5 = $bdd->prepare($requete_nbr_ques_etat5);
                                  $stmt_nbr_ques_etat5->execute();
                                  $resultat5 = $stmt_nbr_ques_etat5->fetch(PDO::FETCH_ASSOC);
                                  $nombre_formations_etat_5 = $resultat5['nombre_formations_etat_5'];
                                break;
                            default:

                        }
                    }
                ?>  
            <!--------------- CARD 1 ----------------->
            <div style="width:1000px;" class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">
                
                <div style="margin-left:auto;" class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                        <h6>Filtrer</h6>
                    </li>
                    <li><a class="dropdown-item" href="admin_index.php?filter=Aujourd'hui">Aujourd'hui</a></li>
                    <li><a class="dropdown-item" href="admin_index.php?filter=Ce Mois">Ce Mois</a></li>
                    <li><a class="dropdown-item" href="admin_index.php?filter=Cette Année">Cette Année</a></li>
                </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Nombre de Formations planifiées<span>
                    <?php  if(isset($_GET['filter'])) echo "  |  ".$_GET['filter']; else echo "  | Aujourd'hui"; ?>
                </span></h5>

                <div class="d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center me-3">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-book"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $nombre_formations_partagees; ?></h6>
                      <span class="text-success small pt-1 fw-bold">Formation en total</span> <span class="text-muted small pt-2 ps-1"></span>
                    </div>
                  </div>

                  <div class="d-flex align-items-center">
                   
                    <div class="ps-3">
                      <h6><?php echo $nombre_formations_etat_1; ?></h6>
                      <span class="text-success small pt-1 fw-bold">Nouvelles</span> <span class="text-muted small pt-2 ps-1"></span>
                    </div>
                  </div>

                  <div class="d-flex align-items-center">
                    
                    <div class="ps-3">
                      <h6><?php echo $nombre_formations_etat_2; ?></h6>
                      <span class="text-success small pt-1 fw-bold">Ouvertes</span> <span class="text-muted small pt-2 ps-1"></span>
                    </div>
                  </div>
                  <div class="d-flex align-items-center">
                    
                    <div class="ps-3">
                      <h6><?php echo $nombre_formations_etat_3; ?></h6>
                      <span class="text-success small pt-1 fw-bold">Fermées</span> <span class="text-muted small pt-2 ps-1"></span>
                    </div>
                  </div>

                  <div class="d-flex align-items-center">
                   
                    <div class="ps-3">
                      <h6><?php echo $nombre_formations_etat_4; ?></h6>
                      <span class="text-success small pt-1 fw-bold">Terminées</span> <span class="text-muted small pt-2 ps-1"></span>
                    </div>
                  </div>

                  <div class="d-flex align-items-center">
                    
                    <div class="ps-3">
                      <h6><?php echo $nombre_formations_etat_5; ?></h6>
                      <span class="text-success small pt-1 fw-bold">Annulées</span> <span class="text-muted small pt-2 ps-1"></span>
                    </div>
                  </div>

                </div>
                </div>
              </div>
            </div>
<!--------- End Card1 ----------->
<!-------------------------FIN CARDDD --------------------------------------------->



<!------------------------------ DEBUT CARDDD------------------------------------>
<div  class="col-12">
            <div class="row w-100">
            <div style="width:1000px;" class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Nombre de Commentaires partagés par Mois<span>
                </span></h5>
                <?php
                  // Requête SQL pour compter le nombre de commentaires par mois
                  $requete_nombre_commentaires = "SELECT DATE_FORMAT(COMMENT_DATE_CREATION, '%Y-%m') AS mois, COUNT(*) AS nombre_commentaires
                                                  FROM commentaire
                                                  GROUP BY mois";
                  $stmt_nombre_commentaires = $bdd->prepare($requete_nombre_commentaires);
                  $stmt_nombre_commentaires->execute();
                  $resultats_nombre_commentaires = $stmt_nombre_commentaires->fetchAll(PDO::FETCH_ASSOC);
                  // Initialisation des tableaux pour les mois et les données
                  $mois = array();
                  $nombre_commentaires = array();
                  // Parcours des résultats de la requête et remplissage des tableaux
                  foreach ($resultats_nombre_commentaires as $resultat) {
                      $mois[] = $resultat['mois'];
                      $nombre_commentaires[] = $resultat['nombre_commentaires'];
                  }
                  
              ?>
<canvas id="lineChart2" style="max-height: 400px;"></canvas>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        var ctx = document.getElementById('lineChart2').getContext('2d');
        // Récupération des données depuis PHP
        var mois = <?php echo json_encode($mois); ?>;
        var nombre_commentaires = <?php echo json_encode($nombre_commentaires); ?>;
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: mois,
                datasets: [{
                    label: 'Nombre de commentaires par mois',
                    data: nombre_commentaires,
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
    });
</script>

                </div>
              </div>
            </div>
<!---------------------------- FIN  CARDD----------------------------------->



            </div>
            </div>
            </div>
            </div>
        </section>
        </div>
         <!------------- FIN STATISTIQUES ---------------->
   </div><!--tous--->
</main>

<?php
// require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\footer.php';

?>