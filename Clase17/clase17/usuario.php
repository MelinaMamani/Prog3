<?php

class Usuario
{
    public $nombre;
    public $apellido;
    public $division;

    public function __construct($nombre,$apellido,$division)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->division = $division;
    }
}


?>