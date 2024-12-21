<?php

require_once '..\..\controllers\auth\auth_inc.php';
include '..\..\controllers\db\connexion.php';

$visited_id=$_GET["IDD"];
$current_user=  $_SESSION['user_id'];
if($visited_id == $current_user) header("Location:profile.php");
else include '..\headerX\header_user.php'; //include ici pour ne pas avoir 2 header l'un ici et lautre si on visit 'mon profile'

//--------> recuperation des infos de profil
$req = "SELECT * FROM utilisateur WHERE UTILISATEUR_ID=$visited_id";
$stmt=$bdd->query($req);
$visited_user=$stmt->fetchAll(PDO::FETCH_ASSOC);

//----------->FIN PARTIE ASSIA




//--------> recuperation des competences
$sql = "SELECT *
        FROM competence c
        JOIN utilisateur_competence uc ON uc.COMPETENCE_ID = c.COMPETENCE_ID
        JOIN niveau n ON uc.NIVEAU_ID = n.NIVEAU_ID
        WHERE uc.UTILISATEUR_ID = :visited_id";

$stmtt = $bdd->prepare($sql);
$stmtt->bindParam(':visited_id', $visited_id, PDO::PARAM_INT);
$stmtt->execute();
$competences = $stmtt->fetchAll(PDO::FETCH_ASSOC);

//--------> recuperation les titres des  niveaux
$req_niveau="SELECT NIVEAU_TITRE from niveau";
//executer la requete
$stmt_niveau=$bdd->query($req_niveau);
//parcourir le resultat
$niveaux=$stmt_niveau->fetchAll(PDO::FETCH_ASSOC);



//--------> recuperer formation et projet de ce user
/////////////////////////partie salma
$sql="SELECT * FROM formation f,utilisateur_formation uf 
      WHERE uf.UTILISATEUR_ID=? AND uf.FORMATION_ID=f.FORMATION_ID";
$stmt=$bdd->prepare($sql);
$stmt->bindValue(1,$visited_id,PDO::PARAM_INT);
$stmt->execute();
$formation=$stmt->fetchAll(PDO::FETCH_ASSOC);


$sql="SELECT * FROM projet p,utilisateur_projet up,role_projet r 
      WHERE up.UTILISATEUR_ID=? AND up.PROJET_ID=p.PROJET_ID AND r.ROLE_PROJET_ID=up.ROLE_PROJET_ID";
$stmt=$bdd->prepare($sql);
$stmt->bindValue(1,$visited_id,PDO::PARAM_INT);
$stmt->execute();

$projet=$stmt->fetchAll(PDO::FETCH_ASSOC);
$pass = $stmt->rowCount();
////////////////////////fin partie salme


?>
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
    <div class="card section profile">
    <div class="row">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="container bootstrap snippets bootdey">
    <div class="row">
        <div class="panel">
            <div class="cover-photo">
              <div class="fb-timeline-img">
                  <img src="..\..\storage\images\back.jpg" alt="">
              </div>
              <div class="fb-name">
                  <h2><a href="#"></a></h2>
              </div>
            </div>
            <div class="panel-body">
              <div class="profile-thumb">
                  <img src="..\..\storage\images\<?php echo $visited_user[0]['IMAGE']?>" alt="">
              </div>
              <a href="#" class="fb-user-mail"></a>
            </div>
        </div>
    </div>
    
    <!------- CARD 1---->
   
    <div class="card-body pt-3">
    <div class="row">
                  <div class="col-lg-9" class="col-md-6" >
                   <h4 class="card-title"><?php echo $visited_user[0]['NOM'].' '.$visited_user[0]['PRENOM'];?><br> <small><?php echo $visited_user[0]['POSTE'];?></small></h4>
                 </div>
                 
                   
                  <div class="col-lg-2 mt-3">
                       <button class="btn btn-primary"><i class="bi bi-chat-text"></i>  Message</button>
                  </div>
  </div>
                
                 
     </div>
    </section>
    <!-------------end section--->


    
             
    <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Aperçu</button>
                </li>

                <!-- <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">modifier Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Paramétres</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Modifier mot de passe</button>
                </li> -->

              </ul>
           </div>
    </div>
    <!-----fin entete -------->
  
          <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <div class="card">
                <div class="card-body pt-3">
                 <table width="100%">
                    <tr>
                        <td width="90%"> 
                        <h5 class="card-title">Compétences</h5>
                        <p class="small fst-italic"></p>
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
                                    } elseif ($niveau == "Maitrise complete") {
                                        $progress_width = 100;
                                    }
                                   
                                ?>
                        <tr style="line-height: 40px;">
                            <td width="3%"><i class="bi bi-bookmark-star orange-bi"></i>
                            <input type="hidden" name="competence_idd" value="<?php echo $competence["COMPETENCE_ID"]; ?>">
                            </td>
                            <td width="20%" name="competence_nom"> 
                               <input type="hidden" name="competence_nomm" value="<?php echo $competence["COMPETENCE_NOM"]; ?>"> 
                               <?php echo $competence["COMPETENCE_NOM"]; ?>
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
                            
                        </tr>
                        <?php endforeach; ?>
                    
                    </table>
                  </div><!--fin row-->
                </div><!--fin card-body-->
                </div><!--fin card-->


          <!-------dangerous-->
          <?php if (!empty($formation)): ?>
          <div class="card">
                <div class="card-body pt-3" >
                
                    <h5 class="card-title" >Formation</h5>  
                <div class="row">
                   
                    <?php  foreach($formation as $ligne): ?>
                      <table style="margin:20px;" width="100%">
                        <tr>
                          <td> <h5 style="color:#700129"><?php  echo $ligne['THEME']; ?></h5></td>
                        </tr>
                        <tr style="line-height: 40px;"> 
                        <td > 
                           <div id="info">
                          <div class="formation"><b>Formateur : </b><?php echo $ligne['FORMATEUR']; ?></div>
                          <div class="date"><b>Date de debut : </b><?php echo $ligne['FORMATION_DATE_DEBUT']; ?></div>
                          <div class="disc"><b>Description : </b><?php  echo $ligne['FORMATION_DESCR']; ?></p></div>
                          <div class="lieen"><b>Lien de la formation : </b><a href="<?php echo $ligne['FORMATION_LIEN'];?>" ><?php  echo $ligne['FORMATION_LIEN']; ?></a></div>
                        </div>
                       
                           </td>
                        </tr>
                        </table>
                        <hr style="height: 1.5px; background-color: rgba(0, 0, 0, 0.8);">
                        <?php endforeach; ?>
                    
                   
                  </div>
                </div>
          </div>
          <?php endif; ?>
          <!---------fin dangerous-------->

             <!-------dangerous22-->
             <?php if (!empty($projet)): ?>

             <div class="card">
                <div class="card-body pt-3">
                
                       <h5 class="card-title">Projet</h5>  
                <div class="row">
                   
                     <?php  foreach($projet as $ligne): ?>
                      <table style="margin:20px;" width="100%">
                        <tr>
                          <td  width="70%">  <h5 style="color:#700129"><?php  echo $ligne['PROJET_TITRE']; ?></h4></td>
                        </tr>
                        <tr style="line-height: 40px;"> 
                        <td colspan="2"> 
                        <div id="info">
                          <div  class="formation"><b>Role dans le projet : </b><?php echo $ligne['ROLE_PROJET_TITRE']; ?></div>
                          <div class="date"><b>Date de Debut : </b><?php echo $ligne['PROJET_DATE_DEBUT']; ?></div>
                          <div class="date"><b>Date du Fin : </b><?php echo $ligne['PROJET_DATE_FIN']; ?></div>
                          <div class="descr"><b >Description du Role: </b><?php  echo $ligne['ROLE_PROJET_DESCR']; ?></div>
                      </div>
                       
                           </td>
                        </tr>
                        </table>
                        <hr style="height: 1.5px; background-color: rgba(0, 0, 0, 0.8);">
                        <?php endforeach; ?>
                    
                   
                  </div>
                </div>
          </div>
          <?php else: echo "<p>pas de projet $visited_id $pass </p>"; ?>
          <?php endif; ?>
          <!---------fin dangerous22-------->
         </div><!--fin profile overview--->

        <!---//////////PARTIE ASSIA------------------------------>
        <!---//////////FIN PARTIE ASSIA------------------------------>

   </div><!--tous--->
  </main>



<?php
include '..\headerX\footer.php';

?>