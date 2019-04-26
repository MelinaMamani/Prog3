<?php

if ($_GET["devolver"] == 1) {
    $archivo = fopen("remeras.json","r");
        
        $archivoCompleto = fread($archivo,filesize("remeras.json"));
        $arrayObj = json_decode($archivoCompleto);
        echo "<table border='1'>
        <tbody>
        <tr>
            <th>
                Remeras
            </th>
        </tr>";
        foreach ($arrayObj as $remera) {
            echo "<tr>
            <td>".$remera->id."</td>
            <td>".$remera->slogan."</td>
            <td>".$remera->size."</td>
            <td>".$remera->price."</td>
        </tr>";
        }
        echo "</tbody>
        </table>";
}

?>