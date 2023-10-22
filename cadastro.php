<!DOCTYPE html>

<html> 

<head> 



</head>


<body> 

<form action = "" method = "post">
    <h1> Cadastro </h1><br>
  Digite seu nome  <input type = "text" name = "nome"><br>
  Digite seu CPF/CNPJ  <input type = "number" name = "cpf"><br>
  Cadastre sua senha  <input type = "password" name = "senha"><br>
  Cadastre seu email  <input type = "text" name = "email"><br>
  <input type = "submit" name = "cadastrar" value = "Entrar">
</form>



<?php
include_once "conexao.php";

if (isset($_POST['cadastrar'])){

  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $cpf = $_POST['cpf'];
  $senha = $_POST['senha'];

  $sql = $conn->prepare("INSERT INTO usuario(id_cadastro, nm_usuario, nm_email, nr_cpf, nr_senha)
               VALUE (NULL, '$nome','$email','$cpf','$senha')");
  $sql->execute();

  
  if($sql)
  {
    echo "<br>"."cadastrado com sucesso";
  } 





}



?>

</body>

</html> 
