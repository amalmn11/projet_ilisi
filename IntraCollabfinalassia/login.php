<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets\css\login.css">
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
              <small id="emailError" style="color: red; display: none;"></small>
              <small id="emailSuccess" style="color: green; display: none;">Email valide.</small>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Entrer votre mot de passe" required>
              </div>
              <small id="passwordError" style="color: red; display: none;"></small>
              <small id="passwordSuccess" style="color: green; display: none;">Mot de passe valide.</small>
              <div class="text"><a href="#">mot de passe oublié?</a></div>
              <div class="button input-box">
                <input type="submit" onclick="submitForm(event)" name="connecter" value="Se connecter">
              </div>
            </div>
            <small id="errorMessage" style="color: red;">
            <?php session_start(); if(isset($_SESSION['erreur'])){ echo $_SESSION['erreur']; } ?>
            </small>
            <small id="formSuccessMessage" style="color: green; display: none;">Formulaire soumis avec succès !</small>
          </form>
        </div>
      </div>
    </div>
  </div>
<!-- 
  <script>
    function validateEmail(email) {
      const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return regex.test(email);
    }

    function validatePassword(password) {
      if (password.length < 6) {
        return false;
      }
      const hasCharacter = /[a-zA-Z]/.test(password);
      const hasNumber = /\d/.test(password);
      return hasCharacter && hasNumber;
    }

    function showErrorMessage(element, message) {
      const errorElement = document.getElementById(element);
      errorElement.innerText = message;
      errorElement.style.display = 'block';
    }

    function hideErrorMessage(element) {
      const errorElement = document.getElementById(element);
      errorElement.style.display = 'none';
    }

    function showSuccessMessage(element, message) {
      const successElement = document.getElementById(element);
      successElement.innerText = message;
      successElement.style.display = 'block';
    }

    function hideSuccessMessage(element) {
      const successElement = document.getElementById(element);
      successElement.style.display = 'none';
    }

    function checkEmail() {
      const email = document.getElementById("email").value;
      if (!validateEmail(email)) {
        showErrorMessage("emailError", "Veuillez entrer un email valide.");
        hideSuccessMessage("emailSuccess");
      } else {
        hideErrorMessage("emailError");
        showSuccessMessage("emailSuccess", "Email valide.");
      }
    }

    function checkPassword() {
      const password = document.getElementById("password").value;
      if (!validatePassword(password)) {
        showErrorMessage("passwordError", "Le mot de passe doit contenir au moins 6 caractères et inclure des lettres et des chiffres.");
        hideSuccessMessage("passwordSuccess");
      } else {
        hideErrorMessage("passwordError");
        showSuccessMessage("passwordSuccess", "Mot de passe valide.");
      }
    }

    function submitForm(event) {
      const email = document.getElementById("email").value;
      const password = document.getElementById("password").value;

      if (validateEmail(email) && validatePassword(password)) {
        hideErrorMessage("errorMessage");
        showSuccessMessage("formSuccessMessage", "Formulaire soumis avec succès !");
      } else {
        event.preventDefault();
        showErrorMessage("errorMessage", "L'email ou le mot de passe n'est pas valide.");
        hideSuccessMessage("formSuccessMessage");
      }
    }

    document.getElementById("email").addEventListener("blur", checkEmail);
    document.getElementById("password").addEventListener("blur", checkPassword);
  </script> -->
</body>
</html>
