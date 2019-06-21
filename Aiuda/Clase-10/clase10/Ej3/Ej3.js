$(document).ready(function () {
    
    $("#id_form").bootstrapValidator({

        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nombre: {
                validators: {
                    notEmpty: {
                        message: 'Ingrese el nombre!!!'
                    }
                }
            },
            clave: {
                validators: {
                    notEmpty: {
                        message: 'La clave es requerida!!!'
                    },
                    stringLength: {
                        min: 4,
                        max: 20,
                        message: 'Por favor, ingrese entre 4 y 20 caracteres!!!'
                    }
                }
            }
        }
    })
    //SI SUPERA TODAS LAS VALIDACIONES, SE PROVOCA EL SUBMIT DEL FORM
    .on('success.form.bv', function (e) {

        // Prevent form submission (evita que se envie el form por default)
    alert("Submit..");

        
        
    });
});

//FUNCIONES

function Login()
{
    var nombre = $("#nombre").val();
    var clave = $("#clave").val();

    alert("Nombre:  "+nombre+"\nClave:  "+clave);
}