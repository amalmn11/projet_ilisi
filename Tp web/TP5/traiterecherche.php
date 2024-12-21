<?php

require_once 'connexion.php';

$filiere=$_POST['fil'];

$sql2="select * from etudiant where filiere='$filiere'";
//$sql2="select * from etudiant where filiere=:f";

// $stmt2=$bdd->prepare($sql2);
// $stmt2->bindValue(":f",$filiere);
// $stmt2->execute();
$stmt2=$bdd->query($sql2);

$result=$stmt2->fetchall(PDO::FETCH_ASSOC);

//header(location:'afficherfil.php');


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<table border="1"  width="500px" style="border-collapse:collapse;">
            <tr>
                <th>ID</th>
                <th>NOM</th>
                <th>FILIERE</th>
                <th>CONTROLE</th>
                <th>EXAMEN</th>
                <th>MOYENNE</th>
            </tr>
            <?php foreach($result as $ligne): ?>
            <tr>
                <td><?php echo $ligne['id']; ?></td>
                <td><?php echo $ligne['nom']; ?></td>
                <td><?php echo $ligne['filiere']; ?></td>
                <td><?php echo $ligne['controle']; ?></td>
                <td><?php echo $ligne['examen']; ?></td>
                <td><?php echo (2*$ligne['examen']+$ligne['controle'])/3; ?></td>
            </tr>
            <?php endforeach ?>
        </table>
</body>
</html>