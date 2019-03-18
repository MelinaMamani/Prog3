<?php

$suma = 0;

for ($i=0; $i < 5; $i++) { 
    $vec[$i] = rand();
    $suma += $vec[$i];
}

$promedio = $suma/5;

if ($promedio > 6)
{
    echo "El promedio es mayor a 6";
}

elseif ($promedio < 6) 
{
    echo "El promedio es menor a 6";
}

elseif ($promedio == 6) 
{
    echo "El promedio es igual a 6";
}

echo "<br/> Resultado: ".$promedio;

//print_r($vec);
?>