<!DOCTYPE html>

<html>
 <head>
    <title>Como Doar</title>

    
 </head>

<body>

   <h1>Como Doar</h1>
     
    <form action = "" method="post">
        <input type = "text" name = "ocorrido" placeholder="descrição ocorrido">
        <input type = "number" name = "meta" placeholder="meta">
        <input type = "date" name = "data" placeholder="data">
        <input type = "time" name = "horas" placeholder="horário">
        <input type = "text" name = "cortesia" placeholder="cortesia">

        <input type = "submit" name = "publicar" value = "publicar">

</form>

        
     <?php
     include_once "../Banco/conexao.php";
     
      
        if (isset($_POST['publicar'])) {

        $meta = $_POST['meta'];
        $ocorrido = $_POST['ocorrido'];
        $data = $_POST['data'];
        $tempo = $_POST['horas'];
        $cortesia = $_POST['cortesia'];
        


        $sql = $conn->prepare("INSERT INTO `publicação` (`id_causa`, `qt_meta`, `ds_ocorrido`, `dt_date`, `hr_hora`, `ds_cortesia`) 
                               VALUES (NULL, '$meta', '$ocorrido', '$data', '$tempo', '$cortesia')");
   

                       

        $sql->execute();   

        if ($sql)
        {
         echo "publicação cadastrada";
        }                        


      }
   

      



     ?>
     <a href="../Trabalhobarabara/barabara.html"> Página Inicial</a>



</body>


 </html>
