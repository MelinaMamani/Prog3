<?php

require_once "./clases/Juguete.php";

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : NULL;
$pais = isset($_GET['pais']) ? $_GET['pais'] : NULL;


$flag=false;

$juguete= new Juguete("a","3","00");
$arrayJuguetes = $juguete->Traer();

foreach($arrayJuguetes as $jug)
{
    if($jug->GetTipo()== $tipo && $jug->GetPais()==$pais)
    {
        echo $jug->ToString() ."precio(iva): " . $jug->CalcularIva();
        $flag=true;
        break;

    }
}
if($flag==false)
{
    $tipoComp=false;
    $paisComp=false;
    foreach($arrayJuguetes as $jug)
    {
    if($jug->GetTipo()== $tipo)
    {
       $tipoComp=true;
    }
    if($jug->GetPais()== $pais)
    {
        $paisComp=true;

    }
    }

    if($tipoComp ==false && $paisComp ==false)
    {
        echo "no coincide ni tipo ni pais";
    }
    if($tipoComp==true)
    {
       echo "solo coincide el tipo";
    }
    if($paisComp==true)
    {
      echo "solo coincide el pais";
    }
}

?>