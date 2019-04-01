<?php

$cadena = "Erika Mamaní "+date('l jS \of F Y h:i:s A')+"\n\r";

$archivo = fopen("archivo.txt","a");

$cant = fwrite($archivo,$cadena);

if ($cant > 0) {
    echo "Se sobreescribió";
}

fclose($archivo);

?>