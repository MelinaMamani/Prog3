var __extends = (this && this.__extends) || (function () {
    var extendStatics = Object.setPrototypeOf ||
        ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
        function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var Entidades;
(function (Entidades) {
    var Ropa = /** @class */ (function () {
        function Ropa(codigo, nombre, precio) {
            this.codigo = codigo;
            this.nombre = nombre;
            this.precio = precio;
        }
        Ropa.prototype.ropaToString = function () {
            return "\"nombre\":\"" + this.nombre + "\",\"precio\":" + this.precio + ",\"codigo\":" + this.codigo;
        };
        return Ropa;
    }());
    Entidades.Ropa = Ropa;
    var Campera = /** @class */ (function (_super) {
        __extends(Campera, _super);
        function Campera(codigo, nombre, precio, talle, color, path) {
            var _this = _super.call(this, codigo, nombre, precio) || this;
            _this.talle = talle;
            _this.color = color;
            _this.path = path;
            return _this;
        }
        Campera.prototype.camperaToJson = function () {
            return JSON.parse("{\"talle\":\"" + this.talle + "\",\"color\":\"" + this.color + "\",\"path\":\"" + this.path + "\"," + this.ropaToString() + "}");
        };
        return Campera;
    }(Ropa));
    Entidades.Campera = Campera;
})(Entidades || (Entidades = {}));
/// <reference path="./Entidades.ts" />
var Test;
(function (Test) {
    var Manejadora = /** @class */ (function () {
        function Manejadora() {
        }
        Manejadora.AgregarCampera = function (modo) {
            var codigo = parseInt(document.getElementById('txtCodigo').value);
            var nombre = document.getElementById('txtNombre').value;
            var precio = parseInt(document.getElementById('txtPrecio').value);
            var talle = document.getElementById('txtTalle').value;
            var color = document.getElementById('cboColor').value;
            Manejadora.SubirFoto(codigo);
            var path = "";
            path = document.getElementById('imgFoto').alt;
            var camperaPost = new Entidades.Campera(codigo, nombre, precio, talle, color, path);
            var xhttp = new XMLHttpRequest();
            if (modo == 'agregar') {
                xhttp.open("POST", "./BACKEND/administrar.php");
                xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                xhttp.send("caso=agregar&cadenaJson=" + JSON.stringify(camperaPost.camperaToJson()));
                xhttp.onreadystatechange = function () {
                    if (xhttp.readyState == 4 && xhttp.status == 200) {
                        Manejadora.AdministrarSpinner(false);
                        console.log("Funciono al agregar!" + xhttp.responseText);
                        Manejadora.MostrarCamperas("mostrar");
                    }
                    else {
                        Manejadora.AdministrarSpinner(true);
                    }
                };
            }
            else {
                xhttp.open("POST", "./BACKEND/administrar.php");
                xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                xhttp.send("caso=modificar&cadenaJson=" + JSON.stringify(camperaPost.camperaToJson()));
                xhttp.onreadystatechange = function () {
                    if (xhttp.readyState == 4 && xhttp.status == 200) {
                        console.log("Funciono al Modificar!" + xhttp.responseText);
                        Manejadora.AdministrarSpinner(false);
                        Manejadora.MostrarCamperas("mostrar");
                    }
                    else {
                        Manejadora.AdministrarSpinner(true);
                    }
                };
                document.getElementById('btnAgregar').setAttribute('onclick', 'Test.Manejadora.AgregarCampera("agregar")');
                document.getElementById('txtCodigo').readOnly = false;
            }
            Manejadora.LimpiarForm();
        };
        Manejadora.MostrarCamperas = function (caso) {
            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", "./BACKEND/administrar.php");
            xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            xhttp.send("caso=mostrar");
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    Manejadora.AdministrarSpinner(false);
                    var arrayJson = JSON.parse(xhttp.responseText);
                    console.log(arrayJson);
                    document.getElementById('divTabla').innerHTML = "";
                    document.getElementById('divTabla').innerHTML += '<table id="tablaMostrar" style="width:400px;"></table>';
                    arrayJson.forEach(function (campera) {
                        if (caso == 'mostrar') {
                            var camperDatos = campera.codigo + "-" + campera.nombre + "-" + campera.precio + "-" + campera.talle + "-" + campera.color + "-" + campera.path;
                            document.getElementById('tablaMostrar').innerHTML +=
                                "<tr>\n                                <td>" + camperDatos + "</td>\n                                <td><button onclick='Test.Manejadora.EliminarCampera(" + JSON.stringify(campera) + ")'>Eliminar</button></td>\n                                 <td><button onclick='Test.Manejadora.ModificarCampera(" + JSON.stringify(campera) + ")'>Modificar</button></td>\n                                 </tr>";
                        }
                        else {
                            if (document.getElementById('cboColor').value == campera.color) {
                                var camperDatos = campera.codigo + "-" + campera.nombre + "-" + campera.precio + "-" + campera.talle + "-" + campera.color + "-" + campera.path;
                                document.getElementById('tablaMostrar').innerHTML +=
                                    "<tr>\n                                    <td>" + camperDatos + "</td>\n                                    <td><button onclick='Test.Manejadora.EliminarCampera(" + JSON.stringify(campera) + ")'>Eliminar</button></td>\n                                     <td><button onclick='Test.Manejadora.ModificarCampera(" + JSON.stringify(campera) + ")'>Modificar</button></td>\n                                     </tr>";
                            }
                        }
                    });
                }
                else {
                    Manejadora.AdministrarSpinner(true);
                }
            };
        };
        Manejadora.EliminarCampera = function (camperaJson) {
            if (confirm("Desea eliminar a " + camperaJson.codigo + " " + camperaJson.talle + "?")) {
                Test.Manejadora.EliminarFoto(camperaJson.codigo);
                var xhttp_1 = new XMLHttpRequest();
                xhttp_1.open("POST", "./BACKEND/administrar.php");
                xhttp_1.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                xhttp_1.send("caso=eliminar&cadenaJson=" + JSON.stringify(camperaJson));
                xhttp_1.onreadystatechange = function () {
                    if (xhttp_1.readyState == 4 && xhttp_1.status == 200) {
                        Manejadora.AdministrarSpinner(false);
                        console.log(xhttp_1.responseText);
                        Manejadora.MostrarCamperas("mostrar");
                    }
                    else {
                        Manejadora.AdministrarSpinner(true);
                    }
                };
            }
            Manejadora.MostrarCamperas('mostrar');
        };
        Manejadora.ModificarCampera = function (camperaJson) {
            document.getElementById('txtCodigo').value = camperaJson.codigo;
            document.getElementById('txtNombre').value = camperaJson.nombre;
            document.getElementById('txtPrecio').value = camperaJson.precio;
            document.getElementById('txtTalle').value = camperaJson.talle;
            document.getElementById('txtCodigo').readOnly = true;
            document.getElementById('cboColor').value = camperaJson.color;
            document.getElementById('btnAgregar').setAttribute('onclick', 'Test.Manejadora.AgregarCampera("modificar")');
        };
        Manejadora.LimpiarForm = function () {
            document.getElementById('txtCodigo').value = "";
            document.getElementById('txtNombre').value = "";
            document.getElementById('txtPrecio').value = "";
            document.getElementById('txtTalle').value = "";
            document.getElementById('cboColor').selectedIndex = 0;
        };
        Manejadora.CargarColoresJSON = function () {
            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", "./BACKEND/administrar.php");
            xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            xhttp.send("caso=colores");
            var cboColor = document.getElementById('cboColor');
            cboColor.innerHTML = "";
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    Manejadora.AdministrarSpinner(false);
                    var jsonColores = JSON.parse(xhttp.responseText);
                    jsonColores.forEach(function (color) {
                        cboColor.innerHTML += "<option id='" + color.id + "'>" + color.descripcion + "</option>";
                    });
                }
                else {
                    Manejadora.AdministrarSpinner(true);
                }
            };
            Manejadora.LimpiarForm();
        };
        Manejadora.AdministrarSpinner = function (activar) {
            setTimeout(function () {
                if (!activar) {
                    document.getElementById('imgSpinner').setAttribute('src', '');
                }
            }, 1000);
            if (activar)
                document.getElementById('imgSpinner').setAttribute('src', './BACKEND/gif-load.gif');
        };
        Manejadora.ModificarFoto = function (codigo) {
            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", "./BACKEND/administrar.php");
            xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            xhttp.send("caso=modificarFoto&codigo=" + codigo);
            var cboColor = document.getElementById('cboColor');
            cboColor.innerHTML = "";
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    console.log(xhttp.responseText);
                    var retJSON = JSON.parse(xhttp.responseText);
                    if (!retJSON.Ok) {
                        console.error("NO se subió la foto!!!");
                    }
                    else {
                        console.info("Foto subida OK!!!");
                        document.getElementById("imgFoto").src = "./BACKEND/" + retJSON.Path;
                        Manejadora._path = "./BACKEND/" + retJSON.Path;
                    }
                }
            };
        };
        Manejadora.EliminarFoto = function (codigo) {
            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", "./BACKEND/administrar.php");
            xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            xhttp.send("caso=eliminarFoto&codigo=" + codigo);
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    console.log(xhttp.responseText);
                    var retJSON = JSON.parse(xhttp.responseText);
                    if (!retJSON.Ok) {
                        console.error("NO se subió la foto!!!");
                    }
                    else {
                        console.info("Foto subida OK!!!");
                        document.getElementById("imgFoto").src = "./BACKEND/" + retJSON.Path;
                        Manejadora._path = "./BACKEND/" + retJSON.Path;
                    }
                }
            };
        };
        Manejadora.SubirFoto = function (codigo, path) {
            //INSTANCIO OBJETO PARA REALIZAR COMUNICACIONES ASINCRONICAS
            var xhr = new XMLHttpRequest();
            //RECUPERO LA IMAGEN SELECCIONADA POR EL USUARIO
            var foto = document.getElementById("idFoto");
            //INSTANCIO OBJETO FORMDATA
            var form = new FormData();
            //AGREGO PARAMETROS AL FORMDATA:
            //PARAMETRO RECUPERADO POR $_FILES
            form.append('foto', foto.files[0]);
            //PARAMETRO RECUPERADO POR $_POST O $_GET (SEGUN CORRESPONDA)
            form.append('caso', "subirFoto");
            form.append('codigo', codigo.toString());
            //METODO; URL; ASINCRONICO?
            xhr.open('POST', './BACKEND/administrar.php', true);
            //ESTABLEZCO EL ENCABEZADO DE LA PETICION
            xhr.setRequestHeader("enctype", "multipart/form-data");
            //ENVIO DE LA PETICION
            xhr.send(form);
            //FUNCION CALLBACK
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText);
                    var retJSON = JSON.parse(xhr.responseText);
                    if (!retJSON.Ok) {
                        console.error("NO se subió la foto!!!");
                    }
                    else {
                        console.info("Foto subida OK!!!");
                        document.getElementById("imgFoto").src = "./BACKEND/" + retJSON.Path;
                    }
                }
            };
        };
        return Manejadora;
    }());
    Test.Manejadora = Manejadora;
})(Test || (Test = {}));
