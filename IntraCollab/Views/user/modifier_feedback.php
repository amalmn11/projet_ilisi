<?php
require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\header_user.php';
include '..\..\controllers\db\connexion.php';

$id_fb = $_GET['id_fb'];

$req = "SELECT * from feedback where ID_FEEDBACK=?";
$stmt_update = $bdd->prepare($req);
$stmt_update->bindParam(1, $id_fb, PDO::PARAM_INT);
$stmt_update->execute();
$feedback = $stmt_update->fetch(PDO::FETCH_ASSOC);



?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../assets/css/details_question.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
        .container2 {
            display: flex;
            align-items: center;
        }
        .title {
            margin-right: 10px;
        }
        .content p {
            margin:0; /* Supprime la marge par défaut du paragraphe pour un meilleur alignement */
        }
     
        .menu-container {
            position: relative;
        }

        .menu-btn {
            cursor: pointer;
            display: block;
            position: relative;
            z-index: 1;
            height: 30px;
            width: 30px;
        }

        .menu-btn span {
            background-color: #333;
            display: block;
            height: 2px;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.3s ease-in-out;
            width: 100%;
        }

        .menu-btn span:before,
        .menu-btn span:after {
            background-color: #333;
            content: '';
            display: block;
            height: 100%;
            position: absolute;
            transition: all 0.3s ease-in-out;
            width: 100%;
        }

        .menu-btn span:before {
            top: -8px;
        }

        .menu-btn span:after {
            bottom: -8px;
        }

        .menu-btn.active span {
            background-color: transparent;
        }

        .menu-btn.active span:before {
            transform: rotate(45deg);
        }

        .menu-btn.active span:after {
            transform: rotate(-45deg);
        }

        .menu {
            background-color: #fff;
            border: 1px solid #ccc;
            display: none;
            list-style: none;
            padding: 10px;
            position: absolute;
            right: 0;
            top: 40px;
            z-index: 0;
        }

        .menu li {
            margin-bottom: 10px;
        }

        .menu-container input[type="checkbox"] {
            display: none;
        }

        .menu-container input[type="checkbox"]:checked + .menu {
            display: block;
        }
</style>

<main id="main" class="main">
<div class="pagetitle">
      <h1>Modifier feedback</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
          <!-- <li class="breadcrumb-item"></li> -->
          <li class="breadcrumb-item active">Feedback</li>
          <li class="breadcrumb-item active">Modifier feedback</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
<div class="box-footer">
    <form action="..\..\controllers\user\modifier_feedback.php" method="POST">
        <img class="img-responsive img-circle img-sm" src="../../storage/images/<?php echo $_SESSION["image"]; ?>" alt="Alt Text">
        <div class="img-push">
            <!-- Quill Editor Full -->
            <div>
            <textarea class="form-control" rows="5" name="new_feedback"><?php echo $feedback['COMMENTAIRE']; ?></textarea>
            <input type="hidden" class="form-control" value="<?php echo $feedback['ID_FEEDBACK']; ?>" name="feedback_id">
            <sider-quick-compose-btn data-gpts-theme="light"></sider-quick-compose-btn></div>
            <button style="BORDER-RADIUS: 7px;" type="submit" id="btn-submit" name="ajouterReponse" class="share-button">
                <i class="fas fa-share"></i> Modifier
            </button>
            </div>
    </form>   
</div>

</main><!-- End #main -->

<?php
include '..\headerX\footer.php';
?>
