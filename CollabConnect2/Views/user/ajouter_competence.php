
<?php
//connexion à la base de donnees
include '..\..\controllers\db\connexion.php';
//-----> requete pour recuperer les noms des competences de la base de donnees
$req_competence="SELECT COMPETENCE_NOM from competence";
//executer la requete
$stmt_competence=$bdd->query($req_competence);
//parcourir le resultat
$competences_modal=$stmt_competence->fetchAll(PDO::FETCH_ASSOC);
//--------> recuperation les titres des  niveaux
$req_niveau="SELECT NIVEAU_TITRE from niveau";
//executer la requete
$stmt_niveau=$bdd->query($req_niveau);
//parcourir le resultat
$niveaux=$stmt_niveau->fetchAll(PDO::FETCH_ASSOC);



?>
<body>
    <!-- Modal -->
    <div class="modal fade" id="ajouterCompetence" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter Compétence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulaire pour ajouter une compétence -->
                    <form action="..\..\controllers\user\ajouter_competenceAction.php" method="post">
                        <div class="mb-3">
                           <label for="competence_nom" class="form-label">Nom de la Compétence:</label>
                           <select name="competence_nom" id="competence_nom" class="form-select">
                           <?php foreach($competences_modal as $competence_modal): ?>
                               <option value="<?php echo  $competence_modal["COMPETENCE_NOM"];  ?>"><?php echo  $competence_modal["COMPETENCE_NOM"];  ?></option>
                            <?php endforeach; ?>
                           </select>
                           
                        </div>
                        <div class="mb-3">
                           <label for="niveau" class="form-label">Niveau de la Compétence:</label>
                           <select name="niveau" id="competence_niveau" class="form-select">
                           <?php foreach($niveaux as $niveau): ?>
                               <option value="<?php echo $niveau["NIVEAU_TITRE"];  ?>"><?php echo $niveau["NIVEAU_TITRE"];  ?></option>
                            <?php endforeach; ?>
                           </select>
                           
                        </div>
                        <!-- Autres champs de formulaire ici -->
                        <button type="submit" name="ajouterCompetence" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

