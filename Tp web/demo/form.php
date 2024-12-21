<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification</title>
</head>
<body>
    <h3>Authentification</h3>
    <form action="auth.php" method="post">
    Login : <input type="text" name="login"><br><br>
    password : <input type="password" name="pass">
    <hr>
    <input type="submit" value="Entrer">
    </form>
    <?php 
    session_start();
    if(isset($_SESSION['erreur'])) echo $_SESSION['erreur']?>
</body>
</html>