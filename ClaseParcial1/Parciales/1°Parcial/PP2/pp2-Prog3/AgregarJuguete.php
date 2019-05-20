<?php
require_once "./clases/Juguete.php";

$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : NULL;
$precio = isset($_POST['precio']) ? $_POST['precio'] : NULL;
$pais = isset($_POST['pais']) ? $_POST['pais'] : NULL;

$foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : NULL;

$juguete= new Juguete($tipo,$precio,$pais,$foto);

if($juguete->Verificar($juguete->Traer()))
{
    $extension = pathinfo($foto,PATHINFO_EXTENSION);

    $nombreAGuardar=$juguete->GetTipo() . "." . $juguete->GetPais() . "." . date("Gis") . "." . $extension;

    $destino = "imagenes/" . $juguete->GetTipo() . "." . $juguete->GetPais() . "." . date("Gis") . "." . $extension;

    $jugueteFinal = new Juguete($tipo,$precio,$pais,$nombreAGuardar);
   
    if($jugueteFinal->Agregar())
    {
        
        if(move_uploaded_file($_FILES["foto"]["tmp_name"],$destino))
        {
            header('Location:Listado.php');
            
 
        }
        else
        {
            echo "no se pudo agregar la foto";
        }
        
    }
    else
    {
        echo "no se pudo agregar en la base de datos";
    }
   

}
else
{
    echo "el juguete ya existe en la base de datos";
}
?>