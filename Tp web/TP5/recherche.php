
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }
        #d1{
            background: linear-gradient(to right, #f6d5f7, #fbe9d7); 
            width:1280px; 
            height:50px;
        }
    </style>
</head>
<body>
    <div id="d1"></div>
    <form action="traiterecherche.php" method="post">
    <center>
    <table border="0">
        <tr>
            <td width="200px">Filiere </td>
            <td width="350px">
                <input type="text" width="50px" name="fil">
            </td>
            <td width="200px">
                <input type="submit" width="50px" value="valider">
            </td>
        </tr>
    </table>
    </center>
    </form>
</body>
</html>