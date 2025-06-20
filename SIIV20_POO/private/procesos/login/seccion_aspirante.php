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
                        <form id="formulario_primera_vez_aspirantes_registro" class="rounded" method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="form_type" value="aspirante_registro">

                            <div class="row g-2">
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <label class="form-label">NOMBRE(S)</label>
                                    <input type="text" class="form-control" id="primera_vez_nombre" name="primera_vez_nombre">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <label class="form-label">APELLIDO PATERNO</label>
                                    <input type="text" class="form-control" id="primera_vez_apellido_paterno" name="primera_vez_apellido_paterno">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <label class="form-label">APELLIDO MATERNO</label>
                                    <input type="text" class="form-control" id="primera_vez_apellido_materno" name="primera_vez_apellido_materno">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <label class="form-label">FECHA NACIMIENTO</label>
                                    <input type="date" class="form-control" id="primera_vez_fecha_nacimiento" name="primera_vez_fecha_nacimiento" value="2003-01-01">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <label class="form-label">SEXO</label>
                                    <select class="form-select" id="primera_vez_sexo" name="primera_vez_sexo">
                                        <option value="" disabled selected>Selecciona</option>
                                        <option value="H">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <label class="form-label">ENTIDAD</label>
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

                            <!-- CURP, Celular y Email -->
                            <div class="row g-2 mt-2">
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <label class="form-label">CURP</label>
                                    <input type="text" class="form-control" id="primera_vez_curp" name="primera_vez_curp" maxlength="18">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <label class="form-label">CELULAR</label>
                                    <input type="text" class="form-control" id="primera_vez_celular" name="primera_vez_celular" maxlength="10">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <label class="form-label">EMAIL</label>
                                    <input type="email" class="form-control" id="primera_vez_email" name="primera_vez_email">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <label class="form-label">CAPTCHA</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control captchaInput" id="primera_vez_aspirante_registro_captcha" name="primera_vez_aspirante_registro_captcha" maxlength="5">
                                        <canvas class="captchaCanvas" width="128" height="44"></canvas>
                                        <button type="button" class="btn btn-secondary" onclick="generateCaptcha('formulario_primera_vez_aspirantes_registro')">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <button type="button" id="vaciar_aspirantes_registrados" class="btn btn-secondary">Vaciar</button>
                                <button type="submit" class="btn btn-primary">Registrarse</button>
                            </div>
                        </form>
                    </div>
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
                <div id="login-alerts" class="container mb-3">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div id="login-alert-success" class="alert alert-success d-none" role="alert"></div>
                            <div id="login-alert-error" class="alert alert-danger d-none" role="alert"></div>
                        </div>
                    </div>
                </div>

                <form id="formulario_iniciar_session_aspirante" method="POST" class="rounded">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="form_type" value="aspirante_login">
                    <br>
                    <div class="row justify-content-center">

                        <div class="col-lg-3 mb-4">
                            <label for="iniciar_session_aspirante_curp" class="form-label">CURP</label>
                            <input
                                type="text"
                                class="form-control form-control-lg"
                                id="iniciar_session_aspirante_curp"
                                name="iniciar_session_aspirante_curp"
                                maxlength="18">
                            <div class="invalid-feedback" style="display: block;"></div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            <label for="iniciar_session_aspirante_password" class="form-label">NIP</label>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 position-relative">
                                    <input
                                        type="password"
                                        class="form-control form-control-lg passwordInput"
                                        id="iniciar_session_aspirante_password"
                                        name="iniciar_session_aspirante_password"
                                        maxlength="4">
                                    <div class="invalid-feedback" style="display: block;"></div>
                                </div>
                                <button
                                    type="button"
                                    class="btn btn-secondary ms-2 togglePassword"
                                    onclick="togglePasswordVisibility('iniciar_session_aspirante_password', this)">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-lg-4 mb-3">
                            <label for="iniciar_session_aspirante_captcha" class="form-label">CAPTCHA</label>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 position-relative">
                                    <input
                                        type="text"
                                        class="form-control form-control-lg captchaInput"
                                        id="iniciar_session_aspirante_captcha"
                                        name="iniciar_session_aspirante_captcha"
                                        maxlength="5">
                                    <div class="invalid-feedback" style="display: block;"></div>
                                </div>
                                <canvas class="captchaCanvas" width="128" height="44" class="ms-2"></canvas>
                                <button
                                    type="button"
                                    class="btn btn-secondary me-1 ms-2"
                                    onclick="generateCaptcha('formulario_iniciar_session_aspirante')">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
</div>