<?php
class AspiranteController {
    private $defaultPage = 'ASPB.php';
    private $userType = 'aspirante';
    private $pageMapping;

    public function __construct() {
        session_start();
        $this->initializePageMapping();
        $this->loadDependencies();
        $this->checkUserAuthentication();
    }

    private function initializePageMapping() {
        $this->pageMapping = array(
            'Inicio' => 'ASPB.php',
            'Datos socioeconomicos' => 'ASSO.php',
            'Fichas de pagos' => 'ASFP.php',
            'Solicitud de examen' => array('ASSE.php', 'GVP.php'),
            'logout' => 'logout.php',
        );
    }

    private function loadDependencies() {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
        require_once(TEMPLATES_PATH . 'header.php');
        require_once(MENU_PATH . 'menu_aspirante.php');
    }

    private function checkUserAuthentication() {
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== $this->userType) {
            require_once(MODALES_ASPIRANTES_PATH . 'modal_verificar_session.php');
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
        echo '<h1>Página no encontrada</h1>';
        echo '<p>Redirigiendo a la página principal...</p>';
        header('refresh:3;url=index.php');
        exit();
    }
}

$controller = new AspiranteController();
$controller->handleRequest();
?>
            
           