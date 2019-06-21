<?php

interface IApiUsuario
{
    static function AltaUsuario($request, $response, $next);
    static function TraerTodosUsuarios($request, $response, $next);
    static function TraerUnUsuario($request, $response, $next);
    static function EliminarUsuario($request, $response, $next);
    static function ModificarUsuario($request, $response, $next);
}


?>