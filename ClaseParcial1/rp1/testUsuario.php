<?php
    require_once "./clases/Usuario.php";
    require_once "./UsuarioAlta.php";
    require_once "./VerificarUsuario.php";


    $email = $_POST["email"];// ? $_POST['email'] : null;
    $clave = $_POST["clave"];// ? $_POST['clave'] : null;
    
    //echo json_encode(ManejadorAlta::AltaUsuario())."<br>";


    $auxUsuario = new Usuario($email, $clave);
    if(Usuario::VerificarExistencia($auxUsuario)) {
        echo "Existe Usuario<br>";  
    }
    
    echo "Verifica ";
    echo $auxUsuario->ToJson()."<br>";

    //echo json_encode($auxUsuario->GuardarEnArchivo())."<br>";

    /*$auxArray = Usuario::TraerTodos();

    foreach ($auxArray as $usuario) {
        echo $usuario->ToJson();
    }*/

    
    echo json_encode(ManejadorUsuario::VerificarUsuario())."<br>";
?>