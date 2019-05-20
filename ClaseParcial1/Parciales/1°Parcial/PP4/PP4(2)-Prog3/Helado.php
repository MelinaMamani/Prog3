<?php
interface IVendible{
    public function PrecioMasIva();
}
class Helado implements IVendible{
    private $_sabor;
    private $_precio;
    private $_path;
    
    public function __construct($sabor,$precio){
        $this->_sabor=$sabor;
        $this->_precio=$precio;
    }
    public function SetPath($path){
        $this->_path=$path;
    }

    public function GetSabor(){
        return $this->_sabor;
    }
    public function GetPath(){
        return $this->_path;
    }
    public function GetPrecio(){
        return $this->_precio;
    }
    public function PrecioMasIva($cantidad=1){
        return ($cantidad*$this->_precio)*1.21;
    }
    public static function RetornarArrayDeHelados(){
        $helado1=new Helado("Chocolate",2);
        $helado2=new Helado("Limon",4);
        $helado3=new Helado("Dulce de leche",2.7);
        $helado4=new Helado("Americana",6.5);
        $helado5=new Helado("Vainilla",9);

        return array($helado1,$helado2,$helado3,$helado4,$helado5);
    }
    
    public static function RetornarArrayArchivo(){
        $archivo = fopen("./heladosArchivo/helados.txt", "r");
        $arrayRetorno=array();
        while(!feof($archivo))
        {
           $arrayHelado=explode("-",fgets($archivo));
           if(trim($arrayHelado[0]!=""))
           {
            $helado=new Helado(trim($arrayHelado[0]),trim($arrayHelado[1]));
            $helado->SetPath(trim($arrayHelado[2]));
            array_push($arrayRetorno,$helado);
           }
        }
        fclose($archivo);
        return $arrayRetorno;
    }
}



?>