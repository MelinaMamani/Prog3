<?php
require_once "./clases/Ovni.php";

$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : NULL;
$velocidad = isset($_POST['velocidad']) ? $_POST['velocidad'] : NULL;
$planeta = isset($_POST['planeta']) ? $_POST['planeta'] : NULL;
$ovni = new Ovni($tipo,$velocidad,$planeta);

$objJson= new stdClass();
$objJson->Exito=false;
$objJson->Mensaje="No se pudo agregar";

if($ovni->Agregar())
{
    $objJson->Exito=true;
    $objJson->Mensaje="Se pudo agregar en base de datos";
}

echo json_encode($objJson);

?>