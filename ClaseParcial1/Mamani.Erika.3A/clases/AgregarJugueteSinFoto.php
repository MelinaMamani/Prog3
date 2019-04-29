<?php

require_once './Juguete.php';

$_POST['tipo'] = "domino";
$_POST['precio'] = 60;
$_POST['paisOrigen'] = "chile";

$juguete = new Juguete($_POST['tipo'],$_POST['precio'],$_POST['paisOrigen']);

if ($juguete->Agregar()) {
        $archivo = fopen("./archivos/juguetes_sin_foto.txt","a");
        $cant = fwrite($archivo,date('l jS \of F Y h:i:s A')."///".$juguete->ToString()."\r\n");

        if ($cant > 0) {
            return true;
        }

        fclose($archivo);
        echo "Se escribió correctamente"
}
else {
    echo $juguete->ToString();
}

?>