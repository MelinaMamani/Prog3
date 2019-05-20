<?php
require_once "IParte2.php";
require_once "AccesoDatos.php";

class Televisor implements IParte2
{
   #atributos
   public $tipo;
   public $precio;
   public $paisOrigen;
   public $path;

   #constructor
   public function __construct($tipo = null, $precio = null, $paisOrigen = null, $path = null)
   {
    $this->tipo = $tipo != null ? $tipo : "";
    $this->precio = $precio != null ? $precio : "";
    $this->paisOrigen = $paisOrigen != null ? $paisOrigen : "";
    $this->path = $path != null ? $path : "";
    }

    #metodo instancia
    public function ToJson()
    {
        $auxJson = new stdClass();
        $auxJson->tipo = $this->tipo;
        $auxJson->precio = $this->precio;
        $auxJson->paisOrigen = $this->paisOrigen;
        $auxJson->path = $this->path;

        return json_encode($auxJson);
    }


    public function Agregar()
    {

        $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

        $consulta =$objetoDatos->RetornarConsulta("INSERT INTO televisores (tipo, precio, pais, foto)"
                                                    . "VALUES(:tipo, :precio, :pais, :foto)"); 
        
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':pais', $this->paisOrigen, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $this->path, PDO::PARAM_STR);

        

        return $consulta->execute();
    }

    public function Traer()
    {
        $televisores = array();
        $objetoDatos =AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoDatos->RetornarConsulta('SELECT * FROM televisores'); //Se prepara la consulta, aquí se podrían poner los alias
        $consulta->execute();

        /*v1
        $consulta->setFetchMode(PDO::FETCH_LAZY);

        foreach ($consulta as $tele) {
            $auxTele = new Televisor($tele->tipo,$tele->precio,$tele->pais,$tele->foto);
            array_push($auxReturn, $auxTele);
        }*/

        //v2
        while($fila = $consulta->fetch())
        {
          $tele= new Televisor($fila[1],$fila[2],$fila[3],$fila[4]);
          array_push($televisores,$tele);
        }
        return $televisores;
    }

    public function CalcularIva()
    {
        $auxIva = $this->precio *21 /100;            
        return $this->precio + $auxIva;
    }
   
}


?>