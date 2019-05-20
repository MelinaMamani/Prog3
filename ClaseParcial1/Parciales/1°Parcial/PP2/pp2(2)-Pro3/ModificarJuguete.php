<?php
include_once "AccesoDatos.php";
include "Juguete.php";
$tipo = isset($_POST["tipo"])? $_POST["tipo"]:NULL;
$precio=isset($_POST["precio"])? $_POST["precio"]:NULL;
$pais = isset($_POST["paisOrigen"])? $_POST["paisOrigen"]:NULL;

$id = isset($_POST["id"])? $_POST["id"]:NULL; //Se usa para modificar dato específico

$archivo = isset($_FILES['foto']['tmp_name'])? $_FILES['foto']['tmp_name']:NULL;

$extension = pathinfo($_FILES["foto"]["name"],PATHINFO_EXTENSION);
$nombreArchivo = "$tipo.$pais." . date('Gis') .".". $extension; //Nuevo
$destino = "./juguetes/imagenes/$nombreArchivo";


$juguetes = Juguete::Traer(); //Para recuperar el path

foreach($juguetes as $l)
    {
        if($l['id'] == $id) //Para recuperar el path
        {
            $ext = pathinfo($l['foto'],PATHINFO_EXTENSION);
            $date = date('Gis');
            $imagenModificada = $l['tipo'].".".$l['pais']."."."modificada".".".$date.".".$ext; //Vieja
            
            if(move_uploaded_file($archivo, $destino))
            {
                Juguete::Modificar($id,$tipo,$precio,$pais,$nombreArchivo); 
                # el path debe de recuperarse desde la bd para saber qué mover y eliminar
                copy("./juguetes/imagenes/".$l['foto'],"./juguetesModificados/".$imagenModificada);
                unlink("./juguetes/imagenes/".$l['foto']);

                header("Location: ./Listado.php");
            }
            else
            {
                echo("NO SE PUDO MODIFICAR DATOS");
            }
        }
        
    }
    echo "EL JUGUETE A MADIFICAR NO EXISTE";

//ok
?>