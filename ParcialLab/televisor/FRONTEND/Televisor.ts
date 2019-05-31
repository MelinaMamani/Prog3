/// <reference path="./Producto.ts" />

namespace Entidades{
    export class Televisor extends Producto{
        private _tipo:string;
        private _paisOrigen:string;
        private _pathFoto:string;

        public constructor(codigo:number,marca:string,precio:number,tipo:string,paisOrigen:string,pathFoto:string){
            super(codigo,marca,precio);
            this._tipo = tipo;
            this._paisOrigen = paisOrigen;
            this._pathFoto = pathFoto;
        }

        public ToJson():any{
            let json:any = JSON.parse(super.ToString());
            
            json.tipo = this._tipo;
            json.paisOrigen = this._paisOrigen;
            json.pathFoto = this._pathFoto;

            return json;
        }
    }
}