<?php

$email = isset($_GET['email']) ? $_GET['email'] : NULL;

$retornoJson = new stdClass();
$retornoJson->Exito=false;
$retornoJson->Mensaje="No se pudo acceder a la cookie";

//reemplazo el "." por la "_" ya que sino da error al obtener la cookie
$nombreCookie = str_replace(".", "_", $email);

if(isset($_COOKIE[$nombreCookie])) {
    $retornoJson->Exito = true;
    $retornoJson->Mensaje = $_COOKIE[$nombreCookie];
}
echo json_encode($retornoJson);

?>