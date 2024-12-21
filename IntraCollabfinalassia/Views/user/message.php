
<?php
//connexion à la base de donnees
include '..\..\controllers\db\connexion.php';
require_once '..\..\controllers\auth\auth_inc.php';


$visited_id=$_GET["IDD"];
$current_user=  $_SESSION['user_id'];
if($visited_id == $current_user) header("Location:profile.php");
else include '..\headerX\header_user.php'; //include ici pour ne pas avoir 2 header l'un ici et lautre si on visit 'mon profile'

//--------> recuperation des infos de profil
$req = "SELECT * FROM utilisateur WHERE UTILISATEUR_ID=?";
$stmt_utilisateur = $bdd->prepare($req);
$stmt_utilisateur->bindParam(1, $visited_id, PDO::PARAM_INT);
$stmt_utilisateur->execute();
$visited_user=$stmt_utilisateur->fetch(PDO::FETCH_ASSOC);
//----------->FIN PARTIE ASSIA

$_SESSION['messagerie'] = $_SERVER['PHP_SELF'] . "?IDD=" . $visited_id;

//recuperation des messages
$recupMessages = $bdd->prepare("SELECT * FROM message WHERE  AUTEUR_ID  = ?  AND DESTINATAIRE_ID = ? OR AUTEUR_ID  = ?  AND DESTINATAIRE_ID = ? ORDER BY DATE_ENVOI ASC;");
$recupMessages->bindValue(1, $current_user, PDO::PARAM_INT);
$recupMessages->bindValue(2, $visited_id, PDO::PARAM_INT);
$recupMessages->bindValue(3, $visited_id, PDO::PARAM_INT);
$recupMessages->bindValue(4, $current_user, PDO::PARAM_INT);
$recupMessages->execute();
$messages = $recupMessages->fetchAll(PDO::FETCH_ASSOC);      

?>

<main id="main" class="main">
<div class="pagetitle">
      <h1>Envoyer Message</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
          <li class="breadcrumb-item">Messagerie</li>
          <li class="breadcrumb-item active">Envoyer Message</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <?php if(!empty($messages)):?>
    <section class="section">
      <div class="row">
          <div class="card" >
            <div class="card-body" style="margin-top:20px">
                
           
            <?php foreach ($messages as  $message):  ?>
            
                <?php if($message["AUTEUR_ID"]== $current_user):?>
                  <div style="background-color:#DCDCDC;border-radius:10px;padding:3px;margin:2px;width:55%">
                    <p style="color:green"><?php echo $_SESSION['auth'] .' -'?><span class="text-muted" style="font-size:11px;margin-left:5px"><?php echo $message['DATE_ENVOI']?></span></p>
                    <p style="margin-left:10px"><?php echo $message['CONTENU']?></p>
                 </div>
                  <?php else:?>
                        <div style="margin-left:65%;background-color:#ADD8E6;border-radius:10px;padding:3px;">
                        <p style="color:blue"><?php echo $visited_user['NOM'].' '.$visited_user['PRENOM'] .' -'?><span class="text-muted" style="font-size:11px;margin-left:5px"><?php echo $message['DATE_ENVOI']?></span></p>
                        <p style="margin-left:10px"><?php echo $message['CONTENU']?></p>
                      </div><br>
                    <?php endif;?>
               
            <?php endforeach;?>
            </div>
          </div>
      </div>
    </section>
    <?php endif;?>
    <section class="section">
      <div class="row">
          <div class="card">
            <div class="card-body" style="margin-top:20px">
          
              <!-- Custom Styled Validation -->
              <form class="row g-3 needs-validation" action="..\..\controllers\user\envoyer_message.php" method="POST" novalidate>
                <input type="hidden" name="visited_id" value="<?php echo $visited_id?>">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <textarea class="form-control" name="contenu"></textarea>
                    <button class="btn btn-primary" type="submit" name="envoyer" style="margin-left:10px">Envoyer</button>
                </div>
                
         
              </form><!-- End Custom Styled Validation -->
            </div>
          </div>
      </div>
    </section>


   
  </main><!-- End #main -->


<!-- ======= Fin de la page ======= -->
<?php

 include '..\headerX\footer.php';

?>
