<!DOCTYPE html>
<html>
<head>
    <title>BaraBara</title>
</head>

<body>

    <?php
            session_start();

     if (!isset($_SESSION['login']))
     {
        header ('location: ../Login/login.php');
        echo "pare de tentar burlar o site";
     } else {
        include_once "../Banco/conexao.php";
        $consultar = $conn->prepare("SELECT * FROM usuario 
                                   WHERE id_cadastro =:id");
        $consultar -> bindValue(":id", $_SESSION['login']);
        $consultar->execute();
        $row=$consultar->fetch();

     }

    ?>


    <header>
        <h1>Faça uma Doação</h1>
    </header>

    <nav>
        <ul>
            <?php echo "Olá $row[nm_usuario]"; ?>
            <a href="sobrenos.html">Sobre Nós</a>
            <a href="comodoar.html">Como Doar</a>
            <a href="contato.html">Contato</a>
            <a href="sair.php">Sair</a>
            <a href="publicacoes.php">Publicar Ou Conferir Causas</a>

        </ul>
    </nav>

    
   

 

    <footer>
        <p>&copy; BaraBara</p>
    </footer>
</body>
</html>