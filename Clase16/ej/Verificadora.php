<?php
require_once './IMiddlewareable.php';
require_once './Usuario.php';
/*EN EL GET OBTENER LISTA DE ADMINS DESDE ARCHIVO Y MOSTRARLOS COMO UNA LISTA ({TIPO:,NOMBRE:}JSON)*/
class Verificadora implements IMiddlewareable
{
    public static function Verificar($request, $response, $next)
    {
        if ($request->isPost()) {
            $datos = $request->getParsedBody();
            $obj = new stdClass();
            
            $obj->exito = false;
            $obj->mensaje = "No es admin.";
            $newResponse = $response->withJson($obj,403);

            $obj->nombre = $datos["nombre"];
            $obj->tipo = $datos["tipo"];
            //$nombre = $datos["nombre"];
            //$tipo = $datos["tipo"];
            if ($obj->tipo == "admin") {
                //$response->getBody()->write("Entro por post, soy ".$nombre." y ".$tipo."<br>");
                $usuario = new Usuario($obj->tipo, $obj->nombre);
                $usuario->Guardar();
                
                $obj->exito = true;
                $obj->mensaje = "Bienvenido ".$obj->nombre;

                $newResponse = $response->withJson($obj,200);
            }
        }
        $response = $next($request,$response);
        return $newResponse;
    }
}

?>