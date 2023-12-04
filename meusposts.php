<?php
include_once "conexao.php";

session_start(); 
if (!isset($_SESSION['login'])) {
    exit();
}
$user_id = $_SESSION['login'];

$querylistagem = "SELECT publi.id_causa, user.nm_usuario, publi.ds_ocorrido, publi.qt_meta, publi.dt_date, publi.hr_hora, publi.ds_cortesia 
                  FROM publicação AS publi
                  INNER JOIN usuario AS user ON publi.usuariopostagem_id = user.id_cadastro
                  WHERE publi.usuariopostagem_id = :user_id
                  ORDER BY publi.dt_date ASC";

$listagembanco = $conn->prepare($querylistagem);
$listagembanco->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$listagembanco->execute();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset = "UTF-8">

    <title>minhas publicações</title>
    <style>
        body {
            background-color black;
            color: purple;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
            
        h1 {
            text-aling: center;
            margin-top: 20px;
        }
        hr {
            border: 1px solid purple;
        }
    </style>
            <meta charset = "UTF-8">

</head>
<body>
    <h1>Minhas publicações</h1>
    <?php
    while ($rowlistagem = $listagembanco->fetch(PDO::FETCH_ASSOC)) {
        extract($rowlistagem);
        echo "ID: $id_causa"."<br>";
        echo "Usuário: $nm_usuario"."<br>";
        echo "Descrição Ocorrido: $ds_ocorrido"."<br>";
        echo "Meta Quantia: $qt_meta"."<br>";
        echo "Data Publicação: $dt_date"."<br>";
        echo "Horário Da Postagem: $hr_hora"."<br>";
        echo "Cortesia: $ds_cortesia"."<br>";
        echo "<hr>";
    }

    
    ?>

<a href="barabaraposlogin.php">Página Inicial</a>

</body>
</html>



