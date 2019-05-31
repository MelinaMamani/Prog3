var __extends = (this && this.__extends) || (function () {
    var extendStatics = Object.setPrototypeOf ||
        ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
        function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var Entidades;
(function (Entidades) {
    var Producto = /** @class */ (function () {
        function Producto(codigo, marca, precio) {
            this._codigo = codigo;
            this._marca = marca;
            this._precio = precio;
        }
        Producto.prototype.ToString = function () {
            return JSON.stringify({ codigo: this._codigo, marca: this._marca, precio: this._precio });
        };
        return Producto;
    }());
    Entidades.Producto = Producto;
})(Entidades || (Entidades = {}));
/// <reference path="./Producto.ts" />
var Entidades;
(function (Entidades) {
    var Televisor = /** @class */ (function (_super) {
        __extends(Televisor, _super);
        function Televisor(codigo, marca, precio, tipo, paisOrigen, pathFoto) {
            var _this = _super.call(this, codigo, marca, precio) || this;
            _this._tipo = tipo;
            _this._paisOrigen = paisOrigen;
            _this._pathFoto = pathFoto;
            return _this;
        }
        Televisor.prototype.ToJson = function () {
            var json = JSON.parse(_super.prototype.ToString.call(this));
            json.tipo = this._tipo;
            json.paisOrigen = this._paisOrigen;
            json.pathFoto = this._pathFoto;
            return json;
        };
        return Televisor;
    }(Entidades.Producto));
    Entidades.Televisor = Televisor;
})(Entidades || (Entidades = {}));
/// <reference path="./Televisor.ts" />
var PrimerParcial;
(function (PrimerParcial) {
    var Manejadora = /** @class */ (function () {
        function Manejadora() {
        }
        Manejadora.AgregarTelevisor = function (modificar) {
            var codigo = document.getElementById("codigo");
            var marca = document.getElementById("marca");
            var precio = document.getElementById("precio");
            var tipo = document.getElementById("tipo");
            var pais = document.getElementById("pais");
            var foto = document.getElementById("foto");
            var tv = new Entidades.Televisor(codigo.value, marca.value, precio.value, tipo.value, pais.value, codigo.value + ".jpg");
            var form = new FormData();
            var xhttp = new XMLHttpRequest();
            if (modificar) {
                form.append('caso', 'modificar');
            }
            else {
                form.append('caso', 'agregar');
            }
            form.append('cadenaJson', JSON.stringify(tv.ToJson()));
            form.append('foto', foto.files[0]);
            xhttp.open("POST", "./BACKEND/administrar.php", true);
            xhttp.setRequestHeader("ENCTYPE", "multipart/form-data");
            xhttp.send(form);
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    var arrayJson = JSON.parse(xhttp.responseText);
                    if (arrayJson.TodoOK) {
                        var img = document.getElementById("imgFoto");
                        img.setAttribute("src", "BACKEND/fotos/" + codigo.value + ".jpg");
                        alert("Televisor: " + codigo.value + ", Fue agregado correctamente");
                    }
                    else {
                        alert("Error");
                    }
                }
            };
        };
        Manejadora.MostrarTelevisores = function () {
            var xhttp = new XMLHttpRequest();
            var formData = new FormData();
            formData.append("caso", "traer");
            xhttp.open("POST", "./BACKEND/administrar.php", true);
            xhttp.setRequestHeader("ENCTYPE", "multipart/form-data");
            xhttp.send(formData);
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    if (xhttp.responseText != "error") {
                        var obj = JSON.parse(xhttp.responseText);
                        var html = "<table><tr><th>Codigo</th><th>Marca</th><th>Precio</th>" +
                            "<th>Tipo</th><th>Pais</th><th>Foto</th></tr>";
                        obj.forEach(function (o) {
                            html += '<tr><td>' + o.codigo + '</td><td>' + o.marca + '</td><td>' + o.precio
                                + '</td><td>' + o.tipo + '</td>'
                                + '<td>' + o.paisOrigen + '</td>'
                                + '<td><img id="fotoTabla" src="./BACKEND/fotos/' + o.pathFoto + '" height="100px" width="100px" />'
                                + '<td><input type="button" value="Eliminar" class="btn btn-info" onclick="PrimerParcial.Manejadora.EliminarTelevisor(' + o.codigo + ')">'
                                + '<td><input type="button" value="Modificar" class="btn btn-info"  onclick="PrimerParcial.Manejadora.ModificarTelevisor(' + o.codigo + ')"> </tr>';
                        });
                        html += "</table>";
                        var tabla = document.getElementById("divTabla");
                        tabla.innerHTML = html;
                    }
                    else {
                    }
                }
                else {
                }
            };
        };
        Manejadora.GuardarEnLocalStorage = function () {
            var xhttp = new XMLHttpRequest();
            var formData = new FormData();
            formData.append("caso", "traer");
            xhttp.open("POST", "./BACKEND/administrar.php", true);
            xhttp.setRequestHeader("ENCTYPE", "multipart/form-data");
            xhttp.send(formData);
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    if (xhttp.responseText != "error") {
                        // let obj:any = JSON.stringify(xhttp.responseText);
                        localStorage.setItem("televisores_local_storage", xhttp.responseText);
                    }
                }
            };
        };
        Manejadora.VerificarExistencia = function () {
            var codigo = document.getElementById("codigo");
            var marca = document.getElementById("marca");
            var precio = document.getElementById("precio");
            var tipo = document.getElementById("tipo");
            var pais = document.getElementById("pais");
            var foto = document.getElementById("foto");
            var flag = false;
            var locals = localStorage.getItem("televisores_local_storage");
            //  console.log(locals);
            if (locals != null) {
                var obj = JSON.parse(locals);
                // console.log(typeof(obj));
                // console.log(obj);
                obj.forEach(function (o) {
                    if (o.codigo == codigo.value) {
                        console.log("El televisor ya existe");
                        alert("El televisor ya existe");
                        flag = true;
                    }
                });
            }
            if (!flag) {
                console.log("Televisor No encontrado");
                PrimerParcial.Manejadora.AgregarTelevisor();
                PrimerParcial.Manejadora.GuardarEnLocalStorage();
            }
        };
        Manejadora.EliminarTelevisor = function (codigo) {
            var xhttp = new XMLHttpRequest();
            var formData = new FormData();
            var c = "";
            var t = "";
            var tv;
            formData.append("caso", "traer");
            xhttp.open("POST", "./BACKEND/administrar.php", true);
            xhttp.setRequestHeader("ENCTYPE", "multipart/form-data");
            xhttp.send(formData);
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    if (xhttp.responseText != "error") {
                        var obj = JSON.parse(xhttp.responseText);
                        console.log(obj);
                        obj.forEach(function (o) {
                            if (o.codigo == codigo) {
                                tv = new Entidades.Televisor(o.codigo, o.marca, o.precio, o.tipo, o.paisOrigen, o.codigo + ".jpg");
                                c = o.codigo;
                                t = o.tipo;
                                var form = new FormData();
                                if (confirm('¿Estas seguro que desea eliminar el televisor ?' + c + '-' + t)) {
                                    form.append('caso', 'eliminar');
                                    form.append('cadenaJson', JSON.stringify(tv.ToJson()));
                                    xhttp.open("POST", "./BACKEND/administrar.php", true);
                                    xhttp.setRequestHeader("ENCTYPE", "multipart/form-data");
                                    xhttp.send(form);
                                    xhttp.onreadystatechange = function () {
                                        if (xhttp.readyState == 4 && xhttp.status == 200) {
                                            var arrayJson = JSON.parse(xhttp.responseText);
                                            if (arrayJson.TodoOK) {
                                                alert("Televisor: " + codigo + ", Fue eliminado correctamente");
                                                PrimerParcial.Manejadora.MostrarTelevisores();
                                            }
                                            else {
                                                alert("Error");
                                            }
                                        }
                                    };
                                }
                                else {
                                    return false;
                                }
                            }
                        });
                    }
                    else {
                    }
                }
            };
        };
        Manejadora.ModificarTelevisor = function (cod) {
            var codigo = document.getElementById("codigo");
            var marca = document.getElementById("marca");
            var precio = document.getElementById("precio");
            var tipo = document.getElementById("tipo");
            var pais = document.getElementById("pais");
            var foto = document.getElementById("foto");
            var boton = document.getElementById("btn-agregar");
            boton.value = "Modificar";
            boton.onclick = 'PrimerParcial.Manejadora.AgregarTelevisor(true)';
            codigo.readOnly = true;
            var xhttp = new XMLHttpRequest();
            var formData = new FormData();
            var c = "";
            var t = "";
            var tv;
            formData.append("caso", "traer");
            xhttp.open("POST", "./BACKEND/administrar.php", true);
            xhttp.setRequestHeader("ENCTYPE", "multipart/form-data");
            xhttp.send(formData);
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    if (xhttp.responseText != "error") {
                        var obj = JSON.parse(xhttp.responseText);
                        console.log(obj);
                        obj.forEach(function (o) {
                            if (o.codigo == cod) {
                                codigo.value = o.codigo;
                                marca.value = o.marca;
                                precio.value = o.precio;
                                tipo.value = o.tipo;
                                pais.value = o.paisOrigen;
                                var img = document.getElementById("imgFoto");
                                img.setAttribute("src", "BACKEND/fotos/" + codigo.value + ".jpg");
                            }
                        });
                    }
                }
            };
        };
        return Manejadora;
    }());
    PrimerParcial.Manejadora = Manejadora;
})(PrimerParcial || (PrimerParcial = {}));
