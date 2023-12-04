<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('location:login.php');
    echo "pare de tentar burlar o site";
} else {
    include_once "conexao.php";
    $consultar = $conn->prepare("SELECT * FROM usuario WHERE id_cadastro = :id");
    $consultar->bindValue(":id", $_SESSION['login']);
    $consultar->execute();
    $row = $consultar->fetch();
}

?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">

    <title>Como Doar</title>
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

        label,
        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="time"],
        input[type="submit"] {
            display: block;
            margin: 10px;
            padding: 10px;
            width: 80%;
        }

        input[type="submit"] {
            background-color: purple;
            color: black;
            padding: 10px;
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

    <h1>Como Doar</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" name="ocorrido" placeholder="descrição ocorrido">
        <input type="number" name="meta" placeholder="meta">
        <input type="hidden" name="data" value="<?php date_default_timezone_set('America/Sao_Paulo');
                                                $hoje = date('Y-m-d');
                                                echo $hoje; ?>">
        <input type="hidden" name="horas" value="<?php date_default_timezone_set('America/Sao_Paulo');
                                                $today = date("H:i:s");
                                                echo $today; ?>">
        <input type="text" name="cortesia" placeholder="cortesia">
        <input type="text" name="chavepix" placeholder="Chave Pix">
        <input type="text" name="nomebanco" placeholder="Digite o nome do seu banco"><br>
        <input type="number" name="nragencia" placeholder="Digite o número da agência"><br>
        <input type="text" name="nrcontaedigito" placeholder="Digite o número da conta e dígito"><br>
        <input type="file" name="fotospubli" accept="image/*" />
        <input type="submit" name="publicar" value="publicar">
    </form>

    <?php

    include_once "conexao.php";

    if (isset($_POST['publicar'])) {

        $usuario = $_SESSION['login'];
        $meta = $_POST['meta'];
        $ocorrido = $_POST['ocorrido'];
        $data = $_POST['data'];
        $tempo = $_POST['horas'];
        $cortesia = $_POST['cortesia'];
        $pix = $_POST['chavepix'];

        $banco = $_POST['nomebanco'];
        $agencia = $_POST['nragencia'];
        $contaDigito = $_POST['nrcontaedigito'];

        // Verifica se o arquivo de imagem foi enviado com sucesso
        if (isset($_FILES['fotospubli']) && $_FILES['fotospubli']['error'] === 0) {
            $uploadDir = 'publifotos/';
            $uploadFile = $uploadDir . basename($_FILES['fotospubli']['name']);

            // Move o arquivo para o diretório de upload
            if (move_uploaded_file($_FILES['fotospubli']['tmp_name'], $uploadFile)) {
                // Atualiza o nome do arquivo na tabela publicação
                $ds_fotospubli = basename($_FILES['fotospubli']['name']);
            } else {
                echo "Erro ao enviar a foto.";
            }
        }

        $sql = $conn->prepare("INSERT INTO `publicação` (`id_causa`, `usuariopostagem_id`,`qt_meta`, `ds_ocorrido`, `dt_date`, `hr_hora`, `ds_cortesia`, `ds_fotospubli`) 
                               VALUES (NULL, '$usuario', '$meta', '$ocorrido', '$data', '$tempo', '$cortesia', '$ds_fotospubli')");

        $sql->execute();
        $ultimo_id_inserido = $conn->lastInsertId();
        $chavepix = $conn->prepare("INSERT INTO chave_pix(pixcausa_id, nr_chave_cpf) VALUES ('$ultimo_id_inserido', '$pix')");
        $chavepix->execute();

        $inserirDadosBancarios = $conn->prepare("INSERT INTO dados_bancarios (causapagamento_id, nm_banco, nr_agencia, nr_conta_e_digito) VALUES (?, ?, ?, ?)");
        $inserirDadosBancarios->execute([$ultimo_id_inserido, $banco, $agencia, $contaDigito]);

        if ($sql) {
            echo "publicação cadastrada";
        }
    }

    ?>

 <?php
    // Exibir imagens das publicações
    $queryListagem = "SELECT publi.id_causa, user.nm_usuario, publi.ds_ocorrido, publi.qt_meta, publi.dt_date, publi.hr_hora, publi.ds_cortesia, publi.ds_fotospubli, chave_pix.nr_chave_cpf, dados_bancarios.nm_banco, dados_bancarios.nr_agencia, dados_bancarios.nr_conta_e_digito
                      FROM publicação AS publi
                      INNER JOIN usuario AS user ON publi.usuariopostagem_id = user.id_cadastro
                      LEFT JOIN chave_pix ON chave_pix.pixcausa_id = publi.id_causa
                      LEFT JOIN dados_bancarios ON dados_bancarios.causapagamento_id = publi.id_causa
                      ORDER BY publi.dt_date ASC";
    $listagemBanco = $conn->prepare($queryListagem);
    $listagemBanco->execute();

    $causas = array();

    while ($rowListagem = $listagemBanco->fetch(PDO::FETCH_ASSOC)) {
        $causaId = $rowListagem['id_causa'];

        if (!isset($causas[$causaId])) {
            $causas[$causaId] = [
                'usuario' => $rowListagem['nm_usuario'],
                'ocorrido' => $rowListagem['ds_ocorrido'],
                'meta' => $rowListagem['qt_meta'],
                'data' => $rowListagem['dt_date'],
                'hora' => $rowListagem['hr_hora'],
                'cortesia' => $rowListagem['ds_cortesia'],
                'pix' => [],
                'banco' => null,
                'agencia' => null,
                'contaDigito' => null,
                'fotospubli' => $rowListagem['ds_fotospubli'], // Adicionando o nome da foto
            ];
        }

        // Verifique a presença de Chave PIX
        if (!empty($rowListagem['nr_chave_cpf'])) {
            $causas[$causaId]['pix'][] = $rowListagem['nr_chave_cpf'];
        }

        // Verifique a presença de Dados Bancários
        if (!empty($rowListagem['nm_banco']) && !empty($rowListagem['nr_agencia']) && !empty($rowListagem['nr_conta_e_digito'])) {
            $causas[$causaId]['banco'] = $rowListagem['nm_banco'];
            $causas[$causaId]['agencia'] = $rowListagem['nr_agencia'];
            $causas[$causaId]['contaDigito'] = $rowListagem['nr_conta_e_digito'];
        }
    }

    foreach ($causas as $causaId => $causaData) {
        echo "Usuário: {$causaData['usuario']}<br>";
        echo "Descrição Ocorrido: {$causaData['ocorrido']}<br>";
        echo "Meta Quantia: {$causaData['meta']}<br>";
        echo "Data Publicação: {$causaData['data']}<br>";
        echo "Horário Da Postagem: {$causaData['hora']}<br>";
        echo "Cortesia: {$causaData['cortesia']}<br>";

        // Imprima as Chaves PIX
        if (!empty($causaData['pix'])) {
            echo "Chave PIX: " . implode(', ', $causaData['pix']) . "<br>";
        }

        // Imprima os Dados Bancários
        if (!empty($causaData['banco']) && !empty($causaData['agencia']) && !empty($causaData['contaDigito'])) {
            echo "Banco: {$causaData['banco']}<br>";
            echo "Agência: {$causaData['agencia']}<br>";
            echo "Conta e Dígito: {$causaData['contaDigito']}<br>";
        }

        // Imprima a imagem da publicação, se existir
        if (!empty($causaData['fotospubli'])) {
            $imagemPath = 'publifotos/' . $causaData['fotospubli'];
            echo "<img class='imagem-publicacao' src='{$imagemPath}' alt='Imagem da publicação'><br>";
        }

        echo '<form action="doado.php" method="post">';
        echo '<input type="hidden" name="id_publicacao" value="' . $causaId . '">';
        echo '<input type="submit" value="Doar">';
        echo '</form>';

        echo "<hr>";
    }
    ?>



     <a href="barabaraposlogin.php"> Página Inicial</a>



</body>


 </html>
