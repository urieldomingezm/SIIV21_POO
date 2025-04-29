
<?php
class NavigationMenu
{
    private $brand;
    private $SII;
    private $SII_short;
    private $menuItems;
    private $dropdownItems;

    public function __construct()
    {
        $this->brand = 'Menu principal';
        $this->SII = 'Sistema integral de la información | Personal';
        $this->SII_short = 'SII | Personal';
        $this->initializeMenuItems();
        $this->dropdownItems = array(
            array('text' => 'Cerrar Sesión', 'link' => '?page=logout', 'icon' => 'bi-box-arrow-right')
        );
    }

    private function initializeMenuItems()
    {
        $this->menuItems = array(
            array('text' => 'Inicio', 'link' => '?page=Inicio', 'active' => true, 'icon' => 'bi-house-door-fill'),
            array(
                'text' => 'Gestión Académica',
                'link' => '#',
                'icon' => 'bi-journal-text',
                'submenu' => array(
                    array('text' => 'Mis Grupos', 'link' => '?page=mis-grupos', 'icon' => 'bi-people-fill'),
                    array('text' => 'Horarios', 'link' => '?page=horarios', 'icon' => 'bi-calendar3'),
                    array('text' => 'Lista de Asistencia', 'link' => '?page=asistencia', 'icon' => 'bi-list-check')
                )
            ),
            array(
                'text' => 'Evaluaciones',
                'link' => '#',
                'icon' => 'bi-clipboard-check',
                'submenu' => array(
                    array('text' => 'Captura de Calificaciones', 'link' => '?page=captura-calificaciones', 'icon' => 'bi-pencil-square'),
                    array('text' => 'Historial de Evaluaciones', 'link' => '?page=historial-evaluaciones', 'icon' => 'bi-clock-history'),
                    array('text' => 'Reportes Académicos', 'link' => '?page=reportes', 'icon' => 'bi-file-earmark-text')
                )
            ),
            array(
                'text' => 'Planeación Docente',
                'link' => '#',
                'icon' => 'bi-calendar2-week',
                'submenu' => array(
                    array('text' => 'Plan de Trabajo', 'link' => '?page=plan-trabajo', 'icon' => 'bi-file-earmark-text'),
                    array('text' => 'Instrumentaciones', 'link' => '?page=instrumentaciones', 'icon' => 'bi-file-earmark-ruled'),
                    array('text' => 'Material Didáctico', 'link' => '?page=material-didactico', 'icon' => 'bi-folder2-open')
                )
            ),
            array(
                'text' => 'Recursos',
                'link' => '#',
                'icon' => 'bi-tools',
                'submenu' => array(
                    array('text' => 'Biblioteca Digital', 'link' => '?page=biblioteca', 'icon' => 'bi-book'),
                    array('text' => 'Recursos Educativos', 'link' => '?page=recursos', 'icon' => 'bi-collection'),
                    array('text' => 'Sala Virtual', 'link' => '?page=sala-virtual', 'icon' => 'bi-camera-video')
                )
            ),
            array(
                'text' => 'Comunicación',
                'link' => '#',
                'icon' => 'bi-chat-dots',
                'submenu' => array(
                    array('text' => 'Mensajes', 'link' => '?page=mensajes', 'icon' => 'bi-envelope'),
                    array('text' => 'Avisos Académicos', 'link' => '?page=avisos', 'icon' => 'bi-bell'),
                    array('text' => 'Reuniones', 'link' => '?page=reuniones', 'icon' => 'bi-people')
                )
            )
        );
    }

    private function renderMenuItem($item)
    {
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 'inicio';
        $itemId = 'accordion_' . str_replace([' ', '-'], '_', strtolower($item['text']));

        if (isset($item['submenu'])) {
            $submenuItems = '';
            foreach ($item['submenu'] as $submenu) {
                $submenuItems .= "<li class='list-group-item'>
                                    <a href='{$submenu['link']}'>
                                        <i class='bi {$submenu['icon']} me-2'></i>{$submenu['text']}
                                    </a>
                                </li>";
            }

            return "<div class='accordion-item bg-transparent border-0'>
                        <h2 class='accordion-header'>
                            <button class='accordion-button bg-transparent text-white collapsed' type='button' 
                                    data-bs-toggle='collapse' data-bs-target='#{$itemId}'>
                                <i class='bi {$item['icon']} me-2'></i>{$item['text']}
                            </button>
                        </h2>
                        <div id='{$itemId}' class='accordion-collapse collapse'>
                            <div class='accordion-body p-0'>
                                <ul class='list-group list-group-flush'>
                                    {$submenuItems}
                                </ul>
                            </div>
                        </div>
                    </div>";
        }

        return "<div class='accordion-item bg-transparent border-0'>
                    <h2 class='accordion-header'>
                        <a class='nav-link' href='{$item['link']}'>
                            <i class='bi {$item['icon']} me-2'></i>{$item['text']}
                        </a>
                    </h2>
                </div>";
    }

    private function renderDropdownItems()
    {
        $items = '';
        foreach ($this->dropdownItems as $item) {
            $items .= "<li class='list-group-item'>
                        <a href='{$item['link']}'>
                            <i class='bi {$item['icon']} me-2'></i>{$item['text']}
                        </a>
                      </li>";
        }
        return $items;
    }

    public function render()
    {
        echo "<div class='navbar-container fixed-bottom'>";
        echo "<nav class='navbar text-white shadow-sm' style='background-color: #1B396A;'>
                <div class='container-fluid px-md-4'>
                    <div class='d-flex align-items-center text-white'>
                        <span class='SII-MENU-PERSONAL d-none d-md-inline'>{$this->SII}</span>
                        <span class='SII-MENU-PERSONAL d-md-none'>{$this->SII_short}</span>
                    </div>
                    <button class='navbar-toggler bg-light ms-auto' type='button' data-bs-toggle='offcanvas' 
                            data-bs-target='#offcanvasNavbar' aria-controls='offcanvasNavbar'>
                        <span class='navbar-toggler-icon'></span>
                    </button>
                    <div class='offcanvas offcanvas-end text-white' tabindex='-1' id='offcanvasNavbar' 
                         style='background-color: #1B396A;'>
                        <div class='offcanvas-header'>
                            <h5 class='offcanvas-title text-white'>{$this->brand}</h5>
                            <button type='button' class='btn-close btn-close-white' data-bs-dismiss='offcanvas'></button>
                        </div>
                        <div class='offcanvas-body'>
                            <div class='accordion accordion-flush' id='navAccordion'>";
        
        foreach ($this->menuItems as $item) {
            echo $this->renderMenuItem($item);
        }

        // Opciones como acordeón
        echo "<div class='accordion-item bg-transparent border-0'>
                <h2 class='accordion-header'>
                    <button class='accordion-button bg-transparent text-white collapsed' type='button' 
                            data-bs-toggle='collapse' data-bs-target='#optionsAccordion'>
                        <i class='bi bi-gear me-2'></i>Opciones
                    </button>
                </h2>
                <div id='optionsAccordion' class='accordion-collapse collapse'>
                    <div class='accordion-body p-0'>
                        <ul class='list-group list-group-flush'>
                            {$this->renderDropdownItems()}
                        </ul>
                    </div>
                </div>
              </div>
            </div>
            <br>
            <form class='d-flex ms-1' role='search'>
                <input class='form-control me-2 bg-light text-dark' type='search' placeholder='Buscar' aria-label='Search'>
                <button class='btn btn-light' type='submit'><i class='bi bi-search'></i></button>
            </form>
            </div>
            </div>
            </div>
            </nav>";
        echo "</div>";

        echo "<style>
            .navbar-container {
                width: 100%;
                z-index: 1030;
            }
            
            .navbar {
                min-height: 60px;
            }
            
            .accordion-button::after {
                filter: brightness(0) invert(1);
            }
            
            .accordion-button:not(.collapsed) {
                color: white;
                background-color: rgba(255, 255, 255, 0.1);
            }
            
            .accordion-button:focus {
                box-shadow: none;
            }
            
            .list-group-item {
                background-color: transparent;
                border: none;
                padding: 0.5rem 1rem;
            }
            
            .list-group-item a {
                color: white;
                text-decoration: none;
                display: block;
                padding: 0.5rem;
                border-radius: 0.25rem;
            }
            
            .list-group-item a:hover {
                background-color: rgba(255, 255, 255, 0.1);
            }
            
            @media (max-width: 768px) {
                .container-fluid {
                    padding: 0.5rem 1rem;
                }
                
                .navbar-toggler {
                    margin-left: 1rem;
                }
            }
        </style>";
    }
}

$navigation = new NavigationMenu();
$navigation->render();
?>