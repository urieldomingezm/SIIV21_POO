
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
        $this->brand = 'Personal Docente';
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
        echo "<div class='navbar-container'>"; 
        echo "<nav class='navbar text-white shadow-sm' style='background-color: #1B396A;'>
                <div class='container-fluid px-md-4'>
                    <div class='d-flex align-items-center text-white'>
                        <span class='sii-title'>{$this->SII}</span>
                    </div>
                    <button class='navbar-toggler bg-light' type='button' data-bs-toggle='offcanvas' 
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
                            <ul class='navbar-nav justify-content-end flex-grow-1 pe-3'>";

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
            <form class='d-flex mt-3' role='search'>
                <div class='input-group'>
                    <input class='form-control' type='search' placeholder='Buscar' aria-label='Buscar'>
                    <button class='btn btn-outline-success' type='submit'>
                        <i class='bi bi-search'></i>
                    </button>
                </div>
            </form>
            </div>
            </div>
            </div>
            </nav>";
        echo "</div>";
    }
}

$navigation = new NavigationMenu();
$navigation->render();
?>