<?php
$suma = 0;

for($i=0; $i<1000; $i++)
{
    if($suma > 1000)
    {
        break;
    }
    else
    {
        $suma+=$i;
    }
}

echo "Cant num: ".$i." y Suma: ".$suma;

?>