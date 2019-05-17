<?php
require_once "AccesoDatos.php";
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

        $empleados =[];

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM empleados");

        $consulta->execute();
        
        while($fila = $consulta->fetch())
        {
          $empleado= new Empleado($fila[1],$fila[3],$fila[2],$fila[4],$fila[5]);
          array_push($empleados,$empleado);
        }


        return $empleados;
     }
     

     #Metodo Clase


     public static function Agregar($empleado)
     {

        $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

        $consulta =$objetoDatos->RetornarConsulta("INSERT INTO empleados (legajo, nombre, apellido, sueldo, path_foto)"
                                                        . "VALUES(:legajo, :nombre, :apellido, :sueldo, :path_foto)"); 
            
        $consulta->bindValue(':legajo', $empleado->legajo, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $empleado->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $empleado->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':sueldo', $empleado->sueldo, PDO::PARAM_INT);
        $consulta->bindValue(':path_foto', $empleado->path_foto, PDO::PARAM_STR);

        return $consulta->execute();
     }

     public static function Existe($empleado)
     {
        $empleados =Empleado::TraerTodos();
        $auxReturn = false;
        
        foreach($empleados as $emp) {
            if($emp->legajo == $empleado->legajo) {
                $auxReturn = true;
            }
        }

        return $auxReturn;
     }
     

     public static function EliminarArchivo($empleado)
     {
        $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

        //ejecuto la consulta de eliminar un usuario en el "legajo" especificado en la base de datos
        $consulta =$objetoDatos->RetornarConsulta("DELETE FROM empleados WHERE legajo= :legajo");

        $consulta->bindValue(':legajo', $empleado->legajo, PDO::PARAM_INT);

        return $consulta->execute();
    
     }

     public static function ModificarArchivo($empleado)
     {
      $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

      //ejecuto la consulta de eliminar un usuario en el "legajo" especificado en la base de datos
      $consulta =$objetoDatos->RetornarConsulta('UPDATE empleados SET nombre = :nombre, apellido = :apellido, sueldo = :sueldo, path_foto = :path_foto WHERE legajo = :legajoAUX' );

      $consulta->bindValue(':nombre', $empleado->nombre, PDO::PARAM_STR);
      $consulta->bindValue(':apellido', $empleado->apellido, PDO::PARAM_STR);
      $consulta->bindValue(':sueldo', $empleado->sueldo, PDO::PARAM_INT);
      $consulta->bindValue(':path_foto', $empleado->path_foto, PDO::PARAM_STR);

      $consulta->bindValue(':legajoAUX', $empleado->legajo, PDO::PARAM_INT);

      return $consulta->execute();

     }

     //Elimina una en archivo tenieno como referencia el legajo pasado por el empleado que se pasa por parametro
     public static function EliminarFoto($empleado)
     {
        $arrayEmpleados = Empleado::TraerTodos();

        foreach($arrayEmpleados as $emp)
        {
           if($emp->legajo == $empleado->legajo)
           {
              unlink($emp->path_foto);
           }
        }
     }

 }

?>
