<?php
include_once "../Banco/conexao.php";

$querylistagem = "SELECT user.nm_usuario, publi.ds_ocorrido, publi.qt_meta, publi.dt_date, publi.hr_hora, publi.ds_cortesia 
                  FROM publicação AS publi
                  INNER JOIN usuario AS user ON publi.usuariopostagem_id = user.id_cadastro
                  ORDER BY publi.dt_date ASC";
$listagembanco = $conn->prepare($querylistagem);
$listagembanco->execute();

while ($rowlistagem = $listagembanco->fetch(PDO::FETCH_ASSOC)) 
{
     //print_r($rowlistagem);
     extract($rowlistagem);
     echo "Usuário: $nm_usuario"."<br>";
     echo "Descrição Ocorrido: $ds_ocorrido"."<br>";
     echo "Meta Quantia: $qt_meta"."<br>";
     echo "Data Publicação: $dt_date"."<br>";
     echo "Horário Da Postagem: $hr_hora"."<br>";
     echo "Cortesia: $ds_cortesia"."<br>";




     


}






?>