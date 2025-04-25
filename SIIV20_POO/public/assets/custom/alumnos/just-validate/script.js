document.addEventListener('DOMContentLoaded', function() {
    const validation = new JustValidate('#formulario_alumno', {
        errorFieldCssClass: 'is-invalid',
        successFieldCssClass: 'is-valid',
        focusInvalidField: true,
        lockForm: true,
        tooltip: {
            position: 'top',
        },
    });

    // Verificar el token CSRF
    const csrfToken = document.querySelector('input[name="csrf_token"]').value;
    if (!csrfToken) {
        console.error('Token CSRF no encontrado');
        return;
    }

    validation
        .addField('#alumno_numero_control', [
            {
                rule: 'required',
                errorMessage: 'El número de control es requerido'
            },
            {
                rule: 'minLength',
                value: 8,
                errorMessage: 'El número de control debe tener 8 caracteres'
            },
            {
                rule: 'maxLength',
                value: 8,
                errorMessage: 'El número de control debe tener 8 caracteres'
            },
            {
                rule: 'number',
                errorMessage: 'El número de control debe contener solo números'
            }
        ])
        .addField('#alumno_password', [
            {
                rule: 'required',
                errorMessage: 'El NIP es requerido'
            },
            {
                rule: 'minLength',
                value: 4,
                errorMessage: 'El NIP debe tener 4 caracteres'
            },
            {
                rule: 'maxLength',
                value: 4,
                errorMessage: 'El NIP debe tener 4 caracteres'
            },
            {
                rule: 'number',
                errorMessage: 'El NIP debe contener solo números'
            }
        ])
        .addField('#alumno_captcha', [
            {
                rule: 'required',
                errorMessage: 'El CAPTCHA es requerido'
            },
            {
                rule: 'minLength',
                value: 5,
                errorMessage: 'El CAPTCHA debe tener 5 caracteres'
            },
            {
                rule: 'maxLength',
                value: 5,
                errorMessage: 'El CAPTCHA debe tener 5 caracteres'
            }
        ])
        .onSuccess((event) => {
            // Verificar el CSRF token antes del CAPTCHA
            const formCsrfToken = event.target.querySelector('input[name="csrf_token"]').value;
            if (!formCsrfToken) {
                console.error('Token CSRF no válido');
                return;
            }

            // Verificar el CAPTCHA
            if (!verifyCaptcha('formulario_alumno')) {
                event.preventDefault();
                return;
            }
            
            // Si todo está correcto, permitir el envío del formulario
            const formData = new FormData(event.target);
            
            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const modalTitle = document.getElementById('registroModalLabel');
                const modalBody = document.getElementById('modal-body-content');
                
                modalTitle.textContent = data.title;
                modalBody.innerHTML = data.message;
                
                if (data.status === 'success') {
                    modalBody.classList.add('text-success');
                    modalBody.classList.remove('text-danger');
                    
                    const modal = new bootstrap.Modal(document.getElementById('registroModal'));
                    modal.show();
                    
                    if (data.redirect) {
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 2000);
                    }
                } else {
                    modalBody.classList.add('text-danger');
                    modalBody.classList.remove('text-success');
                    const modal = new bootstrap.Modal(document.getElementById('registroModal'));
                    modal.show();
                    
                    generateCaptcha('formulario_alumno');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const modalBody = document.getElementById('modal-body-content');
                modalBody.innerHTML = 'Error en el sistema. Por favor, intente más tarde.';
                modalBody.classList.add('text-danger');
                const modal = new bootstrap.Modal(document.getElementById('registroModal'));
                modal.show();
            });
        });
});