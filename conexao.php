<?php 

$usuario = "tonho";
$senha = "1234";
try{
$conn=new PDO('mysql:host=localhost;dbname=bara_bara','root','');

$conn -> SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
echo "conectado"."<br>";
} catch (PDOException $e){
     echo "erro".$e->getmessage();
}

?>
