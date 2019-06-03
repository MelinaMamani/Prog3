<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;

require_once './vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);


$app->get('/', function (Request $request, Response $response) {    
    $response->getBody()->write("GET => Bienvenido!!! a SlimFramework");
    return $response;

});

$app->post('/Crear',function (Request $request, Response $response){
    $datos = $request->getParsedBody();
    $ahora = time();
    $user =  new stdClass();
    $user->nombre = $datos['nombre'];
    $user->apellido = $datos['apellido'];
    $user->division = $datos['division'];

    $payload = array('iat' => $ahora,
    'exp' => $ahora+(30),
    'data' => $user,
    'app' => "Creando token"
    );

    $token = JWT::encode($payload,"unUsuario");

    return $response->withJSON($token,200);
});

$app->post('/Verificar',function (Request $request, Response $response){
    $arrayDeParam = $request->getParsedBody();
    $token = $arrayDeParam['token'];

    if (empty($token) || $token === "") {
        throw new Exception("Token vacío");
    }

    try{
        var_dump($token);
        $decodificado = JWT::decode($token,"tokenDeUsuario",array('HS256'));
    }
    catch(Exception $e)
    {
        throw new Exception("Ocurrió un error con el token". $e->getMessage());
        
    }

    return "0k= ".$decodificado;
});

$app->run();

?>