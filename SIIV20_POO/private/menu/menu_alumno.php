<style>
.navbar-nav .nav-link, .dropdown-toggle {
    color: white !important;
}
.navbar-nav .nav-link:hover, .dropdown-toggle:hover {
    color: #a8d1ff !important;
}
.dropdown-menu {
    background-color: #025d9a;
}
.dropdown-item {
    color: white !important;
}
.dropdown-item:hover {
    background-color: #014e82;
    color: #a8d1ff !important;
}
.form-control {
    border: 1px solid #a8d1ff;
}
.btn-outline-success {
    color: white;
    border-color: white;
}
.btn-outline-success:hover {
    background-color: #025d9a;
    border-color: #a8d1ff;
}
</style>


<?php
class NavigationMenu
{
    private $brand = 'Alumno';
    private $SII = 'Sistema integral de la información';
    private $menuItems = [];
    private $dropdownItems = [];

    public function __construct()
    {
        $this->initializeMenuItems();
        $this->dropdownItems = [
            ['text' => 'Configuración', 'link' => '?page=configuracion', 'icon' => 'bi-gear'],
            ['text' => 'Cerrar Sesión', 'link' => '?page=logout', 'icon' => 'bi-box-arrow-right']
        ];
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

    public function render()
    {
        echo "<nav class='navbar fixed-top text-white' style='background-color: #014e82;'>
                <div class='container-fluid'>
                    <div class='d-flex align-items-center text-white'>
                        <i class='bi bi-mortarboard-fill me-2 fs-4 text-white'></i>
                        <span class='fs-4 text-white'>{$this->SII}</span>
                    </div>
                    <button class='navbar-toggler bg-light' type='button' data-bs-toggle='offcanvas' 
                            data-bs-target='#offcanvasNavbar' aria-controls='offcanvasNavbar' 
                            aria-label='Toggle navigation'>
                        <span class='navbar-toggler-icon'></span>
                    </button>
                    <div class='offcanvas offcanvas-end text-white' tabindex='-1' id='offcanvasNavbar' 
                         aria-labelledby='offcanvasNavbarLabel' style='background-color: #014e82;'>
                        <div class='offcanvas-header'>
                            <h5 class='offcanvas-title text-white' id='offcanvasNavbarLabel'>
                                <i class='bi bi-mortarboard-fill me-2'></i>{$this->brand}
                            </h5>
                            <button type='button' class='btn-close btn-close-white' data-bs-dismiss='offcanvas' 
                                    aria-label='Close'></button>
                        </div>
                        <div class='offcanvas-body'>
                            <ul class='navbar-nav justify-content-end flex-grow-1 pe-3'>";

        // Render menu items
        foreach ($this->menuItems as $item) {
            echo $this->renderMenuItem($item);
        }

        // Render dropdown
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
    }
}

$navigation = new NavigationMenu();
$navigation->render();
