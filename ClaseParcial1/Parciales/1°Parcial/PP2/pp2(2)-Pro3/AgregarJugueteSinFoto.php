<?php
include_once "AccesoDatos.php"; //Se usa antes
include "Juguete.php";

$tipo = isset($_POST["tipo"])? $_POST["tipo"]:NULL;
$precio=isset($_POST["precio"])? $_POST["precio"]:NULL;
$pais = isset($_POST["paisOrigen"])? $_POST["paisOrigen"]:NULL;



if($tipo != NULL && $precio != NULL && $pais != NULL)
{
    $juguete = new Juguete($tipo,$precio,$pais);

    $respuesta = json_decode($juguete->Agregar());
    
    if($respuesta->Exito == TRUE)
    {
        //Guardo en el archivo
        $obj = new stdClass();
        $obj->Exito = TRUE;
        $obj->Mensaje = "";
        
        $date = date("his");

        $ar = fopen("./archivos/juguetes_sin_foto.txt","a"); //Agrego

        $ok = fwrite($ar,$date.$juguete->ToString()."\r\n");


        if($ok > 0)
        {
            $obj->Mensaje = "Se guardo en el archivo";
        }
        else
        {
            $obj->Exito = FALSE;
            $obj->Mensaje = "Error al guardar en el archivo";
        }
        fclose($ar);

        echo json_encode($obj); //JSON
    }
    else
    {
        echo "EL JUGUETE ES: ".$juguete->ToString();
    }
}
else
{
    echo("Ingrese datos primero!");
}
//ok

?>