
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
                    array('text' => 'Gestion de usuarios', 'link' => '?page=Gestion de alumnos', 'icon' => 'bi-people-fill'),
                    array('text' => 'Gestion de pagos', 'link' => '?page=Gestion de pagos', 'icon' => 'bi-cash-coin'),
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
        $activeClass = ($currentPage === str_replace('?page=', '', $item['link'])) ? 'active' : '';
        $ariaCurrent = $activeClass ? 'aria-current="page"' : '';

        if (isset($item['submenu'])) {
            $submenuItems = '';
            $itemId = 'accordion_' . str_replace(' ', '_', strtolower($item['text']));
            
            foreach ($item['submenu'] as $submenu) {
                $submenuItems .= "<div class='accordion-body py-0'>
                                    <a class='nav-link compact-link' href='{$submenu['link']}'>
                                        <i class='bi {$submenu['icon']} me-2'></i>{$submenu['text']}
                                    </a>
                                </div>";
            }

            return "<div class='accordion-item bg-transparent border-0'>
                        <h2 class='accordion-header'>
                            <button class='accordion-button py-2 collapsed bg-transparent text-white' type='button' 
                                    data-bs-toggle='collapse' data-bs-target='#{$itemId}' 
                                    aria-expanded='false' aria-controls='{$itemId}'>
                                <i class='bi {$item['icon']} me-2'></i>{$item['text']}
                            </button>
                        </h2>
                        <div id='{$itemId}' class='accordion-collapse collapse' data-bs-parent='#menuAccordion'>
                            <div class='accordion-body p-0'>
                                {$submenuItems}
                            </div>
                        </div>
                    </div>";
        }

        return "<div class='accordion-item bg-transparent border-0'>
                    <div class='accordion-body py-0'>
                        <a class='nav-link compact-link {$activeClass}' {$ariaCurrent} href='{$item['link']}'>
                            <i class='bi {$item['icon']} me-2'></i>{$item['text']}
                        </a>
                    </div>
                </div>";
    }

    private function renderDropdownItems()
    {
        $items = '';
        foreach ($this->dropdownItems as $item) {
            $items .= "<a class='nav-link' href='{$item['link']}'>
                        <i class='bi {$item['icon']} me-2'></i>{$item['text']}
                      </a>";
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
                            data-bs-target='#offcanvasNavbar' aria-controls='offcanvasNavbar' 
                            aria-label='Toggle navigation'>
                        <span class='navbar-toggler-icon'></span>
                    </button>
                    <div class='offcanvas offcanvas-end text-white' tabindex='-1' id='offcanvasNavbar' 
                         aria-labelledby='offcanvasNavbarLabel' style='background-color: #1B396A;'>
                        <div class='offcanvas-header'>
                            <h5 class='offcanvas-title text-white' id='offcanvasNavbarLabel'>
                                {$this->brand}
                            </h5>
                            <button type='button' class='btn-close btn-close-white' data-bs-dismiss='offcanvas' 
                                    aria-label='Close'></button>
                        </div>
                        <div class='offcanvas-body'>
                            <div class='accordion' id='menuAccordion'>";

        foreach ($this->menuItems as $item) {
            echo $this->renderMenuItem($item);
        }

        echo "<div class='accordion-item bg-transparent'>
                <h2 class='accordion-header'>
                    <button class='accordion-button collapsed bg-transparent text-white' type='button' 
                            data-bs-toggle='collapse' data-bs-target='#optionsAccordion' 
                            aria-expanded='false' aria-controls='optionsAccordion'>
                        <i class='bi bi-gear me-2'></i>Opciones
                    </button>
                </h2>
                <div id='optionsAccordion' class='accordion-collapse collapse' data-bs-parent='#menuAccordion'>
                    <div class='accordion-body p-0'>
                        {$this->renderDropdownItems()}
                    </div>
                </div>
              </div>
            </div>
            <br>
            <form class='d-flex ms-1' role='search'>
                <input class='form-control me-2 bg-light text-dark' 
                       type='search' 
                       placeholder='Buscar' 
                       aria-label='Search'>
                <button class='btn btn-light' type='submit'>
                    <i class='bi bi-search'></i>
                </button>
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
            
            .sii-title {
                font-size: 1.1rem;
                font-weight: 500;
            }
            
            .accordion {
                margin: 0 -1rem;
            }
            
            .accordion-button {
                padding: 0.5rem 1.5rem;
                min-height: 45px;
                font-weight: 500;
            }
            
            .accordion-button::after {
                filter: invert(1);
                width: 1rem;
                height: 1rem;
                background-size: 1rem;
                margin-left: auto;
            }
            
            .accordion-button:not(.collapsed) {
                color: white;
                background-color: rgba(255, 255, 255, 0.1);
            }
            
            .accordion-button:focus {
                box-shadow: none;
                border-color: transparent;
            }
            
            .nav-link {
                color: white;
                padding: 0.5rem 1.5rem;
                transition: all 0.2s ease;
            }
            
            .compact-link {
                padding: 0.35rem 2rem;
                font-size: 0.95rem;
            }
            
            .nav-link:hover {
                background-color: rgba(255, 255, 255, 0.1);
                color: white;
                transform: translateX(5px);
            }
            
            .accordion-body {
                padding: 0;
            }
            
            .accordion-collapse {
                background-color: rgba(0, 0, 0, 0.1);
            }
            
            .offcanvas-body {
                padding: 1rem;
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