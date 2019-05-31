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
    var Persona = /** @class */ (function () {
        function Persona(nombre, apellido, edad) {
            this._nombre = nombre;
            this._apellido = apellido;
            this._edad = edad;
        }
        Persona.prototype.personaToString = function () {
            return "\"nombre\":\"" + this._nombre + "\",\"apellido\":\"" + this._apellido + "\",\"edad\":" + this._edad;
        };
        return Persona;
    }());
    Entidades.Persona = Persona;
    var Ciudadano = /** @class */ (function (_super) {
        __extends(Ciudadano, _super);
        function Ciudadano(nombre, apellido, edad, dni, pais) {
            var _this = _super.call(this, nombre, apellido, edad) || this;
            _this._dni = dni;
            _this._pais = pais;
            return _this;
        }
        Ciudadano.prototype.ciudadanoToJson = function () {
            return JSON.parse("{" + this.personaToString() + ",\"pais\":\"" + this._pais + "\",\"dni\":" + this._dni + "}");
        };
        return Ciudadano;
    }(Persona));
    Entidades.Ciudadano = Ciudadano;
})(Entidades || (Entidades = {}));
/// <reference path="./Entidades.ts" />
var Test;
(function (Test) {
    var Manejadora = /** @class */ (function () {
        function Manejadora() {
        }
        Manejadora.AgregarCiudadano = function (modo) {
            var xhttp = new XMLHttpRequest();
            var nombre = document.getElementById('txtNombre').value;
            var apellido = document.getElementById('txtApellido').value;
            var edad = parseInt(document.getElementById('txtEdad').value);
            var dni = parseInt(document.getElementById('txtDni').value);
            var pais = document.getElementById('cboPais').value;
            var ciudPost = new Entidades.Ciudadano(nombre, apellido, edad, dni, pais);
            if (modo == 'agregar') {
                xhttp.open("POST", "./BACKEND/administrar.php");
                xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                xhttp.send("caso=agregar&cadenaJson=" + JSON.stringify(ciudPost.ciudadanoToJson()));
                xhttp.onreadystatechange = function () {
                    if (xhttp.readyState == 4 && xhttp.status == 200) {
                        Manejadora.AdministrarSpinner(false);
                        console.log("Funciono al agregar!" + xhttp.responseText);
                    }
                    else {
                        Manejadora.AdministrarSpinner(true);
                    }
                };
            }
            else {
                xhttp.open("POST", "./BACKEND/administrar.php");
                xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                xhttp.send("caso=modificar&cadenaJson=" + JSON.stringify(ciudPost.ciudadanoToJson()));
                xhttp.onreadystatechange = function () {
                    if (xhttp.readyState == 4 && xhttp.status == 200) {
                        console.log("Funciono al Modificar!" + xhttp.responseText);
                        Manejadora.AdministrarSpinner(false);
                    }
                    else {
                        Manejadora.AdministrarSpinner(true);
                    }
                };
                document.getElementById('btnAgregar').setAttribute('onclick', 'Test.Manejadora.AgregarCiudadano("agregar")');
            }
            Manejadora.LimpiarInputs();
        };
        Manejadora.MostrarCiudadanos = function (caso) {
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
                    document.getElementById('divTabla').innerHTML += '<table id="tablaMostrar"></table>';
                    arrayJson.forEach(function (ciudadano) {
                        if (caso == 'mostrar') {
                            var ciudDatos = ciudadano.nombre + "-" + ciudadano.apellido + "-" + ciudadano.edad + "-" + ciudadano.dni + "-" + ciudadano.pais;
                            document.getElementById('tablaMostrar').innerHTML +=
                                "<tr>\n                                <td>" + ciudDatos + "</td>\n                                <td><button onclick='Test.Manejadora.EliminarCiudadano(" + JSON.stringify(ciudadano) + ")'>Eliminar</button></td>\n                                 <td><button onclick='Test.Manejadora.ModificarCiudadano(" + JSON.stringify(ciudadano) + ")'>Modificar</button></td>\n                                 </tr>";
                        }
                        else {
                            console.log(ciudadano.pais);
                            if (document.getElementById('cboPais').value == ciudadano.pais) {
                                var ciudDatos = ciudadano.nombre + "-" + ciudadano.apellido + "-" + ciudadano.edad + "-" + ciudadano.dni + "-" + ciudadano.pais;
                                document.getElementById('tablaMostrar').innerHTML +=
                                    "<tr>\n                                    <td>" + ciudDatos + "</td>\n                                    <td><button onclick='Test.Manejadora.EliminarCiudadano(" + JSON.stringify(ciudadano) + ")'>Eliminar</button></td>\n                                     <td><button onclick='Test.Manejadora.ModificarCiudadano(" + JSON.stringify(ciudadano) + ")'>Modificar</button></td>\n                                     </tr>";
                            }
                        }
                    });
                }
                else {
                    Manejadora.AdministrarSpinner(true);
                }
            };
        };
        Manejadora.EliminarCiudadano = function (ciudJSON) {
            if (confirm("Desea eliminar a " + ciudJSON.nombre + " " + ciudJSON.apellido + "?")) {
                var xhttp_1 = new XMLHttpRequest();
                xhttp_1.open("POST", "./BACKEND/administrar.php");
                xhttp_1.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                xhttp_1.send("caso=eliminar&cadenaJson=" + JSON.stringify(ciudJSON));
                xhttp_1.onreadystatechange = function () {
                    if (xhttp_1.readyState == 4 && xhttp_1.status == 200) {
                        Manejadora.AdministrarSpinner(false);
                        console.log(xhttp_1.responseText);
                    }
                    else {
                        Manejadora.AdministrarSpinner(true);
                    }
                };
            }
            Manejadora.MostrarCiudadanos('mostrar');
        };
        Manejadora.ModificarCiudadano = function (ciudJSON) {
            document.getElementById('txtNombre').value = ciudJSON.nombre;
            document.getElementById('txtApellido').value = ciudJSON.apellido;
            document.getElementById('txtEdad').value = ciudJSON.edad;
            document.getElementById('txtDni').value = ciudJSON.dni;
            document.getElementById('txtDni').readOnly = true;
            document.getElementById('cboPais').value = ciudJSON.pais;
            document.getElementById('btnAgregar').setAttribute('onclick', 'Test.Manejadora.AgregarCiudadano("modificar")');
        };
        Manejadora.LimpiarInputs = function () {
            document.getElementById('txtNombre').value = "";
            document.getElementById('txtApellido').value = "";
            document.getElementById('txtEdad').value = "";
            document.getElementById('txtDni').value = "";
            document.getElementById('cboPais').selectedIndex = 0;
        };
        Manejadora.CargarPaisesJSON = function () {
            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", "./BACKEND/administrar.php");
            xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            xhttp.send("caso=paises");
            var cboPais = document.getElementById('cboPais');
            cboPais.innerHTML = "";
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    Manejadora.AdministrarSpinner(false);
                    var jsonPaises = JSON.parse(xhttp.responseText);
                    jsonPaises.forEach(function (pais) {
                        cboPais.innerHTML += "<option id='" + pais.id + "'>" + pais.descripcion + "</option>";
                    });
                }
                else {
                    Manejadora.AdministrarSpinner(true);
                }
            };
            Manejadora.LimpiarInputs();
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
        return Manejadora;
    }());
    Test.Manejadora = Manejadora;
})(Test || (Test = {}));
