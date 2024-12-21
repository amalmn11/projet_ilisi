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
<div class="image-container set-full-height" style="background-image: url('../../assets/img/wizard-city.jpg')">
    <div class="back">
    <!--   Big container   -->
    <div class="container">
        <div class="row">
        <div class="col-sm-8 col-sm-offset-2">

            <!--      Wizard container        -->
            <div class="wizard-container">

                <div class="card wizard-card" data-color="orange" id="wizardProfile">
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
                                <li><a href="#address" data-toggle="tab">Adresse</a></li>
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
                                        <label>Date de naissance <small>(required)</small></label>
                                        <input required name="datenaissance" type="date" class="form-control">
                                      </div>
                                      
                                  </div>
                              </div>
                            </div>
                            <div class="tab-pane" id="account">
                                <h4 class="info-text"> Veuillez changer votre mot de passe.</h4>
                                    <div class="col-sm-6" style="width: 77%;  margin-left: 215px;">
                                        <div class="form-group">
                                            <label>Mot de passe <small>(required)</small></label>
                                            <input required name="password" type="password" class="form-control" placeholder="Entrer le nouveau mot de passe">
                                        </div>
                                        <div class="form-group">
                                            <label>Confirmer Mot de passe <small>(required)</small></label>
                                            <input required name="password_c" type="password" class="form-control" placeholder="Confirmer le mot de passe">
                                        </div>
                                    </div>
                                <!-- <div class="row">

                                    <div class="col-sm-10 col-sm-offset-1">
                                        <div class="col-sm-4">
                                            <div class="choice" data-toggle="wizard-checkbox">
                                                <input required type="checkbox" name="jobb" value="Design">
                                                <div class="icon">
                                                    <i class="fa fa-pencil"></i>
                                                </div>
                                                <h6>Design</h6>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="choice" data-toggle="wizard-checkbox">
                                                <input required type="checkbox" name="jobb" value="Code">
                                                <div class="icon">
                                                    <i class="fa fa-terminal"></i>
                                                </div>
                                                <h6>Code</h6>
                                            </div>

                                        </div>
                                        <div class="col-sm-4">
                                            <div class="choice" data-toggle="wizard-checkbox">
                                                <input required type="checkbox" name="jobb" value="Develop">
                                                <div class="icon">
                                                    <i class="fa fa-laptop"></i>
                                                </div>
                                                <h6>Develop</h6>
                                            </div>

                                        </div>
                                    </div>

                                </div> -->
                            </div>
                            <div class="tab-pane" id="address">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 class="info-text"> Vivez-vous dans un quartier agréable? </h4>
                                    </div>
                                    <div class="col-sm-7 col-sm-offset-1">
                                         <div class="form-group">
                                            <label>Adresse</label>
                                            <input required type="text" name="adresse" class="form-control" placeholder="Avenue">
                                          </div>
                                    </div>
                                    <div class="col-sm-3">
                                         <div class="form-group">
                                            <label>Code Postale</label>
                                            <input required type="text" name="codepostal" class="form-control" placeholder="50000">
                                          </div>
                                    </div>
                                    <div class="col-sm-5 col-sm-offset-1">
                                         <div class="form-group">
                                            <label>Ville</label>
                                            <input required type="text" name="ville" class="form-control" placeholder="Meknes...">
                                          </div>
                                    </div>
                                    <div class="col-sm-5">
                                         <div class="form-group">
                                            <label>Pays</label><br>
                                            <select name="pays" class="form-control">
                                                <option value="">-----Choisir un pays-----</option>
                                                <option value="Afghanistan"> Afghanistan </option>
                                                <option value="Albania"> Albania </option>
                                                <option value="Algeria"> Algeria </option>
                                                <option value="American Samoa"> American Samoa </option>
                                                <option value="Andorra"> Andorra </option>
                                                <option value="Angola"> Angola </option>
                                                <option value="Anguilla"> Anguilla </option>
                                                <option value="Antarctica"> Antarctica </option>
                                                <option value="Antigua and Barbuda"> Antigua and Barbuda </option>
                                                <option value="Argentina"> Argentina </option>
                                                <option value="Armenia"> Armenia </option>
                                                <option value="Aruba"> Aruba </option>
                                                <option value="Australia"> Australia </option>
                                                <option value="Austria"> Austria </option>
                                                <option value="Azerbaijan"> Azerbaijan </option>
                                                <option value="Bahamas"> Bahamas </option>
                                                <option value="Bahrain"> Bahrain </option>
                                                <option value="Bangladesh"> Bangladesh </option>
                                                <option value="Barbados"> Barbados </option>
                                                <option value="Belarus"> Belarus </option>
                                                <option value="Belgium"> Belgium </option>
                                                <option value="Belize"> Belize </option>
                                                <option value="Benin"> Benin </option>
                                                <option value="Bermuda"> Bermuda </option>
                                                <option value="Bhutan"> Bhutan </option>
                                                <option value="Bolivia"> Bolivia </option>
                                                <option value="Bosnia and Herzegovina"> Bosnia and Herzegovina </option>
                                                <option value="Botswana"> Botswana </option>
                                                <option value="Bouvet Island"> Bouvet Island </option>
                                                <option value="Brazil"> Brazil </option>
                                                <option value="British Indian Ocean Territory"> British Indian Ocean Territory </option>
                                                <option value="Brunei Darussalam"> Brunei Darussalam </option>
                                                <option value="Bulgaria"> Bulgaria </option>
                                                <option value="Burkina Faso"> Burkina Faso </option>
                                                <option value="Burundi"> Burundi </option>
                                                <option value="Cambodia"> Cambodia </option>
                                                <option value="Cameroon"> Cameroon </option>
                                                <option value="Canada"> Canada </option>
                                                <option value="Cape Verde"> Cape Verde </option>
                                                <option value="Cayman Islands"> Cayman Islands </option>
                                                <option value="Central African Republic"> Central African Republic </option>
                                                <option value="Chad"> Chad </option>
                                                <option value="Chile"> Chile </option>
                                                <option value="China"> China </option>
                                                <option value="Christmas Island"> Christmas Island </option>
                                                <option value="Cocos (Keeling) Islands"> Cocos (Keeling) Islands </option>
                                                <option value="Colombia"> Colombia </option>
                                                <option value="Comoros"> Comoros </option>
                                                <option value="Congo"> Congo </option>
                                                <option value="Congo, The Democratic Republic of The"> Congo, The Democratic Republic of The </option>
                                                <option value="Cook Islands"> Cook Islands </option>
                                                <option value="Costa Rica"> Costa Rica </option>
                                                <option value="Cote D'ivoire"> Cote D'ivoire </option>
                                                <option value="Croatia"> Croatia </option>
                                                <option value="Cuba"> Cuba </option>
                                                <option value="Cyprus"> Cyprus </option>
                                                <option value="Czech Republic"> Czech Republic </option>
                                                <option value="Denmark"> Denmark </option>
                                                <option value="Djibouti"> Djibouti </option>
                                                <option value="Dominica"> Dominica </option>
                                                <option value="Dominican Republic"> Dominican Republic </option>
                                                <option value="Ecuador"> Ecuador </option>
                                                <option value="Egypt"> Egypt </option>
                                                <option value="El Salvador"> El Salvador </option>
                                                <option value="Equatorial Guinea"> Equatorial Guinea </option>
                                                <option value="Eritrea"> Eritrea </option>
                                                <option value="Estonia"> Estonia </option>
                                                <option value="Ethiopia"> Ethiopia </option>
                                                <option value="Falkland Islands (Malvinas)"> Falkland Islands (Malvinas) </option>
                                                <option value="Faroe Islands"> Faroe Islands </option>
                                                <option value="Fiji"> Fiji </option>
                                                <option value="Finland"> Finland </option>
                                                <option value="France"> France </option>
                                                <option value="French Guiana"> French Guiana </option>
                                                <option value="French Polynesia"> French Polynesia </option>
                                                <option value="French Southern Territories"> French Southern Territories </option>
                                                <option value="Gabon"> Gabon </option>
                                                <option value="Gambia"> Gambia </option>
                                                <option value="Georgia"> Georgia </option>
                                                <option value="Germany"> Germany </option>
                                                <option value="Ghana"> Ghana </option>
                                                <option value="Gibraltar"> Gibraltar </option>
                                                <option value="Greece"> Greece </option>
                                                <option value="Greenland"> Greenland </option>
                                                <option value="Grenada"> Grenada </option>
                                                <option value="Guadeloupe"> Guadeloupe </option>
                                                <option value="Guam"> Guam </option>
                                                <option value="Guatemala"> Guatemala </option>
                                                <option value="Guernsey"> Guernsey </option>
                                                <option value="Guinea"> Guinea </option>
                                                <option value="Guinea-bissau"> Guinea-bissau </option>
                                                <option value="Guyana"> Guyana </option>
                                                <option value="Haiti"> Haiti </option>
                                                <option value="Heard Island and Mcdonald Islands"> Heard Island and Mcdonald Islands </option>
                                                <option value="Holy See (Vatican City State)"> Holy See (Vatican City State) </option>
                                                <option value="Honduras"> Honduras </option>
                                                <option value="Hong Kong"> Hong Kong </option>
                                                <option value="Hungary"> Hungary </option>
                                                <option value="Iceland"> Iceland </option>
                                                <option value="India"> India </option>
                                                <option value="Indonesia"> Indonesia </option>
                                                <option value="Iran, Islamic Republic of"> Iran, Islamic Republic of </option>
                                                <option value="Iraq"> Iraq </option>
                                                <option value="Ireland"> Ireland </option>
                                                <option value="Isle of Man"> Isle of Man </option>
                                                <option value="Israel"> Israel </option>
                                                <option value="Italy"> Italy </option>
                                                <option value="Jamaica"> Jamaica </option>
                                                <option value="Japan"> Japan </option>
                                                <option value="Jersey"> Jersey </option>
                                                <option value="Jordan"> Jordan </option>
                                                <option value="Kazakhstan"> Kazakhstan </option>
                                                <option value="Kenya"> Kenya </option>
                                                <option value="Kiribati"> Kiribati </option>
                                                <option value="Korea, Democratic People's Republic of"> Korea, Democratic People's Republic of </option>
                                                <option value="Korea, Republic of"> Korea, Republic of </option>
                                                <option value="Kuwait"> Kuwait </option>
                                                <option value="Kyrgyzstan"> Kyrgyzstan </option>
                                                <option value="Lao People's Democratic Republic"> Lao People's Democratic Republic </option>
                                                <option value="Latvia"> Latvia </option>
                                                <option value="Lebanon"> Lebanon </option>
                                                <option value="Lesotho"> Lesotho </option>
                                                <option value="Liberia"> Liberia </option>
                                                <option value="Libyan Arab Jamahiriya"> Libyan Arab Jamahiriya </option>
                                                <option value="Liechtenstein"> Liechtenstein </option>
                                                <option value="Lithuania"> Lithuania </option>
                                                <option value="Luxembourg"> Luxembourg </option>
                                                <option value="Macao"> Macao </option>
                                                <option value="Macedonia, The Former Yugoslav Republic of"> Macedonia, The Former Yugoslav Republic of </option>
                                                <option value="Madagascar"> Madagascar </option>
                                                <option value="Malawi"> Malawi </option>
                                                <option value="Malaysia"> Malaysia </option>
                                                <option value="Maldives"> Maldives </option>
                                                <option value="Mali"> Mali </option>
                                                <option value="Malta"> Malta </option>
                                                <option value="Marshall Islands"> Marshall Islands </option>
                                                <option value="Martinique"> Martinique </option>
                                                <option value="Mauritania"> Mauritania </option>
                                                <option value="Mauritius"> Mauritius </option>
                                                <option value="Mayotte"> Mayotte </option>
                                                <option value="Mexico"> Mexico </option>
                                                <option value="Micronesia, Federated States of"> Micronesia, Federated States of </option>
                                                <option value="Moldova, Republic of"> Moldova, Republic of </option>
                                                <option value="Monaco"> Monaco </option>
                                                <option value="Mongolia"> Mongolia </option>
                                                <option value="Montenegro"> Montenegro </option>
                                                <option value="Montserrat"> Montserrat </option>
                                                <option value="Morocco"> Morocco </option>
                                                <option value="Mozambique"> Mozambique </option>
                                                <option value="Myanmar"> Myanmar </option>
                                                <option value="Namibia"> Namibia </option>
                                                <option value="Nauru"> Nauru </option>
                                                <option value="Nepal"> Nepal </option>
                                                <option value="Netherlands"> Netherlands </option>
                                                <option value="Netherlands Antilles"> Netherlands Antilles </option>
                                                <option value="New Caledonia"> New Caledonia </option>
                                                <option value="New Zealand"> New Zealand </option>
                                                <option value="Nicaragua"> Nicaragua </option>
                                                <option value="Niger"> Niger </option>
                                                <option value="Nigeria"> Nigeria </option>
                                                <option value="Niue"> Niue </option>
                                                <option value="Norfolk Island"> Norfolk Island </option>
                                                <option value="Northern Mariana Islands"> Northern Mariana Islands </option>
                                                <option value="Norway"> Norway </option>
                                                <option value="Oman"> Oman </option>
                                                <option value="Pakistan"> Pakistan </option>
                                                <option value="Palau"> Palau </option>
                                                <option value="Palestinian Territory, Occupied"> Palestinian Territory, Occupied </option>
                                                <option value="Panama"> Panama </option>
                                                <option value="Papua New Guinea"> Papua New Guinea </option>
                                                <option value="Paraguay"> Paraguay </option>
                                                <option value="Peru"> Peru </option>
                                                <option value="Philippines"> Philippines </option>
                                                <option value="Pitcairn"> Pitcairn </option>
                                                <option value="Poland"> Poland </option>
                                                <option value="Portugal"> Portugal </option>
                                                <option value="Puerto Rico"> Puerto Rico </option>
                                                <option value="Qatar"> Qatar </option>
                                                <option value="Reunion"> Reunion </option>
                                                <option value="Romania"> Romania </option>
                                                <option value="Russian Federation"> Russian Federation </option>
                                                <option value="Rwanda"> Rwanda </option>
                                                <option value="Saint Helena"> Saint Helena </option>
                                                <option value="Saint Kitts and Nevis"> Saint Kitts and Nevis </option>
                                                <option value="Saint Lucia"> Saint Lucia </option>
                                                <option value="Saint Pierre and Miquelon"> Saint Pierre and Miquelon </option>
                                                <option value="Saint Vincent and The Grenadines"> Saint Vincent and The Grenadines </option>
                                                <option value="Samoa"> Samoa </option>
                                                <option value="San Marino"> San Marino </option>
                                                <option value="Sao Tome and Principe"> Sao Tome and Principe </option>
                                                <option value="Saudi Arabia"> Saudi Arabia </option>
                                                <option value="Senegal"> Senegal </option>
                                                <option value="Serbia"> Serbia </option>
                                                <option value="Seychelles"> Seychelles </option>
                                                <option value="Sierra Leone"> Sierra Leone </option>
                                                <option value="Singapore"> Singapore </option>
                                                <option value="Slovakia"> Slovakia </option>
                                                <option value="Slovenia"> Slovenia </option>
                                                <option value="Solomon Islands"> Solomon Islands </option>
                                                <option value="Somalia"> Somalia </option>
                                                <option value="South Africa"> South Africa </option>
                                                <option value="South Georgia and The South Sandwich Islands"> South Georgia and The South Sandwich Islands </option>
                                                <option value="Spain"> Spain </option>
                                                <option value="Sri Lanka"> Sri Lanka </option>
                                                <option value="Sudan"> Sudan </option>
                                                <option value="Suriname"> Suriname </option>
                                                <option value="Svalbard and Jan Mayen"> Svalbard and Jan Mayen </option>
                                                <option value="Swaziland"> Swaziland </option>
                                                <option value="Sweden"> Sweden </option>
                                                <option value="Switzerland"> Switzerland </option>
                                                <option value="Syrian Arab Republic"> Syrian Arab Republic </option>
                                                <option value="Taiwan, Province of China"> Taiwan, Province of China </option>
                                                <option value="Tajikistan"> Tajikistan </option>
                                                <option value="Tanzania, United Republic of"> Tanzania, United Republic of </option>
                                                <option value="Thailand"> Thailand </option>
                                                <option value="Timor-leste"> Timor-leste </option>
                                                <option value="Togo"> Togo </option>
                                                <option value="Tokelau"> Tokelau </option>
                                                <option value="Tonga"> Tonga </option>
                                                <option value="Trinidad and Tobago"> Trinidad and Tobago </option>
                                                <option value="Tunisia"> Tunisia </option>
                                                <option value="Turkey"> Turkey </option>
                                                <option value="Turkmenistan"> Turkmenistan </option>
                                                <option value="Turks and Caicos Islands"> Turks and Caicos Islands </option>
                                                <option value="Tuvalu"> Tuvalu </option>
                                                <option value="Uganda"> Uganda </option>
                                                <option value="Ukraine"> Ukraine </option>
                                                <option value="United Arab Emirates"> United Arab Emirates </option>
                                                <option value="United Kingdom"> United Kingdom </option>
                                                <option value="United States"> United States </option>
                                                <option value="United States Minor Outlying Islands"> United States Minor Outlying Islands </option>
                                                <option value="Uruguay"> Uruguay </option>
                                                <option value="Uzbekistan"> Uzbekistan </option>
                                                <option value="Vanuatu"> Vanuatu </option>
                                                <option value="Venezuela"> Venezuela </option>
                                                <option value="Viet Nam"> Viet Nam </option>
                                                <option value="Virgin Islands, British"> Virgin Islands, British </option>
                                                <option value="Virgin Islands, U.S."> Virgin Islands, U.S. </option>
                                                <option value="Wallis and Futuna"> Wallis and Futuna </option>
                                                <option value="Western Sahara"> Western Sahara </option>
                                                <option value="Yemen"> Yemen </option>
                                                <option value="Zambia"> Zambia </option>
                                                <option value="Zimbabwe"> Zimbabwe </option>
                                            </select>
                                            
                                          </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-footer height-wizard">
                            <div class="pull-right">
                                <input required type='button' class='btn btn-next btn-fill btn-warning btn-wd btn-sm' name='next' value='Suivant' />
                                <input required type='submit' class='btn btn-finish btn-fill btn-warning btn-wd btn-sm' name='finish' value='Finir' />

                            </div>

                            <div class="pull-left">
                                <input required type='button' class='btn btn-previous btn-fill btn-default btn-wd btn-sm' name='previous' value='Précédent' />
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

</html>
