<?php
use Firebase\JWT\JWT;
require_once "/Usuario.php";
class MW
{
    public function VerificarSetCorreoYClave($request,$response,$next)
  {
    $ArrayDeParametros=$request->getParsedBody();
    //$user=json_decode ($ArrayDeParametros['user']);

    $flag=false;
    $mensajeError="";

    if(isset($ArrayDeParametros['correo'])&& isset($ArrayDeParametros['clave']))
    {
      $flag=true;
    }
    else if(isset($ArrayDeParametros['correo'])==true && isset($ArrayDeParametros['clave'])==false)
    {
      $mensajeError="Solo esta seteado el correo!";
    }
    else if(isset($ArrayDeParametros['correo'])==false && isset($ArrayDeParametros['clave'])==true)
    {
      $mensajeError="Solo esta seteado la clave!";
    }
    else
    {
      $mensajeError="No esta seteado ni el correo ni la clave!";
    }

    if($flag==true)
    {
        $newResponse=$next($request,$response);
    }
    else
    {
      $objJson= new stdClass();
      $objJson->mensaje=$mensajeError;
      $newResponse= $response->withJson($objJson,409);
    }
    
   return $newResponse;

  }

  public static function VerificarVacioCorreoYClave($request,$response,$next)
  {
    $ArrayDeParametros=$request->getParsedBody();
    $mensajeError="";
    $flag = false;

    if($ArrayDeParametros['clave']!="" && $ArrayDeParametros['correo']!="" )
    {
      $retorno=true;
    }
    else if($ArrayDeParametros['clave']!="" && $ArrayDeParametros['correo']=="")
    {
      $mensajeError="Error!,solo el correo esta vacio!";
    }
    else if($ArrayDeParametros['clave']=="" && $ArrayDeParametros['correo']!="")
    {
      $mensajeError="Error!,solo la clave esta vacia!";
    }
    else
    {
      $mensajeError="Error!, la clave y el correo estan vacios!";
    }
    
    if($retorno==true)
    {
      $newResponse =$next($request,$response);
    }
    else
    {
      $objJson= new stdClass();
      $objJson->mensaje=$mensajeError;
      $response= $response->withJson($objJson,409);
      $newResponse=$response;
    }
    
    return $newResponse;  
  }


  public function VerificarBDCorreoYClave($request,$response,$next)
  {
    $ArrayDeParametros=$request->getParsedBody();
    $clave=$ArrayDeParametros['clave'];
    $correo=$ArrayDeParametros['correo'];

    $flag=false;

    $usuarios=[];

    $user = new Usuario();
    $usuarios=$user->TraerTodosLosUsuariosBD();

    foreach($usuarios as $us)
    {
      if($us->clave == $clave && $us->correo == $correo)
      {
        $flag=true;
        break;
      }
    }

    if($flag==false)
    {

      $objJson= new stdClass();
      $objJson->mensaje="Error , la clave y el correo no se encuentran en la base de datos";
      $response= $response->withJson($objJson,409);
      $newResponse=$response;

    }
    else
    {
      $newResponse= $next($request,$response);
    }

    return $newResponse;
  }

  public function VerificarToken($request,$response,$next)
  {
        $ArrayDeParametros = $request->getParsedBody();
        $token= $ArrayDeParametros['token'];

        $flag=false;

        $objJson= new stdClass();
        $objJson->Mensaje="";
        

        $mensajeError="";

        if(empty($token)  || $token==="")
        {
            $mensajeError="El token esta vacio!";
        }

        try
        {
            $decodificado=JWT::decode(
                $token,
                //tenemos que pasarle la clave tambien con la que lo guardamos
                "claveSecreta",
                ['HS256']
            );

            $flag=true;
        }
        catch(Exception $e)
        {
        // throw new Exception ("Token no valido!!! -->" .$e->getMessage() );
          $mensajeError=$e->getMessage();
        }

        if($flag==true)
        {
           $objJson->Mensaje="Token valido!";
           $newResponse = $next($request,$response);
        }
        else
        {
            $objJson->Mensaje=$mensajeError;
            $newResponse=$response->withJson($objJson,409);
        }

        return $newResponse;
  }

  public static function MWVerificarPropietario($request,$response,$next)
  {
    $ArrayDeParametros=$request->getParsedBody();

    $objJson = new stdClass();
    $objJson->mensaje="";

    $token = $ArrayDeParametros['token'];
 
    //decodifico el token
    $decodificado=JWT::decode(
      $token,
      //tenemos que pasarle la clave tambien con la que lo guardamos
      "claveSecreta",
        ['HS256']
      );

    //obtengo los datos del usuario guardados en el array del token
    $usuario=$decodificado->data;

    if($usuario->perfil == "propietario")
    {
        $newResponse=$next($request,$response);
    }
    else
    {
        $objJson= new stdClass();
        $objJson->mensaje="Error el usuario no es de tipo propietario";
        $newResponse= $response->withJson($objJson,409);
    }

    return $newResponse;
  }

  public function MWVerificarEncargado($request,$response,$next)
  {
    $ArrayDeParametros=$request->getParsedBody();

    $objJson = new stdClass();
    $objJson->mensaje="";

    $token = $ArrayDeParametros['token'];
 
    //decodifico el token
    $decodificado=JWT::decode(
      $token,
      //tenemos que pasarle la clave tambien con la que lo guardamos
      "claveSecreta",
        ['HS256']
      );

    //obtengo los datos del usuario guardados en el array del token
    $usuario=$decodificado->data;

    if($usuario->perfil == "encargado" || $usuario->perfil =="propietario")
    {
        $newResponse=$next($request,$response);
    }
    else
    {
        $objJson= new stdClass();
        $objJson->mensaje="Error el usuario no es de tipo propietario";
        $newResponse= $response->withJson($objJson,409);
    }

    return $newResponse;
  }
}


?>