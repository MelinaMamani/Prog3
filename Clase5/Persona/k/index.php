<?php 

require_once('Persona.php');

$yo = new Persona();
$yo->nombre = "Erika";
$yo->apellido = "Mamaní</br>";

if ($yo->Guardar()) {
    echo "Se guardó.\n";
} else {
    echo "No se guardó.\n";
}

$yo->Leer();


?>