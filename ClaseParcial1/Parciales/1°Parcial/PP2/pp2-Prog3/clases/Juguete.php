<?php
require_once "IParte1.php";
require_once "IParte2.php";
require_once "AccesoDatos.php";
class Juguete implements IParte1 , IParte2
{
    #atributos

    private $tipo;
    private $precio;
    private $paisOrigen;
    private $pathImagen;

    #constructor

    public function __construct($tipo , $precio , $pais , $path=null)
    {
        $this->tipo=$tipo;
        $this->precio = $precio;
        $this->paisOrigen=$pais;
        $this->pathImagen=$path != null ? $path : "";
    }

    #metodos de instancia

    public function GetTipo()
    {
        return $this->tipo;
    }
    public function GetPrecio()
    {
        return $this->precio;
    }
    public function GetPais()
    {
        return $this->paisOrigen;
    }
    public function GetImagen()
    {
        return $this->pathImagen;
    }

    public function ToString()
    {
        return $this->tipo . "-" . $this->precio . "-" . $this->paisOrigen . "-" . $this->pathImagen;
    }

    public function Agregar()
    {
        $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

        $consulta =$objetoDatos->RetornarConsulta("INSERT INTO juguetes (tipo, precio, pais, foto)"
                                                        . "VALUES(:tipo, :precio, :pais, :foto)"); 
            
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':pais', $this->paisOrigen, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $this->pathImagen, PDO::PARAM_STR);

        return $consulta->execute();
        
    }

    public function Traer()
    {
        $juguetes =[];

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM juguetes");

        $consulta->execute();
        
        while($fila = $consulta->fetch())
        {
          $juguete= new Juguete($fila[1],$fila[2],$fila[3],$fila[4]);
          array_push($juguetes,$juguete);
        }


        return $juguetes;
    }

    public function CalcularIva()
    {
        $iva = $this->precio * (21/100);
        return $this->precio+$iva;
    }

    public function Verificar($arraJuguetes)
    {
        $retorno = true;

        foreach ($arraJuguetes as $juguete)
        {
            if($juguete->ToString() == $this->ToString())
            {
                $retorno=false;
                break;
            }
        }

        return $retorno;
    }

    #metodos de clase

    public static function MostrarLog()
    {
        if(file_exists("./archivos/juguetes_sin_foto.txt"))
        {
            $ar = fopen("./archivos/juguetes_sin_foto.txt","r");

            while(!feof($ar))
            {
             $cadena = fgets($ar);
     
             if($cadena=="")
             {
               continue;
             }
   
            echo $cadena;
           }
           fclose($ar);
        }

    }

    public function Modificar($id,$tipo, $precio, $pais, $foto)
    {
        $retorno = false;
            
       
            $objetoDatos = AccesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoDatos->RetornarConsulta('UPDATE juguetes SET tipo = :tipo, precio = :precio, pais = :pais, foto = :foto WHERE id=:id');

            $consulta->bindValue(':tipo', $tipo, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $precio, PDO::PARAM_INT);
            $consulta->bindValue(':pais', $pais, PDO::PARAM_STR);
            $consulta->bindValue(':foto', $foto, PDO::PARAM_STR);

            $consulta->bindValue(':id',$id,PDO::PARAM_INT);
           /* $consulta->bindValue(':tipoAct', $this->tipo, PDO::PARAM_STR);
            $consulta->bindValue(':precioAct', $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(':paisAct', $this->paisOrigen, PDO::PARAM_STR);
            $consulta->bindValue(':fotoAct', $this->pathImagen, PDO::PARAM_STR);*/

            $consulta->execute();
            if($consulta->rowCount() > 0) 
            {
                $retorno = true;
            }
        return $retorno;
        
    }

    public function TraerId($id)
    {
        $usuario = null;

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM juguetes WHERE id=:id");

        $consulta->bindValue(':id',  $id, PDO::PARAM_INT);

        $consulta->execute();

        //V1:obtengo la fila especificada en la consultado , como tipo indexado o por clave
        $fila=$consulta->fetch();

        if($fila!==null)
        {
          $juguete= new Juguete($fila[1],$fila[2],$fila[3],$fila[4]);
        }


        return $juguete;

    }
}
?>