"use strict";
var Ajax;
(function (Ajax) {
    function Saludar() {
        var xmlR = new XMLHttpRequest();
        xmlR.open("GET", "admin.php", true);
        xmlR.send();
        xmlR.onreadystatechange = function () {
            if (xmlR.readyState == 4 && xmlR.status == 200) {
                console.log("Hola mundo ajax");
                alert("Hola mundo ajax");
                document.getElementById("div_mostrar").innerHTML = xmlR.responseText;
            }
        };
    }
    Ajax.Saludar = Saludar;
    function Ingresar() {
        var nombre = document.getElementById("nombre");
        var accion = 2;
        var xmlR = new XMLHttpRequest();
        xmlR.open("GET", "admin.php?nombre=" + nombre.value + "&accion=" + accion, true);
        xmlR.send();
        xmlR.onreadystatechange = function () {
            if (xmlR.readyState == 4 && xmlR.status == 200) {
                console.log(xmlR.responseText);
                if (xmlR.responseText == "1") {
                    Ajax.Mostrar();
                }
                else {
                    alert("No se pudo mostrar");
                }
                //Para accion 1
                //console.log(xmlR.responseText);
                //alert(xmlR.responseText);
                //(<HTMLDivElement>document.getElementById("div_mostrar")).innerHTML = xmlR.responseText;
            }
        };
    }
    Ajax.Ingresar = Ingresar;
    function Mostrar() {
        var accion = 3;
        var xmlR = new XMLHttpRequest();
        xmlR.open("GET", "admin.php?accion=" + accion, true);
        xmlR.send();
        xmlR.onreadystatechange = function () {
            if (xmlR.readyState == 4 && xmlR.status == 200) {
                console.log(xmlR.responseText);
                //alert(xmlR.responseText);
                document.getElementById("div_mostrar").innerHTML = xmlR.responseText;
            }
        };
    }
    Ajax.Mostrar = Mostrar;
})(Ajax || (Ajax = {}));
//# sourceMappingURL=manejadora.js.map