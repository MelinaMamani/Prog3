var Ajax;
(function (Ajax) {
    function DevolverRemeras() {
        var devolver = 1;
        var xmlR = new XMLHttpRequest();
        xmlR.open("GET", "administrarRemeras.php?devolver=" + devolver, true);
        xmlR.send();
        xmlR.onreadystatechange = function () {
            if (xmlR.readyState == 4 && xmlR.status == 200) {
                console.log(xmlR.responseText);
                //alert(xmlR.responseText);
                document.getElementById("div_tabla").innerHTML = xmlR.responseText;
            }
        };
    }
    Ajax.DevolverRemeras = DevolverRemeras;
})(Ajax || (Ajax = {}));
