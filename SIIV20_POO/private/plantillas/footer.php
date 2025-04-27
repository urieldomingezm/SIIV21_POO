<?php
class Footer {
    private $styles;
    private $copyright;
    private $instituteName;
    private $instituteUrl;

    public function __construct() {
        $this->styles = [
            'bg-body-tertiary' => [
                '--bs-bg-opacity' => '1',
                'background-color' => '#807E82 !important'
            ],
            'prueba' => [
                'color' => '#1B396A !important',
                'text-decoration' => 'none'
            ],
            'btn-active' => [
                'color' => 'var(--bs-btn-active-color)',
                'background-color' => '#1B396A',
                'border-color' => '#FFFFFF'
            ]
        ];
        $this->copyright = '&copy; Copyright';
        $this->instituteName = ' Instituto Tecnologico de Ciudad Victoria';
        $this->instituteUrl = 'https://www.itvictoria.edu.mx/';
    }

    private function renderStyles() {
        echo '<style>';
        foreach ($this->styles as $class => $properties) {
            if ($class === 'btn-active') {
                echo '.btn-check:checked+.btn, .btn.active, .btn.show, .btn:first-child:active, :not(.btn-check)+.btn:active {';
            } else {
                echo ".$class {";
            }
            foreach ($properties as $property => $value) {
                echo "$property: $value;";
            }
            echo '}';
        }
        echo '</style>';
    }

    private function renderBackToTop() {
        echo '<div id="backToTop" class="back-to-top-wrapper">';
        echo '<button class="back-to-top-btn" aria-label="Back to top">';
        echo '<i class="bi bi-arrow-up"></i>';
        echo '</button>';
        echo '</div>';
        
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                const backToTop = document.getElementById("backToTop");
                
                window.addEventListener("scroll", () => {
                    if (window.scrollY > 300) {
                        backToTop.classList.add("show");
                    } else {
                        backToTop.classList.remove("show");
                    }
                });
                
                backToTop.addEventListener("click", () => {
                    window.scrollTo({
                        top: 0,
                        behavior: "smooth"
                    });
                });
            });
        </script>';
        
        echo '<style>
            .back-to-top-wrapper {
                position: fixed;
                bottom: 2rem;
                right: 2rem;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease-in-out;
                z-index: 9999;
            }
            
            .back-to-top-wrapper.show {
                opacity: 1;
                visibility: visible;
            }
            
            .back-to-top-btn {
                background-color: #1B396A;
                color: white;
                border: none;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                cursor: pointer;
                box-shadow: 0 2px 6px rgba(0,0,0,0.2);
                transition: transform 0.2s;
            }
            
            .back-to-top-btn:hover {
                transform: translateY(-3px);
            }
        </style>';
    }

    public function render() {
        echo '</section><br>';
        // Footer content
        echo '<footer class="footer mt-auto py-3 bg-body-tertiary">';
        echo '<div class="container text-center">';
        echo '<span class="text-body-primary text-white"><strong>' . $this->copyright . '</strong></span>';
        echo '<a class="prueba" href="' . $this->instituteUrl . '"><strong><span>' . $this->instituteName . '</span></strong></a>';
        echo '<br>';
        echo '</div>';
        echo '</footer>';

        $this->renderStyles();

        $this->renderBackToTop();

        echo '</body>';
        echo '</html>';
    }
}

$footer = new Footer();
$footer->render();
?>