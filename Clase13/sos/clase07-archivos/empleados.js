//ese metodo se va a ejecutar cada vez que se carge la ventana
window.onload = function () {
    MostrarListado();
};
function MostrarListado() {
    var xhr = new XMLHttpRequest();
    var form = new FormData();
    form.append('op', "mostrarListado");
    xhr.open('POST', './BACKEND/nexo.php', true);
    xhr.setRequestHeader("enctype", "multipart/form-data");
    xhr.send(form);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            //la tabla que recuperamos desde nexo.php la mostramos dentro de el "div"
            document.getElementById("div").innerHTML = xhr.responseText;
        }
    };
}
function SubirFoto() {
    //INSTANCIO OBJETO PARA REALIZAR COMUNICACIONES ASINCRONICAS
    var xhr = new XMLHttpRequest();
    //RECUPERO LA IMAGEN SELECCIONADA POR EL USUARIO
    var foto = document.getElementById("fileFoto");
    var nombre = document.getElementById("txtNombre").value;
    var apellido = document.getElementById("txtApellido").value;
    var legajo = document.getElementById("numLegajo").value;
    var sueldo = document.getElementById("numSueldo").value;
    //INSTANCIO OBJETO FORMDATA
    var form = new FormData();
    var op = "";
    //AGREGO PARAMETROS AL FORMDATA:
    //PARAMETRO RECUPERADO POR $_FILES
    form.append('foto', foto.files[0]);
    form.append('txtNombre', nombre);
    form.append('txtApellido', apellido);
    form.append('numLegajo', legajo);
    form.append('numSueldo', sueldo);
    //PARAMETRO RECUPERADO POR $_POST O $_GET (SEGUN CORRESPONDA)
    //form.append('op', "subirFoto");
    //METODO; URL; ASINCRONICO?
    xhr.open('POST', './BACKEND/nexo.php', true);
    //ESTABLEZCO EL ENCABEZADO DE LA PETICION
    xhr.setRequestHeader("enctype", "multipart/form-data");
    //valido la opcion de si el boton es modificar o si es agregar
    //Esta es una forma de hacerlo
    //if((<HTMLInputElement> document.getElementById("btn")).value == "Modificar")
    //Esta es otra forma de hacerlo
    if (localStorage.getItem("modificar") == "true") {
        op = "modificarFoto";
    }
    else {
        op = "subirFoto";
    }
    console.log(op);
    form.append('op', op);
    //ENVIO DE LA PETICION
    xhr.send(form);
    //FUNCION CALLBACK
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            //vuelvo a cambiar el input a enviar en vez de modificar
            document.getElementById("btn").value = "Enviar";
            document.getElementById("btn").className = "btn btn-success";
            //funcion que me limpia los campos una vez subida un empleado o modificado
            LimpiarCampos();
            //limpio el localStorage
            localStorage.clear();
            //recupero el objeto de tipo JSON en formato cadena que nos devuelve nexo.php
            var retJSON = JSON.parse(xhr.responseText);
            //si el atributo "Ok" es falso , mostramos que la foto no se subio
            if (!retJSON.Ok) {
                console.error("NO se subió la foto!!!");
            }
            else {
                //si el atributo "Ok" es true , mostramos la foto subida pisando la que ya estaba por default
                console.info("Foto subida OK!!!");
                //direccion de donde se encuentra la foto
                var path = "./BACKEND/" + retJSON.Path;
                //hay que cambiar el "src" para que sepa donde buscar la foto 
                document.getElementById("imgFoto").src = path;
                console.log(retJSON.Path);
            }
            //le damos a refresacr el listado para que aparezca el nuevo usuario agregado a la lista
            MostrarListado();
        }
    };
}
//ya viene creado el objeto de tipo JSON
function Eliminar(empleado) {
    var objEmp = empleado;
    console.log(empleado.legajo + empleado.apellido + empleado.nombre + empleado.sueldo);
    var datosEmpleado = objEmp.legajo;
    if (confirm("Esta seguro que desea eliminar al empleado:" + datosEmpleado)) {
        var xhr_1 = new XMLHttpRequest();
        var form = new FormData();
        form.append('obj', JSON.stringify(empleado));
        form.append('op', "Eliminar");
        xhr_1.open('POST', './BACKEND/nexo.php', true);
        xhr_1.setRequestHeader("enctype", "multipart/form-data");
        xhr_1.send(form);
        xhr_1.onreadystatechange = function () {
            if (xhr_1.readyState == 4 && xhr_1.status == 200) {
                alert(xhr_1.responseText);
                document.getElementById("imgFoto").src = "./BACKEND/usr_default.jpg";
                MostrarListado();
            }
        };
    }
    else {
        alert("Accion cancelada");
    }
    MostrarListado();
}
function Modificar(empleado) {
    var objEmp = empleado;
    document.getElementById("txtNombre").value = objEmp.nombre;
    document.getElementById("txtApellido").value = objEmp.apellido;
    document.getElementById("numLegajo").value = objEmp.legajo;
    //desabilito que se pueda escribir sobre el legajo ya que este no se cambia
    document.getElementById("numLegajo").disabled = true;
    document.getElementById("numSueldo").value = objEmp.sueldo;
    //direccion de donde se encuentra la foto
    var path = "./BACKEND/" + objEmp.path_foto;
    //hay que cambiar el "src" para que sepa donde buscar la foto 
    document.getElementById("imgFoto").src = path;
    document.getElementById("btn").value = "Modificar";
    //(<HTMLInputElement> document.getElementById("btn")).className="btn btn-warning";
    localStorage.setItem("modificar", "true");
    MostrarListado();
}
function LimpiarCampos() {
    document.getElementById("txtNombre").value = "";
    document.getElementById("txtApellido").value = "";
    document.getElementById("numSueldo").value = "";
    document.getElementById("fileFoto").value = "";
    document.getElementById("numLegajo").value = "";
    document.getElementById("numLegajo").disabled = false;
    document.getElementById("imgFoto").src = "./BACKEND/usr_default.jpg";
}
