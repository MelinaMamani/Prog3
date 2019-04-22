<?php

class Acceso
{
    private static $_objetoAccesoDatos;
    private $_objetoPDO;

    public function __construct()
    {
        try
        {
            $user = "root";
            $pass = "";

            $this->_objetoPDO = new PDO("mysql:host=localhost;dbname=productos;charset=utf8",$user,$pass);

        }
        
        catch(PDOException $e)
        {
            echo "Error! ".$e->getMessage();
            die();
        }
    }

    public function RetornarConsulta($sql)
    {
        return $this->_objetoPDO->prepare($sql);
    }
 
    public static function DameUnObjetoAcceso()
    {
        if (!isset(self::$_objetoAccesoDatos)) {       
            self::$_objetoAccesoDatos = new Acceso(); 
        }
 
        return self::$_objetoAccesoDatos;        
    }
 
    public function __clone()
    {
        trigger_error('La clonaci&oacute;n de este objeto no est&aacute; permitida!!!', E_USER_ERROR);
    }
}



?>