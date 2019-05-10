"use strict";
window.onload = function () {
    MostrarListado();
};
function EnviarDatos() {
    var xhr = new XMLHttpRequest();
    var nombre = document.getElementById("nombre");
    var legajo = document.getElementById("legajo");
    var apellido = document.getElementById("apellido");
    var sexo = document.getElementById("cboSexo");
    var sueldo = document.getElementById("sueldo");
    var foto = document.getElementById("foto");
    var form = new FormData();
    form.append('nombre', nombre.value);
    form.append('legajo', legajo.value);
    form.append('apellido', apellido.value);
    form.append('sexo', sexo.value);
    form.append('sueldo', sueldo.value);
    form.append('foto', foto.files[0]);
    form.append('op', "subirDatos");
    xhr.open('POST', './BACKEND/nexo.php', true);
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
                document.getElementById("foto_mostrar").src = "./BACKEND/" + retJSON.Path;
            }
        }
    };
}
function MostrarListado() {
    var xmlR = new XMLHttpRequest();
    var form = new FormData();
    form.append('op', 'mostrarListado');
    xmlR.open('POST', './BACKEND/nexo.php', true);
    xmlR.send(form);
    xmlR.onreadystatechange = function () {
        if (xmlR.readyState == 4 && xmlR.status == 200) {
            console.log(xmlR.responseText);
            document.getElementById("mostrar").innerHTML = xmlR.responseText;
        }
    };
}
function Eliminar(miJson) {
    var xmlR = new XMLHttpRequest();
    var form = new FormData();
    var rta = confirm("Está seguro de eliminar al empleado " + miJson.nombre + " " + miJson.apellido + "?");
    if (!rta) {
        return;
    }
    form.append('legajo', miJson.legajo);
    form.append('op', 'eliminarEmpleado');
    xmlR.open('POST', './BACKEND/nexo.php', true);
    xmlR.send(form);
    xmlR.onreadystatechange = function () {
        if (xmlR.readyState == 4 && xmlR.status == 200) {
            console.info(xmlR.responseText);
            var rta_1 = JSON.parse(xmlR.responseText);
            if (!rta_1.exito) {
                alert("Ha ocurrido un error inesperado.");
            }
            else {
                MostrarListado();
            }
        }
    };
}
function Modificar(miJson) {
    document.getElementById("nombre").value = miJson.nombre;
    document.getElementById("apellido").value = miJson.apellido;
    document.getElementById("cboSexo").value = miJson.sexo;
    document.getElementById("sueldo").value = miJson.sueldo;
    document.getElementById("foto").value = miJson.foto.files[0];
}
//# sourceMappingURL=manejadora2.js.map