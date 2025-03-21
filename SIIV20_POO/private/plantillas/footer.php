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

        // Render styles
        $this->renderStyles();

        // Back to top buttons
        echo '<a href="#" class="btn btn-primary btn-square back-to-top"><i class="bi bi-arrow-up"></i></a>';
        echo '<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up"></i></a>';

        // Close body and html tags
        echo '</body>';
        echo '</html>';
    }
}

// Initialize and render footer
$footer = new Footer();
$footer->render();
?>