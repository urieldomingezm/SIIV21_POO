<div class="content" id="Aspirantes">
    <div class="accordion accordion-flush" id="accordionFlushExample">
        <!-- Acordeón 1: Registro por primera vez -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed" style="background-color:rgb(58, 97, 74); color: white;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    Registro por primera vez
                </button>
            </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body bg-white">
                    <div id="container">
                        <form id="formulario_primera_vez_aspirantes_registro" class="rounded" method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="form_type" value="aspirante_registro">
                            <br>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="row g-2">
                                            <div class="col-md-4">
                                                <div class="mb-2">
                                                    <label for="primera_vez_apellido_paterno" class="form-label">APELLIDO PATERNO</label>
                                                    <input type="text" class="form-control" id="primera_vez_apellido_paterno" name="primera_vez_apellido_paterno">
                                                    <div class="invalid-feedback" style="display: block; font-size: 0.8rem;"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-2">
                                                    <label for="primera_vez_apellido_materno" class="form-label">APELLIDO MATERNO</label>
                                                    <input type="text" class="form-control" id="primera_vez_apellido_materno" name="primera_vez_apellido_materno">
                                                    <div class="invalid-feedback" style="display: block; font-size: 0.8rem;"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-2">
                                                    <label for="primera_vez_nombre" class="form-label">NOMBRE(S)</label>
                                                    <input type="text" class="form-control" id="primera_vez_nombre" name="primera_vez_nombre">
                                                    <div class="invalid-feedback" style="display: block; font-size: 0.8rem;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Información Adicional -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="row g-2">
                                            <div class="col-md-4">
                                                <div class="mb-2">
                                                    <label for="primera_vez_fecha_nacimiento" class="form-label">FECHA NACIMIENTO</label>
                                                    <input type="date" class="form-control" id="primera_vez_fecha_nacimiento" name="primera_vez_fecha_nacimiento" value="2003-01-01">
                                                    <div class="invalid-feedback" style="display: block; font-size: 0.8rem;"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-2">
                                                    <label for="primera_vez_sexo" class="form-label">SEXO</label>
                                                    <select class="form-select" id="primera_vez_sexo" name="primera_vez_sexo">
                                                        <option value="" disabled selected>Selecciona</option>
                                                        <option value="H">Masculino</option>
                                                        <option value="F">Femenino</option>
                                                    </select>
                                                    <div class="invalid-feedback" style="display: block; font-size: 0.8rem;"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-2">
                                                    <label for="primera_vez_entidad" class="form-label">ESTADO</label>
                                                    <select class="form-select" id="primera_vez_entidad" name="primera_vez_entidad">
                                                        <option value="TS">Tamaulipas</option>
                                                        <option value="AS">Aguascalientes</option>
                                                        <option value="BC">Baja California</option>
                                                        <option value="BS">Baja California Sur</option>
                                                        <option value="CC">Campeche</option>
                                                        <option value="CL">Coahuila</option>
                                                        <option value="CM">Colima</option>
                                                        <option value="CS">Chiapas</option>
                                                        <option value="CH">Chihuahua</option>
                                                        <option value="DF">Ciudad de México</option>
                                                        <option value="DG">Durango</option>
                                                        <option value="GT">Guanajuato</option>
                                                        <option value="GR">Guerrero</option>
                                                        <option value="HG">Hidalgo</option>
                                                        <option value="JC">Jalisco</option>
                                                        <option value="MC">Estado de México</option>
                                                        <option value="MN">Michoacán</option>
                                                        <option value="MS">Morelos</option>
                                                        <option value="NT">Nayarit</option>
                                                        <option value="NL">Nuevo León</option>
                                                        <option value="OC">Oaxaca</option>
                                                        <option value="PL">Puebla</option>
                                                        <option value="QT">Querétaro</option>
                                                        <option value="QR">Quintana Roo</option>
                                                        <option value="SP">San Luis Potosí</option>
                                                        <option value="SL">Sinaloa</option>
                                                        <option value="SR">Sonora</option>
                                                        <option value="TC">Tabasco</option>
                                                        <option value="TL">Tlaxcala</option>
                                                        <option value="VZ">Veracruz</option>
                                                        <option value="YN">Yucatán</option>
                                                        <option value="ZS">Zacatecas</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="row g-2">
                                    <!-- CURP -->
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="primera_vez_curp" class="form-label">CURP</label>
                                            <input type="text" class="form-control" id="primera_vez_curp" name="primera_vez_curp" maxlength="18">
                                            <div class="invalid-feedback" style="display: block; font-size: 0.8rem;"></div>
                                        </div>
                                    </div>

                                    <!-- Celular -->
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="primera_vez_celular" class="form-label">CELULAR</label>
                                            <input type="text" class="form-control" id="primera_vez_celular" name="primera_vez_celular" maxlength="10">
                                            <div class="invalid-feedback" style="display: block; font-size: 0.8rem;"></div>
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="primera_vez_email" class="form-label">EMAIL</label>
                                            <input type="email" class="form-control" id="primera_vez_email" name="primera_vez_email">
                                            <div class="invalid-feedback" style="display: block; font-size: 0.8rem;"></div>
                                        </div>
                                    </div>

                                    <!-- CAPTCHA -->
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="primera_vez_aspirante_registro_captcha" class="form-label">CAPTCHA</label>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 position-relative">
                                                    <input type="text" class="form-control captchaInput" id="primera_vez_aspirante_registro_captcha" name="primera_vez_aspirante_registro_captcha" maxlength="5">
                                                    <div class="invalid-feedback" style="display: block; font-size: 0.8rem;"></div>
                                                </div>
                                                <canvas class="captchaCanvas ms-2" width="128" height="44"></canvas>
                                                <button type="button" class="btn btn-secondary btn-sm me-1 ms-2" onclick="generateCaptcha('formulario_primera_vez_aspirantes_registro')">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center mt-3">
                                    <button type="button" id="vaciar_aspirantes_registrados" class="btn btn-secondary btn-sm me-2">Vaciar</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Registrarse</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <br>
            <!-- Acordeón 2: Iniciar sesión -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingTwo">
                    <button class="accordion-button collapsed" style="background-color:rgb(58, 97, 74); color: white;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        Iniciar sesión
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body" style="background-color: white;">
                        <!-- Alert container for form messages -->
                        <div id="login-alerts" class="container mb-3">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <div id="login-alert-success" class="alert alert-success d-none" role="alert"></div>
                                    <div id="login-alert-error" class="alert alert-danger d-none" role="alert"></div>
                                </div>
                            </div>
                        </div>

                        <div class="aspirante-login">
                            <form id="formulario_iniciar_session_aspirante" method="POST" class="needs-validation" novalidate>
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                <input type="hidden" name="form_type" value="aspirante_login">

                                <div class="row g-3">
                                    <!-- CURP -->
                                    <div class="col-12 col-md-4">
                                        <label for="iniciar_session_aspirante_curp" class="form-label">CURP</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-person"></i>
                                            </span>
                                            <input type="text"
                                                class="form-control"
                                                id="iniciar_session_aspirante_curp"
                                                name="iniciar_session_aspirante_curp"
                                                placeholder="Ingresa tu CURP"
                                                maxlength="18">
                                        </div>
                                        <div class="error-container mt-1" id="error_iniciar_session_aspirante_curp"></div>
                                    </div>

                                    <!-- Contraseña (NIP) -->
                                    <div class="col-12 col-md-4">
                                        <label for="iniciar_session_aspirante_password" class="form-label">NIP</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-lock"></i>
                                            </span>
                                            <input type="password"
                                                class="form-control"
                                                id="iniciar_session_aspirante_password"
                                                name="iniciar_session_aspirante_password"
                                                placeholder="Ingresa tu NIP"
                                                maxlength="4">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('iniciar_session_aspirante_password', this)">
                                                <i class="bi bi-eye-slash"></i>
                                            </button>
                                        </div>
                                        <div class="error-container mt-1" id="error_iniciar_session_aspirante_password"></div>
                                    </div>

                                    <!-- CAPTCHA -->
                                    <div class="col-12 col-md-4">
                                        <label for="iniciar_session_aspirante_captcha" class="form-label">Verificación de Seguridad</label>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="bi bi-shield-lock"></i>
                                                    </span>
                                                    <input type="text"
                                                        class="form-control"
                                                        id="iniciar_session_aspirante_captcha"
                                                        name="iniciar_session_aspirante_captcha"
                                                        placeholder="Código"
                                                        maxlength="5">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex align-items-center h-100">
                                                    <canvas class="captcha-canvas me-1" width="80" height="38"></canvas>
                                                    <button class="btn btn-outline-secondary h-100" type="button" onclick="generateCaptcha('formulario_iniciar_session_aspirante')">
                                                        <i class="bi bi-arrow-clockwise"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="error-container mt-1" id="error_iniciar_session_aspirante_captcha"></div>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validación para el formulario de registro
        const validatorRegistro = new JustValidate('#formulario_primera_vez_aspirantes_registro', {
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

        validatorRegistro
            .addField('#primera_vez_apellido_paterno', [{
                rule: 'required',
                errorMessage: 'Ingrese apellido paterno'
            }])
            .addField('#primera_vez_apellido_materno', [{
                rule: 'required',
                errorMessage: 'Ingrese apellido materno'
            }])
            .addField('#primera_vez_nombre', [{
                rule: 'required',
                errorMessage: 'Ingrese nombre(s)'
            }])
            .addField('#primera_vez_curp', [{
                    rule: 'required',
                    errorMessage: 'Ingrese CURP'
                },
                {
                    rule: 'minLength',
                    value: 18,
                    errorMessage: 'Debe tener 18 caracteres'
                }
            ])
            .addField('#primera_vez_celular', [{
                    rule: 'required',
                    errorMessage: 'Ingrese número celular'
                },
                {
                    rule: 'minLength',
                    value: 10,
                    errorMessage: 'Debe tener 10 dígitos'
                },
                {
                    rule: 'number',
                    errorMessage: 'Solo números'
                }
            ])
            .addField('#primera_vez_email', [{
                    rule: 'required',
                    errorMessage: 'Ingrese correo electrónico'
                },
                {
                    rule: 'email',
                    errorMessage: 'Ingrese un correo válido'
                }
            ])
            .addField('#primera_vez_aspirante_registro_captcha', [{
                    rule: 'required',
                    errorMessage: 'Ingrese CAPTCHA'
                },
                {
                    rule: 'minLength',
                    value: 5,
                    errorMessage: 'Debe tener 5 caracteres'
                }
            ]);

        // Validación para el formulario de inicio de sesión
        const validatorLogin = new JustValidate('#formulario_iniciar_session_aspirante', {
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

        validatorLogin
            .addField('#iniciar_session_aspirante_curp', [{
                    rule: 'required',
                    errorMessage: 'Ingrese CURP'
                },
                {
                    rule: 'minLength',
                    value: 18,
                    errorMessage: 'Debe tener 18 caracteres'
                }
            ])
            .addField('#iniciar_session_aspirante_password', [{
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
            .addField('#iniciar_session_aspirante_captcha', [{
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
                if (!verifyCaptcha('formulario_iniciar_session_aspirante')) {
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
                            generateCaptcha('formulario_iniciar_session_aspirante');
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