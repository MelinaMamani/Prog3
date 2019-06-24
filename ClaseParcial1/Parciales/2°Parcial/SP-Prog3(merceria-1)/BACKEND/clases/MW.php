<?php
require_once "/AccesoDatos.php";
require_once "/Usuario.php";

class MW
{
  public static function MWVerificarPropietario($request,$response,$next)
  {
    $ArrayDeParametros = $request->getParsedBody();
    $user=json_decode ($ArrayDeParametros['user']);

    if($user->perfil == "propietario")
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

  public  function MWVerificarEncargado($request,$response,$next)
  {
    $ArrayDeParametros = $request->getParsedBody();
    $user=json_decode ($ArrayDeParametros['user']);

    if($user->perfil == "encargado" || $user->perfil =="propietario")
    {
        $newResponse=$next($request,$response);
    }
    else
    {
        $objJson= new stdClass();
        $objJson->mensaje="Error el usuario no es de tipo encargado o propietario";
        $newResponse= $response->withJson($objJson,409);
    }


    return $newResponse;
  }

  public static function MWVerificarEmpleado($request,$response,$next)
  {
    $ArrayDeParametros = $request->getParsedBody();
    $user=json_decode ($ArrayDeParametros['user']);

    if($user->perfil == "empleado")
    {
        $newResponse=$next($request,$response);
    }
    else
    {
        $objJson= new stdClass();
        $objJson->mensaje="Error el usuario no es de tipo empleado";
        $newResponse= $response->withJson($objJson,409);
    }


    return $newResponse;
  }

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
/*
  public function VerificarBDCorreoYClave($request,$response,$next)
  {
    $ArrayDeParametros=$request->getParsedBody();
    $clave=$ArrayDeParametros['clave'];
    $correo=$ArrayDeParametros['correo'];
    $mensajeError="";
    $flag=false;

    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios WHERE clave=:clave AND correo=:correo");
    $consulta->bindValue(':clave', $clave, PDO::PARAM_STR);
    $consulta->bindValue(':correo', $correo, PDO::PARAM_STR);
    $consulta->execute();

    $fila = $consulta->fetch();
    $user= new Usuario($fila[0],$fila[1],$fila[2],$fila[3],$fila[4],$fila[5],$fila[6]);



    if($user->clave!=$clave && $user->correo!=$correo)
    {
      $flag=true;
    }
    else if($user->clave!=$clave && $user->correo==$correo)
    {
      $mensajeError="Error!,solo el correo ya se encuentra en la base de datos!";
    }
    else if($user->clave==$clave && $user->correo!=$correo)
    {
      $mensajeError="Error!,solo la clave ya se encuentra en la base de datos!";
    }
    else
    {
      $mensajeError="Error!, la clave y el correo ya se encuentran en la base de datos!";
    }

    if($flag==true)
    {
      $newResponse=$next($request,$response);
    }
    else
    {
      $objJson= new stdClass();
      $objJson->mensaje=$mensajeError;
      $response= $response->withJson($objJson,409);
      $newResponse=$response;
    }

    return $newResponse;
    
  }*/

  public function VerificarBDCorreoYClave($request,$response,$next)
  {
    $ArrayDeParametros=$request->getParsedBody();
    $clave=$ArrayDeParametros['clave'];
    $correo=$ArrayDeParametros['correo'];

    $mensajeError="";

    $validarCorreo=true;
    $validarClave=true;

    $usuarios=[];

    $user = new Usuario();
    $usuarios=$user->TraerTodosLosUsuariosBD();

    foreach($usuarios as $us)
    {
      if($us->clave == $clave && $us->correo == $correo)
      {
        $validarCorreo=false;
        $validarClave=false;
        break;
      }
      else if($us->clave != $clave && $us->correo == $correo)
      {
          $validarCorreo=false;
      }
      else if($us->clave == $clave && $us->correo != $correo)
      {
        $validarClave=false;
      }
    }

    if($validarClave==false || $validarCorreo==false)
    {
      if($validarClave==false && $validarCorreo==false)
      {
        $mensajeError="Error!,La clave y el correo ya existen en la base de datos!";
      }
      else if($validarClave==false && $validarCorreo==true)
      {
        $mensajeError="Error!,solo la clave existe en la base de datos!";
      }
      else if($validarClave==true && $validarCorreo==false)
      {
        $mensajeError="Error!,solo el correo existe en la base de datos!";
      }

      $objJson= new stdClass();
      $objJson->mensaje=$mensajeError;
      $response= $response->withJson($objJson,409);
      $newResponse=$response;

    }
    else
    {
      $newResponse= $next($request,$response);
    }

    return $newResponse;
  }

}

?>