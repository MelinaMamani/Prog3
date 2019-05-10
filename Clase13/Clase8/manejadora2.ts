window.onload = function() {
    MostrarListado();
}

function EnviarDatos() : void {
    
        let xhr : XMLHttpRequest = new XMLHttpRequest();
        let nombre = (<HTMLInputElement> document.getElementById("nombre"));
        let legajo = (<HTMLInputElement> document.getElementById("legajo"));
        let apellido = (<HTMLInputElement> document.getElementById("apellido"));
        let sexo = (<HTMLInputElement> document.getElementById("cboSexo"));
        let sueldo = (<HTMLInputElement> document.getElementById("sueldo"));
        let foto : any = (<HTMLInputElement> document.getElementById("foto"));
        let form : FormData = new FormData();
        form.append('nombre',nombre.value);
        form.append('legajo',legajo.value);
        form.append('apellido',apellido.value);
        form.append('sexo',sexo.value);
        form.append('sueldo', sueldo.value);
        form.append('foto', foto.files[0]);
        form.append('op', "subirDatos");
        xhr.open('POST', './BACKEND/nexo.php', true);
        xhr.setRequestHeader("enctype", "multipart/form-data");
        xhr.send(form);
    
        xhr.onreadystatechange = () => {
    
            if (xhr.readyState == 4 && xhr.status == 200) {
    
                console.log(xhr.responseText);
                
                let retJSON = JSON.parse(xhr.responseText);
                if(!retJSON.Ok){
                    console.error("NO se subió la foto!!!");
                }
                else{
                    console.info("Foto subida OK!!!");
                    (<HTMLImageElement> document.getElementById("foto_mostrar")).src = "./BACKEND/" + retJSON.Path;
                }
            }
        }
    }

    function MostrarListado():void {
        let xmlR = new XMLHttpRequest();
        let form : FormData = new FormData();
        form.append('op','mostrarListado');

        xmlR.open('POST', './BACKEND/nexo.php', true);
        xmlR.send(form);

        xmlR.onreadystatechange = () => {
            if (xmlR.readyState == 4 && xmlR.status == 200) {
                console.log(xmlR.responseText);
                (<HTMLDivElement>document.getElementById("mostrar")).innerHTML = xmlR.responseText;
            }
        }
    }

    function Eliminar(miJson:any) {
        let xmlR : XMLHttpRequest = new XMLHttpRequest();
        let form : FormData = new FormData();
        let rta = confirm("Está seguro de eliminar al empleado "+miJson.nombre+" "+miJson.apellido+"?");
        if (!rta) {
            return;
        }
        form.append('legajo',miJson.legajo);
        form.append('op','eliminarEmpleado');

        xmlR.open('POST', './BACKEND/nexo.php', true);
        xmlR.send(form);

        xmlR.onreadystatechange = () => {
            if (xmlR.readyState == 4 && xmlR.status == 200) {
                console.info(xmlR.responseText);
                let rta = JSON.parse(xmlR.responseText);
                if (!rta.exito) {
                    alert("Ha ocurrido un error inesperado.");
                }
                else{
                    MostrarListado();
                }
            }
        }
    }

    function Modificar(miJson:any) {
        (<HTMLInputElement>document.getElementById("nombre")).value = miJson.nombre;
        (<HTMLInputElement>document.getElementById("apellido")).value = miJson.apellido;
        (<HTMLInputElement>document.getElementById("cboSexo")).value = miJson.sexo;
        (<HTMLInputElement>document.getElementById("sueldo")).value = miJson.sueldo;
        (<HTMLInputElement>document.getElementById("foto")).value = miJson.foto.files[0];
    }