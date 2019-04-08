namespace Empleados
{
    export abstract class Persona
    {
        private _apellido : string;
        private _dni : number;
        private _nombre : string;
        private _sexo : string;

        public constructor(nombre:string, apellido:string, sexo : string, dni : number)
        {
            this._apellido =  apellido;
            this._dni = dni;
            this._nombre = nombre;
            this._sexo = sexo;
        }

        /**
         * GetApellido : devuelve apellido
         */
        public GetApellido():string 
        {
            return this._apellido;
        }

        /**
         * GetNombre : devuelve nombre
         */
        public GetNombre():string 
        {
            return this._nombre;
        }

        /**
         * GetSexo
         */
        public GetSexo():string 
        {
            return this._sexo;
        }

        /**
         * GetDNI
         */
        public GetDNI():number 
        {
            return this._dni;
        }

        public abstract Hablar(idioma:string):string;

        /**
         * ToString
         */
        public ToString():string 
        {
            return this.GetApellido()+"-"+this.GetNombre()+"-"+this.GetDNI()+"-"+this.GetSexo()+"-";
        }
    }
}