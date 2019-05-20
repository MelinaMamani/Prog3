<?php
if(isset($_POST['correo']) && isset($_POST['clave']))
{
    $archivo=fopen("./archivos/clientesActuales.txt","r");
    $seEncontro=false;

    while(!feof($archivo))
    {
        $arrayCliente=explode("-",fgets($archivo));
        if(trim($arrayCliente[0])!="")
        {
            if(trim($arrayCliente[1])==$_POST['correo'] && trim($arrayCliente['2'])==$_POST['clave'])
            {
                $seEncontro=true;
                echo "Cliente logeado, ".$arrayCliente[0];
                break;
            }
        }
           
    }
    if(!$seEncontro)
    echo "Cliente inexistente";
    fclose($archivo);
}

?>