<?php
class producto
{
    public $id;
    public $nombre;
    public $precio;
    
    public function InsertarParametros()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

		$query = "INSERT into DonFuBD.productos (nombre, precio"
		. ") values (:nombre, :precio);";

		//var_dump($query); die();

		$consulta = $objetoAccesoDato->RetornarConsulta($query);

		$consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
		$consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);

		$consulta->execute();
		return $objetoAccesoDato->RetornarUltimoidInsertado();
	}

    public static function TraerTodoLosProductos()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from DonFuBD.productos");
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_CLASS, "producto");
    }
    
    public function borrarProducto()
	{
	 	$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("delete from DonFuBD.productos WHERE id =:id;");

		$consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
		$consulta->execute();
		return $consulta->rowCount();
    }
    
    public function ModificarProducto()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta =$objetoAccesoDato->RetornarConsulta(
			"UPDATE DonFuBD.productos SET nombre = :nombre, precio = :precio WHERE id = :id;");

        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
		$consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
		$consulta->execute();
		return $consulta->rowCount();
	}
}


?>
