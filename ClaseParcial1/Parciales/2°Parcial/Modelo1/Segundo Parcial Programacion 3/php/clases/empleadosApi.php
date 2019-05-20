<?php
require_once 'entidad.php';
require_once 'IApiUsuario.php';
require_once 'MWparaAutentificar.php';

class empleadosApi extends entidad implements IApiUsuario
{

    public function Login($request, $response, $next)
    {
        sleep(1); // para evitar overflooding de peticiones...
        $token = "";
        $ArrayDeParametros = $request->getParsedBody();
    
        if(isset( $ArrayDeParametros['email']) && isset( $ArrayDeParametros['password']) )
        {
            $email = $ArrayDeParametros['email'];
            $clave = $ArrayDeParametros['password'];
            
            if(usuario::esValido($email, $clave))
            {
                $usuario = entidad::BuscarUsuario($email, $clave);
                
                $datos = array(
                    'ID' => $usuario->id,
                    'email' => $usuario->email, 
                    'perfil' => $usuario->perfil,
                    'nombre' => $usuario->nombre,
                    'apellido' => $usuario->apellido,
                    'legajo' => $usuario->legajo,
                );

                $token = AutentificadorJWT::CrearToken($datos);
                $retorno = array('token' => $token );
                
                ////////////////// esto pide para primeros puntos, se modifico para otro punto posterior //////////////////////
                //$retorno = array('valido' => true, 'usuario' => $usuario ); 
                $newResponse = $response->withJson( $retorno, 200 );
            }
            else
            {
                $retorno = array('valido' => false, 'error' => "No es usuario valido." );
                $newResponse = $response->withJson( $retorno, 409 );
            }
        } 
        else
        {
            $retorno = array('error'=> "Faltan los datos del usuario y su clave." );
            $newResponse = $response->withJson( $retorno ,409); 
        }
    
        return $newResponse;
    }

    public function esAdmin($request, $response, $next) {
        $token = apache_request_headers()["token"];
        $usuario = json_decode(MWparaAutentificar::VerificarToken($token));
        
        if($usuario->perfil == 'admin')
        {
            $resp = $next($request, $response);
        }
        else
        {
            $arr = array('error' => 'No es administrador.');
            $resp = $response->withJson($arr, 409);
        }
        
        return $resp;
    }

    public function TraerTodos($request, $response, $args) {
        $todosLosUsuarios = entidad::TraerTodoLosUsuarios();

        foreach ($todosLosUsuarios as $key => $value) {
            if($value->perfil == 'admin')
                unset($todosLosUsuarios[$key]);
        }

        $newresponse = $response->withJson($todosLosUsuarios, 200);
        return $newresponse;
    }

    public function altaEmpleado($request, $response, $args) {
        // id-nombre-apellido-email-foto-legajo-clave-perfil
        $objDelaRespuesta= new stdclass();
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        if(
            isset($ArrayDeParametros['email']) &&
            isset($ArrayDeParametros['password']) &&
            isset($ArrayDeParametros['nombre']) &&
            isset($ArrayDeParametros['apellido']) &&
            isset($ArrayDeParametros['perfil']) &&
            isset($ArrayDeParametros['legajo'])
        ) {
            $entidad = new entidad();

            $archivos = $request->getUploadedFiles();
            $destino="./images/";
            $foto = null;
            //var_dump($archivos);
            //var_dump($archivos['foto']);
            if(isset($archivos['foto']))
            {
                $nombreAnterior = $archivos['foto']->getClientFilename();
                $extension = explode(".", $nombreAnterior);
                //var_dump($nombreAnterior);
                $extension = array_reverse($extension);
                $foto = $destino.$ArrayDeParametros['email'].".".$extension[0];
                $archivos['foto']->moveTo($foto);
            }
            
            $entidad->email = $ArrayDeParametros['email'];
            $entidad->password = $ArrayDeParametros['password'];
            $entidad->nombre = $ArrayDeParametros['nombre'];
            $entidad->apellido = $ArrayDeParametros['apellido'];
            $entidad->perfil = $ArrayDeParametros['perfil'];
            $entidad->legajo = $ArrayDeParametros['legajo'];

            $entidad->foto = isset($foto) ? $foto : null;      // por defecto en db es ""
        }
        else
        {
            return $response->withJson(array("error" => "Faltan parametros obligatorios del usuario."), 409);
        }
        
        $entidad->InsertarParametros();
        
        $objDelaRespuesta->respuesta = "Se guardo la entidad.";   
        return $response->withJson($objDelaRespuesta, 200);
    }

    public function borrarUsuario($request, $response, $args) { 
        $ArrayDeParametros = $request->getParsedBody();      // pasar valores por 'x-www-form-urlencoded'
        $objDelaRespuesta = new stdclass();
        
        if(isset($ArrayDeParametros['id']))
        {
            $id = $ArrayDeParametros['id'];

            $entidad = new entidad();
            $entidad->id = $id;
            $cantidadDeBorrados = $entidad->borrarEntidad();
            
            $objDelaRespuesta->cantidad = $cantidadDeBorrados;
            if($cantidadDeBorrados > 0)
            {
                $objDelaRespuesta->resultado = "Se ha eliminado el usuario exitosamente.";
            }
            else
            {
                $objDelaRespuesta->resultado = "Error: no se pudo eliminar el usuario.";
            }
        }
        else
        {
            $objDelaRespuesta->resultado = "No se pasó el ID del usuario a eliminar.";

        }

	    $newResponse = $response->withJson($objDelaRespuesta, 200);  
      	return $newResponse;
    }
}