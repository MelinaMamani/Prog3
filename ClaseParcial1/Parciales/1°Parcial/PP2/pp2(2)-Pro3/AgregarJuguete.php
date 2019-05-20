<?php
include_once "AccesoDatos.php";
require_once "Juguete.php";

$tipo = isset($_POST["tipo"])? $_POST["tipo"]:NULL;
$precio=isset($_POST["precio"])? $_POST["precio"]:NULL;
$pais = isset($_POST["paisOrigen"])? $_POST["paisOrigen"]:NULL;


$extension = pathinfo($_FILES["foto"]["name"],PATHINFO_EXTENSION);
$archivo = isset($_FILES['foto']['tmp_name'])? $_FILES['foto']['tmp_name']:NULL;

$nombreArchivo = "$tipo.$pais." . date('Gis') .".". $extension;
$destino = "./juguetes/imagenes/$nombreArchivo";


$array = Juguete::Traer();

if($precio != NULL && $pais != NULL && $tipo != NULL && $archivo != NULL)
{
    $juguete = new Juguete($tipo, $precio, $pais,$nombreArchivo);
    if($juguete->Verificar($array))
    {
        $res= json_decode($juguete->Agregar());

        if($res->Exito == TRUE)
        {
            if(move_uploaded_file($archivo, $destino))
            {
        
                header("Location: ./Listado.php");
            }
            else
            {
                echo("OCURRIO UN ERROR CON LA SUBIDA DE IMAGEN");
            }
        }
        echo "EEROR, NO SE PUDO AGREGAR EL PRODUCTO";
        
    }
    else
    {
        echo("EL JUGUETE YA EXISTE");
    }
}
//ok



?>