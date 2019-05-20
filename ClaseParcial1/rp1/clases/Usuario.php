<?php
    class Usuario {
        private $_email;
        private $_clave;

        public function __construct($email, $clave) {
            $this->_email = $email;
            $this->_clave = $clave;
        }

        public function ToJson() {
            $auxJson = new stdClass();
            $auxJson->email = $this->_email;
            $auxJson->clave = $this->_clave;
            return json_encode($auxJson);
        }

        public function GuardarEnArchivo() {
            $json = new stdClass();
            $file = fopen('./archivos/usuarios.json', "a+");

            if($file != false) {
                if(fwrite($file, $this->ToJson()."\r\n")) {
                    $json->Exito = true;
                    $json->Mensaje = "Usuario guardado en el archivo.";
                }
                
                fclose($file);
            }

            return $json;
        }

        public static function TraerTodos() {
            $usuarios = array();

            if(file_exists("./archivos/usuarios.json")) {
                $file = fopen("./archivos/usuarios.json", "r");

                if($file != false) {
                    while(!feof($file)) {
                        $auxlinea = trim(fgets($file));
                        if($auxlinea != "") {
                            $auxJson = json_decode($auxlinea);
                            $auxUsuario = new Usuario($auxJson->email, $auxJson->clave);

                            array_push($usuarios, $auxUsuario);
                        }
                    }
                    fclose($file);
                }
            }

            return $usuarios;
        }

        public static function VerificarExistencia($usuario) {
            $retorno = false;
            $arrayUsuarios = Usuario::TraerTodos(); 

            foreach ($arrayUsuarios as $usuarioA) {
                if($usuarioA->ToJson() === $usuario->ToJson()) {
                    $retorno = true;
                    break;
                }
            }

            return $retorno;
        }
    }
?>