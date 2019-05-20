<?php

require_once "./clases/Televisor.php";

$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : NULL;
$precio = isset($_POST['precio']) ? $_POST['precio'] : NULL;
$pais = isset($_POST['pais']) ? $_POST['pais'] : NULL;
$televisor = new Televisor($tipo,$precio,$pais);

$objJson= new stdClass();
$objJson->Exito=false;
$objJson->Mensaje="No se pudo agregar";

if($televisor->Agregar())
{
    $objJson->Exito=true;
    $objJson->Mensaje="Se pudo agregar en base de datos";
}

echo json_encode($objJson);

?>