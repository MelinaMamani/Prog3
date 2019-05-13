<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);


$app->get('/', function (Request $request, Response $response) {    
    $response->getBody()->write("GET => Bienvenido!!! a SlimFramework");
    return $response;

});

$app->post('/', function (Request $request, Response $response) {    
    $response->getBody()->write("POST => Bienvenido!!! a SlimFramework");
    return $response;

});

$app->put('/', function (Request $request, Response $response) {    
    $response->getBody()->write("PUT => Bienvenido!!! a SlimFramework");
    return $response;

});

$app->delete('/', function (Request $request, Response $response) {    
    $response->getBody()->write("DELETE => Bienvenido!!! a SlimFramework");
    return $response;

});

/*
COMPLETAR POST, PUT Y DELETE
*/

$app->get('/saludar/', function (Request $request, Response $response) {    
    $response->getBody()->write("saludar, hola mundo");
    return $response;

});

$app->get('/mostrar/{nombre}', function (Request $request, Response $response, $args) {
    $nombre = $args['nombre'];
    $response->getBody()->write("hola ".strtoupper($nombre));
    return $response;

});

$app->post('/datos/', function (Request $request, Response $response) {
    $datos = $request->getParsedBody();
    $obj = new stdClass();
    $obj->nombre = $datos['nombre'];
    $obj->apellido = $datos['apellido'];
    $obj->id = rand();

    $newResponse = $response->withJson($obj,200);
    
    return $newResponse;

});

$app->run();

?>