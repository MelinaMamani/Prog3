<?php
//require_once "IApiUsable.php";
require_once "IApiEmpleado.php";
require_once "AccesoDatos.php";
 class Empleado1 implements IApiEmpleado
 {
     #Atributos

     public $apellido;
     public $nombre;
     public $legajo;
     public $sueldo;
     public $path_foto;

     #Constructor

     function __construct($legajo=null,$nombre=null,$apellido=null,$sueldo=null,$path=null)
     {
         $this->apellido=$apellido;
         $this->nombre=$nombre;
         $this->legajo=$legajo;
         $this->sueldo=$sueldo;
         $this->path_foto=$path;
     }


     public static function AltaUsuario($request,$response,$next)
     {
         //obtengo el json
        $ArrayDeParametros = $request->getParsedBody();
        $user=json_decode ($ArrayDeParametros['user']);

        //obtengo la foto
        $archivos= $request->getUploadedFiles();
        $foto=$archivos['foto']->getClientFilename();

        //json de retorno
        $objJson= new stdClass();
        $objJson->Exito=false;
        $objJson->Mensaje="Error no se pudo agregar empleado";
        $objJson->Estado=404;

        //obtengo la extension
        $extension= explode(".", $foto);
        $extension=array_reverse($extension);
 
        //obtengo el nombre que voy a guardar como path en base de datos
        $nombreAGuardar= date("d-m-Y") .".".$user->legajo ."." . $extension[0];

        //destino en donde voy a guardar la foto
        $destino = "./fotos/" . $nombreAGuardar;

        $empleado= new Empleado1($user->legajo,$user->nombre,$user->apellido,$user->sueldo,$nombreAGuardar);

        //agrego el usuario
        if($empleado->AgregarUsuarioBD())
        {
            $objJson->Mensaje="Ok";
            $objJson->Estado=200;
            $objJson->Exito=true;

            $newResponse= $response->withJson($objJson,$objJson->Estado); 
            try
            {
                $archivos["foto"]->moveTo($destino);
            }
            catch(Exception $e)
            {
                $objJson->Mensaje=$e->getMessage();
               $newResponse= $response->withJson($objJson,$objJson->Estado); 
            }

        }
        else
        {
            $newResponse= $response->withJson($objJson,$objJson->Estado); 
        }
        
         return $newResponse;
     }

     public static function TraerTodosLosUsuarios($request,$response,$next)
     {
         $objJson= new stdClass();
         $objJson->Exito=false;
         $objJson->Mensaje="Error no se pudo recuperar todos los usuarios!";
         $objJson->arrayEmpleado=null;

         $emp = new Empleado1();
         $arrayEmp=$emp->TraerTodosLosUsuariosBD();

         if(count($arrayEmp)>0)
         {
             $objJson->Exito=true;
             $objJson->Mensaje="Se recuperaron todos los usuarios";
             $objJson->arrayEmpleado=$arrayEmp;

             $newResponse= $response->withJson($objJson,200);
         }
         else
         {
            $newResponse= $response->withJson($objJson,404);
         }

        return $newResponse;
     }

     public static function EliminarUsuario($request,$response,$next)
     {
        $ArrayDeParametros = $request->getParsedBody();
        $legajo = $ArrayDeParametros['legajo'];


        $objJson= new stdClass();
        $objJson->Exito=false;
        $objJson->Mensaje="No se encontro al usuario";
       
        $empleado= new Empleado1($legajo);

        $empleadoViejo=$empleado->TraerUnUsuarioBD();
       
        //valido que me retorne algo correcto
        if($empleadoViejo->legajo ==$legajo)
        {
            $cantidadDeBorrados= $empleado->EliminarUsuarioBD();

            if($cantidadDeBorrados>0)
            {
                copy("./fotos/".$empleadoViejo->path_foto,"./fotos/eliminadas/".$empleadoViejo->path_foto);
                //elimino la imagen anterior ya que esta es reemplazada por la nueva que agregamos
                unlink("./fotos/".$empleadoViejo->path_foto);
            $objJson->Mensaje="Se pudo eliminar al empleado";
            $objJson->Exito=true;
            $newResponse = $response->withJson($objJson,202);
            }
            else
            {
                $objJson->Mensaje="No se pudo eliminar de la base de datos";
                $newResponse = $response->withJson($objJson,404);
            }
        }
        else
        {
            $newResponse = $response->withJson($objJson,404);
        }

        return $newResponse;


     }
     public static function ModificarUsuario($request,$response,$next)
     {
         //otengo el objUsuario y lo decodeo
        $ArrayDeParametros = $request->getParsedBody();
        $user=json_decode ($ArrayDeParametros['user']);
        
        //obtengo la foto
        $archivos= $request->getUploadedFiles();
        $foto=$archivos['foto']->getClientFilename();

          //json de retorno
          $objJson= new stdClass();
          $objJson->Exito=false;
          $objJson->Mensaje="Error no se encontro  el empleado";
          $objJson->Estado=404;
  
          //obtengo la extension
          $extension= explode(".", $foto);
          $extension=array_reverse($extension);
   
          //obtengo el nombre que voy a guardar como path en base de datos
          $nombreAGuardar= date("d-m-Y") .".".$user->legajo ."." . $extension[0];
  
          //destino en donde voy a guardar la foto
          $destino = "./fotos/" . $nombreAGuardar;
  
          $empleado= new Empleado1($user->legajo,$user->nombre,$user->apellido,$user->sueldo,$nombreAGuardar);

          $empleadoViejo=$empleado->TraerUnUsuarioBD();


          //verifico que el empleado anterior exista con el legajo
          if($empleadoViejo->legajo==$empleado->legajo)
          {
              //verifico que se modifique en la base de datos
                if($empleado->ModificarEmpleadoBD())
                {
                    $objJson->Mensaje="Ok";
                    $objJson->Estado=200;
                    $objJson->Exito=true;
        
                    $newResponse= $response->withJson($objJson,$objJson->Estado); 

                    //verifico que la foto se pueda mover a su destino y la anterior que la mueva a fotos/modificadas
                    try
                    {
                        $archivos["foto"]->moveTo($destino);
                        copy("./fotos/".$empleadoViejo->path_foto,"./fotos/modificadas/".$empleadoViejo->path_foto);
                        //elimino la imagen anterior ya que esta es reemplazada por la nueva que agregamos
                       unlink("./fotos/".$empleadoViejo->path_foto);
                    }
                    catch(Exception $e)
                    {
                        $objJson->Mensaje=$e->getMessage();
                        $objJson->Exito=false;
                        $objJson->Estado=404;
                    $newResponse= $response->withJson($objJson,$objJson->Estado); 
                    }
        
                }
                else
                {
                    $objJson->Exito=false;
                    $objJson->Mensaje="Error no se encontro  pudo modificar el empleado en la base de datos";
                    $objJson->Estado=404;
                    $newResponse= $response->withJson($objJson,$objJson->Estado); 
                }
          }
          else
          {
              $newResponse=$response->withJson($objJson,$objJson->Estado); 
          }



        return $newResponse;

     }

    public static function TraerUnUsuario($request,$response,$next)
    {
        //recupero el legajo
        $legajo = $_GET['legajo'];

        $objJson= new stdClass();
        $objJson->Exito=false;
        $objJson->Mensaje="Error, no se encontro al usuario";
        $objJson->usuarioJson=null;


        $empleado = new Empleado1($legajo);

        //otengo al empleado de la base de datos
        $empleadoViejo=$empleado->TraerUnUsuarioBD();

        if($empleadoViejo->legajo ==$legajo)
        {
            $objJson->Exito=true;
            $objJson->Mensaje="Usuario existente";
            $objJson->usuarioJson= $empleadoViejo;
           
            $newResponse= $response->withJson($objJson,200);
        }
        else
        {
            $newResponse= $response->withJson($objJson,404);
        }

        return $newResponse;

    }

     public function AgregarUsuarioBD()
     {
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into empleados2 (legajo,nombre,apellido,sueldo,path)values('$this->legajo','$this->nombre','$this->apellido','$this->sueldo','$this->path_foto')");
       // return $objetoAccesoDato->RetornarUltimoIdInsertado();
       return $consulta->execute();

     }

     public function EliminarUsuarioBD()
     {
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
        DELETE 
        FROM empleados2 				
        WHERE legajo=:legajo");	
        $consulta->bindValue(':legajo',$this->legajo, PDO::PARAM_INT);		
        $consulta->execute();
        return $consulta->rowCount();
     }

     public function TraerUnUsuarioBD()
     {
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM empleados2 WHERE legajo=:legajo");
        $consulta->bindValue(':legajo', $this->legajo, PDO::PARAM_INT);
        $consulta->execute();
        $fila = $consulta->fetch();
        $empleado= new Empleado1($fila[1],$fila[2],$fila[3],$fila[4],$fila[5]);
        return $empleado;
     }

     public function ModificarEmpleadoBD()
     {
        $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

        //ejecuto la consulta de eliminar un usuario en el "legajo" especificado en la base de datos
        $consulta =$objetoDatos->RetornarConsulta('UPDATE empleados2 SET nombre = :nombre, apellido = :apellido, sueldo = :sueldo, path = :path WHERE legajo = :legajoAUX' );
  
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':sueldo', $this->sueldo, PDO::PARAM_INT);
        $consulta->bindValue(':path', $this->path_foto, PDO::PARAM_STR);
  
        $consulta->bindValue(':legajoAUX', $this->legajo, PDO::PARAM_INT);
  
        return $consulta->execute();

     }

    /* inicio funciones especiales para slimFramework*/

    public function TraerTodosLosUsuariosBD()
    {
        $empleados = array();
        $objetoDatos =AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoDatos->RetornarConsulta('SELECT * FROM empleados2'); //Se prepara la consulta, aquí se podrían poner los alias
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
          $empleado= new Empleado1($fila[1],$fila[2],$fila[3],$fila[4],$fila[5]);
          array_push($empleados,$empleado);
        }
        return $empleados;
    }

     

     
     public function mostrarDatos()
     {
         return "Metodo mostrar" . $this->legajo." ". $this->nombre." ". $this->apellido . " " . $this->sueldo . " " . $this->path_foto;
     }

 }


?>