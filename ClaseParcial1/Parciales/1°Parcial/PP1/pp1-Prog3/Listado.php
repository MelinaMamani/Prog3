
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
                <td>Precio</td>
                <td>Pais</td>
                <td>Imagen</td>
            </tr>
        </thead>    
    <?php
    require_once "./clases/Televisor.php";
    $televisor = new Televisor();
    $arrayTele = $televisor->Traer();
    if($arrayTele!==null && count($arrayTele)!==0)
    {
        foreach($arrayTele as $tele)
        {
            echo "<tr>";

            echo "<td>";
            echo $tele->tipo;
            echo "</td>";

            echo "<td>";
            echo $tele->precio;
            echo "</td>";

            echo "<td>";
            echo $tele->paisOrigen;
            echo "</td>";

            echo "<td>";
            if($tele->path != "")
            {
                if(file_exists("imagenes/".$tele->path)) {
                    //echo '<img src="img/'.$jug->GetImagen().'" alt="'.$jug->GetImagen().'" height="100px" width="100px">'; 
                    echo '<img src="imagenes/'.$tele->path.'" alt=imagenes/"'.$tele->path.'" height="100px" width="100px">'; 
                  
                }
                else 
                {
                   echo 'no hay imagen '.$tele->path; 
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