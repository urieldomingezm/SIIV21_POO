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
                  <form id="formulario_aspirantes_registro" class="was-validated rounded" method="POST">

                    <div class="row mb-3 justify-content-center">
                      <!-- Apellido Paterno -->
                      <div class="col-md-2 mb-3">
                        <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
                        <input type="text" class="form-control form-control-sm" id="apellido_paterno" name="apellido_paterno" required>
                      </div>

                      <!-- Apellido Materno -->
                      <div class="col-md-2 mb-3 ">
                        <label for="apellido_materno" class="form-label">Apellido Materno</label>
                        <input type="text" class="form-control form-control-sm" id="apellido_materno" name="apellido_materno" required>
                      </div>

                      <!-- Nombre del Aspirante -->
                      <div class="col-md-2 mb-3">
                        <label for="nombre" class="form-label">Nombre(S)</label>
                        <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" required>
                      </div>

                      <!-- Fecha de Nacimiento -->
                      <div class="col-md-2 mb-3">
                        <label for="fecha_nacimiento" class="form-label">Fecha Nacimiento</label>
                        <input type="date" class="form-control form-control-sm" id="fecha_nacimiento" name="fecha_nacimiento" value="2003-01-01">
                      </div>

                      <!-- Sexo -->
                      <div class="col-md-2 mb-3">
                        <label for="sexo" class="form-label">Sexo</label>
                        <select class="form-select form-select-sm" id="sexo" name="sexo" required>
                          <option value="" disabled selected>Selecciona</option>
                          <option value="H">Masculino</option>
                          <option value="F">Femenino</option>
                        </select>
                      </div>


                      <!-- Entidad Federativa -->
                      <div class="col-md-2 mb-3">
                        <label for="entidad" class="form-label">Estado</label>
                        <select class="form-select form-select-sm" id="entidad" name="entidad" required>
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
                        <input type="text" class="form-control form-control-sm" maxlength="18" id="curp" name="curp" required>
                      </div>

                      <!-- CELULAR -->
                      <div class="col-lg-2 mb-3">
                        <label for="celular" class="form-label">Celular</label>
                        <input type="text" class="form-control form-control-sm" id="celular" maxlength="10" name="celular" required>
                      </div>

                      <div class="col-md-2 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control form-control-sm" id="email" name="email" required>
                      </div>

                      <!-- CAPTCHA -->
                      <div class="col-lg-4 mb-3">
                        <label for="aspirante_registro_captcha" class="form-label">Captcha</label>
                        <div class="d-flex align-items-center">
                          <input type="text" class="form-control form-control-sm" id="aspirante_registro_captcha" name="aspirante_registro_captcha" maxlength="5" required>
                          <canvas class="captchaCanvas" width="128" height="40" class="ms-2"></canvas>
                          <button type="button" class="btn btn-secondary me-1 ms-2" onclick="generateCaptcha('formulario_aspirantes_registro')">
                            <i class="bi bi-arrow-clockwise"></i></button>
                        </div>
                      </div>
                    </div>

                    <!-- Botones -->
                    <div class="text-center">
                      <button type="button" id="vaciar_aspirantes_registrados" class="btn btn-secondary btn-dos btn-lg">VACIAR</button>
                      <button type="submit" class="btn btn-primary btn-dos btn-lg">GUARDAR</button>
                    </div>
                  </form>
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
                <form id="formulario_alumnos_session" action="private/procesos/login_aspirantes.php" method="POST" class="was-validated rounded">

                  <div class="row justify-content-center">

                    <!-- CURP -->
                    <div class="col-lg-4 mb-3">
                      <label for="aspirante_curp" class="form-label">CURP</label>
                      <input type="text" class="form-control form-control-lg" id="aspirante_curp" maxlength="18" name="aspirante_curp" required>
                    </div>

                    <!-- Contraseña (NIP) -->
                    <div class="col-lg-3 mb-3">
                      <label for="aspirante_password" class="form-label">NIP</label>
                      <div class="d-flex align-items-center">
                        <input
                          type="password"
                          class="form-control form-control-lg passwordInput"
                          id="aspirante_password"
                          name="aspirante_password"
                          maxlength="4"
                          required>
                        <button
                          type="button"
                          class="btn btn-secondary ms-2 togglePassword"
                          onclick="togglePasswordVisibility('aspirante_password', this)">
                          <i class="bi bi-eye-slash"></i>
                        </button>
                      </div>
                    </div>

                    <!-- CAPTCHA -->
                    <div class="col-lg-5 mb-3">
                      <label for="aspirante_captcha" class="form-label">CAPTCHA</label>
                      <div class="d-flex align-items-center">
                        <input type="text" class="form-control form-control-lg captchaInput" id="aspirante_captcha" name="aspirante_captcha" maxlength="5" required>
                        <canvas class="captchaCanvas ms-2" width="128" height="40"></canvas>
                        <button type="button" class="btn btn-secondary me-1 ms-2" onclick="generateCaptcha('formulario_alumnos_session')">
                          <i class="bi bi-arrow-clockwise"></i></button>
                      </div>
                    </div>

                  </div>

                  <br>
                  <div class="d-flex justify-content-center">
                    <br>
                    <button type="submit" class="btn btn-primary btn-lg">Iniciar Sesión</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>