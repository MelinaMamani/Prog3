"use strict";
/*
Mascota: tamaño (cadena), edad (entero) y precio (flotante) como atributos. Un constructor que reciba tres parámetros. Un
método, ToString():string, que retorne la representación de la clase en formato cadena (preparar la cadena para que, al juntarse
con el método ToJSON, de la clase perro, forme un JSON válido).
*/
var Entidades;
(function (Entidades) {
    var Mascota = /** @class */ (function () {
        function Mascota(tamaño, edad, precio) {
            this.tamaño = tamaño;
            this.edad = edad;
            this.precio = precio;
        }
        Mascota.prototype.ToString = function () {
            return "\"tamanio\":\"" + this.tamaño + "\",\"edad\":" + this.edad + ",\"precio\":" + this.precio;
        };
        return Mascota;
    }());
    Entidades.Mascota = Mascota;
})(Entidades || (Entidades = {}));
//# sourceMappingURL=Mascota.js.map