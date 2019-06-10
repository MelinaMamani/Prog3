<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require_once './clasesN/Usuario.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->group('/usuarios', function (){
    $this->post('/alta', \Usuario::class . '::AltaUsuario');
    $this->post('/traerTodos', \Usuario::class . '::TraerTodosUsuarios');
    $this->post('/traerUno', \Usuario::class . '::TraerUnUsuario');
});

$app->run();

?>