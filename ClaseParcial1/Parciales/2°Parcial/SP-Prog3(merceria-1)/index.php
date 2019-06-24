<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;

require_once './vendor/autoload.php';

require_once './BACKEND/clases/AccesoDatos.php';
require_once './BACKEND/clases/Media.php';
require_once './BACKEND/clases/Venta.php';
require_once './BACKEND/clases/Usuario.php';
require_once './BACKEND/clases/MW.php';
//require_once './clases/middleware.php';
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
#MEDIAS

$app->post('[/]', \Media::class . '::Alta');
$app->get('/medias',\Media::class . '::TraerTodos');
$app->delete('[/]',\Media::class . '::Borrar')->add(\MW::class . '::MWVerificarPropietario');
$app->put('[/]',\Media::class . '::Modificar')->add(\MW::class . ':MWVerificarEncargado');

#USUARIOS

$app->post('/usuarios', \Usuario::class . '::Alta')->add(\MW::class . ':VerificarBDCorreoYClave')->add(\MW::class . '::VerificarVacioCorreoYClave')->add(\MW::class . ':VerificarSetCorreoYClave');
$app->get('[/]',\Usuario::class . '::TraerTodos');

$app->get('/listadoFotos',\Usuario::class . '::ListadoFotos');



#VENTAS
$app->post('/ventas', \Venta::class . '::Alta');
$app->get('/ventas',\Venta::class . '::TraerTodos');
$app->delete('/ventas',\Venta::class . '::Borrar')->add(\MW::class . ':MWVerificarEmpleado');
$app->put('/ventas',\Venta::class . '::Modificar')->add(\MW::class . ':MWVerificarEmpleado');


$app->run();