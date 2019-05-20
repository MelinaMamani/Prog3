<?php
require_once('Helado.php');
$archivoInfo = pathinfo($_FILES['foto']['name']);
if(isset($_POST['sabor']) && isset($_POST['precio']))
{ 
    $saborHelado=$_POST['sabor'];
    $saborPrecio=$_POST['precio'];
    $pathHelado="./heladosImagen/".$saborHelado.".".date("his").".".$archivoInfo['extension'];
    
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
            
            unset($arrayHelado[$indice]);
            unlink($arrayHelado[$indice]->GetPathFoto());
            move_uploaded_file($_FILES['foto']['tmp_name'], $pathHelado);
        }
        $archivo=fopen("./heladosArchivo/helados.txt","w");
        foreach($arrayHelado as $hel)
        {  
            fwrite($archivo, $hel->GetSabor()."-".$hel->GetPrecio()."-".$hel->GetPath()."\r\n"); 
        }
       
        fclose($archivo);
}
?>