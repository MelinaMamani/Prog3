<?php

$archivoL = fopen("archivo.txt","r");

$lectura = fread($archivoL,filesize("archivo.txt"));

echo $lectura;

fclose($archivoL);

?>