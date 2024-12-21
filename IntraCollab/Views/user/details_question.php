<?php

require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\header_user.php';
include '..\..\controllers\db\connexion.php';

// $id_question = $_GET['IDD'];


//recuperee l id du projet concerne
if(isset($_SESSION["id_question"]))
{
  $id_question= $_SESSION["id_question"];
}
else 
{
  $id_question=$_GET['IDD'];
  $_SESSION["id_question"] =  $_GET['IDD'];
}
//partie salma

// Préparer et exécuter la requête
$sql = "SELECT *
-- , rr.*
FROM reponse r
-- JOIN reaction_reponse rr ON r.REPONSE_ID = rr.REPONSE_ID
WHERE  r.QUESTION_ID = ?;";
$stmt = $bdd->prepare($sql);
$stmt->bindValue(1, $id_question, PDO::PARAM_INT);
$stmt->execute(); // Ajout de cette ligne pour exécuter la requête
$reponses = $stmt->fetchAll(PDO::FETCH_ASSOC);
//end partie salma

//partie fatiha
$req_question="SELECT 
u.NOM,
u.PRENOM,
u.IMAGE,
u.UTILISATEUR_ID,
p.QUESTION_TITRE,
p.QUESTION_DESCR,
p.DATE_CREATION,
p.PROJET_ID,
e.ETAT_NOM,
e.ETAT_ID
FROM 
utilisateur u 
JOIN 
QUESTION p ON p.UTILISATEUR_ID = u.UTILISATEUR_ID
JOIN 
etat_question e ON p.ETAT_ID = e.ETAT_ID
WHERE 
p.QUESTION_ID = :question_id;";
//preparer la requete
$stmt_question = $bdd->prepare($req_question);
$stmt_question->bindParam(':question_id', $id_question, PDO::PARAM_INT);
$stmt_question->execute();
// Récupération des résultats
$questions = $stmt_question->fetch(PDO::FETCH_ASSOC);

//recuperer nombre de reponses
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


//recuperer les infos de l'utilisateur connecté
$user_id = $_SESSION['user_id'];
$req_curr_user="SELECT *
FROM utilisateur
WHERE UTILISATEUR_ID = :user_id";
// Préparation de la requête
$stmt_curr_user = $bdd->prepare($req_curr_user);
// Liaison du paramètre
$stmt_curr_user->bindParam(':user_id', $user_id, PDO::PARAM_INT);
// Exécution de la requête
$stmt_curr_user->execute();
// Récupération des résultats
$result_curr_user = $stmt_curr_user->fetch(PDO::FETCH_ASSOC);

//end partie fatiha

?>





<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../assets/css/details_question.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
.blue-icon {
    color: blue;
}
select {
/* styling */
background-color: white;
border: thin solid blue;
border-radius: 4px;
display: inline-block;
font: inherit;
line-height: 1.5em;
padding: 0.5em 3.5em 0.5em 1em;

/* reset */

margin: 0;      
-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
box-sizing: border-box;
-webkit-appearance: none;
-moz-appearance: none;
}


/* arrows */
select.classic {
  background-image:
    linear-gradient(45deg, transparent 50%, blue 50%),
    linear-gradient(135deg, blue 50%, transparent 50%),
    linear-gradient(to right, skyblue, skyblue);
  background-position:
    calc(100% - 20px) calc(1em + 2px),
    calc(100% - 15px) calc(1em + 2px),
    100% 0;
  background-size:
    5px 5px,
    5px 5px,
    2.5em 2.5em;
  background-repeat: no-repeat;

  padding: 2px 8px;
  font-size: 14px;
  height: auto;
  box-sizing: border-box;
  width: 250px;  /* Ajustez la valeur selon vos besoins */
}


select.classic:focus {
background-image:
  linear-gradient(45deg, white 50%, transparent 50%),
  linear-gradient(135deg, transparent 50%, white 50%),
  linear-gradient(to right, gray, gray);
background-position:
  calc(100% - 15px) 1em,
  calc(100% - 20px) 1em,
  100% 0;
background-size:
  5px 5px,
  5px 5px,
  2.5em 2.5em;
background-repeat: no-repeat;
border-color: grey;
outline: 0;
}




select.round {
background-image:
  linear-gradient(45deg, transparent 50%, gray 50%),
  linear-gradient(135deg, gray 50%, transparent 50%),
  radial-gradient(#ddd 70%, transparent 72%);
background-position:
  calc(100% - 20px) calc(1em + 2px),
  calc(100% - 15px) calc(1em + 2px),
  calc(100% - .5em) .5em;
background-size:
  5px 5px,
  5px 5px,
  1.5em 1.5em;
background-repeat: no-repeat;
}

select.round:focus {
background-image:
  linear-gradient(45deg, white 50%, transparent 50%),
  linear-gradient(135deg, transparent 50%, white 50%),
  radial-gradient(gray 70%, transparent 72%);
background-position:
  calc(100% - 15px) 1em,
  calc(100% - 20px) 1em,
  calc(100% - .5em) .5em;
background-size:
  5px 5px,
  5px 5px,
  1.5em 1.5em;
background-repeat: no-repeat;
border-color: green;
outline: 0;
}





select.minimal {
background-image:
  linear-gradient(45deg, transparent 50%, gray 50%),
  linear-gradient(135deg, gray 50%, transparent 50%),
  linear-gradient(to right, #ccc, #ccc);
background-position:
  calc(100% - 20px) calc(1em + 2px),
  calc(100% - 15px) calc(1em + 2px),
  calc(100% - 2.5em) 0.5em;
background-size:
  5px 5px,
  5px 5px,
  1px 1.5em;
background-repeat: no-repeat;
}

select.minimal:focus {
background-image:
  linear-gradient(45deg, green 50%, transparent 50%),
  linear-gradient(135deg, transparent 50%, green 50%),
  linear-gradient(to right, #ccc, #ccc);
background-position:
  calc(100% - 15px) 1em,
  calc(100% - 20px) 1em,
  calc(100% - 2.5em) 0.5em;
background-size:
  5px 5px,
  5px 5px,
  1px 1.5em;
background-repeat: no-repeat;
border-color: green;
outline: 0;
}


select:-moz-focusring {
color: transparent;
text-shadow: 0 0 0 #000;
}





.rating {
  display: inline-block;
}

.rating input {
  display: none;
}

.rating label {
  cursor: pointer;
  width: 20px;
  height: 20px;
  margin: 0 0px;
  background-color: #ccc;
  border-radius: 50%;
  display: inline-block;
}

.rating label:hover,
.rating input:checked + label {
  background-color: #f90;
}

</style>
</head>

<body>


<!--------------------------- Modal --------------->
<div class="modal fade" id="noter_reponse" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">REVIEW</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulaire pour ajouter une note à une reponse -->
                    <form action="..\..\controllers\user\noter_reponse.php" method="post">
                    <input type="hidden" name="reponse_id" id="reponse_id">
                        <div class="mb-3">
                           <label for="la_note" class="form-label">La Note:</label>
                           <label class="rating-label">
                           <select name="note" class="classic">
                            <option value="">Sélectionnez une option</option>
                            <option value="1">1 - Pas du tout pertinent</option>
                            <option value="2">2 - Peu pertinent</option>
                            <option value="3">3 - Moyennement pertinent</option>
                            <option value="4">4 - Pertinent</option>
                            <option value="5">5 - Très pertinent</option>
                          </select>
                        </div>
                        <!-- Autres champs de formulaire ici -->
                        
                        <button type="submit" name="noter" class="btn btn-primary">Ajouter La Note</button>
                    </form>
                </div>
            </div>
        </div>
</div>
<!---------FIN  MODAL----------------->








<!-------------- MODAL MODIFIER COMMENTAIRE -------------->
<div class="modal fade" id="modifierCommentaireModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier Commentaire</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulaire pour ajouter une commentaire -->
                    <form action="..\..\controllers\user\modifier_commentAction.php" method="POST">
                    <div class="mb-3">
                        <input type="hidden" name="comment_id"  id="comment_id">
                    </div>
                        <div class="mb-3">
                            <label for="newComp" class="form-label">Contenue:</label>
                            <input type="text" name="newComment" id="newComment" class="form-control" >
                        </div>
                        <!-- Autres champs de formulaire ici -->
                        <button type="submit" id="modifier_comment" name="modifierComment" class="btn btn-primary">modifier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!--------------- MODAL -------------->



<!-------------- MODAL MODIFIER REPONSE -------------->
<div class="modal fade" id="modifierReponseModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier Reponse</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulaire pour ajouter un Reponse -->
                    <form action="..\..\controllers\user\modifier_reponseAction.php" method="POST">
                    <div class="mb-3">
                        <input type="hidden" name="reponse_idd"  id="reponse_idd">
                    </div>
                        <div class="mb-3">
                            <label for="newComp" class="form-label">Contenue:</label>
                            <input type="text" name="newReponse" id="newReponse" class="form-control" >
                        </div>
                        <!-- Autres champs de formulaire ici -->
                        <button type="submit" id="modifier_reponse" name="modifierReponse" class="btn btn-primary">modifier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!---------------MODAL ---->



<main id="main" class="main">
    <div class="pagetitle">
     
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><?php echo  $questions["QUESTION_TITRE"];?></h1>
            <a href="ajouter_question.php" class="btn" style="background-color:#0048ae;color:white">Poser une Question</a>
        </div>
    </div><!-- End Page Title -->
    <hr style="color:black">

<div class="container">

<div class="row">
<div class="col-md-12">
<div id="content" class="content content-full-width">
<section style="padding:0px 30px 0px 30px;" class="section profile">
<div class="box box-widget">
<div class="box-header with-border">
<div class="user-block">
<img class="img-circle" src="..\..\storage\images\<?php echo $questions["IMAGE"]; ?>" alt="User Image">
<span class="username"><a href="details_profil.php?IDD=<?php echo $questions["UTILISATEUR_ID"]; ?>" ><?php echo $questions["NOM"]." ".$questions["PRENOM"]; ?></a></span>
<span class="description">Question partagé le - <?php echo $questions["DATE_CREATION"]; ?></span>
</div>

<div class="box-tools">
   
<?php
if($questions["ETAT_ID"]==1)//nouvelle
echo "<span class='labell nouvelle'><i class='fas fa-plus-circle'></i>Nouvelle</span>";
else if($questions["ETAT_ID"]==5)//annulee
echo "<span class='labell annulee'><i class='fas fa-times-circle'></i></i>Annulée</span>";
else if($questions["ETAT_ID"]==2)//en cours
echo "<span class='labell annulee'><i class='fas fa-times-circle'></i></i>En Cours</span>";
else if($questions["ETAT_ID"]==3)//Resolue
echo "<span class='labell resolue'><i class='fas fa-check-circle'></i></i>Résolue</span>";
else if($questions["ETAT_ID"] == 4)//Completé
echo "<span class='labell completee'><i class='fas fa-check-double'></i>Complétée</span>";
else
echo "<span class='labell relancee'><i class='fas fa-redo'></i>Relancée</span>";
?>

  <!-- partie options -->
  <?php if($questions['UTILISATEUR_ID'] == $_SESSION['user_id']):?>
                    <a class="nav-link" href="#" data-bs-toggle="dropdown">
                    <span>
                        &#x2022;&#x2022;&#x2022;
                    </span>
                    </a><!-- End Three points -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header">
                    <a href="modifier_question.php?id=<?php echo $id_question ?>">Modifier</a>
                    </li>
                   
                    <?php if($result_nbr_reponses['nombre_reponses']==0):?>

                        <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="dropdown-header">
                    <a  href="..\..\controllers\user\supprimer_questionAction.php?id=<?php echo $id_question ?>">Supprimer</a>
                    </li>
                    <?php  elseif ($questions['ETAT_ID'] == 2 ):?>
                        <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="dropdown-header">
                        <a  href="..\..\controllers\user\annuler_questionAction.php?id=<?php echo $id_question ?>">Annuler</a>
                        </li>
                        <?php endif;?>
                    
                    </ul>

                <?php endif;?>
               <!-- fin partie options -->

</div>
</div>
<div class="box-body">
<div class="pagetitle">
<h4><?php echo $questions["QUESTION_TITRE"]; ?></h4>
</div>
<p><?php echo $questions["QUESTION_DESCR"]; ?></p>
<?php if($questions['PROJET_ID'] != NULL):?>
            <?php
                       // Fetch user data
                        $projet_id = $questions["PROJET_ID"];
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

<!-- <div class="attachment-block clearfix">
<img class="attachment-img" src="https://www.bootdey.com/image/400x300/" alt="Attachment Image">
<div class="attachment-pushed">
<h4 class="attachment-heading"><a href="http://www.lipsum.com/">Lorem ipsum text generator</a></h4>
<div class="attachment-text">
Description about the attachment can be placed here.
Lorem Ipsum is simply dummy text of  the printing and typesetting industry... <a href="#">more</a>
</div>
</div>
</div> -->

<div style="height:20px;background-color:white;">
<span class="pull-right text-muted">
<?php echo $result_nbr_reponses['nombre_reponses'];  ?> Réponses
</span>
</div>
</div>
</div>
<div class="box-footer">
<form action="..\..\controllers\user\ajouter_reponseAction.php" method="POST" id="reponseForm">
        <img class="img-responsive img-circle img-sm" src="../../storage/images/<?php echo $result_curr_user["IMAGE"]; ?>" alt="Alt Text">
        <div class="img-push">
            <!-- Quill Editor Full -->
            <div>
                <input type="hidden" name="question_id" value=<?php echo $id_question?> >
            </div>
            <div>
            <textarea class="form-control" rows="5" name="reponsee" id="reponsee" placeholder="Ajouter une reponse ..."></textarea>
            </div>
            <button type="submit" id="btn-submit" name="ajouterReponse" class="share-button">
                <i class="fas fa-share"></i> Repondre
            </button>
    </form>

    </div>
</div>
</div>
</section>

<!------------------- La liste des reponses ---------------------->
<div class="profile-content">

<div class="tab-content p-0">

    <div class="tab-pane fade active show" id="profile-post">

        <ul class="timeline">
            <?php foreach($reponses as $reponse): ?>
            <li>
            <div style="display:none;" id="reponse_container">
                   <input type="hidden" name="reponse_contenuu" value="<?php echo htmlspecialchars($reponse["REPONSE_CONTENU"]); ?>">
                    <input type="hidden" name="reponse_idd" value="<?php echo $reponse["REPONSE_ID"]; ?>">
             </div>


                <div class="timeline-time">
                    <span class="date"><?php echo $reponse['REPONSE_DATE_CREATION']; ?></span>
                </div>

                <div class="timeline-icon">
                    <a href="javascript:;">&nbsp;</a>
                </div>
                <?php 
                  // Fetch user data
                    $utilisateur_id = $reponse["UTILISATEUR_ID"];
                    $req_utilisateur = "SELECT * FROM utilisateur WHERE UTILISATEUR_ID = :utilisateur_id";
                    $stmt_utilisateur = $bdd->prepare($req_utilisateur);
                    $stmt_utilisateur->bindParam(':utilisateur_id', $utilisateur_id, PDO::PARAM_INT);
                    $stmt_utilisateur->execute();
                    $utilisateur = $stmt_utilisateur->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="timeline-body"  style="padding-bottom:0">
                    <div class="timeline-header">
                        <span class="userimage"><img src="../../storage/images/<?php echo $utilisateur["IMAGE"]?>" alt></span>
                        <span class="username"> <a href="details_profil.php?IDD=<?php echo $utilisateur["UTILISATEUR_ID"]; ?>"  ><?php echo $utilisateur["NOM"] .' '.  $utilisateur["PRENOM"]?></a></span>                               
                        
                            <span style="float:right;">
                            <?php if($reponse["NOTE"]==0) echo "Note 0.0/5";
                             else echo "Note ".$reponse["NOTE"]."/5"; ?>
                             <?php if($_SESSION['user_id'] ==  $utilisateur["UTILISATEUR_ID"]):?>
                            <a href="..\..\controllers\user\supprimer_reponseAction.php?id=<?php echo $reponse['REPONSE_ID']; ?>"><i style="color:red;" class="bi bi-x"></i></a>
                            <a id="editBtn2" type="button" class="my-btn editBtn2" data-bs-toggle="modal">
                            <i style="color:blue" class="bi bi-pencil"></i>
                            </a>
                            
                            </span>
                        <?php endif;?>
                      
                    </div>
                    <div class="timeline-content">
                        <p>
                            <?php echo $reponse['REPONSE_CONTENU']; ?>
                        </p>
                    </div>
                    <div class="timeline-footer">
                        <?php 
                        $type_reaction = 0; // Stocker la valeur littérale dans une variable
                         $queryCheck = "SELECT * FROM ajouter_reaction WHERE REPONSE_ID = :reponseId AND UTILISATEUR_ID = :utilisateurId AND TYPE != :type_reaction";
                         $stmtCheck = $bdd->prepare($queryCheck);
                         $stmtCheck->bindParam(':reponseId', $reponse['REPONSE_ID'], PDO::PARAM_INT);
                         $stmtCheck->bindParam(':utilisateurId',$_SESSION['user_id'], PDO::PARAM_INT);
                         $stmtCheck->bindParam(':type_reaction',$type_reaction, PDO::PARAM_INT);
                         $stmtCheck->execute();
                         $reaction = $stmtCheck->fetch(PDO::FETCH_ASSOC);
                        
                        
                        ?>

                        <a href="javascript:;" class="m-r-15 text-inverse-lighter dislike-button" data-id="<?php echo $reponse['REPONSE_ID']; ?>">
                            <i id="dislike_icon<?php echo $reponse['REPONSE_ID']; ?>" class="fa fa-thumbs-down fa-fw fa-lg m-r-3 <?php echo $reaction['TYPE'] == 2 ? 'blue-icon' : ''; ?>"></i> 
                            <span id="dislikes-<?php echo $reponse['REPONSE_ID']; ?>"><?php echo $reponse['NB_DISLIKE']; ?></span>
                        </a>
                        <a href="javascript:;" class="m-r-15 text-inverse-lighter like-button" data-id="<?php echo $reponse['REPONSE_ID']; ?>">
                            <i id="like_icon<?php echo $reponse['REPONSE_ID']; ?>" class="fa fa-thumbs-up fa-fw fa-lg m-r-3 <?php echo $reaction['TYPE'] == 1 ? 'blue-icon' : ''; ?>"></i>
                            <span id="likes-<?php echo $reponse['REPONSE_ID']; ?>"><?php echo $reponse['NB_LIKE']; ?></span>
                        </a>

                        <a style="color:white;font-weight:bold;margin-left:65%;" type="button" class="btn btn-primary editBtn3" data-bs-toggle="modal" data-bs-target="#noter_reponse" data-id="<?php echo $reponse['REPONSE_ID']; ?>">
                            <i class="bi bi-star"> Noter</i>
                        </a>
                    </div>
                    <hr>
                    <!-- liste des commentaires -->
                   
                    <?php 
                     
                        // Fetch user data
                        $reponse_id = $reponse['REPONSE_ID'];
                        $req_commentaire = "SELECT * FROM commentaire WHERE REPONSE_ID = :reponse_id";
                        $stmt_commentaire = $bdd->prepare($req_commentaire);
                        $stmt_commentaire->bindParam(':reponse_id', $reponse_id, PDO::PARAM_INT);
                        $stmt_commentaire->execute();
                        $commentaires = $stmt_commentaire->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                     <?php if (!empty($commentaires)): ?>
                     <div style="margin:5px; padding:1px">
                     <?php foreach($commentaires as $commentaire): ?>
                        <?php
                            
                        $comment_auteur_id = $commentaire["UTILISATEUR_ID"];
                        $req_comment_auteur = "SELECT * FROM utilisateur WHERE UTILISATEUR_ID = :utilisateur_id";
                        $stmt_comment_auteur = $bdd->prepare($req_comment_auteur);
                        $stmt_comment_auteur->bindParam(':utilisateur_id', $comment_auteur_id, PDO::PARAM_INT);
                        $stmt_comment_auteur->execute();
                        $comment_auteur = $stmt_comment_auteur->fetch(PDO::FETCH_ASSOC);
                        ?>
                            
                    <div class="m-6" style="margin-left: 10px;background-color:lightgrey; padding:0.5px;max-width: 100%;"></div>
                    <div class="m-6" style="padding:2px;max-width: 100%;">
                        <div style="margin-left: 18px;" >
                            <small >
                                 <?php echo  $commentaire['COMMENT_CONTENU']?> – <a href="details_profil.php?IDD=<?php echo $comment_auteur["UTILISATEUR_ID"]; ?>"><?php echo htmlspecialchars($comment_auteur['NOM'].' '.$comment_auteur['PRENOM']); ?></a>
                                 <span style=" color: #999;"><?php echo htmlspecialchars($commentaire['COMMENT_DATE_CREATION']); ?></span>
                            </small>
                            <?php if($_SESSION['user_id'] == $comment_auteur['UTILISATEUR_ID']):?>
                            <a href="..\..\controllers\user\supprimer_commentaire.php?id=<?php echo $commentaire['COMMENT_ID']; ?>"><i  style="color:red" class="bi bi-x"></i></a>
                            </a>

                            <div style="display:none;" id="comment_container">
                                <input type="hidden" name="comment_contenuu" value="<?php echo htmlspecialchars($commentaire['COMMENT_CONTENU']); ?>">
                                <input type="hidden" name="comment_idd" value="<?php echo $commentaire['COMMENT_ID']; ?>">
                            </div>

                        

                            <a id="editBtn" type="button" class="my-btn editBtn" data-bs-toggle="modal">
                            <i style="color:blue" class="bi bi-pencil"></i>
                            </a>
                            <?php endif;?>

                           
                    </div>

                    </div>
                    <?php endforeach; ?>
                     </div>
                    <?php endif;?>
                    <!-- fin liste des commentaire -->



                    <div class="timeline-comment-box">
                        <div class="user"><img src="../../storage/images/<?php echo $_SESSION["image"]?>"></div>
                        <div class="input">
                            <form action="..\..\controllers\user\ajouter_commentaireAction.php" method="post">
                                <div>
                                    <input type="hidden" name="id_reponse" value="<?php echo $reponse['REPONSE_ID']; ?>">
                                </div>
                                <div class="input-group">
                                    <input name="comment" type="text" class="form-control rounded-corner" placeholder="Ecrivez un commentaire...">
                                    <span class="input-group-btn p-l-10">
                                        <button class="btn btn-primary f-s-12 rounded-corner"  type="submit">Commenter</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </li>
            <?php endforeach; ?>

           
        </ul>

    </div>

</div>

</div>

<!--------------------Fin Liste des Reponses --------------------------------------->

</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>


<script>
document.querySelectorAll('.editBtn3').forEach(button => {
    button.addEventListener('click', function() {
        const reponseId = this.getAttribute('data-id');
        document.getElementById('reponse_id').value = reponseId;
    });
});
</script>


<script>
$(document).ready(function () {
    $('.editBtn').on('click', function () {
        // Récupérer les données du commentaire depuis les champs cachés
        var commentId = $('#comment_container input[name="comment_idd"]').val();
        var commentContenu = $('#comment_container input[name="comment_contenuu"]').val();
        
        // Mettre à jour les champs du modal avec les données récupérées
        $('#comment_id').val(commentId);
        $('#newComment').val(commentContenu);
        
        // Afficher le modal
        $('#modifierCommentaireModal').modal('show');
    });
});
</script>
<script>
$(document).ready(function () {
    $('#editBtn2').on('click', function () {
        // Récupérer les données de la réponse depuis les champs cachés
        var reponseId = $('#reponse_container input[name="reponse_idd"]').val();
        var reponseContenu = $('#reponse_container input[name="reponse_contenuu"]').val();
        
        // Mettre à jour les champs du modal avec les données récupérées
        $('#reponse_idd').val(reponseId);
        $('#newReponse').val(reponseContenu);
        
        // Afficher le modal
        $('#modifierReponseModal').modal('show');
    });
});
</script>



<script>
        $(document).ready(function () {
            $('.editBtn3').on('click', function () {
                $('#noter_reponse').modal('show');
            });
        });
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.like-button, .dislike-button').click(function() {
            var reponseId = $(this).data('id');
            var action = $(this).hasClass('like-button') ? 'like' : 'dislike';

            $.post('update_reaction.php', {reponse_id: reponseId, action: action}, function(response) {
                var result = JSON.parse(response);
                if (result.status === 'success') {
                    $('#likes-' + reponseId).text(result.likes);
                    $('#dislikes-' + reponseId).text(result.dislikes);

                    // Change icon background color
                    if(result.type == 1) {
                        $('#like_icon' + reponseId).addClass('blue-icon');
                        $('#dislike_icon' + reponseId).removeClass('blue-icon');
                    } 
                    else if(result.type == 2) {
                        $('#like_icon' + reponseId).removeClass('blue-icon');
                        $('#dislike_icon' + reponseId).addClass('blue-icon');
                    }
                    else{
                        $('#like_icon' + reponseId).removeClass('blue-icon');
                        $('#dislike_icon' + reponseId).removeClass('blue-icon');
                    }
                    
                } 
                else {


                    // alert('Error: ' + (result.message || 'An unexpected error occurred.'));
                }
            }).fail(function() {
                alert('Failed to update reaction.');
            });
        });
    });
</script>




 <!-- ======= Fin de la page ======= -->
 <?php

include '..\headerX\footer.php';

?>


