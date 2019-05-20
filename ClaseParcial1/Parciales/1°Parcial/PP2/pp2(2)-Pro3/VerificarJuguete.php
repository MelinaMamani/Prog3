<?php 
include_once "AccesoDatos.php"; //Se usa antes
include "Juguete.php";

$tipo = $_GET["tipo"];
$pais = $_GET["paisOrigen"];

$existeTipo = FALSE;
$existePais = FALSE;

$aux = Juguete::Traer();
//var_dump($aux);

foreach($aux as $a)
{
    if($a['tipo'] == $tipo)
    {
        $existeTipo = TRUE;        
    }
    if($a['pais'] == $pais)
    {
        $existePais = TRUE;
        $juguete = new Juguete($a['tipo'],$a['precio'],$a['pais'],$a['foto']); 
    }
}

if($existePais == TRUE && $existeTipo == TRUE)
{
    echo(trim($juguete->ToString()." ".$juguete->CalcularIVA()));
}

if($existePais == TRUE && $existeTipo == FALSE)
{
    echo("NO COINCIDE EL TIPO");
}

if($existePais == FALSE && $existeTipo == TRUE)
{
    echo("NO COINCIDE EL PAIS");
}

if($existePais == FALSE && $existeTipo == FALSE)
{
    echo("NO COINCIDEN NI PAIS NI TIPO");
}

//ok
?>