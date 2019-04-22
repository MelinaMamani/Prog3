<?php

try
{
    $user = "root";
    $pass = "";
    $objetoPDO = new PDO("mysql:host=localhost;dbname=cdcol",$user,$pass);

    $objetoQuery = $objetoPDO->query("SELECT * FROM cds");

    var_dump($objetoQuery->fetchAll();
}

catch  (PDOException $exPDO)
{
    echo "Error al conectar! ".$exPDO->getMessage();
}


?>