<?php

$nombre = "Erika Mamaní\n";

$archivo = fopen("archivo.txt","w");

$cant = fwrite($archivo,$nombre);

if ($cant > 0) {
    echo "Se creó el archivo";
}
fclose($archivo);
?>