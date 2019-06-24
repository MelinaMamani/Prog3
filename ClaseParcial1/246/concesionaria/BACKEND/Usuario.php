<?php

require_once 'AccesoDatos.php';

class Usuario
{
    public $nombre;
    public $apellido;
    public $correo;
    public $clave;
    public $perfil;
    public $foto;

    public function __construct($correo, $clave, $nombre, $apellido, $perfil, $foto)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->perfil = $perfil;
        $this->foto = $foto;
    }

    public static function AltaUsuario($request, $response, $next)
    {
        $datos = $request->getParsedBody();
        $usuario = new stdClass();
        $usuario->nombre = $datos["nombre"];
        $usuario->apellido = $datos["apellido"];
        $usuario->correo = $datos["correo"];
        $usuario->clave = $datos["clave"];
        $usuario->perfil = $datos["perfil"];
        
        $imagen = $request->getUploadedFiles();
        $nombreFoto = $imagen["foto"]->getClientFileName();
        
        $obj = new stdClass();
        $obj->exito = false;
        $obj->mensaje = "El usuario ".$usuario->correo." no fue dado de alta";
        $newResponse = $response->withJson($obj,418);

        $extension=pathinfo($nombreFoto,PATHINFO_EXTENSION);
        $destino ="./fotos/" . date('Ymd') ."_" . $usuario->perfil . "." .$extension;
        
        $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

        $consulta =$objetoDatos->RetornarConsulta("INSERT INTO usuarios (nombre, apellido, correo,
        clave, perfil, foto) VALUES(:nombre, :apellido, :correo, :clave, :perfil, :foto)");

        $consulta->bindValue(':nombre', $usuario->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $usuario->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':correo', $usuario->correo, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $usuario->clave, PDO::PARAM_STR);
        $consulta->bindValue(':perfil', $usuario->perfil, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $destino, PDO::PARAM_STR);

        $Agrega = $consulta->execute();

        if ($Agrega) {
            $imagen["foto"]->moveTo($destino);
            $obj->exito = true;
            $obj->mensaje = "El usuario ".$usuario->correo." fue dado de alta";
            $newResponse = $response->withJson($obj,200);
        } 
        
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
          $usuario = new Usuario($fila[1],$fila[2],$fila[3],$fila[4],$fila[5],$fila[6]);
          array_push($usuarios,$usuario);
        }
        
        if (empty($usuarios)) 
        {
            $obj->exito = false;
            $obj->mensaje = "No hay usuarios.";
            $newResponse = $response->withJson($obj,424);
        } 
        else 
        {
            $obj->exito = true;
            $obj->mensaje = "Usuarios cargados.";
            $obj->tabla = json_encode($usuarios);
            $newResponse = $response->withJson($obj,200);
        }
        
        return $newResponse;
    }
    
    public static function TraerUnUsuario($request, $response, $next)
    {
        $datos = $request->getParsedBody();
        $usuario = new stdClass();
        $usuario->correo = $datos["correo"];

        $obj = new stdClass();

        $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

        $consulta =$objetoDatos->RetornarConsulta("SELECT * FROM usuarios WHERE legajo = :legajo");

        $consulta->bindValue(':legajo', $usuario->correo, PDO::PARAM_INT);

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
            $obj->mensaje = $e.", el usuario ".$usuario->correo." no fue encontrado.";
            $newResponse = $response->withJson($obj,403);
        }
        
        return $newResponse;
    }

    public static function EliminarUsuario($request, $response, $next)
    {
        $datos = $request->getParsedBody();
        $usuario = new stdClass();
        $usuario->correo = $datos["legajo"];

        $obj = new stdClass();

        $objetoDatos = AccesoDatos::DameUnObjetoAcceso(); 
        $consulta =$objetoDatos->RetornarConsulta("DELETE FROM usuarios WHERE legajo=:legajo");	
        $consulta->bindValue(':legajo',$usuario->correo, PDO::PARAM_INT);

        $usuarioAnt = Usuario::TraerUnUsuarioBD($usuario->correo);
        $nombre = explode("./fotos/",$usuarioAnt->foto);
        copy($usuarioAnt->foto,"./fotos/eliminadas/".$nombre[1]);
        unlink($usuarioAnt->foto);

        try
        {
            $consulta->execute();
            
            $obj->exito = true;
            $obj->mensaje = "El usuario ".$usuario->correo." fue dado de baja.";
            $newResponse = $response->withJson($obj,200);
        }
        catch(Exception $e)
        {
            $obj->exito = false;
            $obj->mensaje = $e.", error al dar de baja a el usuario ".$usuario->correo.".";
            $newResponse = $response->withJson($obj,403);
        }
        
        return $newResponse;
    }

    public static function ModificarUsuario($request, $response, $next)
    {
        $datos = $request->getParsedBody();
        $usuario = new stdClass();
        $usuario->nombre = $datos["nombre"];
        $usuario->apellido = $datos["apellido"];
        $usuario->correo = $datos["correo"];
        $usuario->clave = $datos["clave"];
        $usuario->perfil = $datos["perfil"];
        
        $imagen = $request->getUploadedFiles();
        $nombreFoto = $imagen["foto"]->getClientFileName();
        
        $obj = new stdClass();
        $obj->exito = false;
        $obj->mensaje = "El usuario ".$usuario->correo." no fue modificado.";
        $newResponse = $response->withJson($obj,418);

        $extension=pathinfo($nombreFoto,PATHINFO_EXTENSION);
        $destino ="./fotos/" . date('Ymd') ."_" . $usuario->correo . "." .$extension;
        
        $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

        $consulta =$objetoDatos->RetornarConsulta("UPDATE usuarios SET nombre = :nombre, apellido = :apellido, correo =
        :correo, clave = :clave, dni = :dni, perfil = :perfil, sueldo = :sueldo, foto = :foto WHERE legajo = :legajo");

        $consulta->bindValue(':nombre', $usuario->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $usuario->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':correo', $usuario->correo, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $usuario->clave, PDO::PARAM_STR);
        $consulta->bindValue(':perfil', $usuario->perfil, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $destino, PDO::PARAM_STR);

        $usuarioAnt = Usuario::TraerUnUsuarioBD($usuario->correo);
        $nombre = explode("./fotos/",$usuarioAnt->foto);
        copy($usuarioAnt->foto,"./fotos/modificadas/".$nombre[1]);
        unlink($usuarioAnt->foto);

        $modifica = $consulta->execute();

        if ($modifica) {
            $imagen["foto"]->moveTo($destino);
            $obj->exito = true;
            $obj->mensaje = "El usuario ".$usuario->correo." fue modificado.";
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