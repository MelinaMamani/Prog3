export abstract class Vehiculo{

    protected _marca:string;

    public constructor(marca:string){
        this._marca = marca;
    }

    public abstract Acelerar():void;

    public abstract get Marca() : string;
    public abstract set Marca(value: string);
    
    public Mostrar():string{
        return this._marca;
    }
}

export class Auto extends Vehiculo{

    public color : string;
    private _precio : number;

    public GetPrecio():number{
        return this._precio;
    }

    public constructor(color:string, precio:number, marca:string){
        super(marca);
        this._precio = precio;
        this.color = color;
    }

    //DE LA CLASE ABSTRACTA
    public Acelerar():void{
        console.log("Acelerando...");
    }

    //DE LA CLASE ABSTRACTA
    public get Marca():string{
        return this._marca;
    }

    //DE LA CLASE ABSTRACTA
    public set Marca(value:string){
        this.color = value;
    }

    //POLIMORFISMO
    public Mostrar():string{
        return super.Mostrar() + this._precio + this.color;
    }

}