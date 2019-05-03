"use strict";
window.onload = function () {
    MostrarListado();
};
function EnviarDatos() {
    var xhr = new XMLHttpRequest();
    var nombre = document.getElementById("nombre");
    var legajo = document.getElementById("legajo");
    var foto = document.getElementById("foto");
    var form = new FormData();
    form.append('nombre', nombre.value);
    form.append('legajo', legajo.value);
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
//# sourceMappingURL=manejadora2.js.map