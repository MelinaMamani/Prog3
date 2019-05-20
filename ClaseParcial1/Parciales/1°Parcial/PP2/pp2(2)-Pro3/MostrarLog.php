<?php
include_once "AccesoDatos.php"; //Se usa antes
include "Juguete.php";

$juguetes = Juguete::MostrarLog();

foreach ($juguetes as $key) {
    
    echo($key->ToString()."<br>");
    
}


?>