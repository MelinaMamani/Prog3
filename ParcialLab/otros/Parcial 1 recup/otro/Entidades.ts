namespace Entidades {
    export class Ropa {
        public codigo: number;
        public nombre: string;
        public precio: number;

        public constructor(codigo: number, nombre: string, precio: number) {
            this.codigo = codigo;
            this.nombre = nombre;
            this.precio = precio;
        }

        protected ropaToString() {
            return `"nombre":"${this.nombre}","precio":${this.precio},"codigo":${this.codigo}`;
        }
    }

    export class Campera extends Ropa {
        public talle: string;
        public color: string;
        public path: string;

        public constructor(codigo: number, nombre: string, precio: number, talle: string, color: string, path: string) {
            super(codigo, nombre, precio);
            this.talle = talle;
            this.color = color;
            this.path=path;
        }

        public camperaToJson(): JSON {
            return JSON.parse(`{"talle":"${this.talle}","color":"${this.color}","path":"${this.path}",${this.ropaToString()}}`);
        }
    }
}