<?php
require_once("Persona.php");
//var_dump($_GET);
$yo = new Persona();
$yo->nombre = $_GET['nombre'];
$yo->apellido = $_GET['apellido'];

if ($yo->Guardar()) {
    echo "Se guardó.</br>";
} else {
    echo "No se guardó.\n";
}

$yo->Leer();
//die();
?>