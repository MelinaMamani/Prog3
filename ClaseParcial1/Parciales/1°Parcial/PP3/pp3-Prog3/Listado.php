
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Listado</title>
</head>
<body>
    <div>
    <table border=1>
        <thead>
            <tr>
                <td>Tipo</td>
                <td>Velocidad</td>
                <td>Velocidad Warp</td>
                <td>Planeta</td>
                <td>Imagen</td>
            </tr>
        </thead>    
    <?php
    require_once "./clases/Ovni.php";
    $ovni = new Ovni();
    $arrayOvni = $ovni->Traer();
    if($arrayOvni!==null && count($arrayOvni)!==0)
    {
        foreach($arrayOvni as $ov)
        {
            echo "<tr>";

            echo "<td>";
            echo $ov->tipo;
            echo "</td>";

            echo "<td>";
            echo $ov->velocidad;
            echo "</td>";
           
            echo "<td>";
            echo $ov->ActivarVelocidadWarp();
            echo "</td>";

            echo "<td>";
            echo $ov->planetaOrigen;
            echo "</td>";

            echo "<td>";
            if($ov->pathFoto != "")
            {
                if(file_exists("imagenes/".$ov->pathFoto)) {
                    //echo '<img src="img/'.$jug->GetImagen().'" alt="'.$jug->GetImagen().'" height="100px" width="100px">'; 
                    echo '<img src="imagenes/'.$ov->pathFoto.'" alt=imagenes/"'.$ov->pathFoto.'" height="100px" width="100px">'; 
                  
                }
                else 
                {
                   echo 'no hay imagen '.$ov->pathFoto; 
                }
            }
            echo "</td>";

            echo "</tr>";
            
        }
    }
    ?>
    </table>
</div>
 
    
</body>
</html>