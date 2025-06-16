<?php
class PersonalController {
    private $defaultPage = 'PLBN.php';
    private $userType = 'personal';
    private $pageMapping;
    private $breadcrumbMapping; // Nueva propiedad

    public function __construct() {
        session_start();
        $this->initializePageMapping();
        $this->initializeBreadcrumbMapping(); // Nueva inicialización
        $this->loadDependencies();
        $this->checkUserAuthentication();
    }

    private function initializePageMapping() {
        $this->pageMapping = array(
            'Inicio' => 'PLBN.php',
            'Gestion de alumnos' => 'PLGA.php',
            'Gestion de pagos' => 'PLGP.php',
            'logout' => 'logout.php',
        );
    }

    // Nueva función para mapear breadcrumbs
    private function initializeBreadcrumbMapping() {
        $this->breadcrumbMapping = array(
            'Inicio' => array(
                array('text' => 'Home', 'link' => '?page=Inicio', 'icon' => 'bi-house-door'),
                array('text' => 'Dashboard', 'link' => '#', 'active' => true)
            ),
            'Gestion de alumnos' => array(
                array('text' => 'Home', 'link' => '?page=Inicio', 'icon' => 'bi-house-door'),
                array('text' => 'Gestión Académica', 'link' => '#'),
                array('text' => 'Gestión de Alumnos', 'link' => '#', 'active' => true)
            ),
            'Gestion de pagos' => array(
                array('text' => 'Home', 'link' => '?page=Inicio', 'icon' => 'bi-house-door'),
                array('text' => 'Gestión Académica', 'link' => '#'),
                array('text' => 'Gestión de Pagos', 'link' => '#', 'active' => true)
            )
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

    // Nueva función para renderizar breadcrumb solo con Bootstrap
    private function renderBreadcrumb($page) {
        $breadcrumbs = isset($this->breadcrumbMapping[$page]) ? $this->breadcrumbMapping[$page] : $this->breadcrumbMapping['Inicio'];
        
        // Espaciado con br tags
        echo '<br><br><br>';
        
        // Breadcrumb usando solo clases de Bootstrap
        echo '<nav aria-label="breadcrumb" class="bg-light py-1 px-3 mb-1">';
        echo '<ol class="breadcrumb mb-0">';
        
        foreach ($breadcrumbs as $breadcrumb) {
            if (isset($breadcrumb['active']) && $breadcrumb['active']) {
                echo '<li class="breadcrumb-item active" aria-current="page">' . $breadcrumb['text'] . '</li>';
            } else {
                $icon = isset($breadcrumb['icon']) ? '<i class="' . $breadcrumb['icon'] . '"></i> ' : '';
                echo '<li class="breadcrumb-item"><a href="' . $breadcrumb['link'] . '" class="text-decoration-none">' . $icon . $breadcrumb['text'] . '</a></li>';
            }
        }
        
        echo '</ol>';
        echo '</nav>';
    }

    public function handleRequest() {
        $page = isset($_GET['page']) ? $_GET['page'] : 'Inicio';
        
        // Renderizar breadcrumb antes del contenido
        $this->renderBreadcrumb($page);
        
        if ($page !== '' && $page !== 'Inicio') {
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

$controller = new PersonalController();
$controller->handleRequest();
?>