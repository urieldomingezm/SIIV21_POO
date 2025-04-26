
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
        $this->SII_short = 'SII';
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
        $activeClass = ($currentPage === str_replace('?page=', '', $item['link'])) ? 'active' : '';
        $ariaCurrent = $activeClass ? 'aria-current="page"' : '';

        if (isset($item['submenu'])) {
            $submenuItems = '';
            foreach ($item['submenu'] as $submenu) {
                $submenuItems .= "<li>
                                    <a class='dropdown-item' href='{$submenu['link']}'>
                                        <i class='bi {$submenu['icon']} me-2'></i>{$submenu['text']}
                                    </a>
                                </li>";
            }

            return "<li class='nav-item dropdown'>
                        <a class='nav-link dropdown-toggle {$activeClass}' href='#' role='button' 
                           data-bs-toggle='dropdown' aria-expanded='false'>
                            <i class='bi {$item['icon']} me-2'></i>{$item['text']}
                        </a>
                        <ul class='dropdown-menu'>
                            {$submenuItems}
                        </ul>
                    </li>";
        }

        return "<li class='nav-item'>
                    <a class='nav-link {$activeClass}' {$ariaCurrent} href='{$item['link']}'>
                        <i class='bi {$item['icon']} me-2'></i>{$item['text']}
                    </a>
                </li>";
    }

    private function renderDropdownItems()
    {
        $items = '';
        foreach ($this->dropdownItems as $item) {
            $items .= "<li>
                        <a class='dropdown-item' href='{$item['link']}'>
                            <i class='bi {$item['icon']} me-2'></i>{$item['text']}
                        </a>
                      </li>";
            if ($item !== end($this->dropdownItems)) {
                $items .= "<li><hr class='dropdown-divider'></li>";
            }
        }
        return $items;
    }

    public function render()
    {
        echo "<div class='navbar-container'>"; // Removido fixed-bottom para mejor adaptabilidad
        echo "<nav class='navbar navbar-expand-lg text-white shadow-sm' style='background-color: #1B396A;'>
                <div class='container-fluid px-md-4'>
                    <div class='d-flex align-items-center text-white'>
                        <span class='sii-title d-none d-lg-inline'>{$this->SII}</span>
                        <span class='sii-title d-lg-none'>{$this->SII_short}</span>
                    </div>
                    
                    <button class='navbar-toggler bg-light' type='button' 
                            data-bs-toggle='collapse' 
                            data-bs-target='#navbarContent' 
                            aria-controls='navbarContent' 
                            aria-expanded='false' 
                            aria-label='Toggle navigation'>
                        <span class='navbar-toggler-icon'></span>
                    </button>

                    <div class='collapse navbar-collapse' id='navbarContent'>
                        <ul class='navbar-nav me-auto mb-2 mb-lg-0'>";

        foreach ($this->menuItems as $item) {
            echo $this->renderMenuItem($item);
        }

        echo "<li class='nav-item dropdown'>
                <a class='nav-link dropdown-toggle' href='#' role='button' 
                   data-bs-toggle='dropdown' aria-expanded='false'>
                    <i class='bi bi-gear me-2'></i>Opciones
                </a>
                <ul class='dropdown-menu'>
                    {$this->renderDropdownItems()}
                </ul>
              </li>
            </ul>
            
            <form class='d-flex' role='search'>
                <div class='input-group'>
                    <input class='form-control' type='search' placeholder='Buscar' aria-label='Search'>
                    <button class='btn btn-light' type='submit'>
                        <i class='bi bi-search'></i>
                    </button>
                </div>
            </form>
            </div>
            </div>
            </nav>";
        echo "</div>";

        // Agregar estilos CSS para mejor responsividad
        echo "<style>
            .navbar-container {
                width: 100%;
                z-index: 1030;
            }
            
            @media (max-width: 991.98px) {
                .navbar-collapse {
                    background-color: #1B396A;
                    padding: 1rem;
                    border-radius: 0.25rem;
                    margin-top: 0.5rem;
                }
                
                .dropdown-menu {
                    background-color: rgba(255,255,255,0.1);
                    border: none;
                }
                
                .dropdown-item {
                    color: white;
                }
                
                .dropdown-item:hover {
                    background-color: rgba(255,255,255,0.2);
                    color: white;
                }
                
                .form-control {
                    margin-top: 1rem;
                }
            }
            
            .sii-title {
                font-size: 1.1rem;
                font-weight: 500;
            }
            
            .nav-link {
                color: rgba(255,255,255,0.9) !important;
                padding: 0.5rem 1rem;
            }
            
            .nav-link:hover {
                color: white !important;
                background-color: rgba(255,255,255,0.1);
                border-radius: 0.25rem;
            }
            
            .dropdown-menu {
                margin-top: 0.5rem;
            }
        </style>";
    }
}

$navigation = new NavigationMenu();
$navigation->render();
?>