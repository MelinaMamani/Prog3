<?php

class Rectangulo extends FiguraGeometrica
{
    private $_ladoDos;
    private $_ladoUno;

    public function __construct(double $l1, $l2)
    {
        parent::__construct();
        $this->_ladoDos = $l1;
        $this->_ladoUno = $l2;
    }

    protected function CalcularDatos()
    {
        $this->_perimetro = $this->ladoUno*4;
    }

}



?>