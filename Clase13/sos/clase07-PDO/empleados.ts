//ese metodo se va a ejecutar cada vez que se carge la ventana
window.onload = function(){

    MostrarListado();

}

function MostrarListado(){

let xhr : XMLHttpRequest = new XMLHttpRequest();

let form : FormData = new FormData();

form.append('op', "mostrarListado");


xhr.open('POST', './BACKEND/nexo.php', true);

xhr.setRequestHeader("enctype", "multipart/form-data");

xhr.send(form);

xhr.onreadystatechange = () => {

    if (xhr.readyState == 4 && xhr.status == 200) {
        //la tabla que recuperamos desde nexo.php la mostramos dentro de el "div"
       (<HTMLInputElement>document.getElementById("div")).innerHTML=xhr.responseText;
    }
};

}



function SubirFoto() : void {
    
    //INSTANCIO OBJETO PARA REALIZAR COMUNICACIONES ASINCRONICAS
    let xhr : XMLHttpRequest = new XMLHttpRequest();

    //RECUPERO LA IMAGEN SELECCIONADA POR EL USUARIO
    let foto : any = (<HTMLInputElement> document.getElementById("fileFoto"));

    let nombre : string =(<HTMLInputElement> document.getElementById("txtNombre")).value;
    let apellido : string =(<HTMLInputElement> document.getElementById("txtApellido")).value;
    let legajo : string =(<HTMLInputElement> document.getElementById("numLegajo")).value;
    let sueldo : string =(<HTMLInputElement> document.getElementById("numSueldo")).value;
    //INSTANCIO OBJETO FORMDATA
    let form : FormData = new FormData();

    let op:string="";

    //AGREGO PARAMETROS AL FORMDATA:

    //PARAMETRO RECUPERADO POR $_FILES
    form.append('foto', foto.files[0]);
    form.append('txtNombre',nombre);
    form.append('txtApellido',apellido);
    form.append('numLegajo',legajo);
    form.append('numSueldo',sueldo);

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
    if(localStorage.getItem("modificar") == "true")
    {
        op="modificarFoto";
        
    }
    else
    {
        op="subirFoto";    
    }

    console.log(op);

    form.append('op',op);


    //ENVIO DE LA PETICION
    xhr.send(form);

    //FUNCION CALLBACK
    xhr.onreadystatechange = () => {

        if (xhr.readyState == 4 && xhr.status == 200) {

            //vuelvo a cambiar el input a enviar en vez de modificar
            (<HTMLInputElement> document.getElementById("btn")).value = "Enviar";
            (<HTMLInputElement> document.getElementById("btn")).className="btn btn-success";
           
            //funcion que me limpia los campos una vez subida un empleado o modificado
            LimpiarCampos();
           
           
            //limpio el localStorage
            localStorage.clear();

            //recupero el objeto de tipo JSON en formato cadena que nos devuelve nexo.php
            let retJSON = JSON.parse(xhr.responseText);

            //si el atributo "Ok" es falso , mostramos que la foto no se subio
            if(!retJSON.Ok){
                console.error("NO se subió la foto!!!");
            }
            else{
                //si el atributo "Ok" es true , mostramos la foto subida pisando la que ya estaba por default
                console.info("Foto subida OK!!!");
                
                //direccion de donde se encuentra la foto
                let path :string="./BACKEND/"+retJSON.Path;
                //hay que cambiar el "src" para que sepa donde buscar la foto 
                (<HTMLImageElement> document.getElementById("imgFoto")).src = path;
                console.log(retJSON.Path);
            }
            //le damos a refresacr el listado para que aparezca el nuevo usuario agregado a la lista
            MostrarListado();
        }
    };
}

//ya viene creado el objeto de tipo JSON
function Eliminar(empleado:any)
{
   let objEmp :any = empleado;
   let datosEmpleado= objEmp.nombre;

   if(confirm("Esta seguro que desea eliminar al empleado: " +datosEmpleado))
   {
    let xhr : XMLHttpRequest = new XMLHttpRequest();

    let form : FormData = new FormData();

    form.append('obj',JSON.stringify(empleado) );

    form.append('op', "Eliminar");

    xhr.open('POST', './BACKEND/nexo.php', true);

    xhr.setRequestHeader("enctype", "multipart/form-data");

    xhr.send(form);

    xhr.onreadystatechange = () => {

        if (xhr.readyState == 4 && xhr.status == 200) {
          alert(xhr.responseText);
          MostrarListado();
        }
    };
   }
   else
   {
       alert("Accion cancelada");
   }
   MostrarListado();
}

function Modificar(empleado:any)
{
   let objEmp :any = empleado;


  (<HTMLInputElement> document.getElementById("txtNombre")).value=objEmp.nombre;
  (<HTMLInputElement> document.getElementById("txtApellido")).value=objEmp.apellido;
  (<HTMLInputElement> document.getElementById("numLegajo")).value=objEmp.legajo;

    //desabilito que se pueda escribir sobre el legajo ya que este no se cambia
    (<HTMLInputElement> document.getElementById("numLegajo")).disabled=true;

  (<HTMLInputElement> document.getElementById("numSueldo")).value=objEmp.sueldo;

  //direccion de donde se encuentra la foto
  let path :string="./BACKEND/"+objEmp.path_foto;
  //hay que cambiar el "src" para que sepa donde buscar la foto 
  (<HTMLImageElement> document.getElementById("imgFoto")).src = path;

  (<HTMLInputElement> document.getElementById("btn")).value ="Modificar";
  //(<HTMLInputElement> document.getElementById("btn")).className="btn btn-warning";

  localStorage.setItem("modificar","true");



   MostrarListado();
}

function LimpiarCampos()
{
    (<HTMLInputElement> document.getElementById("txtNombre")).value="";
    (<HTMLInputElement> document.getElementById("txtApellido")).value="";
    (<HTMLInputElement> document.getElementById("numSueldo")).value="";
    (<HTMLInputElement> document.getElementById("fileFoto")).value="";

    (<HTMLInputElement> document.getElementById("numLegajo")).value="";
    (<HTMLInputElement> document.getElementById("numLegajo")).disabled=false;

    (<HTMLImageElement> document.getElementById("imgFoto")).src = "./BACKEND/usr_default.jpg";
    
    

}