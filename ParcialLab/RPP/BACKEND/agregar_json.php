<?php

$cadenaJSON = isset($_POST['cadenaJson']) ? $_POST['cadenaJson'] : null;

$objJson = json_decode($cadenaJSON);    

$extension = pathinfo($_FILES["foto"]["name"],PATHINFO_EXTENSION);
$fecha=date("Gis");
$destino = "fotos/". $objJson->nombre ."." . $fecha. "." . $extension;

$objJson->pathFoto=$destino;

$objJson2=json_decode($cadenaJSON);  
$objJson2->pathFoto=   $objJson->nombre ."." . $fecha. "." . $extension;
$cadenaJSON2=json_encode($objJson2);

$ar = fopen("./perro.json", "a");

$cant = fwrite($ar, $cadenaJSON2 . "\r\n");

fclose($ar);

$objRetorno= new stdClass();

$objRetorno->Ok= false; 
$objRetorno->pathFoto=$destino;


if(move_uploaded_file($_FILES["foto"]["tmp_name"],$objJson->pathFoto))
{
    $objRetorno->Ok=true;

}

echo json_encode($objRetorno);


?>