<?php

sleep(2);

$numero = isset($_REQUEST["adivino2"]) ? (int)$_REQUEST["adivino2"] : NULL;

$al_azar = rand(1,5); 

$valido = ($al_azar == $numero) ? TRUE : FALSE;

// Finally, return a JSON
echo json_encode(array(
    'valid' => $valido,
    'numero' => $numero,
    'al_azar' => $al_azar
));