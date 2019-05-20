<?php

require_once "./clases/Usuario.php";

$arrayUsuarios= Usuario::TraerTodos();
$cadena="";
foreach($arrayUsuarios as $user)
{
    $cadena.=$user->ToJson()."<br>";

}
echo $cadena;

?>