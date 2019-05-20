<?php
require_once("Helado.php");
if(isset($_GET['sabor']) && isset($_GET['cantidad']))
{
    $arrayHelados=Helado::RetornarArrayDeHelados();
    $seEncontro=false;
    foreach($arrayHelados as $hel)
    {
        if($hel->GetSabor()==$_GET['sabor'])
        {
            $seEncontro=true;
           echo "Sabor:".$_GET['sabor']." Cantidad: ".$_GET['cantidad']."</br>"."Precio con IVA incluido:".$hel->PrecioMasIva($_GET['cantidad']);
        }
    }
    if(!$seEncontro)
    echo "No se encontro el sabor de helado";
}
?>