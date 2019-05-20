<?php
interface IParteI
{
    function Agregar();
    static function Traer();
    function CalcularIVA();
    function Verificar($objeto);
    static function Modificar($id,$tipo,$precio,$pais,$foto);
}
?>