<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';

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

$app = new \Slim\App(["settings" => $config]);


$app->get('[/]', function (Request $request, Response $response) {    
$response->getBody()->write("GET => Bienvenido!!! a SlimFramework");
return $response;

});



/*
COMPLETAR POST, PUT Y DELETE
*/

$app->post('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("POST => Bienvenido!!! a SlimFramework");
    return $response;

});

$app->put('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("PUT => Bienvenido!!! a SlimFramework");
    return $response;

});

$app->delete('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("DELETE => Bienvenido!!! a SlimFramework");
    return $response;

});


/******RUTEOS*****/
$app->get('/saludar/', function (Request $request, Response $response) {    
    $response->getBody()->write("Hola Mundo");
    return $response;

});

//ruteo con parametros en GET devuelve el nombre ingresado en MAYUSCULA
$app->get('/saludar/{nombre}', function (Request $request, Response $response ,$args) {  
    $nombre = $args['nombre'];  
    $response->getBody()->write(strtoupper($nombre));
    return $response;
});

//cargo datos con post desde el encabezado y los recupero directamente

$app->post('/saludar1/{nombre}/{apellido}', function (Request $request, Response $response ,$args) 
{  
    $obj= new stdClass();
    $obj->nombre = $args['nombre'];  
    $obj->apellido= $args['apellido'];
    $obj->id =  rand(0,10);

    //retorna objeto de tipo JSON
    $newResponse = $response->withJson($obj,200);

    return $newResponse;
});

//cargo datos con post desde los inputs del BODY y los recupero en un array utilizando "getParsedBody"

$app->post('/saludar2/', function (Request $request, Response $response ,$args) 
{  
    $ArrayDeParametros =  $request->getParsedBody();

    $obj= new stdclass();
    $obj->nombre =  $ArrayDeParametros['nombre'];  
    $obj->apellido=  $ArrayDeParametros['apellido'];
    $obj->id =  rand(0,10);

    //retorna objeto de tipo JSON
    $newResponse = $response->withJson($obj,200);

    return $newResponse;
});

//cargo datos con post desde el encabezado (un JSON y lo muestro)

$app->post('/saludar3/{cadenaJson}', function (Request $request, Response $response ,$args) 
{  
    $cadena = $args['cadenaJson'];
    
    //retorna objeto de tipo JSON
    $obj= json_decode($cadena);
    var_dump($obj);
});

//cargo datos con post desde input del body una cadena JSON y la recupero y la muestro
$app->post('/saludar3/', function (Request $request, Response $response ,$args) 
{
    $ArrayDeParametros =  $request->getParsedBody();   
    $obj = json_decode($ArrayDeParametros['cadenaJson']);

    var_dump($obj);


});

// se utiliza siempre al final
$app->run();