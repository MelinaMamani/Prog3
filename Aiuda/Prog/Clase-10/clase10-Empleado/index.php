<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
//require_once '/clases/AccesoDatos.php';
require_once './clases/Empleado1.php';
//require_once '/clases/Empleado.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

/*
¡La primera línea es la más importante! A su vez en el modo de 
desarrollo para obtener información sobre los errores
 (sin él, Slim por lo menos registrar los errores por lo que si está utilizando
  el construido en PHP webserver, entonces usted verá en la salida de la consola 
  que es útil).

  La segunda línea permite al servidor web establecer el encabezado Content-Length, 
  lo que hace que Slim se comporte de manera más predecible.
*/

//*********************************************************************************************//
//INICIALIZO EL APIREST
//*********************************************************************************************//
$app = new \Slim\App(["settings" => $config]);


//*********************************************************************************************//
/*LLAMADA A METODOS DE INSTANCIA DE UNA CLASE*/
//*********************************************************************************************//
$app->group('/empleado', function () 
{   
    $this->post('/Alta', \Empleado1::class . '::AltaUsuario');
    $this->delete('/Eliminar', \Empleado1::class . '::EliminarUsuario');
    $this->post('/Modificar',\Empleado1::class . '::ModificarUsuario');
    $this->get('/TraerUno', \Empleado1::class . '::TraerUnUsuario');  
    $this->get('/TraerTodos', \Empleado1::class . '::TraerTodosLosUsuarios');  
});


$app->run();