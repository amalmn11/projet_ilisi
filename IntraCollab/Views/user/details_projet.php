<?php

require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\header_user.php';
include '..\..\controllers\db\connexion.php';

//recuperee l id du projet concerne
if(isset($_SESSION["id_projet"]))
{
  $id= $_SESSION["id_projet"];
}
else 
{
  $id=$_GET["IDD"];
  $_SESSION["id_projet"] =  $_GET["IDD"];
}


//--------> recuperer l'id de la competence à modifier
/////////////////////////partie salma
$sql="select * from projet where PROJET_ID=$id";
//executer la requete
$stmt=$bdd->query($sql);
//parcourir le resultat
$projet=$stmt->fetchAll(PDO::FETCH_ASSOC);


///////////////////////Partie fatihaaaa 
//recuperer les participants dans les projets et leurs roles
//la requete
$requete_participants=
"SELECT IMAGE,NOM,PRENOM,r.ROLE_PROJET_TITRE,r.ROLE_PROJET_ID
FROM utilisateur u 
JOIN utilisateur_projet up ON u.UTILISATEUR_ID = up.UTILISATEUR_ID
JOIN role_projet r ON up.ROLE_PROJET_ID = r.ROLE_PROJET_ID
WHERE PROJET_ID=?;
";
//preparation de la requete
$stmt_participants=$bdd->prepare($requete_participants);
$stmt_participants->bindParam(1,$id, PDO::PARAM_INT);
// Exécution de la requête
$stmt_participants->execute();
//parcourir le resultat
$participants=$stmt_participants->fetchAll(PDO::FETCH_ASSOC);

//recuperer les roles qui existent
$req_roles="SELECT ROLE_PROJET_TITRE from role_projet";
$stmt_roles=$bdd->query($req_roles);
if ($stmt_roles) {
  $roles = $stmt_roles->fetchAll(PDO::FETCH_ASSOC);
} else {
  echo "Erreur lors de l'exécution de la requête SQL";
}
?>

<!-----------MODAL PARTICIPATION DALS LE PROJET------------------>
 <!-- Modal -->
 <div class="modal fade" id="participerProjet" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Indiquer Votre Role dans le Projet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulaire pour ajouter une compétence -->
                    <form action="..\..\controllers\user\participer_projet.php" method="post">
                        <div class="mb-3">
                        <input type="hidden" name="id_projet" value="<?php echo $id; ?>">
                           <label for="role_projet" class="form-label">Role Projet</label>
                           <select name="role_projet" id="role_projet" class="form-select">
                           <?php foreach($roles as $role): ?>
                               <option value="<?php echo $role["ROLE_PROJET_TITRE"]; ?>"><?php echo $role["ROLE_PROJET_TITRE"]; ?></option>
                            <?php endforeach; ?>
                           </select>
                           
                        </div>
                        <!-- Autres champs de formulaire ici -->
                        <button type="submit" name="participerProjet" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
</div>

<!----------- FIN MODAL PARTICIPATION DALS LE PROJET------------------>


<!-----------MODAL MODIFICATION ROLE DANS LE PROJET------------------>
 <!-- Modal -->
 <div class="modal fade" id="formModifierroleprojet" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Indiquer Votre Role dans le Projet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulaire pour ajouter une compétence -->
                    <form action="..\..\controllers\user\modifier_role_projet_liste.php" method="post">
                        <div  for="projet_id" class="mb-3">
                            <input type="hidden" name="projet_id"  id="projet_id">
                            <input type="hidden" name="role_projet_id"  id="role_projet_id">
                        </div>
                        <div class="mb-3">
                            <label for="role_projet_titre" class="form-label">Role Projet</label>
                            <input type="text" id="role_projet_titre" name="role_projet_titre" class="form-control" disabled>
                        </div>
                        <div class="mb-3">
                           
                           <label for="new_role_projet" class="form-label">Nouveau Role Projet</label>
                           <?php $req_roles="SELECT * from role_projet";
                                $stmt_roles=$bdd->query($req_roles);
                                $roles = $stmt_roles->fetchAll(PDO::FETCH_ASSOC);?>

                           <select name="new_role_projet" id="new_role_projet" class="form-select">
                           <?php foreach($roles as $role): ?>
                               <option value="<?php echo $role["ROLE_PROJET_ID"]; ?>"><?php echo $role["ROLE_PROJET_TITRE"]; ?></option>
                            <?php endforeach; ?>
                           </select>
                           
                        </div>
                        <!-- Autres champs de formulaire ici -->
                        <button type="submit" name="modifierRoleProjet" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
</div>

<!----------- FIN MODAL MODIFICATION ROLE DANS LE PROJET------------------>






<main id="main" class="main">
<div class="pagetitle">
      <h1>Projet</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
          <li class="breadcrumb-item active">Projet</li>
        </ol>
      </nav>
</div><!-- End Page Title -->
<section class="section profile">
    <div class="card section profile" style="border-radius: 24px">
    <div class="row">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="container bootstrap snippets bootdey">
    <div class="row">
        <div class="panel">
            <div class="cover-photo">
              <div class="fb-timeline-img">
                  <?php  foreach($projet as $ligne): ?><h3 style="margin-left: 27px;color: #000000;position: absolute;top: 10px;left: 10px;z-index: 1;margin-top: 130px;"><?php  echo $ligne['PROJET_TITRE']; ?></h3><?php endforeach; ?>
                  <img style="border-radius: 24PX 24px 0px 0px;" src="..\..\assets\img\back_prj.jpeg" alt="">
              </div>
              <div class="fb-name">
                  <h2><a href="#"></a></h2>
              </div>
            </div>
            <div class="panel-body">
              <!-- <div class="profile-thumb">
                  <img src="..\..\storage\images\default_pfp.jpg" alt="">
              </div> -->
              <a href="#" class="fb-user-mail"></a>
            </div>
        </div>
    </div>
    
    <!------- CARD 1---->
   
    <div class="card-body pt-3" style="margin-top: -35px;">
                  <div class="row">
                    <div class="col-lg-9 col-md-8">
                      <?php if (!empty($projet)): ?>
                      <!-- <div class="card"> -->
                          <div class="card-body pt-3"> 
                          <div class="row" style="margin-left: -21px; margin-top: -20px;">
                              <?php  foreach($projet as $ligne): ?>
                                <table style="margin:20px;" width="100%">
                                  <tr style="line-height: 40px;"> 
                                    <td colspan="2"> 
                                      <div id="info">
                                        <div class="date"><b>Date de Debut : </b><?php echo $ligne['PROJET_DATE_DEBUT']; ?></div>
                                        <div class="date"><b>Date du Fin : </b><?php echo $ligne['PROJET_DATE_FIN']; ?></div>
                                        <div class="descr"><b >Description du projet: </b><?php  echo $ligne['PROJET_DESCR']; ?></div>
                                        <div  class="formation"><b>Status: </b><?php echo $ligne['STATUT']; ?></div>
                                      </div>
                                    </td>
                                  </tr>
                                  </table>
                                  <!-- <hr style="height: 1.5px; background-color: rgba(0, 0, 0, 0.8);"> -->
                                  <?php endforeach; ?>
                          </div>
                        </div>
          </div>
          <?php endif; ?>
                    </div>
                  </div>
                
     </div>
  </div>
</div>
</section>

<!---------CARD FATIHA -------->
<div class="card">
                <div class="card-body pt-3">
                     <table width="100%">
                      <tr>
                        <td width="80%"> <h5 class="card-title">La Liste Des Participants</h5>  </td>
                        <td>
                          

                          <?php 
                              //tester si l'utilisateur connecté est deja inscrit dans une formation
                              $req_is_inscrit="SELECT * FROM utilisateur_projet where PROJET_ID=? and
                              UTILISATEUR_ID=?;";
                              // Préparation de la requête
                              $stmt_is_inscrit = $bdd->prepare($req_is_inscrit);
                              // Liaison des valeurs
                              $stmt_is_inscrit->bindParam(1, $id,PDO::PARAM_INT);
                              $stmt_is_inscrit->bindParam(2,$_SESSION['user_id'], PDO::PARAM_INT);
                              // Exécution de la requête
                              $stmt_is_inscrit->execute();
                              // Récupération du résultat
                              $result_is_inscrit = $stmt_is_inscrit->fetchAll(PDO::FETCH_ASSOC);
                           
                                ?>
                               
                               
                            <?php if (count($result_is_inscrit) > 0):?> 
                            
                              <a  type="button" href="..\..\controllers\user\retirer_participation_projet.php?IDD=<?php echo $id; ?>" class="btn btn-danger">
                                Retirer participartion
                              </a>
                            <?php else:?>
                              <a  type="button" data-bs-target="#participerProjet"   class="btn btn-warning" data-bs-toggle="modal">
                                participer
                              </a>
                            <?php endif;?>
                        </td>
                      </tr>
                     </table>
                    
                    <div class="row">
                     <!---------tableau -------->
                     <table class="table datatable">
                      <thead>
                       <tr>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Rôle</th>
                       </tr>
                      </thead>
                      <tbody>
                        <?php foreach($participants as $participant): ?>
                        <tr>
                          <td><img height="50px" width="50px" src="..\..\storage\images\<?php echo $participant["IMAGE"]; ?>"></td>
                          <td><?php echo $participant["NOM"]; ?>j</td>
                          <td><?php echo $participant["PRENOM"]; ?></td>
                          <td><?php echo $participant["ROLE_PROJET_TITRE"]; ?></td>
                          <td>
                          <input type="hidden" name="role_projet_id" value="<?php echo $participant["ROLE_PROJET_ID"]; ?>">
                          <input type="hidden" name="projet_id" value="<?php echo $id ?>">
                          <input type="hidden" name="role_projet_titre" value="<?php echo $participant["ROLE_PROJET_TITRE"]; ?>">
                       
                          <a  id="editBtn2" type="button" class="my-btn editBtn2" data-bs-toggle="modal">                         
                          <button type="button" class="btn btn-outline-primary"> <i class="bi bi-pen-fill"></i></button>
                          </a>
                          
                            
                        </td>
                          
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                     <!---------FIN tableau -------->
                     </div>
                </div>
          </div>
           <!---------END CARD FATIHA -------->
           

</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
            $('.editBtn2').on('click', function () {
                $('#formModifierroleprojet').modal('show');
                 var projetId = $(this).closest('tr').find('input[name="projet_id"]').val();
                 var roleprojetId = $(this).closest('tr').find('input[name="role_projet_id"]').val();
                 var roleprojetTitre = $(this).closest('tr').find('input[name="role_projet_titre"]').val();
                
                $('#projet_id').val(projetId);
                $('#role_projet_id').val(roleprojetId);
                $('#role_projet_titre').val(roleprojetTitre);
                
            });
        });
</script>

<?php
// require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\footer.php';

?>
