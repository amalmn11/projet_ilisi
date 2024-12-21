
<?php

include '..\..\controllers\db\connexion.php';
//session_start();
$user_id=$_SESSION["user_id"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>IntraCollab</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../../assets/img/newlogo.png" rel="icon">
  <link href="../../assets/img/newlogo.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../../assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../../assets/css/style.css" rel="stylesheet">

  <!------our css---->
  <link href="../../assets/css/profile.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="../user/profile.php" class="logo d-flex align-items-center">
        <img src="../../assets/img/fatiha.png" alt="">
        <!-- <span class="d-none d-lg-block"></span> -->
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="GET" action="..\user\recherche_resultat.php">
        <input type="text" name="query" placeholder="Rechercher" title="Entrer le mot clé">
        <button type="submit" title="Rechercher"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->
        <!-------PARTIE DE NAVBAR DE MSG ET NOTIFICATION--------------->
        <li class="nav-item dropdown">

<?php
// Récupérer toutes les notifications de l'utilisateur
// $requete_notifications = "SELECT * FROM notification WHERE UTILISATEUR_ID = :user_id";
// $stmt_notifications = $bdd->prepare($requete_notifications);
// $stmt_notifications->bindParam(':user_id', $user_id, PDO::PARAM_INT);
// $stmt_notifications->execute();
// $notifications = $stmt_notifications->fetchAll(PDO::FETCH_ASSOC);

//recuperer les notification non lue
$requete_notifications_non_lues = "SELECT * FROM notification WHERE 
UTILISATEUR_ID = :user_id and EST_LU=0;";
$stmt_notifications_non_lues = $bdd->prepare($requete_notifications_non_lues);
$stmt_notifications_non_lues->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_notifications_non_lues->execute();
$notifications_non_lues = $stmt_notifications_non_lues->fetchAll(PDO::FETCH_ASSOC);

?>
<a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
  <i class="bi bi-bell"></i>
  <span class="badge bg-primary badge-number"><?php echo count($notifications_non_lues); ?></span>
</a><!-- End Notification Icon -->



<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
  <li class="dropdown-header">
    Vous avez <?php echo count($notifications_non_lues); ?> nouvelles notifications
    <?php $_SESSION['page']=$_SERVER['REQUEST_URI'];?>
    <a href="../user/marquer_notifications_lues.php"><span class="badge rounded-pill bg-primary p-2 ms-2">lire tous</span></a>
  </li>
  <li>
    <hr class="dropdown-divider">
  </li>

  <?php foreach ($notifications_non_lues as $notification): ?>
    <li class="notification-item">
    <i class="bi bi-check-circle text-success"></i> 
      <div>
        <h4><?php echo $notification['NOTIF_CONTENUE']; ?></h4>
        <p><?php echo $notification['DATE_CREATION']; ?></p>
      </div>
    </li>

    <li>
      <hr class="dropdown-divider">
    </li>
  <?php endforeach; ?>

  <li class="dropdown-footer">
    <a href="#">Afficher Toutes les Notifications</a>
  </li>
</ul>
<!-- End Notification Dropdown Items -->



</li><!-- End Notification Nav -->

<li class="nav-item dropdown">

<a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
  <i class="bi bi-chat-left-text"></i>
  <span class="badge bg-success badge-number">3</span>
</a><!-- End Messages Icon -->

<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
  <li class="dropdown-header">
    You have 3 new messages
    <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
  </li>
  <li>
    <hr class="dropdown-divider">
  </li>

  <li class="message-item">
    <a href="#">
      <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
      <div>
        <h4>Maria Hudson</h4>
        <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
        <p>4 hrs. ago</p>
      </div>
    </a>
  </li>
  <li>
    <hr class="dropdown-divider">
  </li>

  <li class="message-item">
    <a href="#">
      <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
      <div>
        <h4>Anna Nelson</h4>
        <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
        <p>6 hrs. ago</p>
      </div>
    </a>
  </li>
  <li>
    <hr class="dropdown-divider">
  </li>

  <li class="message-item">
    <a href="#">
      <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
      <div>
        <h4>David Muldon</h4>
        <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
        <p>8 hrs. ago</p>
      </div>
    </a>
  </li>
  <li>
    <hr class="dropdown-divider">
  </li>

  <li class="dropdown-footer">
    <a href="#">Show all messages</a>
  </li>

</ul><!-- End Messages Dropdown Items -->

</li><!-- End Messages Nav -->



        <!-----------END DE NAVBAR DE MSG ET NOTIFICATION------------>

   

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="..\..\storage\images\<?php echo  $_SESSION["image"]; ?>" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION['auth'];?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $_SESSION['auth'];?></h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="..\user\profile.php">
                <i class="bi bi-person"></i>
                <span>Mon Profile</span>
              </a>
            </li>
           

           
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Aide ?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center"  href="..\..\controllers\db\deconnexion.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Se déconnecter</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <!-- <a class="nav-link collapsed" href="..\user\user_index.php"> -->
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-house-fill"></i>
          <span>Accueil</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="..\user\forum.php">
        
          <i class="bi bi-chat-square-fill"></i>
          <span>Forum</span>
        </a>
      </li><!-- End Profile Page Nav -->
      <li class="nav-item">
      <a class="nav-link collapsed" href="..\user\annonce.php">

       
          <i class="bi bi-megaphone-fill"></i>
          <span>Annonce</span>
        </a>
      </li><!-- End Profile Page Nav -->
      <li class="nav-item">
      <a class="nav-link collapsed" href="..\user\formation.php">
       
          <i class="bi bi-book-fill"></i>
          <span>Formation</span>
        </a>
      </li><!-- End Profile Page Nav -->
      <li class="nav-item">
      <a class="nav-link collapsed" href="..\user\projet.php">
      
          <i class="bi bi-briefcase-fill"></i>
          <span>Projet</span>
        </a>
      </li><!-- End Profile Page Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="..\user\connaissance.php">
       
          <i class="bi bi-journal-bookmark-fill"></i>
          <span>Base de connaissance</span>
        </a>
      </li><!-- End Profile Page Nav -->


      

      <li class="nav-heading"><hr></li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="..\user\profile.php">
          <i class="bi bi-person-fill"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Page Nav -->
       <li class="nav-item">
        <a class="nav-link collapsed" href="..\user\statistique_profile.php">
          <i class="bi bi-clipboard-data"></i>
          <span>Statistique</span>
        </a>
      </li> 
      <!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-telephone-fill"></i>
          <span>Contact us</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="..\..\controllers\db\deconnexion.php">
          <i class="bi bi-box-arrow-right"></i>
          <span>Se déconnecter</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->
    </ul>

  </aside><!-- End Sidebar-->