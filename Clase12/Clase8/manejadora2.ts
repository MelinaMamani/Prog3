window.onload = function() {
    MostrarListado();
}

function EnviarDatos() : void {
    
        let xhr : XMLHttpRequest = new XMLHttpRequest();
        let nombre = (<HTMLInputElement> document.getElementById("nombre"));
        let legajo = (<HTMLInputElement> document.getElementById("legajo"));
        let foto : any = (<HTMLInputElement> document.getElementById("foto"));
        let form : FormData = new FormData();
        form.append('nombre',nombre.value);
        form.append('legajo',legajo.value);
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