namespace Entidades
{
    export class Mascota {
        
        public tamanio:string;
        public edad:number;
        public precio:number;
        
        public constructor(tamanio:string,edad:number,precio:number) 
        {
            this.tamanio = tamanio;
            this.edad = edad;
            this.precio = precio;
        }

        public ToString():string 
        {
            return "{tamanio: "+this.tamanio+", edad: "+this.edad+",precio: "+this.precio+"}";
        }
    }
}