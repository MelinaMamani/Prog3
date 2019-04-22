<?php

require_once 'usuario.php';
require_once 'acceso.php';

$op = isset($_POST['op']) ? $_POST['op'] : NULL;

switch ($op) {
    case 'acceso':
    $objetoAccesoDato = Acceso::DameUnObjetoAcceso();
        
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios");
    $consulta->execute();
    
    $consulta->setFetchMode(PDO::FETCH_INTO, new usuario);
    
    foreach ($consulta as $usuario) {
    
        print_r($usuario->MostrarDatos());
        print("
                ");
    }
        break;

        case 'insertarUsuario':
    
        $nuevoUsuario = new usuario();
        $nuevoUsuario->id = 66;
        $nuevoUsuario->correo = "correito@mail.com";
        $nuevoUsuario->clave = "dinosaurio";
        $nuevoUsuario->apellido = "surname";
        $nuevoUsuario->nombre = "name";
        $nuevoUsuario->perfil = 2000;
        
        $nuevoUsuario->InsertarUnUsuario();

        echo "Insertó gg";
        
        break;

    case 'modificarUsuario':
    
        $id = $_POST['id'];        
        $correo = $_POST['correo'];
        $clave = $_POST['clave'];
        $apellido = $_POST['apellido'];
        $nombre = $_POST['nombre'];
        $perfil = $_POST['perfil'];
    
        echo usuario::ModificarUsuario($id, $correo, $clave, $apellido, $nombre, $perfil);
            
        break;

    case 'eliminarUsuario':
    
        $nuevoUsuario = new usuario();
        $nuevoUsuario->id = 66;
        
        $nuevoUsuario->eliminarUsuario($nuevoUsuario);

        echo "Elimina3";
        
        break;
    
    case 'verificarUsuario':
        $correo = $_POST['correo'];
        $clave = $_POST['clave'];
        if(usuario::verificarUsuario($correo,$clave))
        {
            echo "Si está el usuario en la bd.";
        }
        break;

    default:
        # code...
        break;
}

?>