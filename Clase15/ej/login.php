<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./login.css">
    <title>Ingreso</title>
</head>
<body>
    <table>
        <tbody>
            <th>Ingreso</th>
            <form action="unaSubida.php" method="post">
            <tr>
                <td>
                    <span>Legajo:</span>
                </td>
            </tr>
            <tr>
                <td>
                <input type="text" name="legajo" id="legajo">
                </td>
            </tr>
            <tr>
                <td>
                    <span>Clave:</span>
                </td>
            </tr>
            <tr>
                <td>
                <input type="password" name="clave" id="clave">
                </td>
            </tr>
            <tr>
                <td>
                <input type="button" value="Aceptar" class="Aceptar">
                <input type="button" value="Cancelar" class="Cancelar">
                </td>
            </tr>
            </form>
        </tbody>
    </table>
</body>
</html>