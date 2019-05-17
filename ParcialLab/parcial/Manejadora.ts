/// <reference path="Clases/Perro.ts"/>
namespace PrimerParcial
{
    function AgregarPerroJSON() 
    {
        let xhr : XMLHttpRequest = new XMLHttpRequest();
        let nombre = (<HTMLInputElement> document.getElementById("nombre"));
        let edad = (<HTMLInputElement> document.getElementById("edad"));
        let raza = (<HTMLInputElement> document.getElementById("cboRaza"));
        let tamanio = (<HTMLInputElement> document.getElementById("tamanio"));
        let precio = (<HTMLInputElement> document.getElementById("precio"));
        let foto : any = (<HTMLInputElement> document.getElementById("foto"));
        let form : FormData = new FormData();
        form.append('nombre',nombre.value);
        form.append('edad',edad.value);
        form.append('raza',raza.value);
        form.append('tamanio',tamanio.value);
        form.append('precio',precio.value);
        form.append('foto',foto.files[0]);
        form.append('op', "subirDatos");
        xhr.open('POST', './BACKEND/agregar_json.php', true);
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
                    retJSON.perro = new Entidades.Perro(tamanio.value,parseInt(edad.value),parseFloat(precio.value),nombre.value,raza.value,foto.value[0]);
                    (<HTMLImageElement> document.getElementById("foto_mostrar")).src = "./BACKEND/" + retJSON.Path;
                }
            }
        }
    }
}