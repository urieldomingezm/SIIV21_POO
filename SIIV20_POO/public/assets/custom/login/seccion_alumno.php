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

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Configuración común
    const validation = new JustValidate('#formulario_alumno', {
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
        .addField('#alumno_numero_control', [
            requiredRule,
            { rule: 'minLength', value: 8, errorMessage: '8 caracteres' }
        ])
        .addField('#alumno_password', [
            requiredRule,
            { rule: 'minLength', value: 4, errorMessage: '4 dígitos' },
            { rule: 'number', errorMessage: 'Solo números' }
        ])
        .addField('#alumno_captcha', [
            requiredRule,
            { rule: 'minLength', value: 5, errorMessage: '5 caracteres' }
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