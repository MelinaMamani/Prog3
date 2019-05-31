/// <reference path="./Televisor.ts" />

namespace PrimerParcial{
   export class Manejadora{
        public static AgregarTelevisor(modificar?:boolean){
            var codigo:any = <HTMLInputElement>document.getElementById("codigo");
            var marca:any = <HTMLInputElement>document.getElementById("marca");
            var precio:any = <HTMLInputElement>document.getElementById("precio");
            var tipo:any = <HTMLInputElement>document.getElementById("tipo");
            var pais:any = <HTMLSelectElement>document.getElementById("pais");
            var foto:any = <HTMLInputElement>document.getElementById("foto");

            let tv:Entidades.Televisor = new Entidades.Televisor(codigo.value,marca.value,precio.value,tipo.value,pais.value,codigo.value+".jpg");
            let form:FormData = new FormData();
            let xhttp : XMLHttpRequest = new XMLHttpRequest();
            
            if(modificar){
                form.append('caso','modificar');
            }else{
                form.append('caso','agregar');
            }
            form.append('cadenaJson',JSON.stringify(tv.ToJson()));
            form.append('foto',foto.files[0]);
    
            xhttp.open("POST", "./BACKEND/administrar.php", true);
            xhttp.setRequestHeader("ENCTYPE","multipart/form-data");
            xhttp.send(form);
        
            xhttp.onreadystatechange = () => {
        
                if(xhttp.readyState == 4 && xhttp.status == 200){
                    let arrayJson : any = JSON.parse(xhttp.responseText);
                    if(arrayJson.TodoOK){
                       let img = <HTMLImageElement>document.getElementById("imgFoto");
                        img.setAttribute("src","BACKEND/fotos/"+codigo.value+".jpg");
                        alert("Televisor: " + codigo.value + ", Fue agregado correctamente");
                    }else{
                        alert("Error");
                    }
        
        
                }

            }
        }

        public static MostrarTelevisores(){
            
            let xhttp : XMLHttpRequest = new XMLHttpRequest();
            let formData : FormData = new FormData();
            formData.append("caso","traer");

            xhttp.open("POST", "./BACKEND/administrar.php", true);
            xhttp.setRequestHeader("ENCTYPE","multipart/form-data");
            xhttp.send(formData);
            
            xhttp.onreadystatechange = () => {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    if(xhttp.responseText != "error"){
                        let obj:any = JSON.parse(xhttp.responseText);
                       var html:string = "<table><tr><th>Codigo</th><th>Marca</th><th>Precio</th>"+
                            "<th>Tipo</th><th>Pais</th><th>Foto</th></tr>";
                        obj.forEach(function(o:any) {
                            html += '<tr><td>'+o.codigo+'</td><td>'+o.marca+'</td><td>'+o.precio
                                +'</td><td>'+o.tipo+'</td>'
                                +'<td>'+o.paisOrigen+'</td>' 
                                +'<td><img id="fotoTabla" src="./BACKEND/fotos/'+o.pathFoto+'" height="100px" width="100px" />'                                
                                +'<td><input type="button" value="Eliminar" class="btn btn-info" onclick="PrimerParcial.Manejadora.EliminarTelevisor('+o.codigo+')">'
                                +'<td><input type="button" value="Modificar" class="btn btn-info"  onclick="PrimerParcial.Manejadora.ModificarTelevisor('+o.codigo+')"> </tr>';
                           
                          });
                          html+= "</table>";
                          let tabla = <HTMLElement>document.getElementById("divTabla");
                          tabla.innerHTML = html;
                    }else{

                    }
                    
                }else{  
                }
            }
        }

       public static GuardarEnLocalStorage(){
        let xhttp : XMLHttpRequest = new XMLHttpRequest();
        let formData : FormData = new FormData();
        formData.append("caso","traer");

        xhttp.open("POST", "./BACKEND/administrar.php", true);
        xhttp.setRequestHeader("ENCTYPE","multipart/form-data");
        xhttp.send(formData);
        
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                if(xhttp.responseText != "error"){
                   // let obj:any = JSON.stringify(xhttp.responseText);
                    localStorage.setItem("televisores_local_storage",xhttp.responseText);
                }
                
            }
        }
        
       }

       public static VerificarExistencia(){           
            var codigo:any = <HTMLInputElement>document.getElementById("codigo");
            var marca:any = <HTMLInputElement>document.getElementById("marca");
            var precio:any = <HTMLInputElement>document.getElementById("precio");
            var tipo:any = <HTMLInputElement>document.getElementById("tipo");
            var pais:any = <HTMLSelectElement>document.getElementById("pais");
            var foto:any = <HTMLInputElement>document.getElementById("foto");
            var flag:boolean = false;
            var locals = localStorage.getItem("televisores_local_storage");
          //  console.log(locals);
            if(locals!=null){
                let obj:any = JSON.parse(locals);
               // console.log(typeof(obj));
               // console.log(obj);
                obj.forEach(function(o:any) {
                    if(o.codigo == codigo.value){
                        console.log("El televisor ya existe");
                        alert("El televisor ya existe");
                        flag = true;
                    }
                });
            }
            if(!flag){
                
                console.log("Televisor No encontrado");
                PrimerParcial.Manejadora.AgregarTelevisor();
                PrimerParcial.Manejadora.GuardarEnLocalStorage();
            }
           
       }

       public static EliminarTelevisor(codigo:string){

            let xhttp : XMLHttpRequest = new XMLHttpRequest();
            let formData : FormData = new FormData();
            var c:string="";
            var t:string = "";
            let tv:Entidades.Televisor;
            formData.append("caso","traer");

            xhttp.open("POST", "./BACKEND/administrar.php", true);
            xhttp.setRequestHeader("ENCTYPE","multipart/form-data");
            xhttp.send(formData);
            
            xhttp.onreadystatechange = () => {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    if(xhttp.responseText != "error"){
                        let obj:any = JSON.parse(xhttp.responseText);
                        console.log(obj);
                        obj.forEach(function(o:any) {                            
                            if(o.codigo == codigo){
                                tv = new Entidades.Televisor(o.codigo,
                                    o.marca,o.precio,o.tipo,o.paisOrigen,o.codigo+".jpg");
                                 c = o.codigo;
                                 t= o.tipo;
                                 let form:FormData = new FormData();
                                 if(confirm('¿Estas seguro que desea eliminar el televisor ?' + c + '-' + t))
                                 {                
                                     form.append('caso','eliminar');
                                     form.append('cadenaJson',JSON.stringify(tv.ToJson()));
                                     xhttp.open("POST", "./BACKEND/administrar.php", true);
                                     xhttp.setRequestHeader("ENCTYPE","multipart/form-data");
                                     xhttp.send(form);            
                                     xhttp.onreadystatechange = () => {            
                                         if(xhttp.readyState == 4 && xhttp.status == 200){
                                             let arrayJson : any = JSON.parse(xhttp.responseText);
                                             if(arrayJson.TodoOK){
                                                 alert("Televisor: " + codigo + ", Fue eliminado correctamente");
                                                 PrimerParcial.Manejadora.MostrarTelevisores();
                                             }else{
                                                 alert("Error");
                                             }
                                 
                                 
                                         }
                     
                                     }
                                 }
                                 else
                                 {
                                     return false;
                                 }
                                    
                            }
                        });
                    }else{

                    }
                    
                }	
        }
    }

    
    public static ModificarTelevisor(cod:string){
        var codigo:any = <HTMLInputElement>document.getElementById("codigo");
        var marca:any = <HTMLInputElement>document.getElementById("marca");
        var precio:any = <HTMLInputElement>document.getElementById("precio");
        var tipo:any = <HTMLInputElement>document.getElementById("tipo");
        var pais:any = <HTMLSelectElement>document.getElementById("pais");
        var foto:any = <HTMLInputElement>document.getElementById("foto");
        var boton:any = <HTMLInputElement>document.getElementById("btn-agregar");

        boton.value = "Modificar";
        boton.onclick = 'PrimerParcial.Manejadora.AgregarTelevisor(true)';
        codigo.readOnly = true;


        let xhttp : XMLHttpRequest = new XMLHttpRequest();
        let formData : FormData = new FormData();
        var c:string="";
        var t:string = "";
        let tv:Entidades.Televisor;
        formData.append("caso","traer");

        xhttp.open("POST", "./BACKEND/administrar.php", true);
        xhttp.setRequestHeader("ENCTYPE","multipart/form-data");
        xhttp.send(formData);
        
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                if(xhttp.responseText != "error"){
                    let obj:any = JSON.parse(xhttp.responseText);
                    console.log(obj);
                    obj.forEach(function(o:any) {                            
                        if(o.codigo == cod){                            
                            codigo.value = o.codigo;
                            marca.value = o.marca;
                            precio.value = o.precio;
                            tipo.value = o.tipo;
                            pais.value = o.paisOrigen; 
                            let img = <HTMLImageElement>document.getElementById("imgFoto");
                            img.setAttribute("src","BACKEND/fotos/"+codigo.value+".jpg");
        
                        }
                    });
                }
            }
        }

    }
}
}