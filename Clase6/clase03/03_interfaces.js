"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var Auto = /** @class */ (function () {
    function Auto(color, precio) {
        this._precio = precio;
        this.color = color;
    }
    Object.defineProperty(Auto.prototype, "Precio", {
        get: function () {
            return this._precio;
        },
        enumerable: true,
        configurable: true
    });
    //DE LA INTERFACE
    Auto.prototype.GetColor = function () {
        return this.color;
    };
    //DE LA INTERFACE
    Auto.prototype.SetColor = function (color) {
        this.color = color;
    };
    return Auto;
}());
exports.Auto = Auto;
//NOTAS:
//1) LAS INTERFACES SE PUEDEN HEREDAR
//2) LAS INTERFACES PUEDEN CONTENER ATRIBUTOS Y METODOS
//# sourceMappingURL=03_interfaces.js.map