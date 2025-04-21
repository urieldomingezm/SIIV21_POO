<div class="content" id="Alumnos">
  <form id="formulario_alumno" method="POST" class="rounded">
      <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
      <input type="hidden" name="form_type" value="alumno_login">
      <br>
      <div class="row justify-content-center">
          <!-- Número de Control -->
          <div class="col-lg-3 mb-4">
              <label for="alumno_numero_control" class="form-label">NUMERO DE CONTROL</label>
              <input type="text" class="form-control form-control-lg" id="alumno_numero_control" name="alumno_numero_control">
              <div class="invalid-feedback" style="display: block;"></div>
          </div>

          <!-- NIP -->
          <div class="col-lg-3 mb-4">
              <label for="alumno_password" class="form-label">NIP</label>
              <div class="d-flex align-items-center">
                  <div class="flex-grow-1 position-relative">
                      <input type="password" class="form-control form-control-lg passwordInput" 
                             id="alumno_password" name="alumno_password" maxlength="4">
                      <div class="invalid-feedback" style="display: block;"></div>
                  </div>
                  <button type="button" class="btn btn-secondary ms-2 togglePassword"
                          onclick="togglePasswordVisibility('alumno_password', this)">
                      <i class="bi bi-eye-slash"></i>
                  </button>
              </div>
          </div>

          <!-- CAPTCHA -->
          <div class="col-lg-4 mb-3">
              <label for="alumno_captcha" class="form-label">CAPTCHA</label>
              <div class="d-flex align-items-center">
                  <div class="flex-grow-1 position-relative">
                      <input type="text" class="form-control form-control-lg captchaInput" id="alumno_captcha" name="alumno_captcha" maxlength="5">
                      <div class="invalid-feedback" style="display: block;"></div>
                  </div>
                  <canvas class="captchaCanvas" width="128" height="44" class="ms-2"></canvas>
                  <button type="button" class="btn btn-secondary me-1 ms-2" onclick="generateCaptcha('formulario_alumno')">
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