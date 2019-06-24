<?php
require_once "/AccesoDatos.php";
require_once "/IBDApis.php";

class Producto implements IBDApis
{
    #ATRIBUTOS

    public $id;
    public $nombre;
    public $precio;

    #CONSTRUCTOR

    public function __construct($id=null,$nombre=null,$precio=null)
    {
        $this->id=$id;
        $this->nombre=$nombre;
        $this->precio=$precio;

    }

    public static function Alta($request,$response,$next)
    {
        //obtengo el json
        $ArrayDeParametros = $request->getParsedBody();

        $id=$ArrayDeParametros['id'];
        $nombre=$ArrayDeParametros['nombre'];
        $precio=$ArrayDeParametros['precio'];

        //json de retorno
        $objJson= new stdClass();
        $objJson->Exito=false;
        $objJson->Mensaje="Error no se pudo agregar el producto en la bd";

        $producto = new Producto($id,$nombre,$precio);

        if($producto->AltaProductoBD())
        {
            $objJson->Mensaje="Se pudo agregar el  producto en la bd";
            $objJson->Exito=true;

            $newResponse= $response->withJson($objJson,200);
        }
        else
        {
            $newResponse= $response->withJson($objJson,404); 
        }

       return $newResponse;

    }
    public static function TraerTodos($request,$response,$next)
    {
        $objJson= new stdClass();
        $objJson->Exito=false;
        $objJson->Mensaje="Error no se pudo recuperar todos los prodcutos!";
        $objJson->arrayProductos=null;

        $producto = new Producto();
        $arrayProductos=$producto->TraerTodosLosProductos();

        if(count($arrayProductos)>0)
        {
            $objJson->Exito=true;
            $objJson->Mensaje="Se recuperaron todos los empleados";
            $objJson->arrayProductos=$arrayProductos;

            $newResponse= $response->withJson($objJson,200);
        }
        else
        {
           $newResponse= $response->withJson($objJson,404);
        }

       return $newResponse;
    }
    public static function Borrar($request,$response,$next)
    {
        $ArrayDeParametros = $request->getParsedBody();

        $id=$ArrayDeParametros['id'];
    
        $producto= new Producto($id);
    
        $objJson= new stdClass();
        $objJson->Exito=false;
        $objJson->Mensaje="No se pudo borrar el producto";
    
        $cantidadDeBorrados= $producto->BorrarProductoBD();
        if($cantidadDeBorrados>0)
        {
          $objJson->Exito=true;
          $objJson->Mensaje="Se pudo borrar el producto";
    
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
        $id=$ArrayDeParametros['id'];
        $nombre=$ArrayDeParametros['nombre'];
        $precio=$ArrayDeParametros['precio'];
        

        //json de retorno
        $objJson= new stdClass();
        $objJson->Exito=false;
        $objJson->Mensaje="Error no se pudo modificar el producto en la BD";

        $producto = new Producto($id,$nombre,$precio);


        if($producto->ModificarProductoBD())
        {
            $objJson->Exito=true;
            $objJson->Mensaje="Se pudo modifcar el producto en la BD";
            $newResponse=$response->withJson($objJson,200);

        }
        else
        {
            $newResponse = $response->withJson($objJson,404);
        }

     return $newResponse;
    }

    private function AltaProductoBD()
    {
        $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

        $consulta =$objetoDatos->RetornarConsulta("INSERT INTO productos (nombre, precio)"
                                                        . "VALUES(:nombre, :precio)"); 
            
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);

        //return $objetoAccesoDato->RetornarUltimoIdInsertado();
        return $consulta->execute();
    }

    private function TraerTodosLosProductos()
    {
        $productos = array();
        $objetoDatos =AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoDatos->RetornarConsulta('SELECT * FROM productos'); //Se prepara la consulta, aquí se podrían poner los alias
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
          $producto= new Producto($fila[0],$fila[1],$fila[2]);
          array_push($productos,$producto);
        }
        return $productos;
    }

    private function BorrarProductoBD()
    {
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
        DELETE 
        FROM productos 				
        WHERE id=:id");	

        $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
        $consulta->execute();

        return $consulta->rowCount();
    }

    private function ModificarProductoBD()
    {
        $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

        //ejecuto la consulta de eliminar un usuario en el "legajo" especificado en la base de datos
        $consulta =$objetoDatos->RetornarConsulta('UPDATE productos SET nombre = :nombre, precio = :precio WHERE id = :idAUX' );
    
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);

        $consulta->bindValue(':idAUX', $this->id, PDO::PARAM_INT);
    
        return $consulta->execute();
    }

}

?>