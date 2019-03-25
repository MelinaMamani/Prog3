<?php

class Triangulo extends FiguraGeometrica
{
    private $_base;
    private $_altura;

    public function __construct(double $h, $b)
    {
        parent::__construct();
        $this->_base = $b;
        $this->_altura = $h;
    }

}

?>