<?php
require_once "./clases/Ovni.php";

$id =  isset($_POST['id']) ? $_POST['id'] : NULL;
$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : NULL;
$velocidad = isset($_POST['velocidad']) ? $_POST['velocidad'] : NULL;
$planeta = isset($_POST['planeta']) ? $_POST['planeta'] : NULL;



//obtengo nueva foto
$foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : NULL;

//obtengo extension de nueva foto
$extension = pathinfo($foto,PATHINFO_EXTENSION);

//obtengo el nombre a guardar de la nueva foto
$nombreAGuardar=$tipo . "." . $planeta . "." . date("Gis") . "." . $extension;//nuevaimagen

//obtengo el destino a guardar de la nueva foto
$destino = "imagenes/" . $nombreAGuardar;


$ovni= new Ovni($tipo,$velocidad,$planeta,$nombreAGuardar);

//obtengo instancia del ovni que vamos a modificar con sus valores "Originales"
$ovniAnterior = $ovni->TraerId($id);



//modifico el ovni
if($ovni->Modificar($id,$tipo,$velocidad,$planeta,$nombreAGuardar))
{
    //muevo la foto nueva a la carpeta de imagenes
    if(move_uploaded_file($_FILES['foto']["tmp_name"],$destino))
    {
        $ext = pathinfo($ovniAnterior->pathFoto,PATHINFO_EXTENSION);
        $date = date('Gis');
        $imagenModificada = $ovniAnterior->tipo.".".$ovniAnterior->planetaOrigen."."."modificado".".".$date.".".$ext; //Vieja


        //copio la imagen original anterior a la carpeta de "ovnisModificados"
        copy("./imagenes/".$ovniAnterior->pathFoto,"./ovnisModificados/".$imagenModificada);
        //elimino la imagen anterior ya que esta es reemplazada por la neuva que agregamos
        unlink("./imagenes/".$ovniAnterior->pathFoto);

        echo "ovni modificado";

        header('Location:Listado.php');
    }
}
else
{
    echo "No se pudo modificar";
}



?>