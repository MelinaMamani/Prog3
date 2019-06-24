<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;

require_once './vendor/autoload.php';
require_once './BACKEND/Usuario.php';
require_once './BACKEND/Auto.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->group('/usuarios', function (){
    $this->post('/', \Usuario::class . '::AltaUsuario');
    //$this->post('/traerUno', \Usuario::class . '::TraerUnUsuario');
    //$this->post('/eliminar', \Usuario::class . '::EliminarUsuario');
    //$this->post('/modificar', \Usuario::class . '::ModificarUsuario');
});

$app->get('/', \Usuario::class . '::TraerTodosUsuarios');

$app->post('/', \Auto::class . '::AltaAuto');

$app->group('/autos', function (){
    $this->get('/', \Auto::class . '::TraerTodosAutos');
    //$this->post('/traerUno', \Usuario::class . '::TraerUnUsuario');
    //$this->post('/eliminar', \Usuario::class . '::EliminarUsuario');
    //$this->post('/modificar', \Usuario::class . '::ModificarUsuario');
});

$app->group('/login', function (){
    $this->post('/', function (Request $request, Response $response){
        $datos = $request->getParsedBody();
        $ahora = time();
        $user =  new stdClass();
        $user->correo = $datos['correo'];
        $user->clave = $datos['clave'];
        
        $json = new stdClass();
        
        
        try{
            $payload = array('iat' => $ahora,
            'exp' => $ahora+(30),
            'data' => $user,
            'app' => "user token"
            );
            $json->exito = true;
            $json->jwt = JWT::encode($payload,"unUsuario");

            $newResponse = $response->withJSON($json,200);
        }
        catch(Exception $e)
        {
            $json->exito = false;
            $json->jwt = null;
            $newResponse = $response->withJSON($json,403);
        }

        return $newResponse;
    });
    $this->get('/', function (Request $request, Response $response, $args){
        $arrayDeParam = $request->getParsedBody();
        $token = $arrayDeParam['token'];
        var_dump($token);
            die();

        if (empty($token) || $token === "") {
            throw new Exception("Token vacío");
        }

        try{
            
            $decodificado = JWT::decode($token,"unUsuario",['HS256']);
        }
        catch(Exception $e)
        {
            throw new Exception("Ocurrió un error con el token". $e->getMessage());
            
        }

        return $response->withJSON("Ok",200);
    });
});

$app->run();

?>