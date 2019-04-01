<?php

class Persona
{
    public $nombre;
    public $apellido;

    public function ToString()
    {
        return $this->nombre."-".$this->apellido."</br>";
    }

    public function Guardar()
    {
        $archivo = fopen("archivo.txt","a");
        $cant = fwrite($archivo,$this->ToString());

        if ($cant > 0) {
            return true;
        }

        fclose($archivo);
    }

    public function Leer()
    {
        $archivoL = fopen("archivo.txt","r");

        $lectura = fread($archivoL,filesize("archivo.txt"));

        echo $lectura;

        return true;

        fclose($archivoL);
    }

    static function TraerTodasLasPersonas()
    {
        $archivo = fopen("archivo.txt","r");
        $lectura = fread($archivo,filesize($archivo));
        $persona = new Persona();

        while (!(feof($lectura))) {
            $persona->nombre = explode($lectura,"-");
            $persona->apellido = explode($lectura,"</br>");
            $array = $persona;
        }
    }
}


?>