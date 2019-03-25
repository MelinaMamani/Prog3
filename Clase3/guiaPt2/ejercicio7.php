<?php

$fecha = date('l jS \of F Y h:i:s A');
$mes = date('m');
$estacion = "";

switch ($mes) {
    case '01':
        
    case '02':
    case '03': 
        $estacion = "Verano";
        break;

    case '04':
        
    
    case '05':
    case '06': 
        $estacion = "Otoño";
        break;
    
    case '07':
        

    case '08':
    case '09': 
        $estacion = "Invierno";
        break;

    case '10':
        

    case '11':
    case '12': 
        $estacion = "Primavera";
        break;    

    default:
        # code...
        break;
}


echo "Estación: ".$estacion." y fecha ".$fecha;
?>