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
    var Mascota = /** @class */ (function () {
        function Mascota(tamanio, edad, precio) {
            this.tamanio = tamanio;
            this.edad = edad;
            this.precio = precio;
        }
        Mascota.prototype.ToString = function () {
            var json;
            json.tamanio = this.tamanio;
            json.edad = this.edad;
            json.precio = this.precio;
            return JSON.stringify(json);
        };
        return Mascota;
    }());
    Entidades.Mascota = Mascota;
})(Entidades || (Entidades = {}));
/// <reference path = "./Mascota.ts"/>
var Entidades;
(function (Entidades) {
    var Perro = /** @class */ (function (_super) {
        __extends(Perro, _super);
        function Perro(tamanio, edad, precio, nombre, raza, pathFoto) {
            var _this = _super.call(this, tamanio, edad, precio) || this;
            _this.nombre = nombre;
            _this.raza = raza;
            _this.pathFoto = pathFoto;
            return _this;
        }
        Perro.prototype.ToJson = function () {
            var unJson;
            unJson.mascota = _super.prototype.ToString.call(this);
            unJson.nombre = this.nombre;
            unJson.raza = this.raza;
            unJson.pathFoto = this.pathFoto;
            return unJson;
        };
        return Perro;
    }(Entidades.Mascota));
    Entidades.Perro = Perro;
})(Entidades || (Entidades = {}));
/// <reference path="Clases/Perro.ts"/>
var PrimerParcial;
(function (PrimerParcial) {
    function AgregarPerroJSON() {
        var xhr = new XMLHttpRequest();
        var nombre = document.getElementById("nombre");
        var edad = document.getElementById("edad");
        var raza = document.getElementById("cboRaza");
        var tamanio = document.getElementById("tamanio");
        var precio = document.getElementById("precio");
        var foto = document.getElementById("foto");
        var form = new FormData();
        form.append('nombre', nombre.value);
        form.append('edad', edad.value);
        form.append('raza', raza.value);
        form.append('tamanio', tamanio.value);
        form.append('precio', precio.value);
        form.append('foto', foto.files[0]);
        form.append('op', "subirDatos");
        xhr.open('POST', './BACKEND/agregar_json.php', true);
        xhr.setRequestHeader("enctype", "multipart/form-data");
        xhr.send(form);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                console.log(xhr.responseText);
                var retJSON = JSON.parse(xhr.responseText);
                if (!retJSON.Ok) {
                    console.error("NO se subió la foto!!!");
                }
                else {
                    console.info("Foto subida OK!!!");
                    retJSON.perro = new Entidades.Perro(tamanio.value, parseInt(edad.value), parseFloat(precio.value), nombre.value, raza.value, foto.value[0]);
                    document.getElementById("foto_mostrar").src = "./BACKEND/" + retJSON.Path;
                }
            }
        };
    }
})(PrimerParcial || (PrimerParcial = {}));
