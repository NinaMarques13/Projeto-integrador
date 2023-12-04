<?php 

$usuario = "root";
$senha = "";
try{
$conn=new PDO('mysql:host=localhost;dbname=u769877498_barabara', 'u769877498_bancobarabara', '684235791Gui');

$conn -> SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
     echo "erro".$e->getmessage();
}



?>
