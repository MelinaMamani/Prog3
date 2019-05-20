<?php
include "IParteI.php";

class Juguete implements IParteI
{
    private $tipo;
    private $precio;
    private $paisOrigen;
    private $path;

    public function __construct($tipo, $precio, $paisOrigen, $path = "Sin imagen")
    {
        $this->tipo = $tipo;
        $this->precio = $precio;
        $this->paisOrigen = $paisOrigen;
        $this->path = $path;
    }

    public function ToString()
    {
        return $this->tipo." - ".$this->precio." - ".$this->paisOrigen." - ".$this->path;
    }

    # -- Implementando la Interface --

    public function Agregar()
    {
        try 
        {

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO juguetes(tipo, precio, pais, foto) VALUES (:tipo,:precio,:pais,:foto)");

            $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT); 
            $consulta->bindValue(':pais',$this->paisOrigen, PDO::PARAM_STR);
            $consulta->bindValue(':foto', $this->path, PDO::PARAM_STR); 

            $obj = new stdClass();
            $obj->Exito = FALSE;
            $obj->Mensaje = "";

            $consulta->execute();
            $rows = $consulta->rowCount(); //Para PDO se usa el rowCount en vez de mysql_affected_row()
            
            if($rows > 0)
            {
                $obj->Exito = TRUE;
                $obj->Mensaje = "Producto agregado con exito";
            }
            else
            {
                $obj->Mensaje = "Error al agregar el producto";
            }
            
        } 
        catch (PDOException $e)
        {
            $obj->Mensaje = "Error!!!<br/>" . $e->getMessage();
            echo json_encode($obj); // No tengo que devolver nada, si da error, muestro acá
        }

        return json_encode($obj);
    }

    public static function Traer()
    {
        $obj = new stdClass();
        $obj->Mensaje = "";

        try
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * from juguetes");

            $consulta->execute();
            
            $rows = $consulta->rowCount(); //Para PDO se usa el rowCount en vez de mysql_affected_row()
            if($rows > 0)
            {
                return $consulta->fetchall();
            }
            else
            {
                $obj->Mensaje = "Error, no se pudo encontrar nada!";
            }
        }
        catch (PDOException $e) 
        {
            $obj->Mensaje = "Error!!!<br/>" . $e->getMessage();
        }

        echo json_encode($obj);
    }
# En caso de necesitar eso, desarrollar
    public function Verificar($juguete) //Recibe un array 
    {
        try
        {
            foreach($juguete as $j)
            {
                if($j[1] == $this->tipo && $j[2] == $this->precio && $j[3] == $this->paisOrigen)
                {
                    return false;
                }
            }
            return true;
        }
        catch (Exception $e) 
        {
            print "Error!!!<br/>" . $e->getMessage();
            die();
        }
    } 

    public static function Modificar($id,$tipo,$precio,$pais,$foto)
    {

        $obj = new stdClass();
        $obj->Mensaje = "";

        try
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE juguetes SET tipo=:tipo, precio=:precio, pais=:pais, foto=:foto WHERE id=:id");
            
            $consulta->bindValue(':tipo', $tipo, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $precio, PDO::PARAM_INT);
            $consulta->bindValue(':pais',$pais, PDO::PARAM_STR);
            $consulta->bindValue(':foto', $foto, PDO::PARAM_STR);
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);  
            
            $consulta->execute();
            
            $rows = $consulta->rowCount(); //Para PDO se usa el rowCount en vez de mysql_affected_row()
            
            if($rows > 0)
            {
                $obj->Mensaje = TRUE;
            }
            else
            {
                $obj->Mensaje = FALSE;
            }
        }
        catch (PDOException $e) 
        {
            $obj->Mensaje = "Error!!!<br/>" . $e->getMessage();
            echo json_encode($obj); // No tengo que devolver nada, si da error, muestro acá
        }

        return json_encode($obj);
    }

    public function CalcularIVA()
    {
        $IVA =  $this->precio * 1.21;
        return $this->precio + $IVA;
    }

    # -- Fin de la implementacion de la Interface --

    public static function MostrarLog()
    {
        $array = array();

        $ar = fopen("./archivos/juguetes_sin_foto.txt","r"); //Leo

        while(!feof($ar)){

            $cadena = fgets($ar);
            $bloque = explode(" - ",$cadena);

            if($cadena == ""){
                continue;
            }
            $juguete = new Juguete($bloque[0],$bloque[1],$bloque[2],$bloque[3]);
            array_push($array,$juguete);
        }

        fclose($ar);

        return $array;
    }
}

?>