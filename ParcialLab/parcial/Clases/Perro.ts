/// <reference path = "./Mascota.ts"/>
namespace Entidades
{
    export class Perro extends Entidades.Mascota
    {
        public nombre:string;
        public raza:string;
        public pathFoto:string;

        public constructor(tamanio:string,edad:number,precio:number,nombre:string,raza:string,pathFoto:string)
        {
            super(tamanio,edad,precio);
            this.nombre = nombre;
            this.raza = raza;
            this.pathFoto = pathFoto;
        }

        public ToJson():JSON
        {
            var unJson = super.ToString();
            return unJson;
        }
    }
}