export interface IAutoBase{
    
    GetColor():string;
    SetColor(color:string):void;
    patente : string;
}

export class Auto implements IAutoBase{

    private color : string;
    private _precio : number;

    //DE LA INTERFACE
    public patente : string;

    public get Precio():number{
        return this._precio;
    }

    public constructor(color:string, precio:number){
        this._precio = precio;
        this.color = color;
    }

    //DE LA INTERFACE
    public GetColor():string{
        return this.color;
    }

    //DE LA INTERFACE
    public SetColor(color:string):void{
        this.color = color;
    }
}
//NOTAS:
//1) LAS INTERFACES SE PUEDEN HEREDAR
//2) LAS INTERFACES PUEDEN CONTENER ATRIBUTOS Y METODOS
