<?php
require_once 'connexion.php';
require_once 'auth.php';

$sql="select * from comptes";
$st=$bdd->query($sql);
$result=$st->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div style="background-color:red;">
    <table>
        <tr>
            <td>NCompte</td>
            <td>Solde</td>
            <td>Client</td>
        </tr>
        <?php foreach($result as $ligne): ?>
            <tr>
                <td><?php echo $ligne['NCompte']; ?></td>
                <td><?php echo $ligne['Solde']; ?></td>
                <td><?php echo $ligne['client']; ?></td>
            </tr>
        <?php endforeach ?>
    </table>
    </div>
    <br><br>
    <div style="background-color: rgba(255, 0, 0, 0.527);">
            <ul>
                <li><a href="depot.php">Dépot</a></li>
                <li><a href="retrait.php">Retrait</a></li>
                <li><a href="Deconnexion.php">Déconnexion</a></li>
            </ul>
        </div>
</body>
</html>