<div class="content" id="Alumnos">
        <form id="formulario_alumno" action="private/procesos/login_alumnos_personal.php" method="POST" class="was-validated rounded">
          <br>
          <div class="row justify-content-center">

            <!-- Número de Control -->
            <div class="col-lg-3 mb-3">
              <label for="alumno_numero_control" class="form-label">NUMERO DE CONTROL</label>
              <input type="text" class="form-control form-control-lg" id="alumno_numero_control" name="usuario" required>
            </div>

            <!-- Contraseña (NIP) -->
            <div class="col-lg-3 mb-3">
              <label for="alumno_password" class="form-label">NIP</label>
              <div class="d-flex align-items-center">
                <input
                  type="password"
                  class="form-control form-control-lg passwordInput"
                  id="alumno_password"
                  name="password"
                  maxlength="4"
                  required>
                <button
                  type="button"
                  class="btn btn-secondary ms-2 togglePassword"
                  onclick="togglePasswordVisibility('alumno_password', this)">
                  <i class="bi bi-eye-slash"></i>
                </button>
              </div>
            </div>

            <!-- CAPTCHA -->
            <div class="col-lg-4 mb-3">
              <label for="alumno_captcha" class="form-label">CAPTCHA</label>
              <div class="d-flex align-items-center">
                <input type="text" class="form-control form-control-lg captchaInput" id="alumno_captcha" name="alumno_captcha" maxlength="5" required>
                <canvas class="captchaCanvas" width="128" height="40" class="ms-2"></canvas>
                <button type="button" class="btn btn-secondary me-1 ms-2" onclick="generateCaptcha('formulario_alumno')">
                  <i class="bi bi-arrow-clockwise"></i></button>
              </div>
            </div>
          </div>

          <br>
          <div class="d-flex justify-content-center">
            <br>
            <br>
            <button type="submit" class="btn btn-primary btn-lg">Iniciar Sesión</button>
          </div>
        </form>
      </div>