<?php
require_once "IParte2.php";
require_once "IParte3.php";
require_once "AccesoDatos.php";

class Ovni implements IParte2,IParte3
{
    #atributos

    public $tipo;
    public $velocidad;
    public $planetaOrigen;
    public $pathFoto;

    public function __construct($tipo = null, $velocidad = null, $planetaOrigen = null, $pathFoto = null)
    {
     $this->tipo = $tipo != null ? $tipo : "";
     $this->velocidad = $velocidad != null ? $velocidad : "";
     $this->planetaOrigen = $planetaOrigen != null ? $planetaOrigen : "";
     $this->pathFoto = $pathFoto != null ? $pathFoto : "";
    }

    //metodos instancia
    public function ToJson()
    {
        $auxJson = new stdClass();
        $auxJson->tipo = $this->tipo;
        $auxJson->velocidad = $this->velocidad;
        $auxJson->planeta = $this->planetaOrigen;
        $auxJson->foto = $this->pathFoto;

        return json_encode($auxJson);
    }

    public function Agregar()
    {
        $objetoDatos =AccesoDatos::DameUnObjetoAcceso();

        $consulta =$objetoDatos->RetornarConsulta("INSERT INTO ovnis (tipo, velocidad, planeta, foto)"
                                                    . "VALUES(:tipo, :velocidad, :planeta, :foto)"); 
        
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':velocidad', $this->velocidad, PDO::PARAM_INT);
        $consulta->bindValue(':planeta', $this->planetaOrigen, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);

        return $consulta->execute();
    }

    public function Traer()
    {
        $ovnis = array();
        $objetoDatos = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoDatos->RetornarConsulta('SELECT * FROM ovnis');
        $consulta->execute();

        
       /*v1
        $consulta->setFetchMode(PDO::FETCH_LAZY);

        foreach ($consulta as $ovniA) {
            $auxOvni = new Ovni($ovniA->tipo,$ovniA->velocidad,$ovniA->planeta,$ovniA->foto);
            array_push($auxReturn, $auxOvni);
        }*/

        //v2
        while($fila = $consulta->fetch())
        {
          $ovni= new Ovni($fila[1],$fila[2],$fila[3],$fila[4]);
          array_push($ovnis,$ovni);
        }
        return $ovnis;
 
    }

    public function ActivarVelocidadWarp()
    {
        return $this->velocidad * 10.45;
    }

    public function Existe($arrayOvnis)
    {
        $retorno = false;

        foreach($arrayOvnis as $ovni)
        {
            if($this->ToJson()==$ovni->ToJson())
            {
                $retorno=true;
            }
        }
        return $retorno;
    }

    public function Modificar($id, $tipo, $velocidad, $planeta, $foto)
    {
        $retorno = false;
            
        $objetoDatos = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoDatos->RetornarConsulta('UPDATE ovnis SET tipo = :tipo, velocidad = :velocidad, planeta = :planeta, foto = :foto WHERE id=:id');

        $consulta->bindValue(':tipo', $tipo, PDO::PARAM_STR);
        $consulta->bindValue(':velocidad', $velocidad, PDO::PARAM_INT);
        $consulta->bindValue(':planeta', $planeta, PDO::PARAM_STR);
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
        $ovni = null;

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM ovnis WHERE id=:id");

        $consulta->bindValue(':id',  $id, PDO::PARAM_INT);

        $consulta->execute();

        //V1:obtengo la fila especificada en la consultado , como tipo indexado o por clave
        $fila=$consulta->fetch();

        if($fila!==null)
        {
          $ovni= new Ovni($fila[1],$fila[2],$fila[3],$fila[4]);
        }


        return $ovni;

    }


}



?>