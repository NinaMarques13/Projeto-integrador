<?php
include_once "conexao.php";

session_start();
if (!isset($_SESSION['login'])) {
    exit();
}

if (isset($_POST['Anexar'])) {
    $usuario = $_SESSION['login'];
    $formatospermitidos = array("png", "jpg", "jpeg");
    $extensao = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);

    if (in_array($extensao, $formatospermitidos)) {
        $dados_binarios = file_get_contents($_FILES['arquivo']['tmp_name']);
        $nome_arquivo = $_FILES['arquivo']['name'];

        $causaSelecionada = $_POST['credito'];

        $inserirArquivo = $conn->prepare("INSERT INTO arq_midia (ds_arquivo, ds_foto, causaarquivo_id, cadastromidia_id) VALUES (?, ?, ?, $usuario)");
        $inserirArquivo->bindParam(1, $nome_arquivo);
        $inserirArquivo->bindParam(2, $dados_binarios);
        $inserirArquivo->bindParam(3, $causaSelecionada);

        if ($inserirArquivo->execute()) {
            echo "Arquivo anexado com sucesso!";
            echo "Causa doada: Causa $causaSelecionada";
        } else {
            echo "Erro ao anexar o arquivo no banco de dados.";
        }
    } else {
        echo "Formato de arquivo não permitido. Use apenas PNG, JPG ou JPEG.";
    }
}
?>

<?php
$usuario = $_SESSION['login'];

$buscarArquivos = $conn->prepare("SELECT ds_arquivo, ds_foto, causaarquivo_id FROM arq_midia WHERE cadastromidia_id = ?");
$buscarArquivos->bindParam(1, $usuario);
$buscarArquivos->execute();

if ($buscarArquivos->rowCount() > 0) {
    while ($rowArquivo = $buscarArquivos->fetch(PDO::FETCH_ASSOC)) {
        $nome_arquivo = $rowArquivo['ds_arquivo'];
        $causaSelecionada = $rowArquivo['causaarquivo_id'];

        echo "Nome do arquivo: $nome_arquivo<br>";
        echo "Causa doada: Causa $causaSelecionada<br>";

        // Exibir a imagem usando base64
        echo "<img src='data:image/jpeg;base64," . base64_encode($rowArquivo['ds_foto']) . "' alt='Imagem Anexada'>";

        echo "<hr>"; 
    }
} else {
    echo "Nenhum arquivo associado a este usuário.";
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <label for="credito">Escolha a causa:</label>
    <select name="credito">
        <?php
        $buscarpubli = $conn->prepare("SELECT DISTINCT id_causa FROM publicação");
        $buscarpubli->execute();

        while ($rowcausa = $buscarpubli->fetch(PDO::FETCH_ASSOC)) {
            extract($rowcausa);
            echo "<option value='$id_causa'>Causa $id_causa</option>";
        }
        ?>
    </select>
    <br>
    <input type="file" name="arquivo">
    <input type="submit" name="Anexar" value="Anexar">
</form>

<!DOCTYPE html>
<html> 
<head> 
<meta charset = "UTF-8">
<style>
    body {
        background-color: black;
        color: purple;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    header {
        background-color: purple;
        color: black;
        padding: 10px;
        text-align: center;
    }

    .caixa-causa, .caixa-anexo {
        background-color: purple;
        padding: 20px;
        margin: 10px;
    }

    label {
        color: black;
        display: block;
        margin-bottom: 10px;
    }

    select, input[type="text"], input[type="number"] {
        padding: 5px;
        width: 100%;
        margin-bottom: 10px;
    }

    input[type="file"] {
        background-color: purple;
        color: black;
        padding: 5px;
        width: 100%;
        margin-bottom: 10px;
        border: none;
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
    <a href="barabaraposlogin.php">Página Inicial</a>
</body>
</html>

