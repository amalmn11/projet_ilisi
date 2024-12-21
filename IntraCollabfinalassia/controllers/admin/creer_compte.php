<?php
  // Récupérer les données du formulaire
$email=$_POST['email'];
$pwd=$_POST['password'];
$pwdhasher= password_hash($pwd, PASSWORD_DEFAULT);


// connexion a la base de donnee
require_once '..\db\connexion.php';

session_start();
$_SESSION['erreur_form']="";

//verifier si email exist deja

 // pour recuperation des donnees apartir select on utilise query
// Requête préparée pour vérifier si l'e-mail existe déjà dans la table utilisateur
$sql = "SELECT * FROM utilisateur WHERE ROLE_ID = 2 AND email = :email";
$s = $bdd->prepare($sql);
$s->bindParam(':email', $email, PDO::PARAM_STR);
$s->execute();

// Vérification du résultat
if ($s->rowCount() > 0) {
    // L'e-mail existe déjà dans la base de données
    $_SESSION['erreur_form']= "L'e-mail existe déjà.";
    //redirection vers page d'acceuil
    header("location:../../Views/admin/gestion_utilisateur.php");
    exit;
}



///////////////////////////:PARTIE ENVOIE D'EMAIL
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
  
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'eli539529@gmail.com';                     //SMTP username
    $mail->Password   = 'qjsz ohal sacy ijcr';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
     // Destinataire et expéditeur
    $mail->setFrom('eli539529@gmail.com', 'Jawad NASIRI');
    $mail->addReplyTo('eli539529@gmail.com', 'Admin');
    $mail->addAddress($email, '');     //Add a recipient

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    // Contenu du message
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Informations de connexion à votre compte ';
    $mail->Body    = 
    "
    Cher(e) collègue,<br><br>

    Votre compte utilisateur a été créé avec succès. Voici vos informations de connexion :<br>

      Email : $email <br>
      Mot de passe : $pwd <br><br>
    
    Pour accéder à votre compte, veuillez suivre <a href=#>[lien vers la page de connexion de votre système]</a>.<br><br>
  
    Bien cordialement,<br><br>

    Jawad NASIRI.
      
    ";
    $mail->AltBody =    
    "
    Cher(e) collègue,

    Votre compte utilisateur a été créé avec succès. Voici vos informations de connexion :

      Email : $email
      Mot de passe : $pwd 
    Pour accéder à votre compte, veuillez suivre [lien vers la page de connexion de votre système].
  
    Bien cordialement,

    Jawad NASIRI. 
    ";

     // Envoyer l'e-mail
    $mail->send();
    // echo 'E-mail envoyé avec succès !';
} 
catch (Exception $e) {
    echo "Erreur lors de l'envoi du message : {$mail->ErrorInfo}";
    $_SESSION['erreur_form'] = " Erreur lors de l'envoi du message :  {$mail->ErrorInfo}";
    //redirection vers page d'acceuil
    header("location:../../Views/admin/gestion_utilisateur.php");
    exit;
}

///////////////////:::FIN PARTIE D'ENVOIE D'EMAIL

 ////PARTIE INSERTION DANS LA BASE DE DONNEES

    //*******1-preparer la requete
    $req = "INSERT INTO UTILISATEUR (UTILISATEUR_ID, ROLE_ID, EMAIL, PWD,IMAGE) VALUES (NULL,?, ?, ?,?);";
    $stmt=   $bdd->prepare($req);

    //********2-binder les valeur a leur champs
    $stmt->bindValue(1,2,PDO::PARAM_INT);
    $stmt->bindValue(2,$email,PDO::PARAM_STR);

    $stmt->bindValue(3,$pwdhasher,PDO::PARAM_STR);
    $img="default_pfp.jpg";
    $stmt->bindValue(4,$img,PDO::PARAM_STR);
    //*********3-executer la req
    $ok = $stmt->execute();
    if (!$ok) {
      // La requête n'a pas été exécutée correctement
      $_SESSION['erreur_form'] = "Erreur lors de l'enregistrement du compte.";
    }

   

 ////FIN PARTIE INSERTION DANS LA BASE DE DONNEES



//redirection vers page d'acceuil
header("location:../../Views/admin/gestion_utilisateur.php");


?>