<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(TEMPLATES_PATH . 'header.php');
require_once(LOGIN_PATH . 'login_personal.php');

// Verificar si ya hay una sesión activa
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'personal') {
    header('Location: /modulo/personal/');
    exit;
}

$header = new Header("Login - SIIV");
$header->render();
?>

<main class="mt-2 mb-5">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-75">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0">Iniciar Sesión</h4>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="form_type" value="personal_login">
                            
                            <div class="mb-4">
                                <label for="usuario" class="form-label">Usuario</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-person-fill text-primary"></i>
                                    </span>
                                    <input type="text"
                                        class="form-control"
                                        id="usuario"
                                        name="personal_usuario"
                                        placeholder="Ingrese su usuario"
                                        required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-lock-fill text-primary"></i>
                                    </span>
                                    <input type="password"
                                        class="form-control"
                                        id="password"
                                        name="personal_password"
                                        placeholder="Ingrese su contraseña"
                                        required>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Ingresar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
require_once(TEMPLATES_PATH . 'footer.php');
?>