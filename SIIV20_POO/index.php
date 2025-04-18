<?php
class LoginController {
    private $sections;

    public function __construct() {
        session_start();
        $this->sections = array('aspirante', 'alumno', 'personal');
        $this->loadDependencies();
    }

    private function loadDependencies() {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
        require_once(CONFIG_PATH . 'bd.php');
        require_once(LOGIN_PATH. 'proceso_login_registro.php');
        require_once(TEMPLATES_PATH . 'header.php');
    }

    public function render() {
        $this->renderMainSection();
        $this->renderRegistrationModal();
        $this->includeResources();
        require_once(TEMPLATES_PATH . 'footer.php');
    }

    private function renderMainSection() {
        echo '<section class="accordion-demo">
            <div class="container mt-1">
                <br>
                <div class="text-center mb-4">
                    <a href="/pruebas/plantilla.php" class="btn btn-info">
                        <i class="bi bi-bug"></i> Ambiente de Pruebas
                    </a>
                </div>

                <h3 class="text-center">INICIO DE SESIÓN GENERAL</h3>

                <div class="tabs" role="tablist">
                    <dd data-target="#Aspirantes" role="tab">
                        <a href="#" style="color: black;">ASPIRANTES</a>
                    </dd>
                    <dd data-target="#Alumnos" role="tab">
                        <a href="#" style="color: black;">ALUMNOS</a>
                    </dd>
                    <dd data-target="#Personal" role="tab">
                        <a href="#" style="color: black;">PERSONAL</a>
                    </dd>
                </div>

                <div class="tabs-content mt-3">';
        
        $this->renderLoginSections();

        echo '</div></div></section>';
    }

    private function renderLoginSections() {
        foreach ($this->sections as $section) {
            require_once(CUSTOM_INDEX_LOGIN . "seccion_$section.php");
        }
    }

    private function renderRegistrationModal() {
        echo '<div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registroModalLabel">Registro de Aspirante</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="modal-body-content"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
                    </div>
                </div>
            </div>
        </div>';
    }

    private function includeResources() {
        echo '<style>';
        require_once(CUSTOM_INDEX_LOGIN . 'style.css');
        echo '</style>';
        echo '<script>';
        require_once(CUSTOM_INDEX_LOGIN . 'script.js');
        echo '</script>';
    }
}

$loginController = new LoginController();
$loginController->render();
?>