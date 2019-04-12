namespace Ajax
{
    export function Saludar():void {
       
        let xmlR = new XMLHttpRequest ();
       
        xmlR.open("GET","admin.php",true);
        xmlR.send();

        xmlR.onreadystatechange = () => {
            if (xmlR.readyState == 4 && xmlR.status == 200) {
                console.log("Hola mundo ajax");
                alert("Hola mundo ajax");
                (<HTMLDivElement>document.getElementById("div_mostrar")).innerHTML = xmlR.responseText;
            }
        }
    }

    export function Ingresar():void {
        let nombre = (<HTMLInputElement>document.getElementById("nombre"));
        let accion = 2;
        let xmlR = new XMLHttpRequest();

        xmlR.open("GET","admin.php?nombre="+nombre.value+"&accion="+accion,true);
        xmlR.send();

        xmlR.onreadystatechange = () => {
            if (xmlR.readyState == 4 && xmlR.status == 200) {
                console.log(xmlR.responseText);
                if(xmlR.responseText == "1")
                {
                    Ajax.Mostrar();
                }
                else
                {
                    alert("No se pudo mostrar");
                }

                //Para accion 1
                //console.log(xmlR.responseText);
                //alert(xmlR.responseText);
                //(<HTMLDivElement>document.getElementById("div_mostrar")).innerHTML = xmlR.responseText;
            }
        }
    }

    export function Mostrar():void {
        let accion = 3;
        let xmlR = new XMLHttpRequest();

        xmlR.open("GET","admin.php?accion="+accion,true);
        xmlR.send();

        xmlR.onreadystatechange = () => {
            if (xmlR.readyState == 4 && xmlR.status == 200) {
                console.log(xmlR.responseText);
                //alert(xmlR.responseText);
                (<HTMLDivElement>document.getElementById("div_mostrar")).innerHTML = xmlR.responseText;
            }
        }
    }

    export function Verificar(nombre:string):boolean {
        let accion = 4;
        let xmlR = new XMLHttpRequest();

        xmlR.open("GET","admin.php?nombre="+nombre+"&accion="+accion,true);
        xmlR.send();

        xmlR.onreadystatechange = () => {
            if (xmlR.readyState == 4 && xmlR.status == 200) {
                if(xmlR.responseText == "1")
                {
                    return true;
                }
                else if(xmlR.responseText == "0")
                {
                    return false;
                }
            }
        }

        return true;
    }
}