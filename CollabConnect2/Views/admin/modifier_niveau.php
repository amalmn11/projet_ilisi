<?php

include '..\..\controllers\db\connexion.php';
if(isset($_GET['id'])) 
{
    $niv_id = $_GET['id'];
    $req = "SELECT * FROM niveau WHERE NIVEAU_ID = ?";
    $stmt = $bdd->prepare($req);
    $stmt->bindValue(1,$niv_id,PDO::PARAM_INT);
    $stmt->execute();
    $niveau = $stmt->fetch();

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
    <div class="modal fade" id="formModifierNiveau" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier Niveau</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulaire pour ajouter une compétence -->
                    <form action="..\..\controllers\admin\editer_niveau.php" method="post">
                    <div class="mb-3">
                        <input type="hidden" name="niv_id"  value="<?php echo $niveau["NIVEAU_ID"]; ?>">
                    </div>
                        <div class="mb-3">
                            <label for="niv_titre" class="form-label">Titre de niveau:</label>
                            <input type="text" name="newNiveauTitre" id="niv_titre" class="form-control" value="<?php echo $niveau["NIVEAU_TITRE"]; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="niv_descr" class="form-label">Description de Niveau:</label>
                            <textarea name="newNivDescr" id="niv_descr" class="form-control" rows="5">
                                    <?php echo $niveau["NIVEAU_DESCR"]; ?>
                            </textarea>
                        </div>
                        <!-- Autres champs de formulaire ici -->
                        <button type="submit" name="modifierNiveau" class="btn btn-primary">modifier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
