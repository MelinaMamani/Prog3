<?php

$a = 8;
$b = 9;
$c = 6;

if($a < $b && $b > $c)
{
    echo "Entre ".$a." y ".$b." este es el numero del medio: ".$c;
}
elseif($b > $c && $b < $a)
{
    echo "Entre ".$a." y ".$c." este es el numero del medio: ".$b;
}

elseif($a > $c && $a < $b)
{
    echo "Entre ".$b." y ".$c." este es el numero del medio: ".$a;
}

?>