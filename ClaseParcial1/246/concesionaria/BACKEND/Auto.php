<?php

require_once 'AccesoDatos.php';

class Auto
{
    public $color;
    public $marca;
    public $modelo;
    public $precio;
    
    public function __construct($color, $marca, $precio, $modelo)
    {
        $this->color = $color;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->precio = $precio;
    }

    public static function AltaAuto($request, $response, $next)
    {
        $datos = $request->getParsedBody();
        $auto = new stdClass();
        $auto->marca = $datos["marca"];
        $auto->modelo = $datos["modelo"];
        $auto->precio = $datos["precio"];
        $auto->color = $datos["color"];
        
        //$imagen = $request->getUploadedFiles();
        //$nombreFoto = $imagen["foto"]->getClientFileName();
        
        $obj = new stdClass();
        $obj->exito = false;
        $obj->mensaje = "El auto ".$auto->modelo." no fue dado de alta";
        $newResponse = $response->withJson($obj,418);

        //$extension=pathinfo($nombreFoto,PATHINFO_EXTENSION);
        //$destino ="./fotos/" . date('Ymd') ."_" . $auto->perfil . "." .$extension;
        
        $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

        $consulta =$objetoDatos->RetornarConsulta("INSERT INTO autos (marca, modelo,
        precio, color) VALUES(:marca, :modelo, :precio, :color)");

        $consulta->bindValue(':color', $auto->color, PDO::PARAM_STR);
        $consulta->bindValue(':marca', $auto->marca, PDO::PARAM_STR);
        $consulta->bindValue(':modelo', $auto->modelo, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $auto->precio, PDO::PARAM_INT);
        //$consulta->bindValue(':foto', $destino, PDO::PARAM_STR);

        $Agrega = $consulta->execute();

        if ($Agrega) {
            //$imagen["foto"]->moveTo($destino);
            $obj->exito = true;
            $obj->mensaje = "El auto ".$auto->modelo." fue dado de alta";
            $newResponse = $response->withJson($obj,200);
        } 
        
        return $newResponse;
    }

    public static function TraerTodosAutos($request, $response, $next)
    {
        $autos = array();

        $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

        $consulta =$objetoDatos->RetornarConsulta("SELECT * FROM autos");
        
        $consulta->execute();

        while($fila = $consulta->fetch())
        {
          $auto = new auto($fila[1],$fila[2],$fila[3],$fila[4]);
          array_push($autos,$auto);
        }
        
        if (empty($autos)) 
        {
            $obj->exito = false;
            $obj->mensaje = "No hay autos.";
            $newResponse = $response->withJson($obj,424);
        } 
        else 
        {
            $obj->exito = true;
            $obj->mensaje = "Autos cargados.";
            $obj->tabla = json_encode($autos);
            $newResponse = $response->withJson($obj,200);
        }
        
        return $newResponse;
    }
    
    public static function TraerUnAuto($request, $response, $next)
    {
        $datos = $request->getParsedBody();
        $auto = new stdClass();
        $auto->modelo = $datos["modelo"];

        $obj = new stdClass();

        $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

        $consulta =$objetoDatos->RetornarConsulta("SELECT * FROM autos WHERE modelo = :modelo");

        $consulta->bindValue(':modelo', $auto->modelo, PDO::PARAM_INT);

        try
        {
            $consulta->execute();
            $fila = $consulta->fetch();

            $autoN = new auto($fila[1],$fila[2],$fila[3],$fila[4]);

            $obj->exito = true;
            $obj->mensaje = "auto: ".json_encode($autoN);
            $newResponse = $response->withJson($obj,200);
        }
        catch(Exception $e)
        {
            $obj->exito = false;
            $obj->mensaje = $e.", el auto ".$auto->modelo." no fue encontrado.";
            $newResponse = $response->withJson($obj,403);
        }
        
        return $newResponse;
    }

    public static function Eliminarauto($request, $response, $next)
    {
        $datos = $request->getParsedBody();
        $auto = new stdClass();
        $auto->modelo = $datos["modelo"];

        $obj = new stdClass();

        $objetoDatos = AccesoDatos::DameUnObjetoAcceso(); 
        $consulta =$objetoDatos->RetornarConsulta("DELETE FROM autos WHERE modelo=:modelo");	
        $consulta->bindValue(':modelo',$auto->modelo, PDO::PARAM_INT);

        $autoAnt = auto::TraerUnautoBD($auto->modelo);
        $nombre = explode("./fotos/",$autoAnt->foto);
        copy($autoAnt->foto,"./fotos/eliminadas/".$nombre[1]);
        unlink($autoAnt->foto);

        try
        {
            $consulta->execute();
            
            $obj->exito = true;
            $obj->mensaje = "El auto ".$auto->modelo." fue dado de baja.";
            $newResponse = $response->withJson($obj,200);
        }
        catch(Exception $e)
        {
            $obj->exito = false;
            $obj->mensaje = $e.", error al dar de baja a el auto ".$auto->modelo.".";
            $newResponse = $response->withJson($obj,403);
        }
        
        return $newResponse;
    }

    public static function Modificarauto($request, $response, $next)
    {
        $datos = $request->getParsedBody();
        $auto = new stdClass();
        $auto->nombre = $datos["nombre"];
        $auto->marca = $datos["marca"];
        $auto->modelo = $datos["modelo"];
        $auto->precio = $datos["precio"];
        $auto->perfil = $datos["perfil"];
        
        $imagen = $request->getUploadedFiles();
        $nombreFoto = $imagen["foto"]->getClientFileName();
        
        $obj = new stdClass();
        $obj->exito = false;
        $obj->mensaje = "El auto ".$auto->modelo." no fue modificado.";
        $newResponse = $response->withJson($obj,418);

        $extension=pathinfo($nombreFoto,PATHINFO_EXTENSION);
        $destino ="./fotos/" . date('Ymd') ."_" . $auto->modelo . "." .$extension;
        
        $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

        $consulta =$objetoDatos->RetornarConsulta("UPDATE autos SET marca = :marca, precio = :precio,
        color = :color WHERE modelo = :modelo");

        $consulta->bindValue(':color', $auto->color, PDO::PARAM_STR);
        $consulta->bindValue(':marca', $auto->marca, PDO::PARAM_STR);
        $consulta->bindValue(':modelo', $auto->modelo, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $auto->precio, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $destino, PDO::PARAM_STR);

        $autoAnt = auto::TraerUnautoBD($auto->modelo);
        $nombre = explode("./fotos/",$autoAnt->foto);
        copy($autoAnt->foto,"./fotos/modificadas/".$nombre[1]);
        unlink($autoAnt->foto);

        $modifica = $consulta->execute();

        if ($modifica) {
            $imagen["foto"]->moveTo($destino);
            $obj->exito = true;
            $obj->mensaje = "El auto ".$auto->modelo." fue modificado.";
            $newResponse = $response->withJson($obj,200);
        } 
        
        return $newResponse;
    }

    public static function TraerUnautoBD($modelo)
     {
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM autos WHERE modelo=".$modelo."");
        $consulta->execute();
        $fila = $consulta->fetch();
        $auto = new auto($fila[1],$fila[2],$fila[3],$fila[4]);
        return $auto;
     }
}


?>