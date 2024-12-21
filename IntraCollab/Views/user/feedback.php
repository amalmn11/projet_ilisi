<?php

require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\header_user.php';
include '..\..\controllers\db\connexion.php';

?>
<main id="main" class="main">

<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    width: 100%;
    box-sizing: border-box;
}

h1 {
    margin-bottom: 20px;
    font-size: 24px;
}

h2 {
    margin-top: 20px;
    font-size: 20px;
}

h3 {
    margin-top: 20px;
    font-size: 18px;
}

p {
    margin-bottom: 15px;
    line-height: 1.6;
}

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

</style>
<div class="pagetitle">
      <h1>Feedback</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_index.php">Accueil</a></li>
          <!-- <li class="breadcrumb-item"></li> -->
          <li class="breadcrumb-item active">Feedback</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <div class="container">
        <h3>Où puis-je poster des feedbacks sur quelque chose qui ne fonctionne pas ou une idée de fonctionnalité ?</h3>
        <p>Si vous avez une suggestion, une demande de fonctionnalité ou un rapport de bug, la meilleure façon de faire connaître votre idée est de la poster sur notre site de discussion méta. De cette façon, la communauté ainsi que le personnel d'IntraCollaboration peuvent discuter des avantages et des éventuels problèmes de votre idée. Si vous voulez faire un feedback, <a href="ajouter_feedback.php">cliquez ici.</a></p>
        <p><strong>Note :</strong> Les problèmes de sécurité ne doivent pas être rendus publics, et ne doivent donc pas être postés sur notre site méta. Veuillez nous contacter directement à la place.</p>
    </div>
</main>




<?php
// require_once '..\..\controllers\auth\auth_inc.php';
include '..\headerX\footer.php';

?>