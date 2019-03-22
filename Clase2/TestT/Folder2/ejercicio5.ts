var nombre : string;
nombre = "melina";

var apellido : string;
apellido = "mamaní";

function MostrarApellidoNombre(apellido:string, nombre:string):string
{
    return apellido.toUpperCase()+", "+nombre.toLocaleUpperCase();
}

var potencia = (x:number) => x*x;
console.log(MostrarApellidoNombre(apellido,nombre)+potencia(5));

