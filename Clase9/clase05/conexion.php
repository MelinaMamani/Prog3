<?php

class Conexion
{
    public $base = "productos";
    private $user = "root";
    private $clave = "";
    public $con;
    
    static function EstablecerConexion()
    {
        Conexion::$con = mysql_connect("localhost", Conexion::$user, Conexion::$clave);
        return Conexion::$con;
    }

    static function CerrarConexion()
    {
        return mysql_close(Conexion::$con);
    }
}

?>