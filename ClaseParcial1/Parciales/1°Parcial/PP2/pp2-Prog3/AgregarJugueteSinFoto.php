<?php
require_once "./clases/Juguete.php";

$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : NULL;
$precio = isset($_POST['precio']) ? $_POST['precio'] : NULL;
$pais = isset($_POST['pais']) ? $_POST['pais'] : NULL;
$juguete = new Juguete($tipo,$precio,$pais);

if($juguete->Agregar())
{
    $ar = fopen("./archivos/juguetes_sin_foto.txt","a");
   if($ar != false)
   {
    $fecha = date("dnYGis");

    $cantidad=fwrite($ar,$juguete->ToString()."-".$fecha."\r\n");

     if($cantidad>0)
    { 
        $retorno =true;
        echo "Archivo cargado con exito";
    }

     fclose($ar);
   }
  
}
else
{
    echo "Error , info del juguete:<br>";
    echo $juguete->ToString();
}


?>