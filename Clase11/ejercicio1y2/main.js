var Ajax;
(function (Ajax) {
    function Mostrar() {
        var xmlR = new XMLHttpRequest();
        var producto = [{ "codigo": 1000, "nombre": "x", "precio": 90 },
            { "codigo": 1100, "nombre": "x2", "precio": 90 },
            { "codigo": 1200, "nombre": "x3", "precio": 90 }];
        for (var i = 0; i < producto.length; i++) {
            xmlR.open("GET", "mostrar.php?producto=" + JSON.stringify(producto), true);
        }
        xmlR.send();
        xmlR.onreadystatechange = function () {
            if (xmlR.readyState == 4 && xmlR.status == 200) {
                console.log(xmlR.responseText);
                alert(xmlR.responseText);
            }
        };
    }
    Ajax.Mostrar = Mostrar;
})(Ajax || (Ajax = {}));
