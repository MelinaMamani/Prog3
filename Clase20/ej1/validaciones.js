$(document).ready(function() {
    $('#id-form').bootstrapValidator({
        message: 'El valor no es válido.',
        feedbackIcons: {
            valid: 'fas fa-check',
            invalid: 'fas fa-times',
            validating: 'fas fa-spinner'
        },
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'El email es requerido y no puede estar vacío.'
                    },
                    emailAddress: {
                        message: 'Email inválido.'
                    }
                }
            },
            pwd: {
                message: 'Contraseña inválida.',
                validators: {
                    notEmpty: {
                        message: 'La contraseña es requerida y no puede estar vacía.'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'La contraseña debe tener 6 caracteres como mínimo y 30 como máximo.'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: 'La contraseña puede ser alfanumerica.'
                    }
                }
            }
        }
    });
});