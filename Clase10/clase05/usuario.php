<?php
require_once 'acceso.php';

class Usuario
{
    public $id;
    public $correo;
    public $clave;
    public $nombre;
    public $apellido;
    public $perfil;

    public function MostrarDatos()
    {
        return $this->id."-".$this->apellido."-".$this->nombre."-".$this->correo."-".$this->perfil;
    }

    public static function TraerTodos()
    {
        $objAcceso = Acceso::DameUnObjetoAcceso();
        $consulta = $objAcceso->RetornarConsulta("SELECT * FROM usuarios");
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_INTO, new usuario);                                                

        return $consulta; 

    }

    public function InsertarUnUsuario()
    {
        $objAcceso = Acceso::DameUnObjetoAcceso();
        $consulta = $objAcceso->RetornarConsulta("INSERT INTO usuarios (id, correo, clave, nombre, apellido, perfil)".
        " VALUES (:id, :correo, :clave, :nombre, :apellido, :perfil)");

        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);
        $consulta->bindValue(':clave',$this->clave,PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido',$this->apellido,PDO::PARAM_STR);
        $consulta->bindValue(':perfil', $this->perfil, PDO::PARAM_INT);

        $consulta->execute();

    }

    public static function ModificarUsuario($id, $correo, $clave, $nombre, $apellido, $perfil)
    {
        $objAcceso = Acceso::DameUnObjetoAcceso();
        $consulta = $objAcceso->RetornarConsulta("UPDATE usuarios SET correo=:correo, clave=:clave, nombre=:nombre,".
        "apellido=:apellido, perfil=:perfil WHERE id=:id");

        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':correo', $correo, PDO::PARAM_STR);
        $consulta->bindValue(':clave',$clave,PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido',$apellido,PDO::PARAM_STR);
        $consulta->bindValue(':perfil', $perfil, PDO::PARAM_INT);

        return $consulta->execute();
    }

    public static function EliminarUsuario($user)
    {

        $objetoAccesoDato = Acceso::DameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM usuarios WHERE id = :id");
        
        $consulta->bindValue(':id', $user->id, PDO::PARAM_INT);

        return $consulta->execute();

    }

    public static function VerificarUsuario($user,$psw)
    {
        $objAcceso = Acceso::DameUnObjetoAcceso();
        $consulta = $objAcceso->RetornarConsulta("SELECT correo, clave FROM usuarios");
        //$consulta->execute(); se hace con rowCount
        while($fila = $consulta->fetchAll()){
            if (($user == $fila[1]) && ($psw == $fila[2])) {
                return true;
                break;
            }
        }                                

        return false; 
    }
}

?>