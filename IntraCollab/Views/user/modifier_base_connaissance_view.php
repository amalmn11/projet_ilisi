<?php
require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\header_user.php';
include '..\..\controllers\db\connexion.php';

$id_bc = $_GET['id_bc'];

$req = "SELECT * from base_connaissance where BASE_CONNAISSANCE_ID=?";
$stmt_update = $bdd->prepare($req);
$stmt_update->bindParam(1, $id_bc, PDO::PARAM_INT);
$stmt_update->execute();
$base_connaissace = $stmt_update->fetch(PDO::FETCH_ASSOC);

$req = "SELECT * FROM categorie WHERE CATEGORIE_ID = ?";
$stmt = $bdd->prepare($req);
$stmt->bindParam(1, $base_connaissace['CATEGORIE_ID'], PDO::PARAM_INT);
$stmt->execute();
$categorie = $stmt->fetchAll(PDO::FETCH_ASSOC);

$req = "SELECT * FROM categorie";
$stmt = $bdd->prepare($req);
$stmt->execute();
$categorie = $stmt->fetchAll(PDO::FETCH_ASSOC);

$req2 = "SELECT t.TAG_LIBELLE, t.TAG_ID
        FROM se_compose s
        JOIN tag t ON s.TAG_ID = t.TAG_ID
        WHERE s.BASE_CONNAISSANCE_ID = :base_connaissance_id
        LIMIT 3";
$statement = $bdd->prepare($req2);
$statement->bindParam(':base_connaissance_id', $id_bc, PDO::PARAM_INT);
$statement->execute();
$tags = $statement->fetchAll(PDO::FETCH_ASSOC);

$req = "SELECT * FROM tag";
$stmt1 = $bdd->prepare($req);
$stmt1->execute();
$tag = $stmt1->fetchAll(PDO::FETCH_ASSOC);
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Modifier la base de connaissance</h1>
        <br>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
                <li class="breadcrumb-item active">Modifier une base de connaissance</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Modifier la base de connaissance</h5>
                    <!---message de l'état de requête---->
                    <?php 
                    if(isset($_SESSION['erreur_form'])) {
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
                    <form class="row g-3 needs-validation" action="..\..\controllers\user\modifier_base_connaissanceAction.php" method="POST" novalidate>
                        <div class="col-12">
                            <label for="validationCustom01" class="form-label">Titre</label>
                            <input type="text" class="form-control" id="validationCustom01" value="<?php echo $base_connaissace['BASE_CONNAISSANCE_TITRE']; ?>" name="base_titre" required>
                            <input type="hidden" class="form-control" id="validationCustom01" value="<?php echo $base_connaissace['BASE_CONNAISSANCE_ID']; ?>" name="base_id">
                            <div class="invalid-feedback">
                                Veuillez saisir le titre de la base.
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="validationCustom01" class="form-label">Description</label>
                            <input type="text" class="form-control" id="validationCustom01" value="<?php echo $base_connaissace['BASE_CONNAISSANCE_DESCR']; ?>" name="base_descr" required>
                            <div class="invalid-feedback">
                                Veuillez saisir la description de la base.
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <label for="validationCustom01" class="form-label">Categorie</label>
                            <select class="form-select" name="categorie" id="categorie">
                                <?php foreach ($categorie as $catg): ?>
                                    <option value="<?php echo htmlspecialchars($catg['CATEGORIE_ID']); ?>" <?php echo ($catg['CATEGORIE_ID'] == $base_connaissace['CATEGORIE_ID']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($catg['CATEGORIE_LIBELLE']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-4">
                            <label for="validationCustom01" class="form-label">Tag 1</label>
                            <input type="text" class="form-control" id="validationCustom01" value="<?php echo $base_connaissace['TAG1']; ?>" name="tag1" required>
                            <div class="invalid-feedback">
                                Veuillez saisir la description de la base.
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="validationCustom01" class="form-label">Tag 2</label>
                            <input type="text" class="form-control" id="validationCustom01" value="<?php echo $base_connaissace['TAG2']; ?>" name="tag2" required>
                            <div class="invalid-feedback">
                                Veuillez saisir la description de la base.
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="validationCustom01" class="form-label">Tag 3</label>
                            <input type="text" class="form-control" id="validationCustom01" value="<?php echo $base_connaissace['TAG3']; ?>" name="tag3" required>
                            <div class="invalid-feedback">
                                Veuillez saisir la description de la base.
                            </div>
                        </div>

                       
                        <div id="error-message" class="col-12 text-danger mb-3"></div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Modifier</button>
                        </div>
                    </form><!-- End Custom Styled Validation -->
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php
include '..\headerX\footer.php';
?>
