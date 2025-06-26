<div class="alumno-login">
    <form id="formulario_alumno" method="POST" class="needs-validation" novalidate>
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="hidden" name="form_type" value="alumno_login">

        <div class="row g-3">
            <!-- Número de Control -->
            <div class="col-md-4">
                <label class="form-label" for="alumno_numero_control">Número de Control</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>
                    <input type="text"
                        class="form-control"
                        id="alumno_numero_control"
                        name="alumno_numero_control"
                        placeholder="Ingresa tu número de control">
                </div>
                <div class="error-container mt-1" id="error_alumno_numero_control"></div>
            </div>

            <!-- NIP -->
            <div class="col-md-4">
                <label class="form-label" for="alumno_password">NIP</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password"
                        class="form-control"
                        id="alumno_password"
                        name="alumno_password"
                        placeholder="Ingresa tu NIP"
                        maxlength="4">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('alumno_password', this)">
                        <i class="bi bi-eye-slash"></i>
                    </button>
                </div>
                <div class="error-container mt-1" id="error_alumno_password"></div>
            </div>

            <!-- Verification Code -->
            <div class="col-md-4">
                <label class="form-label" for="alumno_captcha">Verificación de Seguridad</label>
                <div class="row g-0">
                    <div class="col-6">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-shield-lock"></i>
                            </span>
                            <input type="text"
                                class="form-control"
                                id="alumno_captcha"
                                name="alumno_captcha"
                                placeholder="Código"
                                maxlength="5">
                        </div>
                    </div>
                    <div class="col-6 d-flex align-items-end">
                        <div class="input-group">
                            <canvas class="captcha-canvas border rounded-start" width="100" height="38"></canvas>
                            <button class="btn btn-outline-secondary rounded-end" type="button" onclick="generateCaptcha('formulario_alumno')">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="error-container mt-1" id="error_alumno_captcha"></div>
                    </div>
                </div>
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
        const validator = new JustValidate('#formulario_alumno', {
            errorFieldCssClass: 'is-invalid',
            successFieldCssClass: 'is-valid',
            focusInvalidField: true,
            lockForm: true,
            messages: {
                required: 'Campo requerido',
                minLength: 'Mínimo {value} caracteres',
                maxLength: 'Máximo {value} caracteres',
                number: 'Solo números'
            }
        });

        validator
            .addField('#alumno_numero_control', [{
                    rule: 'required',
                    errorMessage: 'Ingrese número de control'
                },
                {
                    rule: 'minLength',
                    value: 8,
                    errorMessage: 'Mínimo 8 caracteres'
                }
            ])
            .addField('#alumno_password', [{
                    rule: 'required',
                    errorMessage: 'Ingrese NIP'
                },
                {
                    rule: 'minLength',
                    value: 4,
                    errorMessage: 'Mínimo 4 dígitos'
                },
                {
                    rule: 'number',
                    errorMessage: 'Solo números'
                }
            ])
            .addField('#alumno_captcha', [{
                    rule: 'required',
                    errorMessage: 'Ingrese CAPTCHA'
                },
                {
                    rule: 'minLength',
                    value: 5,
                    errorMessage: 'Debe tener 5 caracteres'
                }
            ])
            .onSuccess((event) => {
                if (!verifyCaptcha('formulario_alumno')) {
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
</script>