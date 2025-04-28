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
    // Configuración común
    const validation = new JustValidate('#formulario_personal', {
        errorFieldCssClass: 'is-invalid',
        successFieldCssClass: 'is-valid',
        focusInvalidField: true,
        lockForm: true,
        tooltip: {
            position: 'top',
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