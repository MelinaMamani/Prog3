/// <reference path="./Entidades.ts" />
namespace Test {
    export class Manejadora {
        public static AgregarCiudadano(modo: string) {
            let xhttp: XMLHttpRequest = new XMLHttpRequest();
            let nombre = (<HTMLInputElement>document.getElementById('txtNombre')).value;
            let apellido = (<HTMLInputElement>document.getElementById('txtApellido')).value;
            let edad: number = parseInt((<HTMLInputElement>document.getElementById('txtEdad')).value);
            let dni = parseInt((<HTMLInputElement>document.getElementById('txtDni')).value);
            let pais = (<HTMLSelectElement>document.getElementById('cboPais')).value;
            let ciudPost: Entidades.Ciudadano = new Entidades.Ciudadano(nombre, apellido, edad, dni, pais);
            if (modo == 'agregar') {
                xhttp.open("POST", "./BACKEND/administrar.php");
                xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                xhttp.send("caso=agregar&cadenaJson=" + JSON.stringify(ciudPost.ciudadanoToJson()));

                xhttp.onreadystatechange = function () {
                    if (xhttp.readyState == 4 && xhttp.status == 200) {
                        Manejadora.AdministrarSpinner(false);
                        console.log("Funciono al agregar!" + xhttp.responseText);
                    }
                    else {
                        Manejadora.AdministrarSpinner(true);
                    }
                };
            }
            else {
                xhttp.open("POST", "./BACKEND/administrar.php");
                xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                xhttp.send("caso=modificar&cadenaJson=" + JSON.stringify(ciudPost.ciudadanoToJson()));
                xhttp.onreadystatechange = function () {
                    if (xhttp.readyState == 4 && xhttp.status == 200) {
                        console.log("Funciono al Modificar!" + xhttp.responseText);
                        Manejadora.AdministrarSpinner(false);
                    }
                    else {
                        Manejadora.AdministrarSpinner(true);
                    }
                };
                (<HTMLSelectElement>document.getElementById('btnAgregar')).setAttribute('onclick', 'Test.Manejadora.AgregarCiudadano("agregar")');
            }
            Manejadora.LimpiarInputs();

        }

        public static MostrarCiudadanos(caso: String) {
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
                    (<HTMLDivElement>document.getElementById('divTabla')).innerHTML += '<table id="tablaMostrar"></table>'
                    arrayJson.forEach((ciudadano: any) => {
                        if (caso == 'mostrar') {
                            let ciudDatos = ciudadano.nombre + "-" + ciudadano.apellido + "-" + ciudadano.edad + "-" + ciudadano.dni + "-" + ciudadano.pais;
                            (<HTMLDivElement>document.getElementById('tablaMostrar')).innerHTML +=
                                `<tr>
                                <td>${ciudDatos}</td>
                                <td><button onclick='Test.Manejadora.EliminarCiudadano(${JSON.stringify(ciudadano)})'>Eliminar</button></td>
                                 <td><button onclick='Test.Manejadora.ModificarCiudadano(${JSON.stringify(ciudadano)})'>Modificar</button></td>
                                 </tr>`;
                        }
                        else {
                            console.log(ciudadano.pais);
                            if ((<HTMLSelectElement>document.getElementById('cboPais')).value == ciudadano.pais) {
                                let ciudDatos = ciudadano.nombre + "-" + ciudadano.apellido + "-" + ciudadano.edad + "-" + ciudadano.dni + "-" + ciudadano.pais;
                                (<HTMLDivElement>document.getElementById('tablaMostrar')).innerHTML +=
                                    `<tr>
                                    <td>${ciudDatos}</td>
                                    <td><button onclick='Test.Manejadora.EliminarCiudadano(${JSON.stringify(ciudadano)})'>Eliminar</button></td>
                                     <td><button onclick='Test.Manejadora.ModificarCiudadano(${JSON.stringify(ciudadano)})'>Modificar</button></td>
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

        public static EliminarCiudadano(ciudJSON: any) {

            if (confirm(`Desea eliminar a ${ciudJSON.nombre} ${ciudJSON.apellido}?`)) {
                let xhttp: XMLHttpRequest = new XMLHttpRequest();

                xhttp.open("POST", "./BACKEND/administrar.php");
                xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                xhttp.send("caso=eliminar&cadenaJson=" + JSON.stringify(ciudJSON));

                xhttp.onreadystatechange = function () {
                    if (xhttp.readyState == 4 && xhttp.status == 200) {
                        Manejadora.AdministrarSpinner(false);
                        console.log(xhttp.responseText);
                    }
                    else {
                        Manejadora.AdministrarSpinner(true);
                    }
                };
            }
            Manejadora.MostrarCiudadanos('mostrar');
        }
        public static ModificarCiudadano(ciudJSON: any) {
            (<HTMLInputElement>document.getElementById('txtNombre')).value = ciudJSON.nombre;
            (<HTMLInputElement>document.getElementById('txtApellido')).value = ciudJSON.apellido;
            (<HTMLInputElement>document.getElementById('txtEdad')).value = ciudJSON.edad;
            (<HTMLInputElement>document.getElementById('txtDni')).value = ciudJSON.dni;
            (<HTMLInputElement>document.getElementById('txtDni')).readOnly = true;
            (<HTMLSelectElement>document.getElementById('cboPais')).value = ciudJSON.pais;
            (<HTMLInputElement>document.getElementById('btnAgregar')).setAttribute('onclick', 'Test.Manejadora.AgregarCiudadano("modificar")');

        }

        public static LimpiarInputs() {
            (<HTMLInputElement>document.getElementById('txtNombre')).value = "";
            (<HTMLInputElement>document.getElementById('txtApellido')).value = "";
            (<HTMLInputElement>document.getElementById('txtEdad')).value = "";
            (<HTMLInputElement>document.getElementById('txtDni')).value = "";
            (<HTMLSelectElement>document.getElementById('cboPais')).selectedIndex = 0;
        }

        public static CargarPaisesJSON() {

            let xhttp: XMLHttpRequest = new XMLHttpRequest();

            xhttp.open("POST", "./BACKEND/administrar.php");
            xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            xhttp.send("caso=paises");
            let cboPais = (<HTMLSelectElement>document.getElementById('cboPais'));
            cboPais.innerHTML = "";
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    Manejadora.AdministrarSpinner(false);
                    let jsonPaises = JSON.parse(xhttp.responseText);
                    jsonPaises.forEach((pais: any) => {
                        cboPais.innerHTML += `<option id='${pais.id}'>${pais.descripcion}</option>`;
                    });
                }
                else {
                    Manejadora.AdministrarSpinner(true);
                }
            };
            Manejadora.LimpiarInputs();
        }

        public static AdministrarSpinner(activar: Boolean) {
            setTimeout(()=> {
                if(!activar){
                    (<HTMLImageElement>document.getElementById('imgSpinner')).setAttribute('src', '');
                }
            }, 1000);
            if (activar)
                (<HTMLImageElement>document.getElementById('imgSpinner')).setAttribute('src', './BACKEND/gif-load.gif');
        }
    }
}