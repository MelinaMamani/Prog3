namespace Ajax
{
    export function DevolverRemeras():void
    {
        let devolver = 1;
        let xmlR = new XMLHttpRequest();

        xmlR.open("GET","administrarRemeras.php?devolver="+devolver,true);
        xmlR.send();

        xmlR.onreadystatechange = () => {
            if (xmlR.readyState == 4 && xmlR.status == 200) {
                console.log(xmlR.responseText);
                //alert(xmlR.responseText);
                (<HTMLDivElement>document.getElementById("div_tabla")).innerHTML = xmlR.responseText;
            }
        }
    }
}