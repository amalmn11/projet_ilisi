<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #f6d5f7, #fbe9d7);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
            font-size: 18px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
        center{
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <form action="traiter.php" method="post">
        <center><h3>Ajouter un Etudiant</h3></center><br>
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom"><br>
        <label for="filiere">Filiere :</label>
        <input type="text" name="filiere"  id="filiere"><br>
        <label for="controle">Controle : </label>
        <input type="text" name="controle" id="controle"><br>
        <label for="examen">Examen : </label>
        <input type="text" name="examen" id="examen"><br>
        <input type="submit" value="ajouter" >
    </form>
</body>
</html>