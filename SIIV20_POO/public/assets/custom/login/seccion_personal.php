<div class="content" id="Personal">
    <form id="formulario_personal" method="POST" class="rounded">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="hidden" name="form_type" value="personal_login">
        <br>
        <div class="row justify-content-center">
            <!-- Usuario -->
            <div class="col-lg-5 mb-4">
                <label for="personal_usuario" class="form-label">USUARIO</label>
                <input type="text" class="form-control form-control-lg"
                    id="personal_usuario" maxlength="20" name="personal_usuario">
                <div class="invalid-feedback" style="display: block;"></div>
            </div>

            <!-- Contraseña -->
            <div class="col-lg-3 mb-4">
                <label for="personal_password" class="form-label">CONTRASEÑA</label>
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 position-relative">
                        <input type="password" class="form-control form-control-lg passwordInput"
                            id="personal_password" name="personal_password">
                        <div class="invalid-feedback" style="display: block;"></div>
                    </div>
                    <button type="button" class="btn btn-secondary ms-2 togglePassword"
                        onclick="togglePasswordVisibility('personal_password', this)">
                        <i class="bi bi-eye-slash"></i>
                    </button>
                </div>
            </div>

            <!-- CAPTCHA -->
            <div class="col-lg-4 mb-3">
                <label for="personal_captcha" class="form-label">CAPTCHA</label>
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 position-relative">
                        <input type="text" class="form-control form-control-lg captchaInput"
                            id="personal_captcha" name="personal_captcha" maxlength="5">
                        <div class="invalid-feedback" style="display: block;"></div>
                    </div>
                    <canvas class="captchaCanvas" width="128" height="44" class="ms-2"></canvas>
                    <button type="button" class="btn btn-secondary me-1 ms-2"
                        onclick="generateCaptcha('formulario_personal')">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                </div>
            </div>
        </div>

        <br>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary btn-lg">Iniciar Sesión</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const validation = new JustValidate('#formulario_personal', {
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
        .addField('#personal_usuario', [
            {
                rule: 'required',
                errorMessage: 'El usuario es requerido'
            },
            {
                rule: 'minLength',
                value: 3,
                errorMessage: 'El usuario debe tener al menos 3 caracteres'
            },
            {
                rule: 'maxLength',
                value: 20,
                errorMessage: 'El usuario no debe exceder 20 caracteres'
            }
        ])
        .addField('#personal_password', [
            {
                rule: 'required',
                errorMessage: 'La contraseña es requerida'
            },
            {
                rule: 'minLength',
                value: 6,
                errorMessage: 'La contraseña debe tener al menos 6 caracteres'
            }
        ])
        .addField('#personal_captcha', [
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
            if (!verifyCaptcha('formulario_personal')) {
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
                    
                    generateCaptcha('formulario_personal');
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
</script>