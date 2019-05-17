<?php
require "./clases/Empleado.php";

$op = isset($_POST["op"]) ? $_POST["op"] : null;


switch ($op) {

    case "subirFoto":

    $objRetorno= new stdClass();

    $objRetorno->Ok= false;
    
    $extension=pathinfo($_FILES["foto"]["name"],PATHINFO_EXTENSION);
    
    
    //voy a obtener el dato de destino de imagen
    $destino ="fotos_empleados/" .$_POST["numLegajo"] ."_" . $_POST["txtApellido"] . "." .$extension;
    
    $empleado = new Empleado($_POST["numLegajo"],$_POST["txtApellido"],$_POST["txtNombre"],$_POST["numSueldo"],$destino);

    //agrego empleado al archivo de texto
    Empleado::Agregar($empleado);
    
    //agrego la foto del empleado a la carpeta de foto_empleados
    if(move_uploaded_file($_FILES["foto"]["tmp_name"],$destino))
    {
        $objRetorno->Ok=true;
        $objRetorno->Path=$destino;
        $objRetorno->nombre=$_POST["txtNombre"];
        $objRetorno->apellido=$_POST["txtApellido"];
        $objRetorno->legajo=$_POST["numLegajo"];
        $objRetorno->sueldo=$_POST["numSueldo"];
    }
    //retorno un objeto de tipo JSON en formato cadena para que puede recibirse desde el lado de typescript
    echo json_encode($objRetorno);
        break;

    case 'mostrarListado':
    $tabla ="";
    $tabla.= "<table border=1>";
    $tabla.= "<thead>";
    $tabla.= "<tr>";
    $tabla.= "<td>Nombre</td>";
    $tabla.= "<td>Legajo</td>";
    $tabla.= "<td>Foto</td>";
    $tabla.= "<td>Accion</td>";
    $tabla.= "</tr>";
    $tabla.= "</thead>";
   // $empleado= new Empleado("as","as","g","t","t");
    //$arrayEmpleados = $empleado->TraerTodos();
    $arrayEmpleados = Empleado::TraerTodos();
    if($arrayEmpleados!==null && count($arrayEmpleados)!==0)
    {
        foreach($arrayEmpleados as $emp)
        {
           
            $tabla.= "<tr>";

            $tabla.= "<td>";
            $tabla.= $emp->nombre;
            $tabla.= "</td>";

            $tabla.= "<td>";
            $tabla.= $emp->legajo;
            $tabla.= "</td>";

            $tabla.= "<td>";
            if($emp->path_foto!= "")
            {
                //me fijo que el path de la foto exista
                if(file_exists($emp->path_foto))
                {
                 //si existe mostramos la foto que esta guardada en ese path
                    $tabla.= '<img src=./BACKEND/'.$emp->path_foto.'  alt="'.$emp->path_foto.'" height="100px" width="100px">'; 
                   
                }
               else {
                $tabla.= 'no hay imagen '.$emp->path_foto; 
                }
            }
            $tabla.= "</td>";

            $JsonRetorno = new stdClass();
            $JsonRetorno->nombre= $emp->nombre;
            $JsonRetorno->apellido=$emp->apellido;
            $JsonRetorno->legajo = $emp->legajo;
            $JsonRetorno->sueldo=$emp->sueldo;
            $JsonRetorno->path_foto=$emp->path_foto;


            $cadenaEmpleado = json_encode($JsonRetorno);

            //a el objeto que se encuentra en esa tabla lo enviamos por json a typescript para dar la opcion de eliminarlo
            $tabla.= "<td><input type='button' onclick='Eliminar(".($cadenaEmpleado).")' value='Eliminar'</td>";


            //a el objeto que se encuentra en esa tabla lo enviamos por json a typescript para mostrarlo en los campos
            $tabla.= "<td><input type='button' onclick='Modificar(".($cadenaEmpleado).")' value='Modificar'</td>";


            $tabla.= "</tr>";
            
        }
        $tabla.= "</table>";
        echo $tabla;
    }
        break;

    case 'Eliminar':
    //si desde json se decide eliminar un usuario , se envia aca en formato de json y se procede a eliminar el usuario del archivo de texto y su foto

    $objEmpleado = json_decode($_POST["obj"]) ;


    $empleado= new Empleado($objEmpleado->legajo,$objEmpleado->apellido,$objEmpleado->nombre,$objEmpleado->sueldo,$objEmpleado->path_foto);
    //si el empleado existe en la lista
    if($empleado->Existe($empleado))
    {
        //elimino el empleado del archivo de texto
        Empleado::EliminarArchivo($empleado);
        //elimino la foto del archivo de texto
        unlink($objEmpleado->path_foto);
        echo "Empleado eliminado con exito";
    }
    else
    {
        echo "No se pudo eliminar el empleado";
    }

       break;

    case 'modificarFoto':

    $objRetorno= new stdClass();

    $objRetorno->Ok= false;
    
    $extension=pathinfo($_FILES["foto"]["name"],PATHINFO_EXTENSION);
    
    //voy a obtener el dato de destino de imagen
    $destino ="fotos_empleados/" .$_POST["numLegajo"] ."_" . $_POST["txtApellido"] . "." .$extension;
    
    $empleado = new Empleado($_POST["numLegajo"],$_POST["txtApellido"],$_POST["txtNombre"],$_POST["numSueldo"],$destino);


    Empleado::ModificarArchivo($empleado);


    //agrego la foto del empleado a la carpeta de foto_empleados
    if(move_uploaded_file($_FILES["foto"]["tmp_name"],$destino))
    {
        $objRetorno->Ok=true;
        $objRetorno->Path=$destino;
        $objRetorno->nombre=$_POST["txtNombre"];
        $objRetorno->apellido=$_POST["txtApellido"];
        $objRetorno->legajo=$_POST["numLegajo"];
        $objRetorno->sueldo=$_POST["numSueldo"];
    }
       //retorno un objeto de tipo JSON en formato cadena para que puede recibirse desde el lado de typescript
    echo json_encode($objRetorno);

    break;

    default:
        echo ":(";
        break;
}

?>