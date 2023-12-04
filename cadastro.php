<!DOCTYPE html>
<html>
<head>
    <title>Cadastro</title>
    <style>
        body {
            background-color: black;
            color: purple;
            text-align: center;
            font-family: Arial, sans-serif;
        }

        h1 {
            background-color: purple;
            color: black;
            padding: 10px;
        }

        form {
            text-align: left;
            margin: 0 auto;
            width: 300px;
        }

        label {
            display: block;
            margin: 10px 0;
            color: purple;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid purple;
        }

        input[type="submit"] {
            background-color: purple;
            color: black;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
    </style>
    <meta charset = "UTF-8">
</head>
<body>
    <h1>Cadastro</h1>
    <form action="" method="post">
        <label for="nome">Digite seu nome:</label>
        <input type="text" id="nome" name="nome" required>
        <label for="cpf">Digite seu CPF/CNPJ:</label>
        <input type="number" id="cpf" name="cpf" required>
        <label for="senha">Cadastre sua senha:</label>
        <input type="password" id="senha" name="senha" required>
        <label for="email">Cadastre seu email:</label>
        <input type="text" id="email" name="email" required>
        <input type="submit" name="cadastrar" value="Cadastrar">
    </form>

    <?php
    include_once "conexao.php";

    if (isset($_POST['cadastrar'])) {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cpf = md5($_POST['cpf']);
        $senha = md5($_POST['senha']);

        $sql = $conn->prepare("INSERT INTO usuario(id_cadastro, nm_usuario, nm_email, nr_cpf, nr_senha)
                   VALUE (NULL, '$nome','$email','$cpf','$senha')");
        $sql->execute();

        if ($sql) {
            echo "<br>" . "Cadastrado com sucesso";
        }
    }
    ?>

<a href="default.php">Página Inicial</a>

</body>
</html>
