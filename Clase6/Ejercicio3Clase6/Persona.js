"use strict";
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
//# sourceMappingURL=Persona.js.map