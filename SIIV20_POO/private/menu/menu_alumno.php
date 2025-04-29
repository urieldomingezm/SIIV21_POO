<?php
class NavigationMenu
{
    private $brand = 'Menu principal';
    private $SII = 'Sistema integral de la información | Alumno';
    private $SII_short = 'SII | Alumno';
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
                        <span class='SII-MENU-ALUMNO d-none d-md-inline'>{$this->SII}</span>
                        <span class='SII-MENU-ALUMNO d-md-none'>{$this->SII_short}</span>
                    </div>
                    <button class='navbar-toggler bg-light ms-auto' type='button' data-bs-toggle='offcanvas' 
                            data-bs-target='#offcanvasNavbar' aria-controls='offcanvasNavbar' 
                            aria-label='Toggle navigation'>
                        <span class='navbar-toggler-icon'></span>
                    </button>
                    <div class='offcanvas offcanvas-end text-white' tabindex='-1' id='offcanvasNavbar' 
                         aria-labelledby='offcanvasNavbarLabel' style='background-color: #1B396A;'>
                        <div class='offcanvas-header'>
                            <h5 class='offcanvas-title text-white' id='offcanvasNavbarLabel'>{$this->brand}</h5>
                            <button type='button' class='btn-close btn-close-white' data-bs-dismiss='offcanvas' 
                                    aria-label='Close'></button>
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
                color: white;
            }
            
            .list-group-item a {
                color: white;
                text-decoration: none;
            }
            
            .list-group-item:hover {
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

    private function renderMenuItem($item)
    {
        $currentPage = $_GET['page'] ?? 'inicio';
        $activeClass = ($currentPage === str_replace('?page=', '', $item['link'])) ? 'active' : '';
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
                        <a class='nav-link {$activeClass}' href='{$item['link']}'>
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
}

$navigation = new NavigationMenu();
$navigation->render();
?>