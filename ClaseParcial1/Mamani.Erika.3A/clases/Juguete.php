<?php
require_once 'acceso.php';
require_once 'IParte1.php';

class Juguete implements IParte1
{
    private $tipo;
    private $precio;
    private $paisOrigen;
    private $pathImagen;

    public function __construct($tipo,$precio,$paisOrigen,$pathImagen = false)
    {
        $this->tipo = $tipo;
        $this->precio = $precio;
        $this->paisOrigen = $paisOrigen;
        
        if ($pathImagen) {
            $this->pathImagen = $pathImagen;
        }
        else {
            $this->pathImagen = "";
        }    
    }

    public function ToString()
    {
        return $this->tipo."-".$this->precio."-".$this->paisOrigen."-".$this->pathImagen;
    }
    
    public function Agregar()
    {
        $objAcceso = acceso::DameUnObjetoAcceso();
        $consulta = $objAcceso->RetornarConsulta("INSERT INTO juguetes (tipo, precio, pais, foto)".
        " VALUES (:tipo, :precio, :pais, :foto)");

        $consulta->bindValue(':tipo',$this->tipo,PDO::PARAM_STR);
        $consulta->bindValue(':precio',$this->precio,PDO::PARAM_STR);
        $consulta->bindValue(':pais',$this->paisOrigen,PDO::PARAM_STR);
        $consulta->bindValue(':foto', $this->pathImagen, PDO::PARAM_STR);

        $consulta->execute();
        return true;
    }

    public function Traer()
    {
        $objAcceso = Acceso::DameUnObjetoAcceso();
        $juguetes = array();
        $consulta = $objAcceso->RetornarConsulta("SELECT * FROM juguetes");
        $consulta->execute();
        
        $consulta->setFetchMode(PDO::FETCH_INTO, new Juguete);
        
        foreach ($consulta as $juguete) {
            array_push($juguetes,$juguete);
        }

        return $juguetes;
    }

    public function CalcularIVA()
    {
        $iva = ($this->precio*21)/100;
        $precioConIVA = $this->precio + $iva;
        return $precioConIVA;
    }

    public function Verificar($juguetes)
    {
        $flag = true;

        foreach ($juguetes as $juguete) {
            if ($juguete == $this) {
                $flag = false;
                break;
            }       
        }
        
        return $flag;
    }

    public static function MostrarLog()
    {
        $archivo = fopen("./archivos/juguetes_sin_foto.txt","r");
        $lectura = fread($archivo,filesize("./archivos/juguetes_sin_foto.txt"));

        echo $lectura;

        fclose($archivo);
    }
}


?>