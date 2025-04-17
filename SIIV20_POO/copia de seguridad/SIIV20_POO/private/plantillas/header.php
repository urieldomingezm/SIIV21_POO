<?php
class Header
{
    private $title;
    private $cdnResources;
    private $localResources;
    private $useLocalResources;

    public function __construct($title)
    {
        $this->title = $title;
        $this->initializeResources();
        $this->checkInternetConnection();
    }

    private function checkInternetConnection()
    {
        $connected = @fsockopen("www.google.com", 80);
        if ($connected) {
            fclose($connected);
            $this->useLocalResources = false;
        } else {
            $this->useLocalResources = true;
        }
    }

    private function initializeResources()
    {
        // CDN resources
        $this->cdnResources = [
            'css' => [
                'bootstrap' => [
                    'cdn' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
                    'local' => '/public/assets/css/bootstrap.min.css'
                ],
                'bootstrap-icons' => [
                    'cdn' => 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css',
                    'local' => '/public/assets/css/bootstrap-icons.css'
                ],
                'boxicons' => [
                    'cdn' => 'https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css',
                    'local' => '/public/assets/css/boxicons.min.css'
                ],
                'simple-datatables' => [
                    'cdn' => 'https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css',
                    'local' => '/public/assets/css/simple-datatables.css'
                ]
            ],
            'js' => [
                'bootstrap' => [
                    'cdn' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js',
                    'local' => '/public/assets/js/bootstrap.bundle.min.js'
                ],
                'jspdf' => [
                    'cdn' => 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js',
                    'local' => '/public/assets/js/jspdf.umd.min.js'
                ],
                'xlsx' => [
                    'cdn' => 'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js',
                    'local' => '/public/assets/js/xlsx.full.min.js'
                ],
                'just-validate' => [
                    'cdn' => 'https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js',
                    'local' => '/public/assets/js/just-validate.production.min.js'
                ],
                'simple-datatables' => [
                    'cdn' => 'https://cdn.jsdelivr.net/npm/simple-datatables@latest',
                    'local' => '/public/assets/js/simple-datatables.js'
                ]
            ]
        ];

        // Additional local resources
        $this->localResources = [
            'css' => [
                '/public/assets/css/style.css',
                '/public/static/estilos_de_menus/style.css',
                '/public/static/data_table_simple/style.css'
            ],
            'js' => [
                '/public/static/data_table_simple/script.js',
                '/public/assets/js/char.js',
                '/public/assets/js/datatable_registrar_actualizar_justvalidate_exportacion_archivos.js'
            ]
        ];
    }

    private function renderResources()
    {
        // Render CSS resources
        foreach ($this->cdnResources['css'] as $key => $resource) {
            $path = $this->useLocalResources ? $resource['local'] : $resource['cdn'];
            echo '<link id="' . $key . '" href="' . $path . '" rel="stylesheet">';
        }

        // Render JS resources
        foreach ($this->cdnResources['js'] as $key => $resource) {
            $path = $this->useLocalResources ? $resource['local'] : $resource['cdn'];
            echo '<script id="' . $key . '" src="' . $path . '"></script>';
        }

        // Render additional local resources
        foreach ($this->localResources['css'] as $css) {
            echo '<link href="' . $css . '" rel="stylesheet">';
        }
        foreach ($this->localResources['js'] as $js) {
            echo '<script src="' . $js . '"></script>';
        }
    }

    public function render()
    {
        echo '<!DOCTYPE html>';
        echo '<html lang="es">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<title>' . $this->title . '</title>';
        echo '<link rel="icon" href="/public/assets/img/TEC_VICTORIA.PNG">';

        $this->renderResources();

        // Rest of the render method remains the same
        echo '</head>';
        echo '<body class="d-flex flex-column min-vh-100 bg-light">';

        // Add the logos header here
        echo '<!--LOGOTIPOS-->
        <header class="fixed-top" style="background-color: rgba(var(--bs-light-rgb), var(--bs-bg-opacity));">
            <section id="topbar" class="d-flex align-items-center">
                <div class="d-flex justify-content-center w-100">
                    <div class="social-links d-none d-md-block">
                        <a class="text-white" href="https://www.gob.mx/" target="_blank" id="pleca_1">
                            <img style="height: auto; min-width: 230px; max-width: 230px"
                                src="/public/assets/img/png/gobierno_mexico.png"
                                alt="Gobierno de México" />
                        </a>
                        <a class="text-white" href="https://www.gob.mx/sep" target="_blank" id="pleca_2">
                            <img style="height: auto; min-width: 250px; max-width: 250px"
                                src="/public/assets/img/png/sep.png"
                                alt="Educación" />
                        </a>
                    </div>
                    <div class="contact-info d-flex align-items-center">
                        <a class="text-white" href="https://www.tecnm.mx/" id="pleca_3">
                            <img style="height: auto; min-width: 120px; max-width: 120px"
                                src="/public/assets/img/png/tecnm.png"
                                alt="TecNM" />
                        </a>
                        <a href="https://www.cdvictoria.tecnm.mx" id="pleca_3" class="text-white">
                            <img style="height: auto; min-width: 80px; max-width: 80px"
                                src="/public/assets/img/png/tecnologico_cdvictoria.png"
                                alt="ITVictoria" />
                        </a>
                    </div>
                </div>
            </section>
        </header>';
    }
}

$header = new Header('SII :: Portal de alumnos');
$header->render();
?>