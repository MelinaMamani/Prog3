namespace Entidades {
    export class Persona {
        protected _nombre: string;
        protected _apellido: string;
        protected _edad: number;

        public constructor(nombre: string, apellido: string, edad: number) {
            this._nombre = nombre;
            this._apellido = apellido;
            this._edad = edad;
        }

        protected personaToString() {
            return `"nombre":"${this._nombre}","apellido":"${this._apellido}","edad":${this._edad}`;
        }
    }

    export class Ciudadano extends Persona {
        protected _dni: number;
        protected _pais: string;

        public constructor(nombre: string, apellido: string, edad: number, dni: number, pais: string) {
            super(nombre, apellido, edad);
            this._dni = dni;
            this._pais = pais;
        }

        public ciudadanoToJson(): JSON {
            return JSON.parse(`{${this.personaToString()},"pais":"${this._pais}","dni":${this._dni}}`);
        }
    }
}