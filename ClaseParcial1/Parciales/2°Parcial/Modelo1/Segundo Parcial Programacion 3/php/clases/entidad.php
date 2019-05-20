<?php

class entidad
{
	//id-nombre-apellido-email-foto-legajo-password-perfil
	public $id;
	public $nombre;
	public $apellido;
	public $legajo;
	public $perfil;
	public $email;
	public $password;
	public $foto;

	public static function BuscarUsuario($email, $pwd)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("select * from DonFuBD.empleados where email = :email and password = :pwd;");
		$consulta->bindValue(':email', $email, PDO::PARAM_STR);
		$consulta->bindValue(':pwd', $pwd, PDO::PARAM_STR);
		$consulta->execute();
		$entidadBuscado = $consulta->fetchObject('entidad');
		return $entidadBuscado;
	}

  	public function borrarEntidad()
	{
	 	$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("delete from DonFuBD.empleados WHERE id =:id;");

		$consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
		$consulta->execute();
		return $consulta->rowCount();
	}

	public function HabilitarUsuario() // habilitar o deshabilitar un usuario, baja lógica
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta =$objetoAccesoDato->RetornarConsulta(
			"UPDATE DonFuBD.empleados SET habilitado = :habilitado WHERE id = :id;"
		);

		$consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
		$consulta->bindValue(':habilitado', $this->habilitado, PDO::PARAM_INT);
		$consulta->execute();
		return $consulta->rowCount();
	}

	public function InsertarParametros()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

		$query = "INSERT into DonFuBD.empleados (nombre, apellido, legajo, perfil, email, password"
		. (isset($this->foto) ? ", foto" : "")
		. ") values (:nombre, :apellido, :legajo, :perfil, :email, :password"
		. (isset($this->foto) ? ", :foto" : "")
		. ");";

		//var_dump($query); die();

		$consulta = $objetoAccesoDato->RetornarConsulta($query);

		$consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
		$consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
		$consulta->bindValue(':legajo', $this->legajo, PDO::PARAM_INT);
		$consulta->bindValue(':perfil', $this->perfil, PDO::PARAM_STR);
		$consulta->bindValue(':email', $this->email, PDO::PARAM_STR);
		$consulta->bindValue(':password', $this->password, PDO::PARAM_STR);

		if(isset($this->foto)) $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);

		$consulta->execute();
		return $objetoAccesoDato->RetornarUltimoidInsertado();
	}

	public function Guardarentidad()
	{
	 	if($this->id>0)
		{
			$this->ModificarentidadParametros();
		}
		else
		{
			$this->InsertarElentidadParametros();
		}
	}

  	public static function TraerTodoLosUsuarios()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from DonFuBD.empleados");
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_CLASS, "entidad");
	}

}
