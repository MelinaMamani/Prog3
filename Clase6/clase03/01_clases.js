"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var Auto = /** @class */ (function () {
    function Auto(color, precio) {
        this._precio = precio;
        this.color = color;
    }
    //GETTERS
    Auto.prototype.GetColor = function () {
        return this.color;
    };
    //SETTERS
    Auto.prototype.SetColor = function (color) {
        this.color = color;
    };
    Object.defineProperty(Auto.prototype, "Precio", {
        //ACCESOR GET
        get: function () {
            return this._precio;
        },
        //ACCESOR SET
        set: function (value) {
            this._precio = value;
        },
        enumerable: true,
        configurable: true
    });
    Auto.MetodoEstatico = function () {
        console.log("Método esático");
    };
    return Auto;
}());
exports.Auto = Auto;
//NOTAS:
//1) LOS ACCESORES REQUIEREN QUE SE ESTABLEZCA EL COMPILADOR PARA SALIDA A ECMAScript 5 O SUPERIOR. 
//2) LOS ACCESORES SOLO CON GET SE INFIEREN AUTOMATICAMENTE COMO READONLY. 
//3) LOS ACCESORES SET, NO PUEDEN LLEVAR TIPO DE RETORNO 
//# sourceMappingURL=01_clases.js.map