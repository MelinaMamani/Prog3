var PrimerParcial;
(function (PrimerParcial) {
    function AgregarPerroJSON() {
        var xhr = new XMLHttpRequest();
        var nombre = document.getElementById("nombre");
        var edad = document.getElementById("edad");
        var raza = document.getElementById("cboRaza");
        var tamanio = document.getElementById("tamanio");
        var precio = document.getElementById("precio");
        var foto = document.getElementById("foto");
        var form = new FormData();
        form.append('nombre', nombre.value);
        form.append('edad', edad.value);
        form.append('raza', raza.value);
        form.append('tamanio', tamanio.value);
        form.append('precio', precio.value);
        form.append('foto', foto.files[0]);
        form.append('op', "subirDatos");
        xhr.open('POST', './BACKEND/agregar_json.php', true);
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
                    retJSON.perro = new Entidades.Perro(tamanio.value, parseInt(edad.value), parseFloat(precio.value), nombre.value, raza.value, foto.value[0]);
                    document.getElementById("foto_mostrar").src = "./BACKEND/" + retJSON.Path;
                }
            }
        };
    }
})(PrimerParcial || (PrimerParcial = {}));
