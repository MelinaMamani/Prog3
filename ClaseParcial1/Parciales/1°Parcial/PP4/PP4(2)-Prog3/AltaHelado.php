<?php
require_once('Helado.php');
$archivoInfo = pathinfo($_FILES['foto']['name']);
if(isset($_POST['sabor']) && isset($_POST['precio']))
{ 
    $saborHelado=$_POST['sabor'];
    $saborPrecio=$_POST['precio'];
    $pathHelado="./heladosImagen/".$saborHelado.".".date("his").".".$archivoInfo['extension'];
    $archivo=fopen("./heladosArchivo/helados.txt","a");
    move_uploaded_file($_FILES['foto']['tmp_name'], $pathHelado);
    fwrite($archivo, trim($_POST['sabor'])."-".trim($_POST['precio'])."-".$pathHelado."\r\n"); 
    fclose($archivo);
    
}

?>