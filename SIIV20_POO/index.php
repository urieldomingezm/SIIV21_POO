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
        echo '<section>
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-12 text-center mb-4">
                        <h2 class="text-uppercase fw-bold">INICIO DE SESIÓN GENERAL</h2>
                    </div>
                    <div class="col-lg-10">
                        <ul class="nav nav-pills nav-justified mb-4" id="loginTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active border-dark border-2 rounded-top px-4 py-3 shadow text-dark fw-bold" 
                                        id="aspirantes-tab" 
                                        data-bs-toggle="tab" 
                                        data-bs-target="#Aspirantes" 
                                        type="button" 
                                        role="tab" 
                                        aria-controls="Aspirantes" 
                                        aria-selected="true">
                                    <i class="bi bi-person-plus-fill me-2"></i>
                                    ASPIRANTES
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link border-dark border-2 rounded-top px-4 py-3 shadow text-dark fw-bold"
                                        id="alumnos-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#Alumnos"
                                        type="button"
                                        role="tab"
                                        aria-controls="Alumnos"
                                        aria-selected="false">
                                    <i class="bi bi-mortarboard-fill me-2"></i>
                                    ALUMNOS
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link border-dark border-2 rounded-top px-4 py-3 shadow text-dark fw-bold"
                                        id="personal-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#Personal"
                                        type="button"
                                        role="tab"
                                        aria-controls="Personal"
                                        aria-selected="false">
                                    <i class="bi bi-person-badge-fill me-2"></i>
                                    PERSONAL
                                </button>
                            </li>
                        </ul>

                        <div class="card shadow rounded">
                            <div class="card-body p-4">
                                <div class="tab-content" id="loginTabsContent">';

        $this->renderLoginSections();

        echo '                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>';
    }

    private function renderLoginSections() {
        $sectionIds = ['Aspirantes', 'Alumnos', 'Personal'];
        foreach ($this->sections as $index => $section) {
            $isActive = $index === 0 ? ' show active' : '';
            echo "<div class='tab-pane fade{$isActive}' id='{$sectionIds[$index]}' role='tabpanel' aria-labelledby='{$section}-tab'>";
            require_once(CUSTOM_INDEX_LOGIN . "seccion_$section.php");
            echo '</div>';
        }
    }

    private function renderRegistrationModal() {
        echo '<div class="modal fade" id="registroModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="registroModalLabel">Registro de Aspirante</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="modal-body-content" class="text-black"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
                    </div>
                </div>
            </div>
        </div>';
    }

    private function includeResources() {
        echo '<script>';
        require_once(CUSTOM_INDEX_LOGIN . 'script.js');
        echo '</script>';
    }
}

$loginController = new LoginController();
$loginController->render();
?>