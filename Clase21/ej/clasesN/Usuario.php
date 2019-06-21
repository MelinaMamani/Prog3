<?php

require_once 'IApiUsuario.php';
require_once 'AccesoDatos.php';

class Usuario implements IApiUsuario
{
    public $legajo;
    public $nombre;
    public $apellido;
    public $mail;
    public $clave;
    public $dni;
    public $sexo;
    public $sueldo;
    public $foto;

    public function __construct($legajo, $nombre, $apellido, $mail, $clave, $dni, $sexo, $sueldo, $foto)
    {
        $this->legajo = $legajo;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->mail = $mail;
        $this->clave = $clave;
        $this->dni = $dni;
        $this->sexo = $sexo;
        $this->sueldo = $sueldo;
        $this->foto = $foto;
    }

    public static function AltaUsuario($request, $response, $next)
    {
        $datos = $request->getParsedBody();
        $usuario = new stdClass();
        $usuario->legajo = $datos["legajo"];
        $usuario->nombre = $datos["nombre"];
        $usuario->apellido = $datos["apellido"];
        $usuario->mail = $datos["mail"];
        $usuario->clave = $datos["clave"];
        $usuario->dni = $datos["dni"];
        $usuario->sexo = $datos["sexo"];
        $usuario->sueldo = $datos["sueldo"];
        
        $imagen = $request->getUploadedFiles();
        $nombreFoto = $imagen["foto"]->getClientFileName();
        
        $obj = new stdClass();
        $obj->exito = false;
        $obj->mensaje = "El usuario ".$usuario->legajo." no fue dado de alta";
        $newResponse = $response->withJson($obj,403);

        $extension=pathinfo($nombreFoto,PATHINFO_EXTENSION);
        $destino ="./fotos/" . date('Ymd') ."_" . $usuario->legajo . "." .$extension;
        
        $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

        $consulta =$objetoDatos->RetornarConsulta("INSERT INTO usuarios (legajo, nombre, apellido, mail,
        clave, dni, sexo, sueldo, foto) VALUES(:legajo, :nombre, :apellido, :mail, :clave, :dni, :sexo, :sueldo, :foto)");

        $consulta->bindValue(':legajo', $usuario->legajo, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $usuario->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $usuario->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':mail', $usuario->mail, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $usuario->clave, PDO::PARAM_STR);
        $consulta->bindValue(':dni', $usuario->dni, PDO::PARAM_INT);
        $consulta->bindValue(':sexo', $usuario->sexo, PDO::PARAM_STR);
        $consulta->bindValue(':sueldo', $usuario->sueldo, PDO::PARAM_INT);
        $consulta->bindValue(':foto', $destino, PDO::PARAM_STR);

        $Agrega = $consulta->execute();

        if ($Agrega) {
            $imagen["foto"]->moveTo($destino);
            $obj->exito = true;
            $obj->mensaje = "El usuario ".$usuario->legajo." fue dado de alta";
            $newResponse = $response->withJson($obj,200);
        } 
        //$response = $next($request,$response);
        return $newResponse;
    }

    public static function TraerTodosUsuarios($request, $response, $next)
    {
        $usuarios = array();

        $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

        $consulta =$objetoDatos->RetornarConsulta("SELECT * FROM usuarios");
        
        $consulta->execute();

        while($fila = $consulta->fetch())
        {
          $usuario = new Usuario($fila[1],$fila[2],$fila[3],$fila[4],$fila[5],$fila[6],$fila[7],$fila[8],$fila[9]);
          array_push($usuarios,$usuario);
        }
        
        if (empty($usuarios)) 
        {
            $obj->exito = false;
            $obj->mensaje = "No hay usuarios.";
            $newResponse = $response->withJson($obj,403);
        } 
        else 
        {
            $obj->exito = true;
            $obj->mensaje = "Usuarios: ".json_encode($usuarios);
            $newResponse = $response->withJson($obj,200);
        }
        
        return $newResponse;
    }
    
    public static function TraerUnUsuario($request, $response, $next)
    {
        $datos = $request->getParsedBody();
        $usuario = new stdClass();
        $usuario->legajo = $datos["legajo"];

        $obj = new stdClass();

        $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

        $consulta =$objetoDatos->RetornarConsulta("SELECT * FROM usuarios WHERE legajo = :legajo");

        $consulta->bindValue(':legajo', $usuario->legajo, PDO::PARAM_INT);

        try
        {
            $consulta->execute();
            $fila = $consulta->fetch();

            $usuarioN = new Usuario($fila[1],$fila[2],$fila[3],$fila[4],$fila[5],$fila[6],$fila[7],$fila[8],$fila[9]);

            $obj->exito = true;
            $obj->mensaje = "Usuario: ".json_encode($usuarioN);
            $newResponse = $response->withJson($obj,200);
        }
        catch(Exception $e)
        {
            $obj->exito = false;
            $obj->mensaje = $e.", el usuario ".$usuario->legajo." no fue encontrado.";
            $newResponse = $response->withJson($obj,403);
        }
        
        return $newResponse;
    }

    public static function EliminarUsuario($request, $response, $next)
    {
        $datos = $request->getParsedBody();
        $usuario = new stdClass();
        $usuario->legajo = $datos["legajo"];

        $obj = new stdClass();

        $objetoDatos = AccesoDatos::DameUnObjetoAcceso(); 
        $consulta =$objetoDatos->RetornarConsulta("DELETE FROM usuarios WHERE legajo=:legajo");	
        $consulta->bindValue(':legajo',$usuario->legajo, PDO::PARAM_INT);

        $usuarioAnt = Usuario::TraerUnUsuarioBD($usuario->legajo);
        $nombre = explode("./fotos/",$usuarioAnt->foto);
        copy($usuarioAnt->foto,"./fotos/eliminadas/".$nombre[1]);
        unlink($usuarioAnt->foto);

        try
        {
            $consulta->execute();
            
            $obj->exito = true;
            $obj->mensaje = "El usuario ".$usuario->legajo." fue dado de baja.";
            $newResponse = $response->withJson($obj,200);
        }
        catch(Exception $e)
        {
            $obj->exito = false;
            $obj->mensaje = $e.", error al dar de baja a el usuario ".$usuario->legajo.".";
            $newResponse = $response->withJson($obj,403);
        }
        
        return $newResponse;
    }

    public static function ModificarUsuario($request, $response, $next)
    {
        $datos = $request->getParsedBody();
        $usuario = new stdClass();
        $usuario->legajo = $datos["legajo"];
        $usuario->nombre = $datos["nombre"];
        $usuario->apellido = $datos["apellido"];
        $usuario->mail = $datos["mail"];
        $usuario->clave = $datos["clave"];
        $usuario->dni = $datos["dni"];
        $usuario->sexo = $datos["sexo"];
        $usuario->sueldo = $datos["sueldo"];
        
        $imagen = $request->getUploadedFiles();
        $nombreFoto = $imagen["foto"]->getClientFileName();
        
        $obj = new stdClass();
        $obj->exito = false;
        $obj->mensaje = "El usuario ".$usuario->legajo." no fue modificado.";
        $newResponse = $response->withJson($obj,403);

        $extension=pathinfo($nombreFoto,PATHINFO_EXTENSION);
        $destino ="./fotos/" . date('Ymd') ."_" . $usuario->legajo . "." .$extension;
        
        $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

        $consulta =$objetoDatos->RetornarConsulta("UPDATE usuarios SET nombre = :nombre, apellido = :apellido, mail =
        :mail, clave = :clave, dni = :dni, sexo = :sexo, sueldo = :sueldo, foto = :foto WHERE legajo = :legajo");

        $consulta->bindValue(':legajo', $usuario->legajo, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $usuario->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $usuario->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':mail', $usuario->mail, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $usuario->clave, PDO::PARAM_STR);
        $consulta->bindValue(':dni', $usuario->dni, PDO::PARAM_INT);
        $consulta->bindValue(':sexo', $usuario->sexo, PDO::PARAM_STR);
        $consulta->bindValue(':sueldo', $usuario->sueldo, PDO::PARAM_INT);
        $consulta->bindValue(':foto', $destino, PDO::PARAM_STR);

        $usuarioAnt = Usuario::TraerUnUsuarioBD($usuario->legajo);
        $nombre = explode("./fotos/",$usuarioAnt->foto);
        copy($usuarioAnt->foto,"./fotos/modificadas/".$nombre[1]);
        unlink($usuarioAnt->foto);

        $modifica = $consulta->execute();

        if ($modifica) {
            $imagen["foto"]->moveTo($destino);
            $obj->exito = true;
            $obj->mensaje = "El usuario ".$usuario->legajo." fue modificado.";
            $newResponse = $response->withJson($obj,200);
        } 
        
        return $newResponse;
    }

    public static function TraerUnUsuarioBD($legajo)
     {
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios WHERE legajo=".$legajo."");
        $consulta->execute();
        $fila = $consulta->fetch();
        $usuario = new Usuario($fila[1],$fila[2],$fila[3],$fila[4],$fila[5],$fila[6],$fila[7],$fila[8],$fila[9]);
        return $usuario;
     }
}


?>