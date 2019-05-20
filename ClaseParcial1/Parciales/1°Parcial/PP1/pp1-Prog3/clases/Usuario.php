<?php
class Usuario 
{
    #atributos

    private $_email;
    private $_clave;
    private $_path;

    #constructor

    public function __construct($email,$clave,$path)
    {
        $this->_email=$email;
        $this->_clave=$clave;
        $this->_path=$path;
        
    }

    public function GetEmail()
    {
        return $this->_email;
    }

    public function GetClave()
    {
        return $this->_clave;
    }

    #metodos instancia

    public function ToJson()
    {
        $auxJson = new stdClass();
        $auxJson->email = $this->_email;
        $auxJson->clave = $this->_clave;
        $auxJson->path=$this->_path;
        return json_encode($auxJson);
    }

    public function GuardarEnArchivo()
    {
        $auxReturn = new stdClass();
        $auxReturn->Exito=false;
        $auxReturn->Mensaje="No se pudo guardar en el archivo";

        $ar=fopen("./archivos/usuarios.json","a");

        if($ar != false) 
        {
            if(fwrite($ar, $this->ToJson()."\r\n")) {
                $auxReturn->Exito = true;
                $auxReturn->Mensaje = "Se ha guardado en el archivo con exito.";
            }
            
            fclose($ar);
        }

        return $auxReturn;
    }

    #metodos de clase

    public static function TraerTodos()
    {
        {
            $auxReturn = array();

            if(file_exists("./archivos/usuarios.json")) 
            {
                $ar = fopen("./archivos/usuarios.json", "r");

                if($ar != false) 
                {
                    while(!feof($ar)) 
                    {
                        $auxlinea = trim(fgets($ar));
                        if($auxlinea != "") 
                        {
                            $auxJson = json_decode($auxlinea);
                            $auxUsuario = new Usuario($auxJson->email, $auxJson->clave,$auxJson->path);

                            array_push($auxReturn, $auxUsuario);
                        }
                    }
                    fclose($ar);
                }
            }

            return $auxReturn;
        }
    }

    public static function VerificarExistencia($usuario)
    {
        $retorno = false;
        $arrayUsuarios = Usuario::TraerTodos();

        foreach($arrayUsuarios as $us)
        {
          // if($us->ToJson()===$usuario->ToJson())
          if($us->_email==$usuario->_email)
           {
               $retorno=true;
           } 
        }

        return $retorno;
    }


}


?>