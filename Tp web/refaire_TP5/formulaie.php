<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom right, rgba(200,11, 22, 0.8), rgba(25,55, 230, 0.95));
            height:800px;
            margin: 0;
            padding: 0;
        }

        form {
            background-color: rgba(255,255, 255, 0.3);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 100px auto;
        }

        h2 {
            color: #FFFFFF;
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color:#ffffff;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <form action="ajout.php" method="POST">
        <h2><center>Ajout d'un nouvel étudiant</center></h2>
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom">
        <br><br>
        <label for="filiere">Filière</label>
        <input type="text" id="filiere" name="filiere">
        <br><br>
        <label for="controle">Contrôle</label>
        <input type="text" name="controle" id="controle">
        <br><br>
        <label for="exam">Examen</label>
        <input type="text" name="exam" id="exam">
        <br><br>
        <CEnter><input type="submit" value="Ajouter"></CEnter>
    </form>
</body>
</html>
