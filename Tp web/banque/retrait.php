<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <center>
            <img style="margin-top:90px;" src="img.png" alt="this is an image">
            <form action="traiter_retrait.php" method="Post">
                <table border="0">
                    <tr>
                        <td>NCompte</td>
                        <td><input type="number" name="NCompte"></td>
                    </tr>
                    <tr>
                        <td>Somme</td>
                        <td><input type="text" name="Somme"></td>
                    </tr>
                    <tr>
                        <td><input type="submit" value="Ok" name="ok"></td>
                        <td><input type="reset" value="Annuler" name="annuler"></td>
                    </tr>
                </table>
            </form>
        </center>
        <?php
        session_start();
        if(isset($_SESSION['error']))
        {
            echo $_SESSION['error'];
        }
        ?>
    </div>
</body>
</html>