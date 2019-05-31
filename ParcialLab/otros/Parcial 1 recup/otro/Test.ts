/// <reference path="./Entidades.ts" />
namespace Test {

    export class Manejadora {
        protected static _path: string;
        public static AgregarCampera(modo: string) {

            let codigo = parseInt((<HTMLInputElement>document.getElementById('txtCodigo')).value);
            let nombre = (<HTMLInputElement>document.getElementById('txtNombre')).value;
            let precio: number = parseInt((<HTMLInputElement>document.getElementById('txtPrecio')).value);
            let talle = (<HTMLInputElement>document.getElementById('txtTalle')).value;
            let color = (<HTMLSelectElement>document.getElementById('cboColor')).value;

            Manejadora.SubirFoto(codigo);
            let path = "";
            path = (<HTMLImageElement>document.getElementById('imgFoto')).alt;
            let camperaPost: Entidades.Campera = new Entidades.Campera(codigo, nombre, precio, talle, color, path);
            let xhttp: XMLHttpRequest = new XMLHttpRequest();

            if (modo == 'agregar') {
                xhttp.open("POST", "./BACKEND/administrar.php");
                xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                xhttp.send("caso=agregar&cadenaJson=" + JSON.stringify(camperaPost.camperaToJson()));
                xhttp.onreadystatechange = function () {
                    if (xhttp.readyState == 4 && xhttp.status == 200) {
                        Manejadora.AdministrarSpinner(false);
                        console.log("Funciono al agregar!" + xhttp.responseText);
                        Manejadora.MostrarCamperas("mostrar");
                    }
                    else {
                        Manejadora.AdministrarSpinner(true);
                    }
                };
            }
            else {

                xhttp.open("POST", "./BACKEND/administrar.php");
                xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                xhttp.send("caso=modificar&cadenaJson=" + JSON.stringify(camperaPost.camperaToJson()));
                xhttp.onreadystatechange = function () {
                    if (xhttp.readyState == 4 && xhttp.status == 200) {
                        console.log("Funciono al Modificar!" + xhttp.responseText);
                        Manejadora.AdministrarSpinner(false);
                        Manejadora.MostrarCamperas("mostrar");
                    }
                    else {
                        Manejadora.AdministrarSpinner(true);
                    }
                };
                (<HTMLSelectElement>document.getElementById('btnAgregar')).setAttribute('onclick', 'Test.Manejadora.AgregarCampera("agregar")');
                (<HTMLInputElement>document.getElementById('txtCodigo')).readOnly = false;
            }
            Manejadora.LimpiarForm();

        }

        public static MostrarCamperas(caso: String) {
            let xhttp: XMLHttpRequest = new XMLHttpRequest();
            xhttp.open("POST", "./BACKEND/administrar.php");
            xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            xhttp.send("caso=mostrar");
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    Manejadora.AdministrarSpinner(false);
                    let arrayJson = JSON.parse(xhttp.responseText);
                    console.log(arrayJson);
                    (<HTMLDivElement>document.getElementById('divTabla')).innerHTML = "";
                    (<HTMLDivElement>document.getElementById('divTabla')).innerHTML += '<table id="tablaMostrar" style="width:400px;"></table>'
                    arrayJson.forEach((campera: any) => {
                        if (caso == 'mostrar') {
                            let camperDatos = campera.codigo + "-" + campera.nombre + "-" + campera.precio + "-" + campera.talle + "-" + campera.color + "-" + campera.path;
                            (<HTMLDivElement>document.getElementById('tablaMostrar')).innerHTML +=
                                `<tr>
                                <td>${camperDatos}</td>
                                <td><button onclick='Test.Manejadora.EliminarCampera(${JSON.stringify(campera)})'>Eliminar</button></td>
                                 <td><button onclick='Test.Manejadora.ModificarCampera(${JSON.stringify(campera)})'>Modificar</button></td>
                                 </tr>`;
                        }
                        else {

                            if ((<HTMLSelectElement>document.getElementById('cboColor')).value == campera.color) {
                                let camperDatos = campera.codigo + "-" + campera.nombre + "-" + campera.precio + "-" + campera.talle + "-" + campera.color + "-" + campera.path;
                                (<HTMLDivElement>document.getElementById('tablaMostrar')).innerHTML +=
                                    `<tr>
                                    <td>${camperDatos}</td>
                                    <td><button onclick='Test.Manejadora.EliminarCampera(${JSON.stringify(campera)})'>Eliminar</button></td>
                                     <td><button onclick='Test.Manejadora.ModificarCampera(${JSON.stringify(campera)})'>Modificar</button></td>
                                     </tr>`;
                            }

                        }

                    });
                }
                else {
                    Manejadora.AdministrarSpinner(true);
                }
            };
        }

        public static EliminarCampera(camperaJson: any) {

            if (confirm(`Desea eliminar a ${camperaJson.codigo} ${camperaJson.talle}?`)) {
                Test.Manejadora.EliminarFoto(camperaJson.codigo);
                let xhttp: XMLHttpRequest = new XMLHttpRequest();

                xhttp.open("POST", "./BACKEND/administrar.php");
                xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                xhttp.send("caso=eliminar&cadenaJson=" + JSON.stringify(camperaJson));

                xhttp.onreadystatechange = function () {
                    if (xhttp.readyState == 4 && xhttp.status == 200) {
                        Manejadora.AdministrarSpinner(false);
                        console.log(xhttp.responseText);
                        Manejadora.MostrarCamperas("mostrar");
                    }
                    else {
                        Manejadora.AdministrarSpinner(true);
                    }
                };
            }
            Manejadora.MostrarCamperas('mostrar');
        }
        public static ModificarCampera(camperaJson: any) {
            (<HTMLInputElement>document.getElementById('txtCodigo')).value = camperaJson.codigo;
            (<HTMLInputElement>document.getElementById('txtNombre')).value = camperaJson.nombre;
            (<HTMLInputElement>document.getElementById('txtPrecio')).value = camperaJson.precio;
            (<HTMLInputElement>document.getElementById('txtTalle')).value = camperaJson.talle;
            (<HTMLInputElement>document.getElementById('txtCodigo')).readOnly = true;
            (<HTMLSelectElement>document.getElementById('cboColor')).value = camperaJson.color;
            (<HTMLInputElement>document.getElementById('btnAgregar')).setAttribute('onclick', 'Test.Manejadora.AgregarCampera("modificar")');

        }

        public static LimpiarForm() {
            (<HTMLInputElement>document.getElementById('txtCodigo')).value = "";
            (<HTMLInputElement>document.getElementById('txtNombre')).value = "";
            (<HTMLInputElement>document.getElementById('txtPrecio')).value = "";
            (<HTMLInputElement>document.getElementById('txtTalle')).value = "";
            (<HTMLSelectElement>document.getElementById('cboColor')).selectedIndex = 0;
        }

        public static CargarColoresJSON() {

            let xhttp: XMLHttpRequest = new XMLHttpRequest();

            xhttp.open("POST", "./BACKEND/administrar.php");
            xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            xhttp.send("caso=colores");
            let cboColor = (<HTMLSelectElement>document.getElementById('cboColor'));
            cboColor.innerHTML = "";
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    Manejadora.AdministrarSpinner(false);
                    let jsonColores = JSON.parse(xhttp.responseText);
                    jsonColores.forEach((color: any) => {
                        cboColor.innerHTML += `<option id='${color.id}'>${color.descripcion}</option>`;
                    });
                }
                else {
                    Manejadora.AdministrarSpinner(true);
                }
            };
            Manejadora.LimpiarForm();
        }

        public static AdministrarSpinner(activar: Boolean) {
            setTimeout(() => {
                if (!activar) {
                    (<HTMLImageElement>document.getElementById('imgSpinner')).setAttribute('src', '');
                }
            }, 1000);
            if (activar)
                (<HTMLImageElement>document.getElementById('imgSpinner')).setAttribute('src', './BACKEND/gif-load.gif');
        }

        public static ModificarFoto(codigo: number) {

            let xhttp: XMLHttpRequest = new XMLHttpRequest();

            xhttp.open("POST", "./BACKEND/administrar.php");
            xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            xhttp.send("caso=modificarFoto&codigo=" + codigo);
            let cboColor = (<HTMLSelectElement>document.getElementById('cboColor'));
            cboColor.innerHTML = "";
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    console.log(xhttp.responseText);

                    let retJSON = JSON.parse(xhttp.responseText);
                    if (!retJSON.Ok) {
                        console.error("NO se subió la foto!!!");
                    }
                    else {
                        console.info("Foto subida OK!!!");
                        (<HTMLImageElement>document.getElementById("imgFoto")).src = "./BACKEND/" + retJSON.Path;
                        Manejadora._path = "./BACKEND/" + retJSON.Path;
                    }
                }
            }
        }
        public static EliminarFoto(codigo: number) {
            let xhttp: XMLHttpRequest = new XMLHttpRequest();

            xhttp.open("POST", "./BACKEND/administrar.php");
            xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            xhttp.send("caso=eliminarFoto&codigo=" + codigo);
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    console.log(xhttp.responseText);

                    let retJSON = JSON.parse(xhttp.responseText);
                    if (!retJSON.Ok) {
                        console.error("NO se subió la foto!!!");
                    }
                    else {
                        console.info("Foto subida OK!!!");
                        (<HTMLImageElement>document.getElementById("imgFoto")).src = "./BACKEND/" + retJSON.Path;
                        Manejadora._path = "./BACKEND/" + retJSON.Path;
                    }
                }
            }

        }
        public static SubirFoto(codigo: number,path:string) {

            //INSTANCIO OBJETO PARA REALIZAR COMUNICACIONES ASINCRONICAS
            let xhr: XMLHttpRequest = new XMLHttpRequest();

            //RECUPERO LA IMAGEN SELECCIONADA POR EL USUARIO
            let foto: any = (<HTMLInputElement>document.getElementById("idFoto"));

            //INSTANCIO OBJETO FORMDATA
            let form: FormData = new FormData();

            //AGREGO PARAMETROS AL FORMDATA:

            //PARAMETRO RECUPERADO POR $_FILES
            form.append('foto', foto.files[0]);

            //PARAMETRO RECUPERADO POR $_POST O $_GET (SEGUN CORRESPONDA)
            form.append('caso', "subirFoto");
            form.append('codigo', codigo.toString());
            //METODO; URL; ASINCRONICO?
            xhr.open('POST', './BACKEND/administrar.php', true);

            //ESTABLEZCO EL ENCABEZADO DE LA PETICION
            xhr.setRequestHeader("enctype", "multipart/form-data");

            //ENVIO DE LA PETICION
            xhr.send(form);
            //FUNCION CALLBACK
            xhr.onreadystatechange = () => {
                if (xhr.readyState == 4 && xhr.status == 200) {

                    console.log(xhr.responseText);
                    let retJSON = JSON.parse(xhr.responseText);
                    if (!retJSON.Ok) {
                        console.error("NO se subió la foto!!!");
                    }
                    else {
                        console.info("Foto subida OK!!!");
                        (<HTMLImageElement>document.getElementById("imgFoto")).src = "./BACKEND/" + retJSON.Path;

                    }
                }

            };

        }
    }
}