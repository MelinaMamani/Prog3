<?php
require_once 'acceso.php';

class Manejadora
{
    public static function ValidarUsuario($legajo,$clave)
    {
        $obj = new stdClass();
        $obj->Exito = false;
        $obj->Empleado = null;

        $objAcceso = Acceso::DameUnObjetoAcceso();
        $consulta = $objAcceso->RetornarConsulta("SELECT * FROM empleados WHERE legajo=".$legajo." AND
        clave=".$clave."");
        $consulta->execute();
        $empleado = $consulta->fetchAll();

        foreach ($empleado as $campo) {
            $aux = new stdClass();
            $aux->legajo = $campo['legajo'];
            $aux->clave = $campo['clave'];

            $obj->Exito = true;
            $obj->Empleado = $aux;
        }

        return $obj;
    }
}


?>