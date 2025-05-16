<div class="content" id="Personal">
    <div class="card mb-3">

        <div class="card-body">
            <form id="formulario_personal" method="POST" class="rounded">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" name="form_type" value="personal_login">
                
                <div class="row g-2">
                    <!-- Usuario -->
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label for="personal_usuario" class="form-label">USUARIO</label>
                            <input type="text" class="form-control form-control-sm" id="personal_usuario" maxlength="20" name="personal_usuario">
                            <div class="invalid-feedback" style="display: block; font-size: 0.8rem;"></div>
                        </div>
                    </div>

                    <!-- Contraseña -->
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label for="personal_password" class="form-label">CONTRASEÑA</label>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 position-relative">
                                    <input type="password" class="form-control form-control-sm passwordInput" id="personal_password" name="personal_password">
                                    <div class="invalid-feedback" style="display: block; font-size: 0.8rem;"></div>
                                </div>
                                <button type="button" class="btn btn-secondary btn-sm ms-2 togglePassword" onclick="togglePasswordVisibility('personal_password', this)">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- CAPTCHA -->
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label for="personal_captcha" class="form-label">CAPTCHA</label>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 position-relative">
                                    <input type="text" class="form-control form-control-sm captchaInput" id="personal_captcha" name="personal_captcha" maxlength="5">
                                    <div class="invalid-feedback" style="display: block; font-size: 0.8rem;"></div>
                                </div>
                                <canvas class="captchaCanvas" width="128" height="44" class="ms-2"></canvas>
                                <button type="button" class="btn btn-secondary btn-sm me-1 ms-2" onclick="generateCaptcha('formulario_personal')">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    <button type="submit" class="btn btn-primary btn-sm">Iniciar Sesión</button>
                </div>
            </form>
        </div>
    </div>
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