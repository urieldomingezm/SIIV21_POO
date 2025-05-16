<div class="content" id="Personal">
    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Iniciar Sesión Personal</h5>
        </div>
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
    // Configuración común
    const validation = new JustValidate('#formulario_personal', {
        errorFieldCssClass: 'is-invalid',
        successFieldCssClass: 'is-valid',
        focusInvalidField: true,
        lockForm: true,
        tooltip: {
            position: 'bottom', // Cambiado de 'top' a 'bottom'
            showOnFocus: true,
            hideOnBlur: true,
            style: {
                fontSize: window.innerWidth < 768 ? '12px' : '14px',
                padding: window.innerWidth < 768 ? '5px 10px' : '8px 16px'
            }
        }
    });

    // Reglas comunes
    const requiredRule = { rule: 'required', errorMessage: 'Campo requerido' };

    // Validaciones de campos
    validation
        .addField('#personal_usuario', [
            requiredRule,
            { rule: 'minLength', value: 3, errorMessage: 'Mínimo 3 caracteres' },
            { rule: 'maxLength', value: 20, errorMessage: 'Máximo 20 caracteres' }
        ])
        .addField('#personal_password', [
            requiredRule,
            { rule: 'minLength', value: 6, errorMessage: 'Mínimo 6 caracteres' }
        ])
        .addField('#personal_captcha', [
            requiredRule,
            { rule: 'minLength', value: 5, errorMessage: '5 caracteres' }
        ])
        .onSuccess((event) => {
            if (!verifyCaptcha('formulario_personal')) {
                event.preventDefault();
                return;
            }
            
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
                modalBody.classList.toggle('text-success', data.status === 'success');
                modalBody.classList.toggle('text-danger', data.status !== 'success');
                
                const modal = new bootstrap.Modal(document.getElementById('registroModal'));
                modal.show();
                
                if (data.status === 'success' && data.redirect) {
                    setTimeout(() => window.location.href = data.redirect, 2000);
                } else {
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