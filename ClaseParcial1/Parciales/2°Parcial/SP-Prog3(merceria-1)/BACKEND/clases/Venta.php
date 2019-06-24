<?php
require_once "/IBDApis.php";
require_once "/AccesoDatos.php";
class Venta implements IBDApis
{
    #ATRIBUTOS

    public $id;
    public $id_usuario;
    public $id_media;
    public $cantidad; //cantidad vendida

    #CONSTRUCTOR

    public function __construct($id=null,$id_usuario=null,$id_media=null,$cantidad=null)
    {
        $this->id=$id;
        $this->id_usuario=$id_usuario;
        $this->id_media=$id_media;
        $this->cantidad=$cantidad;
    }

    public static function Alta($request,$response,$next)
    {
        //json de venta
        $ArrayDeParametros = $request->getParsedBody();
        $venta=json_decode ($ArrayDeParametros['venta']);

        //json de retorno
        $objJson= new stdClass();
        $objJson->Exito=false;
        $objJson->Mensaje="Error no se pudo agregar la venta en la BD";

        $ventaObj = new Venta($venta->id,$venta->id_usuario,$venta->id_media,$venta->cantidad);

  
        if($ventaObj->AltaVentaBd())
        {
            $objJson->Exito=true;
            $objJson->Mensaje="Se pudo agregar la venta en la BD";
            $newResponse=$response->withJson($objJson,200);

        }
        else
        {
            $newResponse = $response->withJson($objJson,504);
        }

     return $newResponse;
    }

    /*TraerTodos con VALIDACIONES directo en la API*/
    /*public static function TraerTodos($request,$response,$next)
    {
        $objJson= new stdClass();
        $objJson->Exito=false;
        $objJson->Mensaje="Error no se pudo recuperar todas las ventas!";
        $objJson->arrayJson=null;

        $venta = new Venta();
        $arrayVentas=$venta->TraerTodasLasVentasBD();

        if(count($arrayVentas)>0)
        {
            $objJson->Exito=true;
            $objJson->Mensaje="Se recuperaron todos las ventas";
            $objJson->arrayJson=$arrayVentas;

            $newResponse= $response->withJson($objJson,200);
        }
        else
        {
        $newResponse= $response->withJson($objJson,404);
        }

     return $newResponse;
    }*/

    /*TraerTodos sin VALIDACIONES directo en la API*/

    public static function TraerTodos($request,$response,$next)
    {
        $objJson= new stdClass();
      
        $venta = new Venta();
        $arrayVentas=$venta->TraerTodasLasVentasBD();
      
        $objJson->Exito=true;
        $objJson->Mensaje="Se recuperaron todos las medias";
        $objJson->arrayJson=$arrayVentas;
      
        // return $response->withJson($objJson,200);
        return $response->withJson($arrayVentas,200);
            
    }

    public static function Borrar($request,$response,$next)
    {
      $ArrayDeParametros = $request->getParsedBody();

      $id_usuario=$ArrayDeParametros['id_usuario'];
      $id_media=$ArrayDeParametros['id_media'];

      $venta= new Venta(2,$id_usuario,$id_media);

      $objJson= new stdClass();
      $objJson->Exito=false;
      $objJson->Mensaje="No se pudo borrar la venta";

      $cantidadDeBorrados= $venta->BorrarVentaBD();
      if($cantidadDeBorrados>0)
      {
        $objJson->Exito=true;
        $objJson->Mensaje="Se pudo borrar la venta";

        $newResponse=$response->withJson($objJson,200);
      }
      else
      {
        $newResponse=$response->withJson($objJson,404);
      }

      return $newResponse;

    }
    public static function Modificar($request,$response,$next)
    {
        //json de media
        $ArrayDeParametros = $request->getParsedBody();
        $venta=json_decode ($ArrayDeParametros['venta']);
        

        //json de retorno
        $objJson= new stdClass();
        $objJson->Exito=false;
        $objJson->Mensaje="Error no se pudo modificar la venta en la BD";

        $ventaObj = new Venta($venta->id,2,2,$venta->cantidad);



        if($ventaObj->ModificarVentaBD())
        {
            $objJson->Exito=true;
            $objJson->Mensaje="Se pudo modifcar la venta en la BD";
            $newResponse=$response->withJson($objJson,200);

        }
        else
        {
            $newResponse = $response->withJson($objJson,404);
        }

      return $newResponse;
    }


    

          
  private function AltaVentaBd()
  {
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into ventas (id_usuario,id_media,cantidad)values(:id_usuario, :id_media, :cantidad)");

    // return $objetoAccesoDato->RetornarUltimoIdInsertado();s
    $consulta->bindValue(':id_usuario', $this->id_usuario, PDO::PARAM_INT);
    $consulta->bindValue(':id_media', $this->id_media, PDO::PARAM_INT);
    $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);


    return $consulta->execute();
  }

  private function TraerTodasLasVentasBD()
  {
    $ventas = array();
    $objetoDatos =AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoDatos->RetornarConsulta('SELECT * FROM ventas'); //Se prepara la consulta, aquí se podrían poner los alias
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
      $venta= new Venta($fila[0],$fila[1],$fila[2],$fila[3]);
      array_push($ventas,$venta);
    }
    return $ventas;
  }

  private function BorrarVentaBD()
  {
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("
    DELETE 
    FROM ventas 				
    WHERE id_usuario=:id_usuario AND id_media=:id_media");	
    $consulta->bindValue(':id_usuario',$this->id_usuario, PDO::PARAM_INT);
    $consulta->bindValue(':id_media',$this->id_media, PDO::PARAM_INT);		
    $consulta->execute();
    return $consulta->rowCount();
  }

  private function ModificarVentaBD()
  {
    $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

    //ejecuto la consulta de eliminar un usuario en el "legajo" especificado en la base de datos
    $consulta =$objetoDatos->RetornarConsulta('UPDATE ventas SET cantidad = :cantidad WHERE id = :idAUX' );

    $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
 

    $consulta->bindValue(':idAUX', $this->id, PDO::PARAM_INT);

    return $consulta->execute();
  }



}

?>