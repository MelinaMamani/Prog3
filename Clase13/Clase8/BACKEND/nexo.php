<?php
require_once 'acceso.php';
$op = isset($_POST["op"]) ? $_POST["op"] : null;

switch ($op) {

    case "subirDatos":
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $sexo = $_POST['sexo'];
        $sueldo = $_POST['sueldo'];
        $legajo = $_POST['legajo'];

        $objRetorno = new stdClass();
        $objRetorno->Ok = false;

        $destino = "./fotos/" . date("Ymd_His") . ".jpg";
        
        if(move_uploaded_file($_FILES["foto"]["tmp_name"], $destino) ){
            $objRetorno->Ok = true;
            $objRetorno->Path = $destino;
        }

        echo json_encode($objRetorno);

        $archivo = fopen("empleados.txt","a");

        $cant = fwrite($archivo,$legajo."-".$nombre."-".$apellido."-".$sexo."-".$sueldo."-".$destino."\r\n");
        
        $objAcceso = acceso::DameUnObjetoAcceso();
        $consulta = $objAcceso->RetornarConsulta("INSERT INTO empleados (legajo, nombre, apellido, sexo, sueldo, foto)".
        " VALUES (:legajo, :nombre, :apellido, :sexo, :sueldo, :foto)");

        $consulta->bindValue(':legajo',$legajo,PDO::PARAM_INT);
        $consulta->bindValue(':nombre',$nombre,PDO::PARAM_STR);
        $consulta->bindValue(':apellido',$apellido,PDO::PARAM_STR);
        $consulta->bindValue(':sexo',$sexo,PDO::PARAM_STR);
        $consulta->bindValue(':sueldo',$sueldo,PDO::PARAM_INT);
        $consulta->bindValue(':foto',$destino,PDO::PARAM_STR);

        $consulta->execute();
        fclose($archivo);

        break;

    case 'mostrarListado':
        $objAcceso = Acceso::DameUnObjetoAcceso();
        $consulta = $objAcceso->RetornarConsulta("SELECT * FROM empleados");
        $consulta->execute();
        $empleados = $consulta->fetchAll();

        echo "<table border='1'>
        <tbody>
            <tr>
                <th>Legajo</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Sexo</th>
                <th>Sueldo</th>
                <th>Foto</th>
            </tr>";
        foreach ($empleados as $value) {
            $empleado = new stdClass();
            $empleado->legajo = $value['legajo'];
            $empleado->nombre = $value['nombre'];
            $empleado->apellido = $value['apellido'];
            $empleado->sexo = $value['sexo'];
            $empleado->sueldo = $value['sueldo'];
            $empleado->foto = $value['foto'];
            echo "<tr>
            <td>".$empleado->legajo."</td>
            <td>".$empleado->nombre."</td>
            <td>".$empleado->apellido."</td>
            <td>".$empleado->sexo."</td>
            <td>".$empleado->sueldo."</td>
            <td><img src='./BACKEND/".$empleado->foto."' height='185px' width='200px'/></td>
            <td><input type='button' value='X' onclick='Eliminar(".json_encode($empleado).")'></td>
            </tr>";
        }
        echo "</tbody>
        </table>";
        break;
    case 'eliminarEmpleado':
        
        break;
    default:
        echo ":(";
        break;
    }
?>