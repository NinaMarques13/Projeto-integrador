<!DOCTYPE html>
<html>
<head>
<meta charset = "UTF-8">

    <title>BaraBara</title>
    <style>
        body {
            background-color: black;
            color: purple;
            text-align: center;
            font-family: Arial, sans-serif;
            padding: 0;
            margin: 0;
        }

        h2 {
            color: purple;
            padding: 10px;
        }

        ul {
            list-style: none;
            padding: 0;
            text-align: left;
        }

        ul li {
            background-color: purple;
            color: black;
            margin: 10px;
            padding: 10px;
        }

        ul li a {
            text-decoration: none;
            color: black;
        }

        ul li a:hover {
            background-color: black;
            color: purple;
        }
    </style>
</head>

<body>
    <h2>Você só pode doar se estiver logado</h2>
    <a href="login.php">Login</a>

    <ul>
<?php
include_once "conexao.php";

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

    </ul>

    <a href="default.php">Página Inicial</a>

</body>
</html>
