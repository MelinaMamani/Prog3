<?php
require_once "/IBDApis.php";
require_once "/Usuario.php";
require_once "/AccesoDatos.php";
class Media implements IBDApis
{
  #ATRIBUTOS

  public $id;//autoincremental
  public $color;
  public $marca;
  public $precio;
  public $talle;


  #CONSTRUCTOR

  public function __construct($id=null,$color=null,$marca=null,$precio=null,$talle=null)
  {
      $this->id=$id;
      $this->color=$color;
      $this->marca=$marca;
      $this->precio=$precio;
      $this->talle=$talle;
      
  }

  #Metodos Apis

  /*Alta con VALIDACIONES directo en la API*/
  /*
  public static function Alta($request,$response,$next)
  {
    //json de media
    $ArrayDeParametros = $request->getParsedBody();
    $media=json_decode ($ArrayDeParametros['media']);

    //json de retorno
    $objJson= new stdClass();
    $objJson->Exito=false;
    $objJson->Mensaje="Error no se pudo agregar la media en la BD";

    $mediaObj = new Media($media->id,$media->color,$media->marca,$media->precio,$media->talle);

    if($mediaObj->AltaMediaBd())
    {
        $objJson->Exito=true;
        $objJson->Mensaje="Se pudo agregar la media en la BD";
        $newResponse=$response->withJson($objJson,200);

    }
    else
    {
        $newResponse = $response->withJson($objJson,404);
    }

   return $newResponse;

  }
  */
  /*Alta sin VALIDACIONES sobre la API*/
  public static function Alta($request,$response,$next)
  {
    //json de media
    $ArrayDeParametros = $request->getParsedBody();
    $media=json_decode ($ArrayDeParametros['media']);

    //json de retorno
    $objJson= new stdClass();
    $objJson->Exito=true;
    $objJson->Mensaje="Se agrego la media";

    $mediaObj = new Media($media->id,$media->color,$media->marca,$media->precio,$media->talle);

    $mediaObj->AltaMediaBd();


   //return $response->withJson($objJson,200);
   return $response->getBody()->write("Se ha insertado la media.");

  }


  /*TraerTodos con VALIDACIONES directo en la API*/
  /*public static function TraerTodos($request,$response,$next)
  {
    $objJson= new stdClass();
    $objJson->Exito=false;
    $objJson->Mensaje="Error no se pudo recuperar todas las medias!";
    $objJson->arrayJson=null;

    $media = new Media();
    $arrayMedias=$media->TraerTodasLasMediasBD();

    if(count($arrayMedias)>0)
    {
        $objJson->Exito=true;
        $objJson->Mensaje="Se recuperaron todos las medias";
        $objJson->arrayJson=$arrayMedias;

        $newResponse= $response->withJson($objJson,200);
    }
    else
    {
       $newResponse= $response->withJson($objJson,404);
    }

   return $newResponse;
  }
  */

  /*TraerTodos sin VALIDACIONES sobre la API*/
  public static function TraerTodos($request,$response,$next)
  {
    $objJson= new stdClass();

    $media = new Media();
    $arrayMedias=$media->TraerTodasLasMediasBD();

    $objJson->Exito=true;
    $objJson->Mensaje="Se recuperaron todos las medias";
    $objJson->arrayJson=$arrayMedias;

  // return $response->withJson($objJson,200);
   return $response->withJson($arrayMedias,200);


  }

  public static function Borrar($request,$response,$next)
  {
    $ArrayDeParametros = $request->getParsedBody();

    $id_media=$ArrayDeParametros['id_media'];

  
    $media= new Media($id_media);

    $objJson= new stdClass();
    $objJson->Exito=false;
    $objJson->Mensaje="No se pudo borrar la media";

    $cantidadDeBorrados= $media->BorrarMediaBD();
    if($cantidadDeBorrados>0)
    {
      $objJson->Exito=true;
      $objJson->Mensaje="Se pudo borrar la media";

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
    $media=json_decode ($ArrayDeParametros['media']);
    

    //json de retorno
    $objJson= new stdClass();
    $objJson->Exito=false;
    $objJson->Mensaje="Error no se pudo modificar la media en la BD";

    $mediaObj = new Media($media->id,$media->color,$media->marca,$media->precio,$media->talle);


    if($mediaObj->ModificarMediaBD())
    {
        $objJson->Exito=true;
        $objJson->Mensaje="Se pudo modifcar la media en la BD";
        $newResponse=$response->withJson($objJson,200);

    }
    else
    {
        $newResponse = $response->withJson($objJson,404);
    }

   return $newResponse;

  }



  #Metodos Base de Datos
  
  private function AltaMediaBd()
  {
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into medias (color,marca,precio,talle)values(:color, :marca, :precio, :talle)");

    // return $objetoAccesoDato->RetornarUltimoIdInsertado();
    $consulta->bindValue(':color', $this->color, PDO::PARAM_STR);
    $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
    $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
    $consulta->bindValue(':talle', $this->talle, PDO::PARAM_STR);

    return $consulta->execute();
  }

  private function TraerTodasLasMediasBD()
  {
    $medias = array();
    $objetoDatos =AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoDatos->RetornarConsulta('SELECT * FROM medias'); //Se prepara la consulta, aquí se podrían poner los alias
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
      $media= new Media($fila[0],$fila[1],$fila[2],$fila[3],$fila[4]);
      array_push($medias,$media);
    }
    return $medias;
  }

  private function BorrarMediaBD()
  {
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("
    DELETE 
    FROM medias 				
    WHERE id=:id");	
    $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
    $consulta->execute();
    return $consulta->rowCount();
  }

  private function ModificarMediaBD()
  {
    $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

    //ejecuto la consulta de eliminar un usuario en el "legajo" especificado en la base de datos
    $consulta =$objetoDatos->RetornarConsulta('UPDATE medias SET color = :color, marca = :marca, precio = :precio, talle = :talle WHERE id = :idAUX' );

    $consulta->bindValue(':color', $this->color, PDO::PARAM_STR);
    $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
    $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
    $consulta->bindValue(':talle', $this->talle, PDO::PARAM_STR);

    $consulta->bindValue(':idAUX', $this->id, PDO::PARAM_INT);

    return $consulta->execute();
  }

}

?>