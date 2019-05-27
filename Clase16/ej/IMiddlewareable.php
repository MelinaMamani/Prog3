<?php

interface IMiddlewareable
{
    static function Verificar($request, $response, $next);
}

?>