
<?php

require_once '..\..\controllers\auth\auth_inc_admin.php';
include '..\headerX\header_admin.php';
include '..\..\controllers\db\connexion.php';



$feedback="SELECT * from feedback f,utilisateur u where f.UTILISATEUR_ID=u.UTILISATEUR_ID ORDER BY f.date_feedback DESC";
//preparer la requete
$stmt_feedback = $bdd->prepare($feedback);
$stmt_feedback->execute();

// Récupération des résultats
$feedbacks = $stmt_feedback->fetchAll();
?>

<style>
        .container2 {
            display: flex;
            align-items: center;
        }
        .title {
            margin-right: 10px;
        }
        .content p {
            margin:0; /* Supprime la marge par défaut du paragraphe pour un meilleur alignement */
        }
     
        .menu-container {
            position: relative;
        }

        .menu-btn {
            cursor: pointer;
            display: block;
            position: relative;
            z-index: 1;
            height: 30px;
            width: 30px;
        }

        .menu-btn span {
            background-color: #333;
            display: block;
            height: 2px;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.3s ease-in-out;
            width: 100%;
        }

        .menu-btn span:before,
        .menu-btn span:after {
            background-color: #333;
            content: '';
            display: block;
            height: 100%;
            position: absolute;
            transition: all 0.3s ease-in-out;
            width: 100%;
        }

        .menu-btn span:before {
            top: -8px;
        }

        .menu-btn span:after {
            bottom: -8px;
        }

        .menu-btn.active span {
            background-color: transparent;
        }

        .menu-btn.active span:before {
            transform: rotate(45deg);
        }

        .menu-btn.active span:after {
            transform: rotate(-45deg);
        }

        .menu {
            background-color: #fff;
            border: 1px solid #ccc;
            display: none;
            list-style: none;
            padding: 10px;
            position: absolute;
            right: 0;
            top: 40px;
            z-index: 0;
        }

        .menu li {
            margin-bottom: 10px;
        }

        .menu-container input[type="checkbox"] {
            display: none;
        }

        .menu-container input[type="checkbox"]:checked + .menu {
            display: block;
        }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../assets/css/details_question.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">



<main id="main" class="main">
<div class="pagetitle">
      <h1>Feedback</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
          <!-- <li class="breadcrumb-item"></li> -->
          <li class="breadcrumb-item active">Feedback</li>
        </ol>
      </nav>
    </div>
<div class="container">

<!------------BEGIN FOREACH------------>
<?php foreach($feedbacks as $feedback): ?>
<div class="row">
<div class="col-md-12">
<div id="content" class="content content-full-width">
<section style="padding:0px 30px 0px 30px;" class="section profile">
<div class="box box-widget">
<div class="box-header with-border">
<div class="user-block">    
<img class="img-circle" src="..\..\storage\images\<?php echo $feedback["IMAGE"]; ?>" alt="User Image">
<span style="display:inline;    margin-left: 15px;" class="username"><a href="#"><?php echo $feedback["NOM"]." ".$feedback["PRENOM"]; ?></a></span>
</span>
<?php 
              if ($_SESSION['user_id'] == $feedback['UTILISATEUR_ID']) {
                
                echo '<div style="display: inline; margin-left: 78%;"><a style="margin-right: 7px;" id="icon" href="..\..\controllers\user\supprimer_feedback.php?IDD=' . $feedback['ID_FEEDBACK'] . '" type="button" class="my-btn">
                <i class="bi bi-trash"></i>
                </a> 
                <a id="editBtn" type="button" href="modifier_feedback.php?id_fb='. $feedback['ID_FEEDBACK'] . '" class="my-btn editBtn" >
                <i class="bi bi-pen-fill"></i>
                </a></div>'; 
            }
            
        ?>
</div>

<div class="box-tools">


</div>
</div>
<div class="box-body">

<div class="container2">
<div class="content">
    <p><?php echo $feedback["COMMENTAIRE"]; ?></p>
</div>      
</div>





</div>
</section>
</div>
</div>
</div>
<?php endforeach; ?>
<!------------END FOREACH------------>



</div>

</main>

<?php
// require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\footer.php';

?>