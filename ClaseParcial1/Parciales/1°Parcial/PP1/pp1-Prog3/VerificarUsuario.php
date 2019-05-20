<?php
require_once "./clases/Usuario.php";
$email = isset($_POST['email']) ? $_POST['email'] : NULL;
$clave = isset($_POST['clave']) ? $_POST['clave'] : NULL;
$foto =isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : NULL;

$usuario = new Usuario($email,$clave,$foto);

if(Usuario::VerificarExistencia($usuario))
{

    //reemplazo el "." por la "_" ya que sino da error al obtener la cookie
    $nombreCookie = str_replace(".", "_", $email);
    //seteo la cookie con el "email" de clave y la fecha como dato y 10seg de duracion
    setcookie($nombreCookie,date("YmdGis"),time()+10);
    //luego me dirijo a el listado
    header("location:ListadoUsuarios.php");

}
else
{
    $retorno = new stdClass();
    $retorno->Exito=false;
    $retorno->Mensaje="El usuario no existe";
    echo json_encode($retorno);
}


?>