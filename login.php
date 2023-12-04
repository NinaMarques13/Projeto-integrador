<?php
  include_once "conexao.php";

    if (isset($_POST['submit'])) {
        if (($_POST['email'] == "") && ($_POST['senha'] == "")) {
            echo "Digite seu email ou senha";
        } else {
            $email = $_POST['email'];
            $senha = md5($_POST['senha']);
            

            $sql = $conn->prepare("SELECT * FROM usuario WHERE nm_email = :email AND nr_senha = :senha");
            $sql->bindValue(":email", $email);
            $sql->bindValue(":senha", $senha);
            $sql->execute();

            if ($sql->rowCount() == 0) {
                echo "E-mail ou Senha Inválida, tente novamente";
                
                
            } else {
                $buscar = $sql->fetch();
                $id = $buscar['id_cadastro'];
                session_start();
                $_SESSION['login'] = $id;
                header('location:barabaraposlogin.php');
            }
        }
    }
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
            text-align: center;
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
    <h1>BaraBara</h1>
    <h2>Login</h2>
    <form action="" method="post">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name = "senha" required>
        <input type="submit" name="submit" value="Entrar">
    </form>

</body>
<a href="default.php"> Página Inicial</a>

</html>
