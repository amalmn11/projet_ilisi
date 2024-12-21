<?php

require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\header_user.php';
include '..\..\controllers\db\connexion.php';

// Récupération des titres des projets
$sql="SELECT * FROM categorie";
$stmt = $bdd->prepare($sql);
$stmt->execute();
$categorie = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .tag {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            margin: 5px;
            position: relative;
            cursor: pointer;
        }
        .tag .remove-tag {
            background: none;
            border: none;
            color: white;
            margin-left: 8px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Ajouter une base de connaissance</h1>
        <br>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
                <li class="breadcrumb-item active">Ajouter une base de connaissance</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ajouter une base de connaissance</h5>
                    <!---message de l'état de requête---->
                    <?php 
                    if(isset($_SESSION['erreur_form'])){
                        if (!empty($_SESSION['erreur_form'])) {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$_SESSION['erreur_form'].
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                        } else {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Enregistrement bien effectué.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                        }
                    }
                    unset($_SESSION['erreur_form']);
                    ?>
                    <!---fin message de l'état de requête---->

                    <!-- Custom Styled Validation -->
                    <form class="row g-3 needs-validation" action="..\..\controllers\user\ajouter_base_connaissanceAction.php" method="POST">
                        <div class="col-12">
                            <label for="validationCustom01" class="form-label">Titre</label>
                            <input type="text" class="form-control" id="validationCustom01" placeholder="Entrer le titre" name="titre_question" required>
                            
                        </div>
                        <div class="col-12">
                            <label for="validationCustom01" class="form-label">Description</label>
                            <input type="text" class="form-control" id="validationCustom01" placeholder="Entrer la description" name="descr" required>
                        </div>
                        
                        <div class="col-12">
                            <label for="validationCustom01" class="form-label">Categorie</label>
                            <select class="form-select" name="categorie" id="categorie">
                                <?php foreach ($categorie as $catg): ?>
                                    <option value="<?php echo htmlspecialchars($catg['CATEGORIE_ID']); ?>">
                                        <?php echo htmlspecialchars($catg['CATEGORIE_LIBELLE']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-4">
                        <label for="validationCustom01" class="form-label">Tag 1</label>
                            <input type="text" class="form-control" id="validationCustom01" placeholder="Entrer le tag1" name="tag1" required>
                                 
                        </div>
                        <div class="col-4">
                        <label for="validationCustom01" class="form-label">Tag 2</label>
                            <input type="text" class="form-control" id="validationCustom01" placeholder="Entrer le tag2" name="tag2" required>
                                
                        </div>
                        <div class="col-4">
                        <label for="validationCustom01" class="form-label">Tag 3</label>
                            <input type="text" class="form-control" id="validationCustom01" placeholder="Entrer le tag3" name="tag3" required>
                                 
                        </div>

                       
                        <div id="error-message" class="col-12 text-danger mb-3"></div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Ajouter</button>
                        </div>
                    </form><!-- End Custom Styled Validation -->
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

</body>
</html>
