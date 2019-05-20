<?php
class Cliente{
    private $_nombre;
    private $_correo;
    private $_clave;

    public function __construct($nombre,$correo,$clave){
        $this->_nombre=$nombre;
        $this->_correo=$correo;
        $this->_clave=$clave;
    }
    public function toString(){
        return $this->_nombre."-".$this->_correo."-".$this->_clave;
    }

    public static function GuardarEnArchivo($cliente){
        $archivo = fopen("./archivos/clientesActuales.txt", "a");
        fwrite($archivo, $cliente->ToString(). "\r\n"); 
        fclose($archivo);
    }
}



?>