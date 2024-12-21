<?php
require_once '..\..\controllers\auth\auth_inc.php';
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>IntraLink</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

	<!--     Fonts and icons     -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.css" rel="stylesheet">

	<!-- CSS Files -->
    <link href="..\..\assets\css\bootstrap.min.css" rel="stylesheet" />
	<link href="..\..\assets\css\gsdk-bootstrap-wizard.css" rel="stylesheet" />

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link href="..\..\assets\css\demo.css" rel="stylesheet" />
</head>

<body>
<?php
    if(isset($error))
    {
        echo "<script>alert('$error');</script>"; // Notez les guillemets simples autour de $error
    }
?>
<div class="image-container" style="background-image: url('../../assets/img/wizard-city.jpg');  height: 100%;">
    <div class="back">
    <!--   Big container   -->
    <div class="container">
        <div class="row">
        <div class="col-sm-8 col-sm-offset-2">

            <!--      Wizard container        -->
            <div class="wizard-container">

                <div class="card wizard-card" style="height: 80%; margin-top:auto" data-color="orange" id="wizardProfile">
                    <form action="..\..\controllers\user\traiter_profile.php" method="Post">
                <!--        You can switch ' data-color="orange" '  with one of the next bright colors: "blue", "green", "orange", "red"          -->

                    	<div class="wizard-header">
                        	<h3>
                        	   <b>Completez</b>  Votre Profil <br>
                        	   <small>Ces informations nous permettront d'en apprendre davantage sur vous.</small>
                        	</h3>
                    	</div>

						<div class="wizard-navigation">
							<ul>
                                <li><a href="#about" data-toggle="tab">À propos de vous</a></li>
                                <li><a href="#account" data-toggle="tab">Compte</a></li>
	                        </ul>

						</div>

                        <div class="tab-content">
                            <div class="tab-pane" id="about">
                              <div class="row">
                                  <h4 class="info-text"> Commençons par les informations de base (avec validation) </h4>
                                  <!-- <div class="col-sm-4 col-sm-offset-1">
                                     <div class="picture-container">
                                          <div class="picture">
                                              <img src="assets_salma/img/default-avatar.png" class="picture-src" id="wizardPicturePreview" title=""/>
                                              <input required requiredtype="file" id="wizard-picture">
                                          </div>
                                          <h6>Choose Picture</h6>
                                      </div>
                                  </div> -->
                                  <div class="col-sm-6">
                                      <div class="form-group">
                                        <label>Nom <small>(required)</small></label>
                                        <input required name="nom" type="text" class="form-control" placeholder="Entrer votre nom">
                                      </div>
                                      <div class="form-group">
                                        <label>Prenom <small>(required)</small></label>
                                        <input required name="prenom" type="text" class="form-control" placeholder="Entrer votre prenom">
                                      </div>
                                    </div>
                                   <div class="col-sm-6" style=" width: 50%;
                                    margin-left: -9%;">
                                    <div class="form-group">
                                        <label>Telephone <small>(required)</small></label>
                                        <input required name="telephone" type="text" class="form-control" placeholder="Entrer votre numéro de telephone">
                                      </div>
                                      <div class="form-group">
                                        <label>Poste <small>(required)</small></label>
                                        <input required name="poste" type="text" class="form-control" placeholder="Entrer votre poste">
                                      </div>
                                      
                                  </div>
                              </div>
                            </div>
                            
                            <!---message de l'etat de requete---->
                            <?php 
                            if(isset($_SESSION['error_pass'])){
                                if (!empty($_SESSION['error_pass'])) {
                                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$_SESSION['error_pass'].
                                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>';
                                } else {
                                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'
                                    .$_SESSION['success'].'
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>';
                                }
                                unset($_SESSION['error_pass']);
                                unset($_SESSION['success']);
                            }
                            ?>
                            <!---fin message de l'etat de requete---->

                            
                            <div class="tab-pane" id="account">
                                <!-- Ajouter un div pour afficher le message d'erreur -->
                                <div id="error-message" class="alert alert-danger" style="display: none;"></div>

                                <h4 class="info-text"> Veuillez changer votre mot de passe.</h4>
                                <div class="col-sm-6" style="width: 77%; margin-left: 215px;">
                                    <div class="form-group">
                                        <label>Mot de passe <small>(required)</small></label>
                                        <input required name="password" id="password" type="password" class="form-control" placeholder="Entrer le nouveau mot de passe">
                                    </div>
                                    <div class="form-group">
                                        <label>Confirmer Mot de passe <small>(required)</small></label>
                                        <input required name="password_c" id="password_c" type="password" class="form-control" placeholder="Confirmer le mot de passe">
                                    </div>
                                </div>
                            </div>

                            <div class="wizard-footer height-wizard">
                                <div class="pull-right">
                                    <input required type='button' style="MARGIN-TOP: 56%;" class='btn btn-next btn-fill btn-warning btn-wd btn-sm' name='next' value='Suivant' />
                                    <input required type='button' style="MARGIN-TOP: 16%;" class='btn btn-finish btn-fill btn-warning btn-wd btn-sm' name='finish' value='Finir' id="finish-btn"/>
                                </div>
                                <div class="pull-left">
                                    <input required type='button' style="MARGIN-TOP: 16%;" class='btn btn-previous btn-fill btn-default btn-wd btn-sm' name='previous' value='Précédent' />
                                </div>
                                <div class="clearfix"></div>
                            </div>


                    </form>
                </div>
            </div> <!-- wizard container -->
        </div>
        </div><!-- end row -->
    </div> <!--  big container -->
    <div class="footer">
        <!-- <div class="container">
             Made with <i class="fa fa-heart heart"></i> by <a href="http://www.creative-tim.com">Creative Tim</a>. Free download <a href="http://www.creative-tim.com/product/bootstrap-wizard">here.</a>
        </div> -->
    </div>

</div>
</div>
</body>

	<!--   Core JS Files   -->
	<script src="..\..\assets\js\jquery-2.2.4.min.js" type="text/javascript"></script>
	<script src="..\..\assets\js\bootstrap.min.js" type="text/javascript"></script>
	<script src="..\..\assets\js\jquery.bootstrap.wizard.js" type="text/javascript"></script>

	<!--  Plugin for the Wizard -->
	<script src="..\..\assets\js\gsdk-bootstrap-wizard.js"></script>

	<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
	<script src="..\..\assets\js\jquery.validate.min.js"></script>
    <script>
        document.getElementById('finish-btn').addEventListener('click', function(e) 
        {
            var password = document.getElementById('password').value;
            var password_c = document.getElementById('password_c').value;
            var errorMessageDiv = document.getElementById('error-message');

            if (password !== password_c) {
                errorMessageDiv.textContent = 'Mot de passe de confirmation est incorrect.';
                errorMessageDiv.style.display = 'block';
            } else {
                // Soumettre le formulaire si les mots de passe correspondent
                errorMessageDiv.style.display = 'none';
                // Changer le type du bouton en submit et déclencher la soumission du formulaire
                this.type = 'submit';
                this.click(); // Assurez-vous que votre formulaire est le premier dans le document
            }
        });
    </script>




</html>
