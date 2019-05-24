<?php
require_once "./empleado.php";

$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$legajo = $_POST["legajo"];
$sueldo = $_POST["sueldo"];
$foto = $_FILES["foto"]["name"];
$destino = "fotos_empleados/".$legajo."_".$apellido.".".pathinfo($foto,PATHINFO_EXTENSION);


$nuevoEmpleado = new Empleado($apellido,$nombre,$legajo,$sueldo,$destino);

if(Empleado::Agregar($nuevoEmpleado))
    move_uploaded_file($_FILES["foto"]["tmp_name"],$destino);
    echo "Se creó el usuario ".$nuevoEmpleado->ToString()."y se guardó.";

?>