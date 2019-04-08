var __extends = (this && this.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var Empleados;
(function (Empleados) {
    var Persona = /** @class */ (function () {
        function Persona(nombre, apellido, sexo, dni) {
            this._apellido = apellido;
            this._dni = dni;
            this._nombre = nombre;
            this._sexo = sexo;
        }
        /**
         * GetApellido : devuelve apellido
         */
        Persona.prototype.GetApellido = function () {
            return this._apellido;
        };
        /**
         * GetNombre : devuelve nombre
         */
        Persona.prototype.GetNombre = function () {
            return this._nombre;
        };
        /**
         * GetSexo
         */
        Persona.prototype.GetSexo = function () {
            return this._sexo;
        };
        /**
         * GetDNI
         */
        Persona.prototype.GetDNI = function () {
            return this._dni;
        };
        /**
         * ToString
         */
        Persona.prototype.ToString = function () {
            return this.GetApellido() + "-" + this.GetNombre() + "-" + this.GetDNI() + "-" + this.GetSexo() + "-";
        };
        return Persona;
    }());
    Empleados.Persona = Persona;
})(Empleados || (Empleados = {}));
/// <reference path="Persona.ts"/>
var Empleados;
(function (Empleados) {
    var Empleado = /** @class */ (function (_super) {
        __extends(Empleado, _super);
        function Empleado(nombre, apellido, sexo, dni, legajo, sueldo) {
            var _this = _super.call(this, nombre, apellido, sexo, dni) || this;
            _this._legajo = legajo;
            _this._sueldo = sueldo;
            return _this;
        }
        /**
         * GetLegajo
         */
        Empleado.prototype.GetLegajo = function () {
            return this._legajo;
        };
        /**
         * GetSueldo
         */
        Empleado.prototype.GetSueldo = function () {
            return this._sueldo;
        };
        /**
         * Hablar
         */
        Empleado.prototype.Hablar = function (idioma) {
            return "El empleado habla " + idioma + "\n";
        };
        /**
         * ToString de Empleado
         */
        Empleado.prototype.ToString = function () {
            return _super.prototype.ToString.call(this) + this.GetLegajo() + "-" + this.GetSueldo() + "\n";
        };
        return Empleado;
    }(Empleados.Persona));
    Empleados.Empleado = Empleado;
})(Empleados || (Empleados = {}));
/// <reference path="./Empleado.ts"/>
function Ingresar() {
    var nombre = document.getElementById("nombre").value;
    var apellido = document.getElementById("apellido").value;
    var dni = parseInt(document.getElementById("dni").value);
    var sexo = document.getElementById("cboSexo").value;
    var legajo = parseInt(document.getElementById("legajo").value);
    var sueldo = parseInt(document.getElementById("sueldo").value);
    var e = new Empleados.Empleado(nombre, apellido, sexo, dni, legajo, sueldo);
    console.log(e.ToString());
    console.log(e.Hablar("español"));
}
