<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="main.js"></script>
    <title>Ingresar perro</title>
</head>
<body>
    <input type="text" name="tamanio" id="tamanio" placeholder="Ingrese tamaño"></br>
    <input type="number" name="edad" id="edad" placeholder="Ingrese edad"></br>
    <input type="number" name="precio" id="precio" placeholder="Ingrese precio"></br>
    <input type="text" name="nombre" id="nombre" placeholder="Ingrese nombre"></br>
    <label>Ingrese su raza: </label></br>    
        <select name="cboRaza" id="cboRaza">
            <option value="Cocker">Cocker</option>
            <option value="Salchicha">Salchicha</option>
            <option value="Chihuahua">Chihuahua</option>
        </select></br>
    <input type="file" name="foto" id="foto"></br>
    <img src="" id="foto_mostrar">
    <input type="button" onclick="PrimerParcial.AgregarPerroJson()" value="Agregar JSON"></br>
    <input type="button" onclick="PrimerParcial.MostrarPerrosJson()" value="Mostrar JSON"></br>
    <input type="button" onclick="PrimerParcial.AgregarPerroEnBD()" value="Agregar en BD"></br>
    <input type="button" onclick="PrimerParcial.VerificarExistencia()" value="Verificar y Agregar BD"></br>
    <input type="button" onclick="PrimerParcial.MostrarPerrosBD()" value="Mostrar Perros BD"></br>
    
    <div id="mostrar"></div>
</body>
</html>