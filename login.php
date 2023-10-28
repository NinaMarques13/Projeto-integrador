<!DOCTYPE html>


<html>



<head>


</head>


<body>

<form action = "" method = "post">
    <input type = "text" name = "email">
    <input type ="password" name = "senha">
    <input type = "submit" name = "submit" value = "Entrar">
</form>


<?php

include_once "../Banco/conexao.php";

if(isset($_POST['submit']))

{
   if (($_POST['email'] == "") && ($_POST['senha'] == "")) {
         echo "digite seu email ou senha";
   } else {
    $email = $_POST['email'];
   $senha = $_POST['senha'];

   $sql = $conn->prepare("SELECT * FROM usuario
                         WHERE nm_email = :email AND nr_senha = :senha");
   $sql->bindValue(":email", $email);
   $sql->bindValue(":senha", $senha);
   $sql->execute();

   if ($sql->rowCount() == 0) {
         echo "E-mail Ou Senha Invalida, tente novamente";
    } else {
       $buscar = $sql->fetch();
       $id = $buscar['id_cadastro'];
       session_start();
       $_SESSION['login'] = $id;
       header('location:../Pos-Login/barabaraposlogin.php');

    }
   }



}

?>


</body>


</html>