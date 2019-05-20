<?php
include_once "AccesoDatos.php"; //Se usa antes
include "Juguete.php";

$juguetes = Juguete::Traer();


$grilla = "<table border='2'><thead align='center'><th>Id</th><th>Tipo</th><th>Precio</th><th>Precio con IVA</th><th>Pais origen</th><th>Imagen</th></thead><tbody>";
foreach($juguetes as $j)
{
    if($j['foto'] !== "Sin imagen")
    {
        $jug = new Juguete($j['tipo'],$j['precio'],$j['pais'],""); 

        $grilla.="<tr><td>".$j['id']."</td><td>".$j['tipo']."</td><td>".($j['precio'])."</td><td>".$jug->CalcularIva()."</td><td>".$j['pais']."</td><td><img src='./juguetes/imagenes/".$j['foto']."'width='60' height='60'></td></tr>";
    }
    else
    {
        $jug = new Juguete($j['tipo'],$j['precio'],$j['pais'],"");

        $grilla.="<tr><td>".$j['id']."</td><td>".$j['tipo']."</td><td>".($j['precio'])."</td><td>".$jug->CalcularIVA()."</td><td>".$j['pais']."</td><td>"."Sin imagen"."</td></tr>";
    }
}
$grilla.="</tbody></table>";
echo($grilla);




?>