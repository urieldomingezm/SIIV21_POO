<?php
// session_start();

// // Basic authentication check
// $currentPage = basename($_SERVER['PHP_SELF']);
// if (!in_array($currentPage, ['login.php']) && !isset($_SESSION['user_id'])) {
//     header('Location: /login.php');
//     exit;
// }

class Header {
    private $title;
    private $cdnResources;
    private $localResources;

    public function __construct($title) {
        $this->title = $title;
        $this->initializeResources();
    }

    private function initializeResources() {
        $this->cdnResources = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
                'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css',
                'https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js',
                'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js',
                'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js',
                'https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js'
            ]
        ];

        $this->localResources = [
            'css' => [
                '/SIIV20/private/assets/css/simple_datatables.css',
                '/SIIV20/private/assets/css/style.css'
            ],
            'js' => [
                '/SIIV20/private/assets/js/char.js',
                '/SIIV20/private/assets/js/simple_datatables.js',
                '/SIIV20/private/assets/js/datatable_registrar_actualizar_justvalidate_exportacion_archivos.js'
            ]
        ];
    }

    public function addLocalCss($path) {
        $this->localResources['css'][] = $path;
    }

    public function addLocalJs($path) {
        $this->localResources['js'][] = $path;
    }

    public function render() {
        echo '<!DOCTYPE html>';
        echo '<html lang="es">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<title>' . $this->title . '</title>';
        echo '<link rel="icon" href="/SIIV20/private/assets/img/TEC_VICTORIA.PNG">';

        // Render CDN resources
        foreach ($this->cdnResources['css'] as $css) {
            echo '<link id="' . basename($css) . '" href="' . $css . '" rel="stylesheet">';
        }
        foreach ($this->cdnResources['js'] as $js) {
            echo '<script id="' . basename($js) . '" src="' . $js . '"></script>';
        }

        // Render local resources
        foreach ($this->localResources['css'] as $css) {
            echo '<link href="' . $css . '" rel="stylesheet">';
        }
        foreach ($this->localResources['js'] as $js) {
            echo '<script src="' . $js . '"></script>';
        }

        // Add fallback script
        echo '<script>
            function checkAndLoadCDN(id, fallbackUrl) {
                var element = document.getElementById(id);
                if (!element || element.sheet === null) {
                    console.warn("CDN no disponible, cargando desde local:", fallbackUrl);
                    var newElement = id.includes(".js") ? 
                        document.createElement("script") : 
                        document.createElement("link");
                    
                    if (id.includes(".js")) {
                        newElement.src = fallbackUrl;
                        newElement.async = false;
                    } else {
                        newElement.rel = "stylesheet";
                        newElement.href = fallbackUrl;
                    }
                    document.head.appendChild(newElement);
                }
            }
            window.onload = function() {
                checkAndLoadCDN("bootstrap.min.css", "/SIIV20/private/assets/css/bootstrap.min.css");
                checkAndLoadCDN("bootstrap.bundle.min.js", "/SIIV20/private/assets/js/bootstrap.bundle.min.js");
            };
        </script>';

        echo '</head>';
        echo '<body class="d-flex flex-column min-vh-100 bg-light">';
    }
}

$header = new Header('SII :: Portal de alumnos');
$header->render();
?>

<!--LOGOTIPOS-->
<header style="background-color: rgba(var(--bs-light-rgb), var(--bs-bg-opacity));">
    <section id="topbar" class="dm-flex align-items-center">
        <div class="d-flex justify-content-center">
            <div class="social-links d-none d-md-block">
                <a class="text-white" href="https://www.gob.mx/" target="_blank" id="pleca_1">
                    <img
                        style="height: auto; min-width: 230px; max-width: 230px"
                        src="/public/assets/img/png/gobierno_mexico.png"
                        alt="Gobierno de México" />
                </a>
                <a class="text-white" href="https://www.gob.mx/sep" target="_blank" id="pleca_2">
                    <img
                        style="height: auto; min-width: 250px; max-width: 250px"
                        src="/public/assets/img/png/sep.png"
                        alt="Educación" />
                </a>
            </div>

            <div class="contact-info d-flex align-items-center">
                <a class="text-white" href="https://www.tecnm.mx/" id="pleca_3">
                    <img
                        style="height: auto; min-width: 120px; max-width: 120px"
                        src="/public/assets/img/png/tecnm.png"
                        alt="TecNM" />
                </a>
                <a
                    href="https://www.cdvictoria.tecnm.mx"
                    id="pleca_3"
                    class="text-white">
                    <img
                        style="height: auto; min-width: 80px; max-width: 80px"
                        src="/public/assets/img/png/tecnologico_cdvictoria.png"
                        alt="ITVictoria" />
                </a>
            </div>
        </div>
</header>


<?php require_once(MENU_PATH. 'menu_alumno.php'); ?>