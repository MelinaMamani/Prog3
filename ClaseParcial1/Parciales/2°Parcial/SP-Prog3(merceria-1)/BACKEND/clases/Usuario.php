<?php
require_once "/IBDApis.php";
require_once "/AccesoDatos.php";

class Usuario implements IBDApis
{
    #ATRIBUTOS

    public $id;
    public $correo;
    public $clave;
    public $nombre;
    public $apellido;
    public $perfil; //propietario-encargado-empleado
    public $foto;

    #CONSTRUCTOR

    public function __construct($id=null,$correo=null,$clave=null,$nombre=null,$apellido=null,$perfil=null,$foto=null)
    {
        $this->id=$id;
        $this->correo=$correo;
        $this->clave=$clave;
        $this->nombre=$nombre;
        $this->apellido=$apellido;
        $this->perfil=$perfil;
        $this->foto=$foto;
    }

   #METODOS SOBRE LAS APIS

    /*Alta con VALIDACIONES sobre el metodo*/
    /*public static function Alta($request,$response,$next)
    {
        //obtengo el json
        $ArrayDeParametros = $request->getParsedBody();
        $user=json_decode ($ArrayDeParametros['user']);

        //obtengo la foto
        $archivos= $request->getUploadedFiles();
        $foto=$archivos['foto']->getClientFilename();
        $destino ="./BACKEND/fotos/" . $foto;

        //json de retorno
        $objJson= new stdClass();
        $objJson->Exito=false;
        $objJson->Mensaje="Error no se pudo agregar el usuario";

        $usuario = new Usuario($user->id,$user->correo,$user->clave,$user->nombre,$user->apellido,$user->perfil,$foto);

        if($usuario->AgregarUsuarioBD())
        {
            $objJson->Mensaje="Ok";
            $objJson->Exito=true;

            $newResponse= $response->withJson($objJson,$objJson->Estado);

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
    }*/

    /*Alta sin VALIDACIONES sobre el metodo API*/
    public static function Alta($request,$response,$next)
    {
        //obtengo el json
        $ArrayDeParametros = $request->getParsedBody();
       // $user=json_decode ($ArrayDeParametros['user']);
       $user= new Usuario();

        $clave=$ArrayDeParametros['clave'];
        $correo=$ArrayDeParametros['correo'];
        echo $clave . " ---- " . $correo;die();

        //obtengo la foto
        $archivos= $request->getUploadedFiles();
        $foto=$archivos['foto']->getClientFilename();
        $destino ="./BACKEND/fotos/" . $foto;

        //json de retorno
        $objJson= new stdClass();
        $objJson->Exito=TRUE;
        $objJson->Mensaje="Se pudo agregar el usuario";

        $usuario = new Usuario($user->id,$user->correo,$user->clave,$user->nombre,$user->apellido,$user->perfil,$foto);

        $usuario->AgregarUsuarioBD();

        $archivos["foto"]->moveTo($destino);
            

       return $response->withJson($objJson,200); 
       //return $response->getBody()->write("Se ha insertado la media.");
    }


    /*TraerTodos con VALIDACIONES sobre el metodo*/
    /*public static function TraerTodos($request,$response,$next)
    {
        $objJson= new stdClass();
        $objJson->Exito=false;
        $objJson->Mensaje="Error no se pudo recuperar todos los usuarios!";
        $objJson->arrayUsuario=null;

        $user = new Usuario();
        $arrayUsuario=$user->TraerTodosLosUsuariosBD();

        if(count($arrayUsuario)>0)
        {
            $objJson->Exito=true;
            $objJson->Mensaje="Se recuperaron todos los usuarios";
            $objJson->arrayUsuario=$arrayUsuario;

            $newResponse= $response->withJson($objJson,200);
        }
        else
        {
           $newResponse= $response->withJson($objJson,404);
        }

       return $newResponse;
    }*/

    /*TraerTodos sin VALIDACIONES sobre el metodo*/
    public static function TraerTodos($request,$response,$next)
    {
        $objJson= new stdClass();
        $objJson->Exito=true;
        $objJson->Mensaje="se pudo recuperar todos los usuarios!";
        $objJson->arrayUsuario=null;

        $user = new Usuario();
        $arrayUsuario=$user->TraerTodosLosUsuariosBD();

        $objJson->arrayUsuario=$arrayUsuario;

      // return $response->withJson($objJson,200);
       return $response->withJson($arrayUsuario,200);
    }
    
    public static function Borrar($request,$response,$next)
    {
        
    }
    public static function Modificar($request,$response,$next){}
    #METODOS SOBRE LA BASE DE DATOS

    private function AgregarUsuarioBD()
    {
        $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

        $consulta =$objetoDatos->RetornarConsulta("INSERT INTO usuarios (correo, clave, nombre, apellido, perfil, foto)"
                                                        . "VALUES(:correo, :clave, :nombre, :apellido, :perfil, :foto)"); 
            
        $consulta->bindValue(':correo', $this->correo, PDO::PARAM_INT);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':perfil', $this->perfil, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);

        //return $objetoAccesoDato->RetornarUltimoIdInsertado();
        return $consulta->execute();
    }

    public function TraerTodosLosUsuariosBD()
    {
        $usuarios = array();
        $objetoDatos =AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoDatos->RetornarConsulta('SELECT * FROM usuarios'); //Se prepara la consulta, aquí se podrían poner los alias
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
          $user= new Usuario($fila[0],$fila[1],$fila[2],$fila[3],$fila[4],$fila[5],$fila[6]);
          array_push($usuarios,$user);
        }
        return $usuarios;
    }

    public function ListadoFotos()
    {
        $user=new Usuario();
        $arrayUsuarios= $user->TraerTodosLosUsuariosBD();

        $tabla="";

        $tabla .= "<table border=1>";
        $tabla .= "<thead>";
        $tabla .= "<tr>";
        $tabla .= "<td>id</td>";
        $tabla .= "<td>correo</td>";
        $tabla .= "<td>clave</td>";
        $tabla .= "<td>nombre</td>";
        $tabla .= "<td>apellido</td>";
        $tabla .= "<td>perfil</td>";
        $tabla .= "<td>foto</td>";
        $tabla .= "</tr>";
        $tabla .= "</thead>";

        foreach($arrayUsuarios as $us)
        {
            $tabla .= "<tr>";
            $tabla .= "<td>";
            $tabla .= $us->id;
            $tabla .= "</td>";
            $tabla .= "<td>";
            $tabla .=$us->correo;
            $tabla .= "</td>";
            $tabla .= "<td>";
            $tabla .= $us->clave;
            $tabla .= "</td>";
            $tabla .= "<td>";
            $tabla .= $us->nombre;
            $tabla .= "</td>";
            $tabla .= "<td>";
            $tabla .= $us->apellido;
            $tabla .= "</td>";
            $tabla .= "<td>";
            $tabla .= $us->perfil;
            $tabla .= "</td>";
            $tabla.="<td>";
            if(file_exists("BACKEND/fotos/".$us->foto)) {
                //echo '<img src="img/'.$jug->GetImagen().'" alt="'.$jug->GetImagen().'" height="100px" width="100px">'; 
                $tabla.= '<img src="BACKEND/fotos/'.$us->foto.'" alt=BACKEND/fotos/"'.$us->foto.'" height="100px" width="100px">'; 
              
            }
            else 
            {
               $tabla.= 'no hay imagen'.$us->foto; 
            }

            $tabla.="</td>";

            $tabla .= "</tr>";
        }
        $tabla .= "</table>";

        return $tabla;

    }
}
?>