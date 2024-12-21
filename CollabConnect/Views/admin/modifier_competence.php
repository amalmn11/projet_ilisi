<?php

include '..\..\controllers\db\connexion.php';
if(isset($_GET['id'])) 
{
    $competence_id = $_GET['id'];
    $req = "SELECT * FROM competence WHERE COMPETENCE_ID = ?";
    $stmt = $bdd->prepare($req);
    $stmt->bindValue(1,$competence_id,PDO::PARAM_INT);
    $stmt->execute();
    $competence = $stmt->fetch();

}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Bootstrap</title>
    <!-- Dépendances Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <!-- Modal -->
    <div class="modal fade" id="formModifierCompetence" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier Competence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulaire pour ajouter une compétence -->
                    <form action="..\..\controllers\admin\editer_competence.php" method="POST">
                    <div class="mb-3">
                        <input type="hidden" name="competence_id"  value="<?php echo $competence["COMPETENCE_ID"]; ?>">
                    </div>
                        <div class="mb-3">
                            <label for="competence_nom" class="form-label">Nom de la Compétence:</label>
                            <input type="text" name="newCompetenceNom" id="competence_nom" class="form-control" value="<?php echo $competence["COMPETENCE_NOM"]; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="competence_descr" class="form-label">Description de la Compétence:</label>
                            <textarea name="newCompetenceDescr" id="competence_descr" class="form-control" rows="5">
                                    <?php echo $competence["COMPETENCE_DESCR"]; ?>
                            </textarea>
                        </div>
                        <!-- Autres champs de formulaire ici -->
                        <button type="submit" name="modifierComp" class="btn btn-primary">modifier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
