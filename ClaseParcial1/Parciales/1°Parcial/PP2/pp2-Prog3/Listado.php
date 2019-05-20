
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
    require_once "./clases/Juguete.php";
    $juguete = new Juguete("h","o","g");
    $arrayJuguete = $juguete->Traer();
    if($arrayJuguete!==null && count($arrayJuguete)!==0)
    {
        foreach($arrayJuguete as $jug)
        {
            echo "<tr>";

            echo "<td>";
            echo $jug->GetTipo();
            echo "</td>";

            echo "<td>";
            echo $jug->GetPrecio();
            echo "</td>";

            echo "<td>";
            echo $jug->GetPais();
            echo "</td>";

            echo "<td>";
            if($jug->GetImagen() != "")
            {
                if(file_exists("imagenes/".$jug->GetImagen())) {
                    //echo '<img src="img/'.$jug->GetImagen().'" alt="'.$jug->GetImagen().'" height="100px" width="100px">'; 
                    echo '<img src="imagenes/'.$jug->GetImagen().'" alt=imagenes/"'.$jug->GetImagen().'" height="100px" width="100px">'; 
                  
                }
                else 
                {
                   echo 'no hay imagen'.$jug->GetImagen(); 
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