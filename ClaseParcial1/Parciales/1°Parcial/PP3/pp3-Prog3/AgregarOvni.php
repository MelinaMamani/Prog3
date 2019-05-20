<?php
require_once "./clases/Ovni.php";

$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : NULL;
$velocidad = isset($_POST['velocidad']) ? $_POST['velocidad'] : NULL;
$planeta = isset($_POST['planeta']) ? $_POST['planeta'] : NULL;

$foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : NULL;

$ovni = new Ovni($tipo,$velocidad,$planeta,$foto);

$arrayOvnis= $ovni->Traer();

if($ovni->Existe($arrayOvnis))
{
    echo "El ovni ya existe en la base de datos";

}
else
{
    $extension = pathinfo($foto,PATHINFO_EXTENSION);

    $nombreAGuardar=$tipo . "." . $planeta . "." . date("Gis") . "." . $extension;

    $destino = "imagenes/" . $nombreAGuardar;

    $ovniFinal = new Ovni($tipo,$velocidad,$planeta,$nombreAGuardar);
   
    if($ovniFinal->Agregar())
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


?>