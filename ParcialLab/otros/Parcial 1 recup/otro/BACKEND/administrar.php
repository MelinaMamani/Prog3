<?php
$caso = isset($_POST["caso"]) ? $_POST["caso"] : null;

sleep(1);

switch ($caso) {

    case 'agregar':

        $cadenaJSON = isset($_POST['cadenaJson']) ? $_POST['cadenaJson'] : null;

        $ar = fopen("./camperas.json", "a");

        $cant = fwrite($ar, $cadenaJSON . "\r\n");

        fclose($ar);

        $resultado["TodoOK"] = $cant > 0 ? true : false;

        echo json_encode($resultado);
        break;

    case 'mostrar':

        $a = fopen("./camperas.json", "r");

        $string = "";

        while (!feof($a)) {

            $linea = trim(fgets($a));

            if (strlen($linea) > 0)
                $string .= $linea . ',';
        }

        fclose($a);

        $string = substr($string, 0, strlen($string) - 1);

        echo ('[' . $string . ']');

        break;

    case 'eliminar':

        $cadenaJSON = isset($_POST['cadenaJson']) ? $_POST['cadenaJson'] : null;
        $obj = json_decode($cadenaJSON);
        $a = fopen("./camperas.json", "r");
        $string = '';

        while (!feof($a)) {
            $linea = trim(fgets($a));

            if (strlen($linea) > 0) {
                $vec = explode(":", $linea);
                $codigo = $vec[6];
                if ($codigo == $obj->codigo) {
                    continue; 
                }
                $string .= $linea . "\r\n";
            }
        }

        fclose($a);

        $objRetorno = new stdClass();
        $objRetorno->TodoOK = true;

        $a = fopen("./camperas.json", "w");

        $cant = fwrite($a, $string);

        fclose($a);

        if ($cant < 1) {
            $objRetorno->TodoOK = false;
        }

        echo json_encode($objRetorno);

        break;

    case 'modificar':

        $cadenaJSON = isset($_POST['cadenaJson']) ? $_POST['cadenaJson'] : null;
        $obj = json_decode($cadenaJSON);
        $a = fopen("./camperas.json", "r");

        $string = '';

        while (!feof($a)) {
            $linea = trim(fgets($a));

            if (strlen($linea) > 0) {
                $vec = explode(":", $linea);
                $codigo = $vec[6];
                if ($codigo == $obj->codigo) {
                    continue;
                }
                $string .= $linea . "\r\n";
            }
        }

        $string .= $cadenaJSON . "\r\n";

        fclose($a);

        $objRetorno = new stdClass();
        $objRetorno->TodoOK = true;

        $a = fopen("./camperas.json", "w");

        $cant = fwrite($a, $string);

        fclose($a);

        if ($cant < 1) {
            $objRetorno->TodoOK = false;
        }

        echo json_encode($objRetorno);

        break;

    case "colores":

        $a = fopen("./colores.json", "r");
        $colores = fread($a, filesize("./colores.json"));
        fclose($a);

        echo ($colores);

        break;

    case "subirFoto":
        $objRetorno = new stdClass();
        $objRetorno->Ok = false;

        $destino = "./fotos/" . $_POST['codigo'] . ".jpg";
        
        if(move_uploaded_file($_FILES["foto"]["tmp_name"], $destino) ){
            $objRetorno->Ok = true;
            $objRetorno->Path = $destino;
        }

        echo json_encode($objRetorno);

    break;
    case "modificarFoto":
        $objRetorno = new stdClass();
        $objRetorno->Ok = false;

        $destino = "./fotos/modificadas" . $_POST['codigo'] . ".jpg";
        
        if(move_uploaded_file("./fotos/".$_POST['codigo'].".jpg", $destino) ){
            $objRetorno->Ok = true;
            $objRetorno->Path = $destino;
        }

        echo json_encode($objRetorno);

    break;

    case "eliminarFoto":
        $objRetorno = new stdClass();
        $objRetorno->Ok = false;

        $destino = "./fotos/eliminadas/" . $_POST['codigo'] . ".jpg";
        
        if(move_uploaded_file("./fotos/".$_POST['codigo'].".jpg", $destino) ){
            $objRetorno->Ok = true;
            $objRetorno->Path = $destino;
        }

        echo json_encode($objRetorno);

    break;
    default:
        echo ":(";
        break;
}