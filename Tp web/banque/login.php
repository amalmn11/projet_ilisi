<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    if(isset($mess))
    {
        echo '<script>alert("' . $mess . '");</script>';
    }
    ?>
    <div>
        <center>
            <img style="margin-top:90px;" src="img.png" alt="this is an image">
            <form action="traiter.php" method="Post">
                <table border="1">
                    <tr>
                        <td>Login</td>
                        <td><input type="text" name="login"></td>
                    </tr>
                    <tr>
                        <td>Passowrd</td>
                        <td><input type="text" name="password"></td>
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