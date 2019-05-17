<?php
$op = isset($_POST["op"]) ? $_POST["op"] : null;

switch ($op) {
    case 'agregarPerroJson':
    $objRetorno = new stdClass();
    $objRetorno->Ok = false;

    foreach ($objRetorno->perro as $value) {
        $nombre = $value->nombre;
        $raza = $value->raza;
        $edad = $value->edad;
        $tamanio = $value->tamanio;
        $precio = $value->precio;

        $destino = "./fotos/" .$nombre.".". date("Ymd_His") . ".jpg";
    
        $archivo = fopen("perros.json","a");

    if(move_uploaded_file($_FILES["foto"]["tmp_name"], $destino) ){
        $objRetorno->Ok = true;
        $objRetorno->Path = $destino;
        }

        $cant = fwrite($archivo,json_encode($objRetorno->perro));
    }

    echo json_encode($objRetorno);
    
    fclose($archivo);
    break;

    default:
        # code...
        break;
}

?>