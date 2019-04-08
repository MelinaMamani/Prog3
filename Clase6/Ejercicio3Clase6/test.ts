/// <reference path="./Empleado.ts"/>

function Ingresar():void {

    let nombre:string = (<HTMLInputElement> document.getElementById("nombre")).value;

    let apellido:string = (<HTMLInputElement> document.getElementById("apellido")).value;
    let dni:number = parseInt((<HTMLInputElement> document.getElementById("dni")).value);
    let sexo:string = (<HTMLInputElement> document.getElementById("cboSexo")).value;
    let legajo:number = parseInt((<HTMLInputElement> document.getElementById("legajo")).value);
    let sueldo:number = parseInt((<HTMLInputElement> document.getElementById("sueldo")).value);

    let e = new Empleados.Empleado(nombre,apellido,sexo,dni,legajo,sueldo);
    console.log(e.ToString());
    console.log(e.Hablar("español")); 
}
