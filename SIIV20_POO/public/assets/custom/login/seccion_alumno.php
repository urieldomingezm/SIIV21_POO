<div class="content" id="Alumnos">
    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Alumno</h5>
        </div>
        <div class="card-body">
            <form id="formulario_alumno" method="POST" class="rounded">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" name="form_type" value="alumno_login">

                <div class="row g-2">
                    <!-- Número de Control -->
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label for="alumno_numero_control" class="form-label">NUMERO DE CONTROL</label>
                            <input type="text" class="form-control form-control-sm" id="alumno_numero_control" name="alumno_numero_control">
                            <div class="invalid-feedback" style="display: block; font-size: 0.8rem;"></div>
                        </div>
                    </div>

                    <!-- NIP -->
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label for="alumno_password" class="form-label">NIP</label>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 position-relative">
                                    <input type="password" class="form-control form-control-sm passwordInput" id="alumno_password" name="alumno_password" maxlength="4">
                                    <div class="invalid-feedback" style="display: block; font-size: 0.8rem;"></div>
                                </div>
                                <button type="button" class="btn btn-secondary btn-sm ms-2 togglePassword" onclick="togglePasswordVisibility('alumno_password', this)">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- CAPTCHA -->
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label for="alumno_captcha" class="form-label">CAPTCHA</label>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 position-relative">
                                    <input type="text" class="form-control form-control-sm captchaInput" id="alumno_captcha" name="alumno_captcha" maxlength="5">
                                    <div class="invalid-feedback" style="display: block; font-size: 0.8rem;"></div>
                                </div>
                                <canvas class="captchaCanvas" width="128" height="44" class="ms-2"></canvas>
                                <button type="button" class="btn btn-secondary btn-sm me-1 ms-2" onclick="generateCaptcha('formulario_alumno')">
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