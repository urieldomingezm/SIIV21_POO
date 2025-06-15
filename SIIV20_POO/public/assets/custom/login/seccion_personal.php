<div class="personal-login">
    <form id="formulario_personal" method="POST" class="needs-validation" novalidate>
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="hidden" name="form_type" value="personal_login">

        <div class="row g-3">
            <!-- Usuario -->
            <div class="col-md-6">
                <label class="form-label" for="personal_usuario">Usuario</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>
                    <input type="text"
                           class="form-control"
                           id="personal_usuario"
                           name="personal_usuario"
                           placeholder="Ingresa tu usuario"
                           maxlength="20">
                </div>
                <div class="error-container mt-1" id="error_personal_usuario"></div>
            </div>

            <!-- Contraseña -->
            <div class="col-md-6">
                <label class="form-label" for="personal_password">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password"
                           class="form-control"
                           id="personal_password"
                           name="personal_password"
                           placeholder="Ingresa tu contraseña">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('personal_password', this)">
                        <i class="bi bi-eye-slash"></i>
                    </button>
                </div>
                <div class="error-container mt-1" id="error_personal_password"></div>
            </div>

            <!-- Captcha -->
            <div class="col-12">
                <label class="form-label" for="personal_captcha">Verificación de Seguridad</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-shield-lock"></i>
                    </span>
                    <input type="text"
                           class="form-control"
                           id="personal_captcha"
                           name="personal_captcha"
                           placeholder="Ingresa el código que ves en la imagen"
                           maxlength="5">
                    <canvas class="captcha-canvas" width="150" height="40"></canvas>
                    <button class="btn btn-outline-secondary" type="button" onclick="generateCaptcha('formulario_personal')">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                </div>
                <div class="error-container mt-1" id="error_personal_captcha"></div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const validador = new JustValidate('#formulario_personal', {
            errorFieldCssClass: 'is-invalid',
            successFieldCssClass: 'is-valid',
            focusInvalidField: true,
            lockForm: true,
            messages: {
                required: 'Campo requerido',
                minLength: 'Mínimo {value} caracteres',
                maxLength: 'Máximo {value} caracteres'
            }
        });

        validador
            .addField('#personal_usuario', [
                { rule: 'required', errorMessage: 'Ingrese usuario' },
                { rule: 'minLength', value: 3, errorMessage: 'Mínimo 3 caracteres' },
                { rule: 'maxLength', value: 20, errorMessage: 'Máximo 20 caracteres' }
            ])
            .addField('#personal_password', [
                { rule: 'required', errorMessage: 'Ingrese contraseña' },
                { rule: 'minLength', value: 6, errorMessage: 'Mínimo 6 caracteres' }
            ])
            .addField('#personal_captcha', [
                { rule: 'required', errorMessage: 'Ingrese CAPTCHA' },
                { rule: 'minLength', value: 5, errorMessage: 'Debe tener 5 caracteres' }
            ])
            .onSuccess((evento) => {
                if (!verifyCaptcha('formulario_personal')) {
                    evento.preventDefault();
                    return;
                }

                const datos = new FormData(evento.target);

                fetch(window.location.href, {
                    method: 'POST',
                    body: datos
                })
                .then(respuesta => respuesta.json())
                .then(datos => {
                    const titulo = document.getElementById('registroModalLabel');
                    const cuerpo = document.getElementById('modal-body-content');

                    titulo.textContent = datos.title;
                    cuerpo.innerHTML = datos.message;
                    cuerpo.classList.toggle('text-success', datos.status === 'success');
                    cuerpo.classList.toggle('text-danger', datos.status !== 'success');

                    const modal = new bootstrap.Modal(document.getElementById('registroModal'));
                    modal.show();

                    if (datos.status === 'success' && datos.redirect) {
                        setTimeout(() => window.location.href = datos.redirect, 2000);
                    } else {
                        generateCaptcha('formulario_personal');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    const cuerpo = document.getElementById('modal-body-content');
                    cuerpo.innerHTML = 'Error del sistema';
                    cuerpo.classList.add('text-danger');
                    const modal = new bootstrap.Modal(document.getElementById('registroModal'));
                    modal.show();
                });
            });
    });
</script>