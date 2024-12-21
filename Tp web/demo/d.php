<?php
//detruire les variables de session
session_start();
unset($_SESSION['auth']);
unset($_SESSION['erreur']);
session_destroy();
header("location:form.php");

?>