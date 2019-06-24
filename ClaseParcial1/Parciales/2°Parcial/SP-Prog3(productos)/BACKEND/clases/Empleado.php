<?php
require_once "/AccesoDatos.php";
require_once "/IBDApis.php";

class Empleado implements IBDApis
{
    #ATRIBUTOS
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $foto;
    public $legajo;
    public $clave;
    public $perfil;


    #CONSTRUCTOR

    public function __construct($id=null,$nombre=null,$apellido=null,$email=null,$foto=null,$legajo=null,$clave=null,$perfil=null)
    {
        $this->id=$id;
        $this->nombre=$nombre;
        $this->apellido=$apellido;
        $this->email=$email;
        $this->foto=$foto;
        $this->legajo=$legajo;
        $this->clave=$clave;
        $this->perfil=$perfil;
    }



    public static function Alta($request,$response,$next)
    {
        //obtengo el json
        $ArrayDeParametros = $request->getParsedBody();

        $id=$ArrayDeParametros['id'];
        $nombre=$ArrayDeParametros['nombre'];
        $apellido=$ArrayDeParametros['apellido'];
        $email=$ArrayDeParametros['email'];
        $legajo=$ArrayDeParametros['legajo'];
        $clave=$ArrayDeParametros['clave'];
        $perfil=$ArrayDeParametros['perfil'];

        //obtengo la foto
        $archivos= $request->getUploadedFiles();
        $foto=$archivos['foto']->getClientFilename();
        $destino ="./BACKEND/fotos/" . $foto;

        //json de retorno
        $objJson= new stdClass();
        $objJson->Exito=false;
        $objJson->Mensaje="Error no se pudo agregar el usuario";

        $empleado = new Empleado($id,$nombre,$apellido,$email,$foto,$legajo,$clave,$perfil);

        if($empleado->AltaEmpleadoBD())
        {
            $objJson->Mensaje="Ok";
            $objJson->Exito=true;

            $newResponse= $response->withJson($objJson,200);

            try
            {
                $archivos["foto"]->moveTo($destino);
            }
            catch(Exception $e)
            {
               $objJson->Mensaje=$e->getMessage();
               $objJson->Exito=false;
               $newResponse= $response->withJson($objJson,404); 
            }

        }
        else
        {
            $newResponse= $response->withJson($objJson,404); 
        }

       return $newResponse;
    }

    public static function Verificar($request,$response,$next)
    {
        $ArrayDeParametros = $request->getParsedBody();

        $id=$ArrayDeParametros['id'];
        $nombre=$ArrayDeParametros['nombre'];
        $apellido=$ArrayDeParametros['apellido'];
        $email=$ArrayDeParametros['email'];
        $legajo=$ArrayDeParametros['legajo'];
        $clave=$ArrayDeParametros['clave'];
        $perfil=$ArrayDeParametros['perfil'];

        //obtengo la foto
        $archivos= $request->getUploadedFiles();
        $foto=$archivos['foto']->getClientFilename();

        //json de retorno
        $objJson= new stdClass();
        $objJson->Exito=false;
        $objJson->Mensaje="Error el usuario no existe en la base de datos";

        $newResponse=$response->withJson($objJson,409);

        $empleado = new Empleado($id,$nombre,$apellido,$email,$foto,$legajo,$clave,$perfil);

        $arrayEmpleados=$empleado->TraerTodosLosEmpleadosBD();

        foreach($arrayEmpleados as $emp)
        {
           if($emp->email == $email && $emp->clave == $clave)
           {
             $objJson->Exito=true;
             $objJson->Mensaje="El empleado existe en la base de datos,empleado correcto!";
             $newResponse=$response->withJson($objJson,200);
           }
        }

        return $newResponse;
        
    }

    public static function TraerTodos($request,$response,$next)
    {
        $objJson= new stdClass();
        $objJson->Exito=false;
        $objJson->Mensaje="Error no se pudo recuperar todos los empleados!";
        $objJson->arrayEmpleado=null;

        $empleado = new Empleado();
        $arrayEmpleados=$empleado->TraerTodosLosEmpleadosBD();

        if(count($arrayEmpleados)>0)
        {
            $objJson->Exito=true;
            $objJson->Mensaje="Se recuperaron todos los empleados";
            $objJson->arrayEmpleado=$arrayEmpleados;

            $newResponse= $response->withJson($objJson,200);
        }
        else
        {
           $newResponse= $response->withJson($objJson,404);
        }

       return $newResponse;
    }

    public static function Borrar($request,$response,$next){}
    public static function Modificar($request,$response,$next){}

    private function AltaEmpleadoBD()
    {
        $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

        $consulta =$objetoDatos->RetornarConsulta("INSERT INTO empleados (nombre, apellido, email, foto, legajo, clave, perfil)"
                                                        . "VALUES(:nombre, :apellido, :email, :foto, :legajo, :clave, :perfil)"); 
            
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':email', $this->email, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
        $consulta->bindValue(':legajo', $this->legajo, PDO::PARAM_INT);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':perfil', $this->perfil, PDO::PARAM_STR);

        //return $objetoAccesoDato->RetornarUltimoIdInsertado();
        return $consulta->execute();
    }

    private function TraerTodosLosEmpleadosBD()
    {
        $empleados = array();
        $objetoDatos =AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoDatos->RetornarConsulta('SELECT * FROM empleados'); //Se prepara la consulta, aquí se podrían poner los alias
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
          $empleado= new Empleado($fila[0],$fila[1],$fila[2],$fila[3],$fila[4],$fila[5],$fila[6],$fila[7]);
          array_push($empleados,$empleado);
        }
        return $empleados;
    }

}


?>