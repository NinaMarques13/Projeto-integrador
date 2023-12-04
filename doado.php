<?php 
session_start();
    include_once "conexao.php";
    if (!isset($_SESSION['login'])) {
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            background-color: black;
            color: purple;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        header {
            background-color: purple;
            color: black;
            padding: 10px;
        }

        h1 {
            margin: 0;
        }

        .mensagem {
            background-color: purple;
            color: black;
            padding: 20px;
            margin: 20px;
        }

        p {
            font-size: 18px;
        }

        a {
            color: purple;
            text-decoration: none;
        }

        a:hover {
            background-color: purple;
            color: black;
        }
    </style>
</head>
<body>
    <header>
        <h1>BaraBara</h1>
    </header>


    <div class="mensagem">
        <p>Parabéns pela doação</p>
    </div>

    <a href="minhasdoacoes.php">Anexar Comprovante</a>
</body>
</html>
