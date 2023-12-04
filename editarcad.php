<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("login.php");
    exit();
}

include_once("conexao.php");
$usuario = $_SESSION['login'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nova_senha = md5($_POST["senha"]);
    $novo_nome = $_POST["nome"];

    $sql = "UPDATE usuario SET nr_senha = :senha, nm_usuario = :nome WHERE id_cadastro = :id";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':senha', $nova_senha);
    $stmt->bindParam(':nome', $novo_nome);
    $stmt->bindParam(':id', $usuario);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        header("refresh:3;url=barabaraposlogin.php");
        echo "Dados do usuário atualizados com sucesso!";
    } else {
        echo "Nenhuma alteração realizada ou usuário não encontrado.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset = "UTF-8">

    <title>Editar Dados do Usuário</title>
    <style>
        body {
            background-color: black;
            color: purple;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        form {
            text-align: center;
            margin: 20px;
        }

        label {
            color: purple;
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px;
            margin: 10px;
        }

        input[type="submit"] {
            background-color: purple;
            color: black;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: black;
            color: purple;
        }
    </style>
</head>
<body>
    <h1>Editar Dados do Usuário</h1>
    <form method="post" action="">
        <label for="nome">Novo Nome:</label>
        <input type="text" name="nome" id="nome"><br>
        <label for="senha">Nova Senha:</label>
        <input type="password" name="senha" id="senha"><br>
        <input type="submit" value="Editar Dados">
    </form>
</body>
</html>
