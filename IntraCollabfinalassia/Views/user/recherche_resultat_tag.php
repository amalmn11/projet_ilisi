<?php
require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\header_user.php';
include '..\..\controllers\db\connexion.php';

// Récupérer les termes de recherche
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Séparer les mots-clés par espace
$keywords = explode(' ', $query);

// Construire la requête SQL dynamique
$req = "SELECT * FROM base_connaissance bc, categorie c
        WHERE bc.CATEGORIE_ID = c.CATEGORIE_ID";

foreach ($keywords as $index => $keyword) {
    $req .= " AND (bc.TAG1 LIKE :tag$index OR bc.TAG2 LIKE :tag$index OR bc.TAG3 LIKE :tag$index";
}

$req .= ")";

$stmt = $bdd->prepare($req);

// Associer les paramètres de la requête
$params = [':query' => '%' . $query . '%'];
foreach ($keywords as $index => $keyword) {
    $params[":tag$index"] = '%' . $keyword . '%';
}

$stmt->execute($params);
$lignes = $stmt->fetchAll(PDO::FETCH_ASSOC);
$nb = count($lignes);
?>

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Résultats de la recherche</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
          <li class="breadcrumb-item active">Résultats de la recherche</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5><strong>Total des Bases de Connaissances trouvées :  </strong> <?php echo $nb ?></h5>
    </div>

    <?php foreach ($lignes as $ligne): ?>

      <div class="card" style="max-width: 90%; margin-left: auto;margin-right: auto;">
        <div class="card-header">
            <div class="row g-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <?php
                          // Fetch user data
                            $utilisateur_id = $ligne["UTILISATEUR_ID"];
                            $req_utilisateur = "SELECT * FROM utilisateur WHERE UTILISATEUR_ID = :utilisateur_id";
                            $stmt_utilisateur = $bdd->prepare($req_utilisateur);
                            $stmt_utilisateur->bindParam(':utilisateur_id', $utilisateur_id, PDO::PARAM_INT);
                            $stmt_utilisateur->execute();
                            $utilisateur = $stmt_utilisateur->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <img src="../../storage/images/<?php echo $utilisateur['IMAGE']; ?>" alt="Profile Picture" class="rounded-circle"  width="40" height="40" style="margin-right:12px">
                        <span class="username"><a href="details_profil.php?IDD=<?php echo $utilisateur["UTILISATEUR_ID"]; ?>" ><?php echo $utilisateur["NOM"] .' '.  $utilisateur["PRENOM"]; ?></a></span>
                    </div>
                    <?php if($ligne['UTILISATEUR_ID'] == $_SESSION['user_id']):?>
                        <a class="nav-link" href="#" data-bs-toggle="dropdown">
                        <span>
                            &#x2022;&#x2022;&#x2022;
                        </span>
                        </a><!-- End Three points -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header">
                        <a  href="modifier_base_connaissance_view.php?id_bc=<?php echo $ligne['BASE_CONNAISSANCE_ID']; ?>">Modifier</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-header">
                    
                            <a  href="..\..\controllers\user\supprimer_base_connaissance.php?IDD=<?php echo $ligne['BASE_CONNAISSANCE_ID']; ?>">Supprimer</a>
                        </li>
                        </ul>
                    <?php endif;?>
                </div>
            </div>
        </div> <!--fin header card-->
        <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title"><strong><?php echo ' ' . $ligne['BASE_CONNAISSANCE_TITRE']; ?></strong></h5>
              <h4 class="card-title mb-2 text-muted" style="padding-top: 0px;"><strong>Categorie :</strong><?php echo ' ' . $ligne['CATEGORIE_LIBELLE']; ?></h4>
              <div>
                  <strong>Tags:</strong>
                  <span class="badge bg-secondary"><?php echo htmlspecialchars($ligne['TAG1']); ?></span>
                  <span class="badge bg-secondary"><?php echo htmlspecialchars($ligne['TAG2']); ?></span>
                  <span class="badge bg-secondary"><?php echo htmlspecialchars($ligne['TAG3']); ?></span>
              </div>
              <?php 
              $description = $ligne['BASE_CONNAISSANCE_DESCR'];
              $words = explode(' ', $description);
              if (count($words) > 10) {
                  $shortDesc = implode(' ', array_slice($words, 0, 10)) . '...';
                  echo '<div class="description" style="margin-top: 12px;border: 1px solid #ccc; border-radius: 10px; padding: 10px; width: 152%; height: auto; max-height: 15%; overflow: hidden; position: relative;">';
                  echo '<span class="short-description" style="display: block;">' . htmlspecialchars($shortDesc) . '</span>';
                  echo '<span class="full-description" style="display: none;">' . htmlspecialchars($description) . '</span>';
                  echo '<div style="width: 100%; margin-top:50px; height: 42%;TEXT-ALIGN: CENTER;"><button style=" margin-top: 59px;border-color:#7a7a7a; position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%);" class="btn read-more">Read More</button></div>';
                  echo '</div>';
              } else {
                  echo '<div class="description" style="border: 1px solid #ccc; border-radius: 10px; padding: 10px; width: 90%; height: auto; max-height: 15%;">';
                  echo htmlspecialchars($description);
                  echo '</div>';
              }
              ?>
            </div>
        </div>             
      </div>
    <?php endforeach; ?>

    </section>
</main><!-- End #main -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.read-more').forEach(function(readMoreBtn) {
        readMoreBtn.addEventListener('click', function() {
            const shortDescription = this.closest('.description').querySelector('.short-description');
            const fullDescription = this.closest('.description').querySelector('.full-description');
            if (shortDescription.style.display === 'none') {
                shortDescription.style.display = 'inline';
                fullDescription.style.display = 'none';
                this.textContent = 'Read More';
            } else {
                shortDescription.style.display = 'none';
                fullDescription.style.display = 'inline';
                this.textContent = 'Read Less';
            }
        });
    });
});
</script>

<?php
include '..\headerX\footer.php';
?>
