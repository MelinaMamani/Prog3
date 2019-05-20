<?php
require_once("Helado.php");
$arrayHelados=Helado::RetornarArrayArchivo();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table border="1">
      <?php
      foreach($arrayHelados as $helado)
      {
          ?> <tr>
              <td>
                <?php echo $helado->GetSabor();?>
              </td>
              <td>
                <?php echo $helado->GetPrecio(); ?>
              </td>
              <td>
               <img src="<?php echo $helado->GetPath();?>" alt="asd">
              </td>
          </tr>
          <?php
      }

    ?>
        
    </table>
</body>
</html>