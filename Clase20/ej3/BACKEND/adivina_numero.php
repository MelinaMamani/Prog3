<?php

$numero = isset($_POST["numero"]) ? (int)$_POST["numero"] : NULL;

$al_azar = rand(1,5); 

$obj = new stdClass();
$obj->adivino = ($al_azar == $numero) ? TRUE : FALSE; 

echo json_encode($obj);