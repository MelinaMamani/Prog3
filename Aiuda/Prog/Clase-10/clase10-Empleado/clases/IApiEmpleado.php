<?php

interface IApiEmpleado
{
    public static function AltaUsuario($request,$response,$next);
    public static function TraerTodosLosUsuarios($request,$response,$next);
    public static function TraerUnUsuario($request,$response,$next);
    public static function EliminarUsuario($request,$response,$next);
    public static function ModificarUsuario($request,$response,$next);



}

?>