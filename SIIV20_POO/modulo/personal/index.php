<?php
class PersonalController {
    private $defaultPage = 'PEB.php';
    private $userType = 'personal';
    private $pageMapping;

    public function __construct() {
        session_start();
        $this->initializePageMapping();
        $this->loadDependencies();
        $this->checkUserAuthentication();
    }

    private function initializePageMapping() {
        $this->pageMapping = array(
            'Inicio' => 'PEB.php',
            'Datos socioeconomicos' => 'ASSO.php',
            'Fichas de pagos' => 'ASFP.php',
            'logout' => 'logout.php',
            'Solicitud de examen' => array('ASSE.php', 'GVP.php')
        );
    }

    private function loadDependencies() {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
        require_once(TEMPLATES_PATH . 'header.php');
        require_once(MENU_PATH . 'menu_personal.php');
    }

    private function checkUserAuthentication() {
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== $this->userType) {
            require_once(MODALES_PERSONAL_PATH . 'modal_verificar_session.php');
            $this->showUnauthorizedModal();
            exit();
        }
    }

    private function showUnauthorizedModal() {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                var modal = new bootstrap.Modal(document.getElementById("unauthorizedModal"));
                modal.show();
                setTimeout(function() {
                    window.location.href = "/index.php";
                }, 3000);
            });
        </script>';
    }

    public function handleRequest() {
        $page = isset($_GET['page']) ? $_GET['page'] : '';
        if ($page !== '') {
            $this->loadRequestedPage($page);
        } else {
            include $this->defaultPage;
        }
        require_once(TEMPLATES_PATH . 'footer.php');
    }

    private function loadRequestedPage($page) {
        if (isset($this->pageMapping[$page])) {
            $pageFiles = $this->pageMapping[$page];
            if (is_array($pageFiles)) {
                foreach ($pageFiles as $file) {
                    include $file;
                }
            } else {
                include $pageFiles;
            }
        } else {
            $this->showPageNotFound();
        }
    }

    private function showPageNotFound() {
        // Usar output buffering para evitar problemas con headers
        ob_start();
        echo '<h1>Página no encontrada</h1>';
        echo '<p>Redirigiendo a la página principal...</p>';
        echo '<script>
            setTimeout(function() {
                window.location.href = "/index.php";
            }, 3000);
        </script>';
        ob_end_flush();
        exit();
    }
}

$controller = new PersonalController();
$controller->handleRequest();
?>