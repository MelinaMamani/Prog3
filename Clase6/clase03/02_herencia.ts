export class Vehiculo{

    protected _marca:string;

    public constructor(marca:string){
        this._marca = marca;
    }

    public Mostrar():string{
        return this._marca;
    }
}

export class Auto extends Vehiculo{

    public color : string;
    private _precio : number;

    public get Precio():number{
        return this._precio;
    }

    public set Precio(value : number) {
        this._precio = value;
    }  

    public constructor(color:string, precio:number, marca:string){
        super(marca);
        this._precio = precio;
        this.color = color;
    }

    //POLIMORFISMO
    public Mostrar():string{
        return super.Mostrar() + this._precio + this.color;
    }
}