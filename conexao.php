<?php 

$usuario = "tonho";
$senha = "1234";
try{
$conn=new PDO('mysql:host=localhost;dbname=test', $usuario, $senha);

$conn -> SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
echo "conectado";
} catch (PDOException $e){
     echo "erro".$e->getmessage();
}

?>
