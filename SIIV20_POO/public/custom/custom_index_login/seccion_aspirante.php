<div class="content" id="Aspirantes">
    <div class="accordion accordion-flush" id="accordionFlushExample">
        <!-- Acordeón 1: Registro por primera vez -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed" style="background-color:rgb(225, 231, 235); color: black;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    Registro por primera vez
                </button>
            </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <div id="container">
                        <form id="formulario_aspirantes_registro" class="rounded" method="POST">
                            <div class="row mb-3 justify-content-center">
                                <!-- Apellido Paterno -->
                                <div class="col-md-2 mb-3">
                                    <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
                                    <input type="text" class="form-control form-control-sm" id="apellido_paterno" name="apellido_paterno">
                                </div>

                                <!-- Apellido Materno -->
                                <div class="col-md-2 mb-3">
                                    <label for="apellido_materno" class="form-label">Apellido Materno</label>
                                    <input type="text" class="form-control form-control-sm" id="apellido_materno" name="apellido_materno">
                                </div>

                                <!-- Nombre del Aspirante -->
                                <div class="col-md-2 mb-3">
                                    <label for="nombre" class="form-label">Nombre(S)</label>
                                    <input type="text" class="form-control form-control-sm" id="nombre" name="nombre">
                                </div>

                                <!-- Fecha de Nacimiento -->
                                <div class="col-md-2 mb-3">
                                    <label for="fecha_nacimiento" class="form-label">Fecha Nacimiento</label>
                                    <input type="date" class="form-control form-control-sm" id="fecha_nacimiento" name="fecha_nacimiento" value="2003-01-01">
                                </div>

                                <!-- Sexo -->
                                <div class="col-md-2 mb-3">
                                    <label for="sexo" class="form-label">Sexo</label>
                                    <select class="form-select form-select-sm" id="sexo" name="sexo">
                                        <option value="" disabled selected>Selecciona</option>
                                        <option value="H">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                </div>

                                <!-- Entidad Federativa -->
                                <div class="col-md-2 mb-3">
                                    <label for="entidad" class="form-label">Estado</label>
                                    <select class="form-select form-select-sm" id="entidad" name="entidad">
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

                            <div class="row mb-3 justify-content-center">
                                <!-- CURP -->
                                <div class="col-lg-3 mb-3">
                                    <label for="curp" class="form-label">CURP</label>
                                    <input type="text" class="form-control form-control-sm" maxlength="18" id="curp" name="curp">
                                </div>

                                <!-- CELULAR -->
                                <div class="col-lg-2 mb-3">
                                    <label for="celular" class="form-label">Celular</label>
                                    <input type="text" class="form-control form-control-sm" id="celular" maxlength="10" name="celular">
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control form-control-sm" id="email" name="email">
                                </div>

                                <!-- CAPTCHA -->
                                <div class="col-lg-4 mb-3">
                                    <label for="aspirante_registro_captcha" class="form-label">Captcha</label>
                                    <div class="d-flex align-items-center">
                                        <input type="text" class="form-control form-control-sm" id="aspirante_registro_captcha" name="aspirante_registro_captcha" maxlength="5">
                                        <canvas class="captchaCanvas" width="128" height="40" class="ms-2"></canvas>
                                        <button type="button" class="btn btn-secondary me-1 ms-2" onclick="generateCaptcha('formulario_aspirantes_registro')">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="text-center">
                                <button type="button" id="vaciar_aspirantes_registrados" class="btn btn-secondary btn-dos">Vaciar</button>
                                <button type="submit" class="btn btn-primary btn-dos">Registrase</button>
                            </div>
                        </form>

                        <script>
                            // Initialize Just-Validate
                            const validation = new JustValidate('#formulario_aspirantes_registro', {
                                errorFieldCssClass: 'is-invalid',
                                successFieldCssClass: 'is-valid'
                            });

                            validation
                                .addField('#apellido_paterno', [{
                                        rule: 'required',
                                        errorMessage: 'El apellido paterno es requerido'
                                    },
                                    {
                                        rule: 'minLength',
                                        value: 2,
                                        errorMessage: 'Mínimo 2 caracteres'
                                    }
                                ])
                                .addField('#apellido_materno', [{
                                        rule: 'required',
                                        errorMessage: 'El apellido materno es requerido'
                                    },
                                    {
                                        rule: 'minLength',
                                        value: 2,
                                        errorMessage: 'Mínimo 2 caracteres'
                                    }
                                ])
                                .addField('#nombre', [{
                                        rule: 'required',
                                        errorMessage: 'El nombre es requerido'
                                    },
                                    {
                                        rule: 'minLength',
                                        value: 2,
                                        errorMessage: 'Mínimo 2 caracteres'
                                    }
                                ])
                                .addField('#fecha_nacimiento', [{
                                    rule: 'required',
                                    errorMessage: 'La fecha de nacimiento es requerida'
                                }])
                                .addField('#sexo', [{
                                    rule: 'required',
                                    errorMessage: 'Seleccione un sexo'
                                }])
                                .addField('#entidad', [{
                                    rule: 'required',
                                    errorMessage: 'Seleccione un estado'
                                }])
                                .addField('#curp', [{
                                        rule: 'required',
                                        errorMessage: 'El CURP es requerido'
                                    },
                                    {
                                        rule: 'customRegexp',
                                        value: /^[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[0-9A-Z][0-9]$/,
                                        errorMessage: 'CURP inválido'
                                    }
                                ])
                                .addField('#celular', [{
                                        rule: 'required',
                                        errorMessage: 'El celular es requerido'
                                    },
                                    {
                                        rule: 'number',
                                        errorMessage: 'Solo números'
                                    },
                                    {
                                        rule: 'minLength',
                                        value: 10,
                                        errorMessage: 'Debe tener 10 dígitos'
                                    }
                                ])
                                .addField('#email', [{
                                        rule: 'required',
                                        errorMessage: 'El email es requerido'
                                    },
                                    {
                                        rule: 'email',
                                        errorMessage: 'Email inválido'
                                    }
                                ])
                                .addField('#aspirante_registro_captcha', [{
                                        rule: 'required',
                                        errorMessage: 'El captcha es requerido'
                                    },
                                    {
                                        rule: 'minLength',
                                        value: 5,
                                        errorMessage: 'Debe tener 5 caracteres'
                                    }
                                ])
                                .onSuccess((event) => {
                                    // Handle form submission
                                    console.log('Form submitted successfully');
                                });
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <!-- Acordeón 2: Iniciar sesión -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingTwo">
                <button class="accordion-button collapsed" style="background-color:rgb(225, 231, 235); color: black;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                    Iniciar sesión
                </button>
            </h2>
            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <!-- Alert container for form messages -->
                    <div id="login-alerts" class="container mb-3">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div id="login-alert-success" class="alert alert-success d-none" role="alert"></div>
                                <div id="login-alert-error" class="alert alert-danger d-none" role="alert"></div>
                            </div>
                        </div>
                    </div>

                    <form id="formulario_alumnos_session" method="POST" class="rounded p-3">
                        <div class="container">
                            <div class="row justify-content-center">
                                <!-- CURP -->
                                <div class="col-12 col-md-6 col-lg-4 mb-3">
                                    <label for="aspirante_curp" class="form-label">CURP</label>
                                    <input type="text" class="form-control" id="aspirante_curp" maxlength="18" name="aspirante_curp">
                                </div>

                                <!-- Contraseña (NIP) -->
                                <div class="col-12 col-md-6 col-lg-3 mb-3">
                                    <label for="aspirante_password" class="form-label">NIP</label>
                                    <div class="input-group">
                                        <input
                                            type="password"
                                            class="form-control passwordInput"
                                            id="aspirante_password"
                                            name="aspirante_password"
                                            maxlength="4">
                                        <button
                                            type="button"
                                            class="btn btn-secondary togglePassword"
                                            onclick="togglePasswordVisibility('aspirante_password', this)">
                                            <i class="bi bi-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- CAPTCHA -->
                                <div class="col-12 col-lg-5 mb-3">
                                    <label for="aspirante_captcha" class="form-label">CAPTCHA</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control captchaInput" id="aspirante_captcha" name="aspirante_captcha" maxlength="5">
                                        <canvas class="captchaCanvas" width="128" height="40"></canvas>
                                        <button type="button" class="btn btn-secondary" onclick="generateCaptcha('formulario_alumnos_session')">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <script>
                        // Initialize Just-Validate
                        const loginValidation = new JustValidate('#formulario_alumnos_session', {
                            errorFieldCssClass: 'is-invalid',
                            successFieldCssClass: 'is-valid'
                        });

                        loginValidation
                            .addField('#aspirante_curp', [{
                                    rule: 'required',
                                    errorMessage: 'El CURP es requerido'
                                },
                                {
                                    rule: 'customRegexp',
                                    value: /^[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[0-9A-Z][0-9]$/,
                                    errorMessage: 'CURP inválido'
                                }
                            ])
                            .addField('#aspirante_password', [{
                                    rule: 'required',
                                    errorMessage: 'El NIP es requerido'
                                },
                                {
                                    rule: 'minLength',
                                    value: 4,
                                    errorMessage: 'El NIP debe tener 4 dígitos'
                                }
                            ])
                            .addField('#aspirante_captcha', [{
                                    rule: 'required',
                                    errorMessage: 'El captcha es requerido'
                                },
                                {
                                    rule: 'minLength',
                                    value: 5,
                                    errorMessage: 'Debe tener 5 caracteres'
                                }
                            ])
                            .onSuccess((event) => {
                                event.preventDefault();
                                const formData = new FormData(event.target);
                                
                                // Hide any existing alerts
                                document.getElementById('login-alert-success').classList.add('d-none');
                                document.getElementById('login-alert-error').classList.add('d-none');
                                
                                fetch('private/procesos/login_aspirantes.php', {
                                    method: 'POST',
                                    body: formData
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        const successAlert = document.getElementById('login-alert-success');
                                        successAlert.textContent = data.message;
                                        successAlert.classList.remove('d-none');
                                        // Redirect or perform additional actions on success
                                    } else {
                                        const errorAlert = document.getElementById('login-alert-error');
                                        errorAlert.textContent = data.message || 'Error en el inicio de sesión';
                                        errorAlert.classList.remove('d-none');
                                    }
                                })
                                .catch(error => {
                                    const errorAlert = document.getElementById('login-alert-error');
                                    errorAlert.textContent = 'Error en la conexión. Por favor, intente nuevamente.';
                                    errorAlert.classList.remove('d-none');
                                    console.error('Login error:', error);
                                });
                            });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>