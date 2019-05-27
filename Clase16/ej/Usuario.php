<?php

class Usuario
{
    public $tipo;
    public $nombre;

    public function __construct($tipo, $nombre)
    {
        $this->tipo = $tipo;
        $this->nombre = $nombre;
    }

    public function ToString()
    {
        return $this->tipo."-".$this->nombre;
    }

    public function MetodoInstancia($request, $response, $next)
    {
        $response->getBody()->write("Estoy en el método de instancia<br>");
        return $next($request, $response);
    }

    public static function MetodoEstatico($request, $response, $next)
    {
        $response->getBody()->write("Estoy en el método estático<br>");
        return $next($request, $response);
    }

    public function Guardar()
    {
        $archivo = fopen("./archivos/admins.txt","a");

        $dato = $this->ToString();

        $valor = fwrite($archivo, $dato."\r\n");

        fclose($archivo);
    }

    public static function TraerTodos()
    {

        $usuarios=[];

        $archivo=fopen("./archivochivos/admins.txt","r");

        while(!feof($archivo))
        {
            $cadena=fgets($archivo);

            if($cadena=="")
            {
                continue;
            }

            $divido=explode("-",$cadena);

            $ultimo = explode("\r\n",$divido[4]);

            $usuario=new Usuario($);

            array_push($array,$usuario);
        }
       fclose($archivo);

       return $usuarios;
    }
}
?>