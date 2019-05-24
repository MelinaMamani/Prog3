<?php

class Empleado
{
    public $apellido;
    public $nombre;
    public $legajo;
    public $sueldo;
    public $path_foto;

    public function __construct($apellido,$nombre,$legajo,$sueldo,$path_foto)
    {
        $this->apellido = $apellido;
        $this->nombre = $nombre;
        $this->legajo = $legajo;
        $this->sueldo = $sueldo;
        $this->path_foto = $path_foto;
    }

    public function ToString()
    {
        return $this->legajo."-".$this->apellido."-".$this->nombre."-".$this->sueldo."-".$this->path_foto."\r\n";
    }

    static function Agregar($empleado)
    {
        $archivo = fopen("ingresantes.txt","a");
        $cant = fwrite($archivo,$empleado->ToString());

        if ($cant > 0) {
            return true;
        }

        fclose($archivo);
    }

    static function TraerTodos()
    {
        $archivo = fopen("ingresantes.txt","r");
        $empleados[] = array();
        
        while (!(feof($archivo))) {
            $datos = fgets($archivo);
            $datoEmp = explode("-",$datos);
            
            
            $empleado = new Empleado($datoEmp[1],$datoEmp[2],$datoEmp[0],$datoEmp[3],$datoEmp[4]);
            array_push($empleados,$empleado);
        }
        
        return $empleados;
    }
}
?>