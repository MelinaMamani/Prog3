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
        $obj->exito = "No";
        $obj->mensaje = "El usuario ".$usuario->legajo." no fue dado de alta";
        $newResponse = $response->withJson($obj,403);

        $extension=pathinfo($nombreFoto,PATHINFO_EXTENSION);
        $destino ="fotos/" . date('Ymd') ."_" . $usuario->legajo . "." .$extension;
        
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
            $obj->exito = "0k.";
            $obj->mensaje = "El usuario ".$usuario->legajo." fue dado de alta";
            $newResponse = $response->withJson($obj,200);
        } 
        //$response = $next($request,$response);
        return $newResponse;
    }
}


?>