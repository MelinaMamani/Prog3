<?php
require_once 'acceso.php';
$op = isset($_POST["op"]) ? $_POST["op"] : null;

switch ($op) {

    case "subirDatos":
        $nombre = $_POST['nombre'];
        $legajo = $_POST['legajo'];

        $objRetorno = new stdClass();
        $objRetorno->Ok = false;

        $destino = "./fotos/" . date("Ymd_His") . ".jpg";
        
        if(move_uploaded_file($_FILES["foto"]["tmp_name"], $destino) ){
            $objRetorno->Ok = true;
            $objRetorno->Path = $destino;
        }

        echo json_encode($objRetorno);

        $archivo = fopen("alumnos.txt","a");

        $cant = fwrite($archivo,$legajo."-".$nombre."-".$destino."\r\n");
        
        $objAcceso = acceso::DameUnObjetoAcceso();
        $consulta = $objAcceso->RetornarConsulta("INSERT INTO alumnos (legajo, nombre, foto)".
        " VALUES (:legajo, :nombre, :foto)");

        $consulta->bindValue(':legajo',$legajo,PDO::PARAM_INT);
        $consulta->bindValue(':nombre',$nombre,PDO::PARAM_STR);
        $consulta->bindValue(':foto',$destino,PDO::PARAM_STR);

        $consulta->execute();
        fclose($archivo);

        break;

    case 'mostrarListado':
        $objAcceso = Acceso::DameUnObjetoAcceso();
        $consulta = $objAcceso->RetornarConsulta("SELECT * FROM alumnos");
        $consulta->execute();
        $alumnos = $consulta->fetchAll();

        echo "<table border='1'>
        <tbody>
            <tr>
                <th>Nombre</th>
                <th>Legajo</th>
                <th>Foto</th>
            </tr>";
        foreach ($alumnos as $value) {
            $alumno = new stdClass();
            $alumno->nombre = $value['nombre'];
            $alumno->legajo = $value['legajo'];
            $alumno->foto = $value['foto'];
            echo "<tr><td>".$alumno->nombre."</td><td>".$alumno->legajo."</td><td><img src='./BACKEND/".$alumno->foto."' height='185px' width='200px'/></td><td><input type='button' value='X' onclick='Eliminar(".json_encode($alumno).")'></td></tr>";
        }
        echo "</tbody>
        </table>";
        break;
    default:
        echo ":(";
        break;
    }
?>