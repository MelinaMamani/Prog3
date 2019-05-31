<?php

require_once "AccesoDatos.php";

$obj = new stdClass();

$obj->exito = true;

$cadenaJSON = isset($_POST['cadenaJson']) ? $_POST['cadenaJson'] : null;

$objJson = json_decode($cadenaJSON);    

$objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();

try
{
    echo $objJson->nombre;
    $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM 'perros' WHERE 'raza' = $objJson->raza AND 'nombre' = $objJson->nombre");

    $consulta->execute();
}

catch(PDOException $e)
        {
            $obj->exito = false;
            $obj->mensaje = $e->getMessage();
        }
        
        echo json_encode($obj);

//unlink("fotos/".$objJson->pathFoto);
?>