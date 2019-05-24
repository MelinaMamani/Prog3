<?php
require_once 'ValidarUsuario.php';
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->get('/validar/', function (Request $request, Response $response) {
    $legajo = $_GET['legajo'];
    $clave = $_GET['clave'];
    
    $newResponse = $response->withJson(Manejadora::ValidarUsuario($legajo,$clave),200);
    
    return $newResponse;

});

$app->run();

?>