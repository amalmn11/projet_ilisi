<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/c/CodingLabYT-->
<html lang="fr" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <!--<title> Login and Registration Form in HTML & CSS | CodingLab </title>-->
    <link rel="stylesheet" href="assets\css\login.css">
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
      <div class="front">
        <img src="assets/img/frontImg.jpg" style="border-radius: 0px 30px 30px 0px;" alt="">
        <div class="text">
        <span class="text-1">Votre passerelle vers<br> l'efficacité collective</span>
          <span class="text-2">commence ici</span>
        </div>
      </div>
      <div class="back">
        <img class="backImg" src="img/backImg.jpg" alt="">
        <div class="text">
          <span class="text-1">Complete miles of journey <br> with one step</span>
          <span class="text-2">Let's get started</span>
        </div>
      </div>
    </div>
    <div class="forms">
        <div class="form-content">
          <div class="login-form">
            <div class="title">Connexion</div>
          <form action="controllers/auth/auth.php" method="post">
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" id="email" name="email" placeholder="Entrer votre email" required>
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Entrer votre mot de passe" required>
              </div>
              <div class="text"><a href="#">mot de passe oublié?</a></div>
              <div class="button input-box">
                <input type="submit" onclick="submitForm()" name="connecter" value="Se connecter">
              </div>
            </div>
            <!-- Ajoutez les éléments small pour afficher les messages d'erreur -->
            <small id="errorMessage" style="color: red;">
            <?php session_start(); if(isset($_SESSION['erreur'])){  echo $_SESSION['erreur']; } ?></small>
        </form>
      </div>
    </div>
    </div>
  </div>
</body>
<script>
  function validateEmail(email) {
      const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return regex.test(email);
  }
  function validatePassword(password) {
      // Vérifie la longueur du mot de passe
      if (password.length < 6) {
          return false;
      }
      // Vérifie la présence de caractères et de chiffres
      const hasCharacter = /[a-zA-Z]/.test(password);
      const hasNumber = /\d/.test(password);
      return hasCharacter && hasNumber;
  }
  function submitForm() {
      // Récupérer la valeur saisie dans le champ de saisie d'e-mail
      const email = document.getElementById("email").value;
      const password = document.getElementById("password").value;
      if (validateEmail(email) && validatePassword(password)) {
      console.log("Les informations sont valides.");
      // Réinitialiser le message d'erreur et le cacher
      errorMessage.innerText = "";
      errorMessage.style.display = "none";
  } else {
      console.log("Les informations ne sont pas valides.");
      // Afficher le message d'erreur et appliquer le style
      if(email=="" || password="") errorMessage.innerText = "Veuillez remplir tous les champs obligatoires.";
      else errorMessage.innerText = "L'email ou le mot de passe n'est pas valide.";
      errorMessage.style.display = "block";
  }
  }
  </script>
</html>
