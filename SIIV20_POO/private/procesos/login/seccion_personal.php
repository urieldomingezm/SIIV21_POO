<div class="content" id="Personal">
    <form id="formulario_personal" method="POST" class="rounded">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="hidden" name="form_type" value="personal_login">
        <br>
        <div class="row justify-content-center">
            <div class="col-lg-5 mb-4">
                <label for="personal_usuario" class="form-label">USUARIO</label>
                <input type="text" class="form-control form-control-lg"
                    id="personal_usuario" maxlength="20" name="personal_usuario">
                <div class="invalid-feedback" style="display: block;"></div>
            </div>

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