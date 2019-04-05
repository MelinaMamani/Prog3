"use strict";
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
//# sourceMappingURL=Empleado.js.map