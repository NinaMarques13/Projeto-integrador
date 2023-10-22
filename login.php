<form action="login.php" method="post">
    <input type="text" name="user"
    placeholder="Usuário"/><br/>
    <input type="password" name="pw"
    placeholder="Senha"/><br/>
    <input type="submit" name="logar" 
    value="Logar"/>
</form>
<?php 
include "conexao.php";
if(isset($_POST['logar'])){
    $user=$_POST['user'];
    $pw=$_POST['pw'];
    $login=$conn->prepare('SELECT * FROM `usuario` 
    WHERE `nm_email` = :user AND `nr_senha`=:pw');
    $login->bindValue(":user", $user);
    $login->bindValue(":pw", $pw);
    $login->execute();
    if($login->rowCount()==0){
        echo "Login ou senha inválida!";
    }else{
        $cons=$login->fetch();
        $id=$cons['id_log'];
        session_start();
        $_SESSION['login']=$id;
        header("location: index.php");
    }
}
