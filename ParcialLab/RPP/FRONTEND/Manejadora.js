"use strict";
///<reference path="Perro.ts"/>
var PrimerParcial;
(function (PrimerParcial) {
    var Manejadora = /** @class */ (function () {
        function Manejadora() {
        }
        Manejadora.AgregarPerroJSON = function () {
            var xhr = new XMLHttpRequest();
            var tamaño = document.getElementById("tamaño").value;
            var edad = document.getElementById("edad").value;
            var precio = document.getElementById("precio").value;
            var nombre = document.getElementById("nombre").value;
            var raza = document.getElementById("raza").value;
            var foto = document.getElementById("foto");
            var path = document.getElementById("foto").value;
            var pathFoto = (path.split('\\'))[2];
            var perro = new Entidades.Perro(tamaño, parseInt(edad), parseFloat(precio), nombre, raza, pathFoto);
            var form = new FormData();
            form.append('foto', foto.files[0]);
            form.append('cadenaJson', perro.ToJson());
            xhr.open('POST', './BACKEND//agregar_json.php', true);
            xhr.setRequestHeader("enctype", "multipart/form-data");
            xhr.send(form);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var retJSON = JSON.parse(xhr.responseText);
                    if (!retJSON.Ok) {
                        console.error("NO se subió la foto!!!");
                    }
                    else {
                        console.info("Foto subida OK!!!");
                        var path_1 = "./BACKEND/" + retJSON.pathFoto;
                        document.getElementById("imgFoto").src = path_1;
                        console.log(path_1);
                    }
                }
            };
        };
        Manejadora.MostrarPerrosJSON = function () {
            var xhr = new XMLHttpRequest();
            var form = new FormData();
            form.append('op', "traer");
            xhr.open('POST', './BACKEND/traer_json.php', true);
            xhr.setRequestHeader("enctype", "multipart/form-data");
            xhr.send(form);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    //recupero la cadena y convierto a array de json
                    var arrayJson = JSON.parse(xhr.responseText);
                    var tabla = "";
                    tabla += "<table border=1>";
                    tabla += "<thead>";
                    tabla += "<tr>";
                    tabla += "<td>Tamaño</td>";
                    tabla += "<td>Edad</td>";
                    tabla += "<td>Precio</td>";
                    tabla += "<td>Nombre</td>";
                    tabla += "<td>Raza</td>";
                    tabla += "<td>Foto</td>";
                    tabla += "</tr>";
                    tabla += "</thead>";
                    for (var i = 0; i < arrayJson.length; i++) {
                        tabla += "<tr>";
                        tabla += "<td>";
                        tabla += arrayJson[i].tamanio;
                        tabla += "</td>";
                        tabla += "<td>";
                        tabla += arrayJson[i].edad;
                        tabla += "</td>";
                        tabla += "<td>";
                        tabla += arrayJson[i].precio;
                        tabla += "</td>";
                        tabla += "<td>";
                        tabla += arrayJson[i].nombre;
                        tabla += "</td>";
                        tabla += "<td>";
                        tabla += arrayJson[i].raza;
                        tabla += "</td>";
                        tabla += "<td>";
                        var img = new Image();
                        var path = arrayJson[i].pathFoto;
                        img.src = "./BACKEND/fotos/" + path;
                        tabla += "<img src='./BACKEND/fotos/" + arrayJson[i].pathFoto + "' height=100 width=100 ></img>";
                        tabla += "</td>";
                        tabla += "</tr>";
                    }
                    tabla += "</table>";
                    document.getElementById("divTabla").innerHTML = tabla;
                }
            };
        };
        Manejadora.AgregarPerroEnBaseDatos = function () {
            var xhr = new XMLHttpRequest();
            var tamaño = document.getElementById("tamaño").value;
            var edad = document.getElementById("edad").value;
            var precio = document.getElementById("precio").value;
            var nombre = document.getElementById("nombre").value;
            var raza = document.getElementById("raza").value;
            var foto = document.getElementById("foto");
            var path = document.getElementById("foto").value;
            var pathFoto = (path.split('\\'))[2];
            var perro = new Entidades.Perro(tamaño, parseInt(edad), parseFloat(precio), nombre, raza, pathFoto);
            var form = new FormData();
            form.append('foto', foto.files[0]);
            form.append('cadenaJson', perro.ToJson());
            xhr.open('POST', './BACKEND//agregar_bd.php', true);
            xhr.setRequestHeader("enctype", "multipart/form-data");
            xhr.send(form);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var retJSON = JSON.parse(xhr.responseText);
                    if (!retJSON.Ok) {
                        console.error("NO se subió la foto!!!");
                    }
                    else {
                        console.info("Foto subida OK!!!");
                        var path_2 = "./BACKEND/" + retJSON.pathFoto;
                        document.getElementById("imgFoto").src = path_2;
                        console.log(path_2);
                    }
                }
            };
        };
        Manejadora.MostrarPerrosBaseDatos = function () {
            var xhr = new XMLHttpRequest();
            var form = new FormData();
            form.append('op', "traer");
            xhr.open('POST', './BACKEND/traer_bd.php', true);
            xhr.setRequestHeader("enctype", "multipart/form-data");
            xhr.send(form);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var arrayJson = JSON.parse(xhr.responseText);
                    var tabla = "";
                    tabla += "<table border=1>";
                    tabla += "<thead>";
                    tabla += "<tr>";
                    tabla += "<td>Tamaño</td>";
                    tabla += "<td>Edad</td>";
                    tabla += "<td>Precio</td>";
                    tabla += "<td>Nombre</td>";
                    tabla += "<td>Raza</td>";
                    tabla += "<td>Foto</td>";
                    tabla += "<td>Eliminar</td>";
                    tabla += "</tr>";
                    tabla += "</thead>";
                    for (var i = 0; i < arrayJson.length; i++) {
                        tabla += "<tr>";
                        tabla += "<td>";
                        tabla += arrayJson[i].tamanio;
                        tabla += "</td>";
                        tabla += "<td>";
                        tabla += arrayJson[i].edad;
                        tabla += "</td>";
                        tabla += "<td>";
                        tabla += arrayJson[i].precio;
                        tabla += "</td>";
                        tabla += "<td>";
                        tabla += arrayJson[i].nombre;
                        tabla += "</td>";
                        tabla += "<td>";
                        tabla += arrayJson[i].raza;
                        tabla += "</td>";
                        tabla += "<td>";
                        var img = new Image();
                        var path = arrayJson[i].pathFoto;
                        img.src = "./BACKEND/fotos/" + path;
                        tabla += "<img src='./BACKEND/fotos/" + arrayJson[i].pathFoto + "' height=100 width=100 ></img>";
                        tabla += "</td>";
                        var objJson = JSON.stringify(arrayJson[i]);
                        tabla += "<td><input type='button' onclick='PrimerParcial.Manejadora.EliminarPerro(" + (objJson) + ")' value='Eliminar'</td>";
                        tabla += "</tr>";
                    }
                    tabla += "</table>";
                    document.getElementById("divTabla").innerHTML = tabla;
                }
            };
        };
        Manejadora.VerificarExistencia = function () {
            var xhr = new XMLHttpRequest();
            var edad = document.getElementById("edad").value;
            var raza = document.getElementById("raza").value;
            var form = new FormData();
            form.append('op', "traer");
            xhr.open('POST', './BACKEND/traer_bd.php', true);
            xhr.setRequestHeader("enctype", "multipart/form-data");
            xhr.send(form);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var flag = false;
                    var arrayJson = JSON.parse(xhr.responseText);
                    for (var i = 0; i < arrayJson.length; i++) {
                        var edad2 = arrayJson[i].edad;
                        if (arrayJson[i].raza == raza && edad2.toString() == edad) {
                            flag = true;
                            break;
                        }
                    }
                    if (flag == true) {
                        console.log("El perro ya existe");
                        alert("El perro existe");
                    }
                    else {
                        Manejadora.AgregarPerroEnBaseDatos();
                    }
                }
            };
        };
        Manejadora.EliminarPerro = function (cadenaJson) {
            if (confirm("Esta seguro que desea eliminar al perro de nombre " + cadenaJson.nombre + " y raza " + cadenaJson.raza)) {
                var xhr_1 = new XMLHttpRequest();
                var form = new FormData();
                form.append('cadenaJson', JSON.stringify(cadenaJson));
                form.append('op', "eliminar_bd");
                xhr_1.open('POST', './BACKEND/eliminar_bd.php', true);
                xhr_1.setRequestHeader("enctype", "multipart/form-data");
                xhr_1.send(form);
                xhr_1.onreadystatechange = function () {
                    if (xhr_1.readyState == 4 && xhr_1.status == 200) {
                        console.log("perro eliminado");
                        document.getElementById("imgFoto").src = "./BACKEND/fotos/perro_default.png";
                        Manejadora.MostrarPerrosBaseDatos();
                    }
                };
            }
            else {
                alert("Accion cancelada");
            }
        };
        return Manejadora;
    }());
    PrimerParcial.Manejadora = Manejadora;
})(PrimerParcial || (PrimerParcial = {}));
//# sourceMappingURL=Manejadora.js.map