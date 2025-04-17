// REGISTROS CON JUST-VALIDATE

document.addEventListener('DOMContentLoaded', function () {
    const validation = new JustValidate('#formulario_registros_datatable');

    validation
        .addField('#numero_control', [
            {
                rule: 'required',
                errorMessage: 'Este campo es obligatorio',
            },
            {
                rule: 'maxLength',
                value: 10,
                errorMessage: 'Máximo 10 caracteres',
            },
        ])
        .addField('#promedio', [
            {
                rule: 'required',
                errorMessage: 'Este campo es obligatorio',
            },
            {
                rule: 'number',
                errorMessage: 'Debe ser un número',
            },
        ])
        .addField('#nombre', [
            {
                rule: 'required',
                errorMessage: 'Este campo es obligatorio',
            },
            {
                rule: 'maxLength',
                value: 50,
                errorMessage: 'Máximo 50 caracteres',
            },
            {
                rule: 'customRegexp',
                value: /^[A-Za-z\s]+$/,
                errorMessage: 'Solo se permiten letras',
            },
        ])
        .addField('#apellidos', [
            {
                rule: 'required',
                errorMessage: 'Este campo es obligatorio',
            },
            {
                rule: 'maxLength',
                value: 50,
                errorMessage: 'Máximo 50 caracteres',
            },
            {
                rule: 'customRegexp',
                value: /^[A-Za-z\s]+$/,
                errorMessage: 'Solo se permiten letras',
            },
        ])
        .addField('#observaciones', [
            {
                rule: 'required',
                errorMessage: 'Seleccione una observación',
            },
        ])
        .addField('#carrera', [
            {
                rule: 'required',
                errorMessage: 'Seleccione una carrera',
            },
        ])
        .onSuccess((event) => {

            const formData = new FormData(event.target);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    location.reload();
                } else {
                    alert('Error en la conexión: ' + xhr.statusText);
                }
            };
            xhr.send(formData);
        });
});


// ACTUALIZAR, ELIMINAR, EXPORTACION PDF Y EXCEL

