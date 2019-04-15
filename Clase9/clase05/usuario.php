<?php
require_once 'conexion.php';

class Usuario
{
    public $id;
    public $correo;
    public $nombre;
    public $apellido;
    public $perfil;

    public function Traer($id)
    {
        Conexion::EstablecerConexion();
        $sql = "SELECT FROM usuarios WHERE id={$id}";
        $usuario = NULL;
        $rs = mysql_db_query("productos", $sql);
        
        if ($rs) {
            $row = mysql_fetch_object($rs);
            $usuario = $row;
        }
        echo $row;
        Conexion::CerrarConexion();
        return $usuario;
    }

    public function TraerTodos()
    {
        Conexion::EstablecerConexion();
        $sql = "SELECT * FROM usuarios";
        $arrayUsuarios = array();
        $rs = mysql_db_query("productos", $sql);
        
        while($row = mysql_fetch_object($rs)){

        }
        
        
        Conexion::CerrarConexion();
        return $usuario;
    }
}

?>