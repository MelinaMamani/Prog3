<?php
    require_once "./clases/Usuario.php";
    
    class ManejadorAlta {
        public static function AltaUsuario() {
            $auxReturn = new stdClass();
            $auxReturn->Exito = false;
            $auxReturn->Mensaje = "Aún no hay alta";

            $email = isset($_POST["email"]) ? $_POST["email"] : null;
            $clave = isset($_POST["clave"]) ? $_POST["clave"] : null;
            $alta = ($email != "" && $clave != "") ? true : false;

            
            if($alta) {
                $auxUsuario = new Usuario($email, $clave);
                
                $auxGuardado = $auxUsuario->GuardarEnArchivo();
                $auxReturn->Exito = true;
                $auxReturn->Mensaje = "Se ha guardado usuario en el archivo desde UsuarioAlta";
                echo json_decode($auxUsuario->ToJSON());
            }
            return $auxReturn;
        }
    }
?>