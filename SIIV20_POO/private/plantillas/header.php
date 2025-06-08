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
        // CDN resources framework css and js
        $this->cdnResources = [
            'css' => [
                'bootstrap' => [
                    'cdn' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
                    'local' => '/public/assets/framework/boostrap/bootstrap/css/bootstrap.min.css'
                ],
                'bootstrap-icons' => [
                    'cdn' => 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css',
                    'local' => '/public/assets/framework/boostrap/bootstrap-icons/bootstrap-icons.css'
                ],
                'boxicons' => [
                    'cdn' => 'https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css',
                    'local' => '/public/assets/framework/boostrap/boxicons/css/boxicons.min.css'
                ],
                'simple-datatables' => [
                    'cdn' => 'https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css',
                    'local' => '/public/assets/framework/simple-datatables/simple-datatables.css'
                ]
            ],
            'js' => [
                'bootstrap' => [
                    'cdn' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js',
                    'local' => '/public/assets/framework/boostrap/bootstrap/js/bootstrap.bundle.min.js'
                ],
                'jspdf' => [
                    'cdn' => 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js',
                    'local' => '/public/assets/framework/pdf/jspdf.umd.min.js'
                ],
                'xlsx' => [
                    'cdn' => 'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js',
                    'local' => '/public/assets/framework/excel/xlsx.full.min.js'
                ],
                'just-validate' => [
                    'cdn' => 'https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js',
                    'local' => '/public/assets/framework/just_validate/just-validate.production.min.js'
                ],
                'simple-datatables' => [
                    'cdn' => 'https://cdn.jsdelivr.net/npm/simple-datatables@latest',
                    'local' => '/public/assets/framework/simple-datatables/simple-datatables.js'
                ],
                'chart' => [
                    'cdn' => 'https://cdn.jsdelivr.net/npm/chart.js',
                    'local' => '/public/assets/framework/chart/chart.js'
                ]
            ]
        ];

        // Additional local custom resources
        $this->localResources = [
            'css' => [
                // ESTILOS GENERALES PARA TODOS LOS MENUS
                '/public/assets/custom/menu/style.css',

                // ASPIRANTES
                '/public/assets/custom/aspirante/formulario_socioeconomicos/css/style.css',
            ],
            'js' => [

                // CAPTURA DE DATOS SOCIOECONOMICOS ASPIRANTES (MUTI FORMULARIO)
                '/public/assets/custom/aspirante/formulario_socioeconomicos/js/script.js',
             ]
        ];
    }

    private function renderResources()
    {
        foreach ($this->cdnResources['css'] as $key => $resource) {
            $path = $this->useLocalResources ? $resource['local'] : $resource['cdn'];
            echo '<link id="' . $key . '" href="' . $path . '" rel="stylesheet">';
        }

        foreach ($this->cdnResources['js'] as $key => $resource) {
            $path = $this->useLocalResources ? $resource['local'] : $resource['cdn'];
            echo '<script id="' . $key . '" src="' . $path . '"></script>';
        }

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

        echo '<style>
            /* Topbar styles */
            .topbar {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 1000;
                background-color: white;
                padding: 12px 0;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            .topbar-images {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 60px; /* Aumentado de 30px a 60px */
                padding: 0 20px;
            }

            .topbar-image {
                height: 50px; /* Aumentado de 40px a 50px */
                width: auto;
                transition: transform 0.2s ease;
            }

            .topbar-image:hover {
                transform: scale(1.05);
            }

            @media (max-width: 767.98px) {
                .topbar {
                    padding: 10px 0;
                }
                
                .topbar-images {
                    gap: 30px; /* Aumentado para móviles también */
                }
                
                .topbar-image {
                    height: 35px; /* Aumentado de 30px a 35px */
                }
            }
        </style>';

        echo '</head>';
        echo '<body class="d-flex flex-column min-vh-100 bg-light" style="padding-top: 74px;">'; /* Ajustado para el header más grande */

        echo '<div class="topbar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="topbar-images">
                            <img src="/public/assets/img/png/plecaa.png" alt="Topbar Image 1" class="topbar-image">
                            <img src="/public/assets/img/png/plecab.png" alt="Topbar Image 2" class="topbar-image">
                            <img src="/public/assets/img/png/plecac.png" alt="Topbar Image 3" class="topbar-image">
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }
}

$header = new Header("SII :: Portal de alumnos");
$header->render();
?>