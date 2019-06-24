<?php

class MW
{
    public static function VerificarEmpleado($request,$response,$next)
    {
        //obtengo el json
        $ArrayDeParametros = $request->getParsedBody();
        $perfil=$ArrayDeParametros['perfil'];

    }
}
?>