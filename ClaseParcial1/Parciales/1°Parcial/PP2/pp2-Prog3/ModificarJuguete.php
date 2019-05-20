<?php

require_once "./clases/Juguete.php";

$id =  isset($_POST['id']) ? $_POST['id'] : NULL;
$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : NULL;
$precio = isset($_POST['precio']) ? $_POST['precio'] : NULL;
$pais = isset($_POST['pais']) ? $_POST['pais'] : NULL;

$id = isset($_POST['id']) ? $_POST['id'] :NULL;

//obtengo nueva foto
$foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : NULL;

//obtengo extension de nueva foto
$extension = pathinfo($foto,PATHINFO_EXTENSION);

//obtengo el nombre a guardar de la nueva foto
$nombreAGuardar=$tipo . "." . $pais . "." . date("Gis") . "." . $extension;//nuevaimagen

//obtengo el destino a guardar de la nueva foto
$destino = "imagenes/" . $nombreAGuardar;


$juguete= new Juguete($tipo,$precio,$pais,$nombreAGuardar);

//obtengo instancia del juguete que vamos a modificar con sus valores "Originales"
$jugueteAnterior = $juguete->TraerId($id);

//modifico el juguete
if($juguete->Modificar($id,$tipo,$precio,$pais,$nombreAGuardar))
{
    //muevo la foto nueva a la carpeta de imagenes
    if(move_uploaded_file($_FILES["foto"]["tmp_name"],$destino))
    {
        $ext = pathinfo($jugueteAnterior->GetImagen(),PATHINFO_EXTENSION);
        $date = date('Gis');
        $imagenModificada = $jugueteAnterior->GetTipo().".".$jugueteAnterior->GetPais()."."."modificada".".".$date.".".$ext; //Vieja


        //copio la imagen original anterior a la carpeta de "juguetesModificados"
        copy("./imagenes/".$jugueteAnterior->GetImagen(),"./juguetesModificados/".$imagenModificada);
        //elimino la imagen anterior ya que esta es reemplazada por la neuva que agregamos
        unlink("./imagenes/".$jugueteAnterior->GetImagen());

        echo "Juguete modificado";

       // header('Location:Listado.php');

        

    }
}
else
{
    echo "No se pudo modificar";
}


?>

