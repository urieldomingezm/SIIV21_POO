<?php
class NavigationMenu
{
    private $brand = 'Menu principal';
    private $SII = 'Sistema integral de la información | Alumno';
    private $SII_short = 'SII';
    private $menuItems = [];
    private $dropdownItems = [];

    public function __construct()
    {
        $this->initializeMenuItems();
        $this->dropdownItems = [
            ['text' => 'Cerrar Sesión', 'link' => '?page=logout', 'icon' => 'bi-box-arrow-right']
        ];
    }

    public function render()
    {
        echo "<div class='navbar-container fixed-bottom'>";
        echo "<nav class='navbar text-white shadow-sm' style='background-color: #1B396A;'>
                <div class='container-fluid px-md-4'>
                    <div class='d-flex align-items-center text-white'>
                        <span class='sii-title d-none d-md-inline'>{$this->SII}</span>
                        <span class='sii-title d-md-none'>{$this->SII_short}</span>
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
            </ul>
            <br>
            <form class='d-flex ms-1' role='search'>
                <input class='form-control me-2 bg-light text-dark' 
                       type='search' 
                       placeholder='Buscar' 
                       aria-label='Search' >
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

    private function initializeMenuItems()
    {
        $this->menuItems = [
            ['text' => 'Inicio', 'link' => '?page=inicio', 'active' => true, 'icon' => 'bi-house-door-fill'],
            [
                'text' => 'Selección de Materias',
                'link' => '#',
                'icon' => 'bi-journal-plus',
                'submenu' => [
                    ['text' => 'Materias Disponibles', 'link' => '?page=materias-disponibles', 'icon' => 'bi-list-check'],
                    ['text' => 'Horarios', 'link' => '?page=horarios-materias', 'icon' => 'bi-calendar3'],
                    ['text' => 'Carga Académica', 'link' => '?page=carga-academica', 'icon' => 'bi-journal-text']
                ]
            ],
            [
                'text' => 'Calificaciones',
                'link' => '#',
                'icon' => 'bi-card-checklist',
                'submenu' => [
                    ['text' => 'Parciales', 'link' => '?page=calificaciones-parciales', 'icon' => 'bi-123'],
                    ['text' => 'Kardex', 'link' => '?page=kardex', 'icon' => 'bi-file-text'],
                    ['text' => 'Boleta', 'link' => '?page=boleta', 'icon' => 'bi-file-earmark-pdf']
                ]
            ],
            ['text' => 'Ficha de Pago', 'link' => '?page=pagos', 'icon' => 'bi-cash-stack'],
            ['text' => 'Biblioteca', 'link' => '?page=biblioteca', 'icon' => 'bi-book'],
            [
                'text' => 'Quejas y Sugerencias',
                'link' => '#',
                'icon' => 'bi-chat-right-text-fill',
                'submenu' => [
                    ['text' => 'Nueva Queja', 'link' => '?page=nueva-queja', 'icon' => 'bi-exclamation-circle'],
                    ['text' => 'Nueva Sugerencia', 'link' => '?page=nueva-sugerencia', 'icon' => 'bi-lightbulb'],
                ]
            ]
        ];
    }

    private function renderMenuItem($item)
    {
        $currentPage = $_GET['page'] ?? 'inicio';
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
}

$navigation = new NavigationMenu();
$navigation->render();


?>

<br>