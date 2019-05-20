<?php
require_once('cliente.php');
if(isset($_GET['nombre']) && isset($_GET['correo']) && isset($_GET['clave']))
{
    $clNombre=trim($_GET['nombre']);
    $clCorreo=trim($_GET['correo']);
    $clClave=trim($_GET['clave']);

    $cliente = new Cliente($clNombre,$clCorreo,$clClave);    
    Cliente::GuardarEnArchivo($cliente);
}

?>