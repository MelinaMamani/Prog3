<?php

function CalcularPotencias($var)
{
    echo "Potencia de ".$var;
    for ($i=1; $i < 5; $i++) { 
        
        echo " -> ".pow($var, $i)."\n";
    }
}

CalcularPotencias(5);

?>