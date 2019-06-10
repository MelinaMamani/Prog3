<?php

interface IApiUsuario
{
    static function AltaUsuario($request, $response, $next);
    static function TraerTodosUsuarios($request, $response, $next);
    static function TraerUnUsuario($request, $response, $next);
    //function EliminarUsuario($request, $response, $next);
    //function ModificarUsuario($request, $response, $next);
}


?>