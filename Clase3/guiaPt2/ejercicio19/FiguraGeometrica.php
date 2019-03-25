<?php

abstract class FiguraGeometrica
{
    protected $_color;
    protected $_superficie;
    protected $_perimetro;

    public function __construct()
    {
        $this->_color = "negro";
        $this->_perimetro = 0.0;
        $this->_superficie = 0.0;
    }

    protected abstract function CalcularDatos();
    public abstract function Dibujar();

    public function GetColor()
    {
        return $this->_color;
    }

    public function SetColor($color)
    {
        $this->_color = $color;
    }

    public function ToString()
    {
        return $this->GetColor()." - ".$this->_superficie." - ".$this->_perimetro;;
    }
}

?>