<?php
require_once "./empleado.php";

echo "<h1>Todos los empleados</h1></br>";


foreach (Empleado::TraerTodos() as $empleado) {
    echo "<p>".$empleado->ToString()."</p>";
}

?>