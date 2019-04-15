<?php
require_once 'usuario.php';
require_once 'conexion.php';
$queHago = isset($_POST['queHago']) ? $_POST['queHago'] : NULL;

$host = "localhost";
$user = "root";
$pass = "";
$base = "productos";

switch($queHago){

    case "establecerConexion":

        $con = @mysql_connect($host, $user, $pass);
        //Conexion::EstablecerConexion();

        echo "<pre>con = mysql_connect(host, user, pass)</pre>";

        if(!$con)
        {
            echo "<pre>Error: No se pudo conectar a MySQL." . PHP_EOL;
            echo "errno de depuración: " . mysql_errno() . PHP_EOL;
            echo "error: " . mysql_error() . PHP_EOL . "</pre>";
            return;
        }

        echo "<pre>Éxito: Se realizó una conexión a MySQL!!!." . PHP_EOL;
        echo "Información del host: " . mysql_get_host_info($con) . PHP_EOL . "</pre>";
        
        mysql_close($con);

        echo "<pre>mysql_close(con);</pre>";

    break;
    
    case "ejecutarConsulta":

        $con = @mysql_connect($host, $user, $pass);
        
        $sql = "SELECT * FROM producto";

        $rs = mysql_db_query($base, $sql);

        echo "<pre>
            con = mysql_connect(host, user, pass); 
            sql = 'SELECT * FROM producto';
            rs = mysql_db_query(base, sql);
        </pre>";
        
        echo "<pre>";
        var_dump($rs);
        echo "</pre>";

        mysql_close($con);
        
        echo "<pre>mysql_close(con);</pre>";
        
    break;
   
    case "mostrarConsulta":
    
        $con = @mysql_connect($host, $user, $pass);
        
        $sql = "SELECT * FROM producto";

        $rs = mysql_db_query($base, $sql);

        echo "<pre>
            con = mysql_connect(host, user, pass); 
            sql = 'SELECT * FROM producto';
            rs = mysql_db_query(base, sql);
        </pre>";
        
        echo "<pre>while(row = mysql_fetch_object(rs)){</pre>";

        echo "<pre>";
        while($row = mysql_fetch_object($rs)){
            
            var_dump($row);
        }
        echo "</pre>";

        mysql_close($con);
        
        echo "<pre>mysql_close(con);</pre>";
        
    break;

    case "ejecutarInsert":
    
        $con = @mysql_connect($host, $user, $pass);
        
        $sql = "INSERT INTO producto (codigo_barra, nombre, path_foto)
                VALUES(1112, 'nombre_producto', 'fake.jpg')";

        mysql_db_query($base, $sql);

        echo "<pre>
            con = mysql_connect(host, user, pass); 
            sql = 'INSERT INTO producto (codigo_barra, nombre, path_foto)';
            VALUES(1112, 'nombre_producto', 'fake.jpg')'
            mysql_db_query(base, sql);
        </pre>";
        
        mysql_close($con);
        
        echo "<pre>mysql_close(con);</pre>";
        
        break;

    case "ejecutarUpdate":
    
        $con = @mysql_connect($host, $user, $pass);
        
        $sql = "UPDATE producto SET codigo_barra=555, nombre='otro_nombre', path_foto='otroFake.jpg'
                WHERE id = 2";

        mysql_db_query($base, $sql);

        echo "<pre>
            con = mysql_connect(host, user, pass); 
            sql = 'UPDATE producto SET codigo_barra=555, nombre='otro_nombre', path_foto='otroFake.jpg'
            WHERE id = 2';
            mysql_db_query(base, sql);
        </pre>";
        
        mysql_close($con);
        
        echo "<pre>mysql_close(con);</pre>";
        
    break;

    case "ejecutarDelete":
    
        $con = @mysql_connect($host, $user, $pass);
        
        $sql = "DELETE FROM producto WHERE id=2";

        mysql_db_query($base, $sql);

        echo "<pre>
            con = mysql_connect(host, user, pass); 
            sql = 'DELETE FROM producto WHERE id=2';
            mysql_db_query(base, sql);
        </pre>";
        
        mysql_close($con);
        
        echo "<pre>mysql_close(con);</pre>";
        
    break;

    case 'traerUnUsuario':
        $usuario = new Usuario();
        $usuario->Traer(1);
        var_dump($usuario);
    break;

    default:
        echo ":(";

}