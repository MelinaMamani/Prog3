<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require_once './Usuario.php';
require_once './Verificadora.php';

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

$app->group('/credenciales', function (){
    $this->get('/', function ($request, $response) {    
        $response->getBody()->write("API=> GET");
        return $response;
    });
    
    $this->post('/', function ($request, $response) {    
        $response->getBody()->write("API => POST");
        return $response;
    
    });
})->add(function(Request $request, Response $response, $next){
    
    if ($request->isGet()) {
        $response->getBody()->write("Entro por get ");
    }

    if ($request->isPost()) {
        $datos = $request->getParsedBody();
        $nombre = $datos["nombre"];
        $tipo = $datos["tipo"];
        if ($tipo == "admin") {
            $response->getBody()->write("Entro por post, soy ".$nombre." y ".$tipo."<br>");
        }
    }

    $response = $next($request,$response);
    $response->getBody()->write("Salgo de mw 1");
    return $response;
})->add(\Usuario::class .  ":MetodoInstancia")->add(\Usuario::class . "::MetodoEstatico");

$app->group('/verificar', function (){
    $this->get('/', function ($request, $response) {    
        $response->getBody()->write("API=> GET");
        return $response;
    });
    
    $this->post('/', function ($request, $response) {    
        $response->getBody()->write("API => POST");
        return $response;
    
    });
})->add(\Verificadora::class .  "::Verificar");

$app->run();

?>