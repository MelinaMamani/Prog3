<?php
//echo "Hola mundo";

if ($_GET["accion"] == 1) {
    echo $_GET["nombre"];
}

elseif ($_GET["accion"] == 2) {
    $archivo = fopen("nombres.txt","a");

    $cant = fwrite($archivo,$_GET["nombre"]."\r\n");

    if ($cant > 0) {
        echo "1";
    }
    else {
        echo "0";
    }

    fclose($archivo);
}

elseif ($_GET["accion"] == 3) {
    $archivo = fopen("nombres.txt","r");
        $ingresantes[] = array();
        
        while (!(feof($archivo))) {
            $linea = fgets($archivo);
            $nombre = trim($linea);
            array_push($ingresantes,$nombre);
        }
        
        echo "<table border='1'>
        <tbody>
            <th>
                Nombres
            </th>";
        foreach ($ingresantes as $ingresante) {
            echo "<tr>
            <td>".$ingresante."</td>
        </tr>";
        }
        echo "</tbody>
        </table>";
}

elseif ($_GET["accion"]==4) {
    # buscar el nombre por param en a lista y mostrar en index 1 o 0 (verificado o no)
}
?>