<?php
class SessionManager {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function destroySession() {
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
        $this->redirect('/index.php');
        return true;
    }

    public function redirect($path = '/index.php') {
        header("Location: " . $path);
        exit();
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'logout') {
            $this->destroySession();
        }
    }
}

$sessionManager = new SessionManager();
$sessionManager->handleRequest();

class LogoutModal {
    public function render() {
        ?>
        <div class="modal fade" id="logoutModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="logoutModalLabel">Confirmar Cierre de Sesión</h5>
                    </div>
                    <div class="modal-body">
                        <div id="logoutMessage">
                            <p>¿Está seguro que desea cerrar la sesión?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='?page=Inicio'">Cancelar</button>
                        <button type="button" class="btn btn-danger" onclick="cerrarSesion()">Cerrar Sesión</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function cerrarSesion() {
                fetch(window.location.href, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=logout'
                })
                .then(response => {
                    if(response.redirected) {
                        window.location.href = response.url;
                    } else {
                        window.location.href = '/index.php';
                    }
                })
                .catch(error => console.error('Error:', error));
            }

            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('logoutModal'), {
                    backdrop: 'static',
                    keyboard: false
                });
                myModal.show();
            });
        </script>
        <?php
    }
}

$logoutModal = new LogoutModal();
$logoutModal->render();
?>