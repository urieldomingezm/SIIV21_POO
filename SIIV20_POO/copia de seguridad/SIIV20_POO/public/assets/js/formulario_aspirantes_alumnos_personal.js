document.addEventListener('DOMContentLoaded', function () {

    // ASPIRANTES NUEVO REGISTRO
    const validationAspirantes = new JustValidate('#formulario_aspirantes_registro');

    validationAspirantes
        .addField('#apellido_paterno', [
            { rule: 'required', errorMessage: 'El apellido paterno es obligatorio' },
            { rule: 'customRegexp', value: /^[A-Za-z\s]+$/, errorMessage: 'Solo se permiten letras' }
        ])
        .addField('#apellido_materno', [
            { rule: 'required', errorMessage: 'El apellido materno es obligatorio' },
            { rule: 'customRegexp', value: /^[A-Za-z\s]+$/, errorMessage: 'Solo se permiten letras' }
        ])
        .addField('#nombre', [
            { rule: 'required', errorMessage: 'El nombre es obligatorio' },
            { rule: 'customRegexp', value: /^[A-Za-z\s]+$/, errorMessage: 'Solo se permiten letras' }
        ])
        .addField('#fecha_nacimiento', [{ rule: 'required', errorMessage: 'La fecha de nacimiento es obligatoria' }])
        .addField('#sexo', [{ rule: 'required', errorMessage: 'Selecciona el sexo' }])
        .addField('#entidad', [{ rule: 'required', errorMessage: 'Selecciona la entidad federativa' }])
        .addField('#curp', [
            { rule: 'required', errorMessage: 'La CURP es obligatoria' },
            { rule: 'minLength', value: 18, errorMessage: 'La CURP debe tener 18 caracteres' },
            { rule: 'maxLength', value: 18, errorMessage: 'La CURP debe tener 18 caracteres' }
        ])
        .addField('#celular', [
            { rule: 'required', errorMessage: 'El número de celular es obligatorio' },
            { rule: 'number', errorMessage: 'El número de celular debe ser numérico' },
            { rule: 'minLength', value: 10, errorMessage: 'El número de celular debe tener 10 dígitos' },
            { rule: 'maxLength', value: 10, errorMessage: 'El número de celular debe tener 10 dígitos' }
        ])
        .addField('#email', [
            { rule: 'required', errorMessage: 'El correo electrónico es obligatorio' },
            { rule: 'email', errorMessage: 'El formato del correo electrónico no es válido' }
        ]).addField('#personal_captcha', [
            { rule: 'required', errorMessage: 'El correo electrónico es obligatorio' },
            { rule: 'email', errorMessage: 'El formato del correo electrónico no es válido' }
        ]);

    // ASPIRANTES INICIO
    const validationInicio = new JustValidate('#formulario_alumnos_session');

    validationInicio
        .addField('#aspirante_curp', [
            { rule: 'required', errorMessage: 'El CURP es obligatorio' },
            { rule: 'minLength', value: 18, errorMessage: 'El CURP debe tener 18 caracteres' },
            { rule: 'maxLength', value: 18, errorMessage: 'El CURP debe tener 18 caracteres' },
            { rule: 'customRegexp', value: /^[A-Z0-9]+$/i, errorMessage: 'El CURP debe contener solo letras y números' }
        ])
        .addField('#aspirante_password', [
            { rule: 'required', errorMessage: 'La contraseña es obligatoria' },
            { rule: 'minLength', value: 4, errorMessage: 'La contraseña debe tener 4 caracteres' },
            { rule: 'maxLength', value: 4, errorMessage: 'La contraseña debe tener 4 caracteres' },
            { rule: 'number', errorMessage: 'La contraseña debe ser numérica' }
        ]).addField('#aspirante_captcha', [
            { rule: 'required', errorMessage: 'El correo electrónico es obligatorio' },
            { rule: 'email', errorMessage: 'El formato del correo electrónico no es válido' }
        ]);

    // ALUMNOS
    const validationAlumno = new JustValidate('#formulario_alumno');

    validationAlumno
        .addField('#alumno_numero_control', [
            { rule: 'required', errorMessage: 'El número de control es obligatorio' },
            { rule: 'minLength', value: 9, errorMessage: 'El número de control debe tener 9 caracteres' },
            { rule: 'maxLength', value: 9, errorMessage: 'El número de control debe tener 9 caracteres' }
        ])
        .addField('#alumno_password', [
            { rule: 'required', errorMessage: 'La contraseña es obligatoria' },
            { rule: 'minLength', value: 4, errorMessage: 'La contraseña debe tener 4 caracteres' },
            { rule: 'maxLength', value: 4, errorMessage: 'La contraseña debe tener 4 caracteres' },
            { rule: 'number', errorMessage: 'La contraseña debe ser numérica' }
        ]).addField('#alumno_captcha', [
            { rule: 'required', errorMessage: 'El correo electrónico es obligatorio' },
            { rule: 'email', errorMessage: 'El formato del correo electrónico no es válido' }
        ]);

    // PERSONAL ACADEMICO
    const validationPersonal = new JustValidate('#formulario_personal');

    validationPersonal
        .addField('#personal_usuario', [
            { rule: 'required', errorMessage: 'El usuario es obligatorio' },
            { rule: 'minLength', value: 5, errorMessage: 'El usuario debe tener al menos 5 caracteres' },
            { rule: 'maxLength', value: 20, errorMessage: 'El usuario no debe exceder los 20 caracteres' }
        ])
        .addField('#personal_password', [
            { rule: 'required', errorMessage: 'La contraseña es obligatoria' },
            { rule: 'minLength', value: 8, errorMessage: 'La contraseña debe tener al menos 8 caracteres' },
            { rule: 'maxLength', value: 15, errorMessage: 'La contraseña no debe exceder los 15 caracteres' }
        ]).addField('#personal_captcha', [
            { rule: 'required', errorMessage: 'El correo electrónico es obligatorio' },
            { rule: 'email', errorMessage: 'El formato del correo electrónico no es válido' }
        ]);
});

