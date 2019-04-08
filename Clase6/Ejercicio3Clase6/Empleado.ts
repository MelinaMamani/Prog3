/// <reference path="Persona.ts"/>
namespace Empleados
{
    export class Empleado extends Persona
    {
        protected _legajo : number;
        protected _sueldo : number;

        public constructor(nombre:string, apellido:string, sexo : string, dni:number, legajo:number, sueldo : number)
        {
            super(nombre,apellido,sexo,dni);
            this._legajo = legajo;
            this._sueldo = sueldo;
        }

        /**
         * GetLegajo
         */
        public GetLegajo():number 
        {
            return this._legajo;
        }

        /**
         * GetSueldo
         */
        public GetSueldo():number 
        {
            return this._sueldo;
        }

        /**
         * Hablar
         */
        public Hablar(idioma:string):string
        {
            return "El empleado habla "+idioma+"\n";
        }

        /**
         * ToString de Empleado
         */
        public ToString():string 
        {
            return super.ToString()+this.GetLegajo()+"-"+this.GetSueldo()+"\n";
        }
    }
}