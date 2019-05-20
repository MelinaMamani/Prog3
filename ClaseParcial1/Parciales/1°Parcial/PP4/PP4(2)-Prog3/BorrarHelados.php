<?php
require_once("Helado.php");
if(isset($_GET['sabor']))
{
    $arrayHelado=Helado::RetornarArrayArchivo();
    foreach($arrayHelado as $helado)
    {
        if($_GET['sabor']==$helado->GetSabor())
        {
            echo "El helado esta en el archivo.";
            break;
        }
    }
}
else if(isset($_POST['sabor']) && isset($_POST['queDeboHacer']))
{
    if($_POST['queDeboHacer']=="borrar")
    {
        $arrayHelado=Helado::RetornarArrayArchivo();
        $heladoComparar;
        foreach($arrayHelado as $helado)
        {
            if($_POST['sabor']==$helado->GetSabor())
            {
                $heladoComparar=new Helado($helado->GetSabor(),$helado->GetPrecio());
                $heladoComparar->SetPath($helado->GetPath());
                break;
            }
        }
        $indice = array_search($heladoComparar,$arrayHelado);
        if($indice ===false)
        {
            echo "No se encontro el helado a borrar";
        }
        else
        {
            move_uploaded_file($arrayHelado[$indice]->GetPath(),"./heladosBorrados/".$arrayHelado[$indice]->GetSabor().".borrado.".$arrayHelado[$indice]->GetPrecio());
            unset($arrayHelado[$indice]);
        }
        $archivo=fopen("./heladosArchivo/helados.txt","w");
        foreach($arrayHelado as $hel)
        {  
            fwrite($archivo, $hel->GetSabor()."-".$hel->GetPrecio()."-".$hel->GetPath()."\r\n"); 
        }
        fclose($archivo);
        


        
        

    }
}

?>