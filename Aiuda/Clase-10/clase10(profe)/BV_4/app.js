//AL TERMINAR DE CARGAR TODO EL DOM, SE ASIGNAN LOS MANEJADORES DE EVENTOS
$(document).ready(function() {

   inicializarBV();

   generarCaptcha();

});


function inicializarBV(){


    $('#loginForm').bootstrapValidator({

        message: 'El valor no es válido',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {

            usuario: {
                message: 'El usuario no es válido',
                validators: {
                    notEmpty: {
                        message: 'El campo Usuario es requerido!'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'El usuario debe ser de entre 6 y 20 caracteres'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'El usuario puede tener letras, números, puntos y guiones bajos.'
                    }
                }
            },
            pais: {
                validators: {
                    notEmpty: {
                        message: 'El campo Pais es requerido!'
                    }
                }
            },
            aceptoTerminos: {
                validators: {
                    notEmpty: {
                        message: 'No has aceptado los términos y condiciones!'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'El campo Password es requerido!'
                    },
                    identical: {
                        field: 'confirmPassword',
                        message: 'La contraseña y su confirmación no coinciden!'
                    }
                }
            },
            confirmPassword: {
                validators: {
                    notEmpty: {
                        message: 'El campo Repita password es requerido!'
                    },
                    identical: {
                        field: 'password',
                        message: 'La contraseña y su confirmación no coinciden!'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'El campo Email es requerido!'
                    },
                    emailAddress: {
                        message: 'El campo email no posee un formato válido!'
                    }
                }
            },
            website: {
                validators: {
                    uri: {
                        allowLocal: true,
                        message: 'El campo URL no posee un formato válido!'
                    }
                }
            },
            color: {
                validators: {
                    notEmpty: {
                        message: 'El campo Color es requerido!'
                    },
                    color: {
                        type: ['hex', 'rgb', 'keyword'],
                        message: 'Debe ser un formato %s de color válido!'
                    }
                }
            },
            colorAll: {
                validators: {
                    color: { 
                        message: 'Ingrese un color válido!'
                    }
                }
            },
            edad: {
                validators: {
                    lessThan: {
                        value: 100,
                        inclusive: true,
                        message: 'La edad debe ser menor a 100'
                    },
                    greaterThan: {
                        value: 10,
                        inclusive: false,
                        message: 'La edad debe ser mayor o igual a 10'
                    }
                }
            },
            foto: {
                validators: {
                    notEmpty: {
                        message: 'Seleccione una imagen'
                    },
                    file: {
                        extension: 'jpeg,jpg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 699392, //=> 1024 * 683 //2097152 => 2048 * 1024
                        message: 'El archivo seleccionado no es válido!'
                    },
                }
            },
            captcha: {
                validators: {
                    callback: {
                        message: 'Respuesta incorrecta!',
                        callback: function(valor) {
                            const items = $('#captcha_operacion').html().split(' ');
                            const sum = parseInt(items[0]) + parseInt(items[2]);
                            //console.log(sum);
                            return valor == sum;
                        }
                    }
                }
            },
            adivino: {
                validators: {
                    notEmpty: {
                        message: 'El campo Adivine el número es requerido!'
                    },
                    callback: {
                        message: 'Respuesta incorrecta!',
                        callback: function(valor) {

                            var retorno = false;
                            
                            $.ajax({
                                url: "../BACKEND/adivina_numero.php",
                                async: false,
                                dataType: "json",
                                type: 'POST',
                                data: {
                                    numero : valor
                                },
                                success: function (obj) {
                                                    
                                    retorno = obj.adivino;
                                    console.log(obj.adivino);
                                }

                                }).fail(function (jqXHR) {
                                    console.error(jqXHR.responseText);
                            });

                            return retorno;
                        }
                    }
                }
            },
            adivino2: {
                validators: {
                    notEmpty: {
                        message: 'El campo Adivine el número es requerido!'
                    },
                    // The validator will create an Ajax request
                        // sending { username: 'its value' } to the back-end
                    remote: {
                        data: {
                            type:"adivino2"
                        },
                        message: 'Respuesta incorrecta!',
                        method: 'POST',
                        url: '../BACKEND/adivina_numero2.php',
                    }
                }
            }                                                            
        }
    })
    //SI SUPERA TODAS LAS VALIDACIONES, SE PROVOCA EL SUBMIT DEL FORM
    .on('success.form.bv', function (e) {
        
        alert("Submit...");

    });
            
}

function generarCaptcha(){

    const numeroRandom = function(min, max) {
        return Math.floor(Math.random() * (max - min + 1) + min);
    };

    const random = [numeroRandom(1, 100), numeroRandom(50, 150)];
 
    var operacion = [random[0], '+', random[1], '='].join(' ');

    $("#captcha_operacion").html(operacion);
//    console.log(operacion);
}