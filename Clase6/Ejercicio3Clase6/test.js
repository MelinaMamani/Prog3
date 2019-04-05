"use strict";
/// <reference path="Persona.ts"/>
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
//# sourceMappingURL=test.js.map