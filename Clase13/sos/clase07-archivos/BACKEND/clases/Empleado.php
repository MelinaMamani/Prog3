<?php

 class Empleado
 {
     #Atributos

     public $apellido;
     public $nombre;
     public $legajo;
     public $sueldo;
     public $path_foto;

     #Constructor

     function __construct($legajo,$apellido,$nombre,$sueldo,$path)
     {
         $this->apellido=$apellido;
         $this->nombre=$nombre;
         $this->legajo=$legajo;
         $this->sueldo=$sueldo;
         $this->path_foto=$path;
     }

     #Metodo Instancia

     public function ToString()
     {   
        return $this->apellido . "-" . $this->nombre."-".$this->legajo . "-" . $this->sueldo . "-" . $this->path_foto;
     }

     public static function TraerTodos()
     {

        $retorno=[];

        $ar=fopen("./archivos/empleados.txt","r");

        while(!feof($ar))
        {
            $cadena=fgets($ar);

            if($cadena=="")
            {
                continue;
            }

            $divido=explode("-",$cadena);

            //para que lo ultimo en leer no tenga el "\r\n"
            $ultimo = explode("\r\n",$divido[4]);

            //$empleado=new Empleado($divido[0],$divido[1],$divido[2],$divido[3],$divido[4]);
            $empleado=new Empleado($divido[2],$divido[1],$divido[0],$divido[3],trim($ultimo[0]));

            array_push($retorno,$empleado);
        }
       fclose($ar);

       return $retorno;
     }
     

     #Metodo Clase


     public static function Agregar($empleado)
     {

        $ar=fopen("./archivos/empleados.txt","a");

        $dato=$empleado->ToString();

        //agrego "\r\n" al final para el salto de linea
        $valor=fwrite($ar,$dato."\r\n" );

        fclose($ar);
     }

     public static function Existe($empleado)
     {
         $retorno=false;
         $aux = new Empleado("as","r","hh","t","j");
         $arrayEmpleados= $aux->TraerTodos();

         foreach($arrayEmpleados as $emp)
         {
             if($emp->ToString()== $empleado->ToString())
             {
                $retorno = true;
                break;
             }
         }
       return $retorno;
     }
     

     public static function EliminarArchivo($empleado)
     {
        $retorno = false;
        //obtengo todos los empleados del txt
        $arrayEmpleados=Empleado::TraerTodos();

        $ar=fopen("./archivos/empleados.txt","w");
        //recorro el array de empleados
        foreach($arrayEmpleados as $emp)
        {
            //si el legajo es igual , NO lo agrego a la lista nueva
            if($emp->legajo ==$empleado->legajo)
            {

            }
            else
            {
                $dato=$emp->ToString();
                $valor=fwrite($ar,$dato."\r\n");
            }
        }

    fclose($ar);
     }

    public static function ModificarArchivo($empleado)
    {
        $retorno = false;
        //obtengo todos los empleados del txt
        $arrayEmpleados=Empleado::TraerTodos();

        $ar=fopen("./archivos/empleados.txt","w");
        //recorro el array de empleados
        foreach($arrayEmpleados as $emp)
        {
            //si el legajo es igual , NO lo agrego a la lista nueva
            if($emp->legajo == $empleado->legajo)
            {
                $dato=$empleado->ToString();
                $valor=fwrite($ar,$dato."\r\n");
                unlink($emp->path_foto);
            }
            else
            {
                $dato=$emp->ToString();
                $valor=fwrite($ar,$dato."\r\n");
            }
        }

    fclose($ar);

    } 

 }

?>
