<?php
class WelcomePage {
    private $usuario;
    private $rol;
    private $saludo;
    private $fecha;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->verificarAutenticacion();
        $this->inicializarDatos();
    }

    private function verificarAutenticacion() {
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'personal') {
            header('Location: /login.php');
            exit;
        }
        $this->usuario = $_SESSION['personal_usuario'];
        $this->rol = $_SESSION['rol'];
    }

    private function inicializarDatos() {
        $this->generarSaludo();
        $this->generarFecha();
    }

    private function generarSaludo() {
        $hora = date('H');
        if ($hora < 12) {
            $this->saludo = "Buenos días";
        } elseif ($hora < 19) {
            $this->saludo = "Buenas tardes";
        } else {
            $this->saludo = "Buenas noches";
        }
    }

    private function generarFecha() {
        $dias = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
        $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", 
                  "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

        $this->fecha = sprintf(
            "%s, %s de %s de %s",
            $dias[date('w')],
            date('d'),
            $meses[date('n') - 1],
            date('Y')
        );
    }

    public function renderizar() {
        echo $this->obtenerHTML();
    }

    private function obtenerHTML() {
        return <<<HTML
        <body>
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card shadow-lg border-0 welcome-card">
                            <div class="card-body p-5">
                                <div class="welcome-header text-center mb-5">
                                    <div class="avatar-container mb-4">
                                        <i class="bi bi-person-circle"></i>
                                    </div>
                                    <h1 class="welcome-title mb-3">{$this->saludo}</h1>
                                    <h2 class="welcome-subtitle">
                                        {$this->obtenerTextoSeguro($this->usuario)}
                                    </h2>
                                </div>
                                
                                <div class="welcome-content text-center">
                                    <p class="welcome-message mb-4">
                                        Bienvenido al Sistema Integral de Información del Instituto Tecnológico
                                    </p>
                                    <div class="role-badge mb-4">
                                        <span class="role-label">Rol actual:</span>
                                        <span class="role-value">
                                            {$this->obtenerTextoSeguro(ucfirst($this->rol))}
                                        </span>
                                    </div>
                                </div>

                                <div class="welcome-footer text-center">
                                    <div class="date-display">
                                        <i class="bi bi-calendar-check"></i>
                                        <span>{$this->fecha}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .welcome-card {
                    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
                    border-radius: 20px;
                    transition: all 0.3s ease;
                    overflow: hidden;
                    position: relative;
                }

                .welcome-card::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    height: 5px;
                    background: linear-gradient(90deg, #007bff, #6610f2);
                }

                .welcome-card:hover {
                    transform: translateY(-10px);
                    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
                }

                .avatar-container {
                    width: 120px;
                    height: 120px;
                    margin: 0 auto;
                    background: linear-gradient(45deg, #007bff, #6610f2);
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    box-shadow: 0 5px 15px rgba(0,123,255,0.3);
                }

                .avatar-container i {
                    font-size: 60px;
                    color: white;
                }

                .welcome-title {
                    font-size: 2.5rem;
                    font-weight: 700;
                    background: linear-gradient(45deg, #007bff, #6610f2);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    margin-bottom: 0.5rem;
                }

                .welcome-subtitle {
                    font-size: 1.5rem;
                    color: #6c757d;
                    font-weight: 500;
                }

                .welcome-message {
                    font-size: 1.2rem;
                    color: #495057;
                    line-height: 1.6;
                }

                .role-badge {
                    display: inline-flex;
                    align-items: center;
                    gap: 10px;
                    padding: 10px 20px;
                    background: rgba(0,123,255,0.1);
                    border-radius: 50px;
                    transition: all 0.3s ease;
                }

                .role-badge:hover {
                    background: rgba(0,123,255,0.2);
                    transform: scale(1.05);
                }

                .role-label {
                    color: #495057;
                    font-weight: 500;
                }

                .role-value {
                    background: linear-gradient(45deg, #007bff, #6610f2);
                    color: white;
                    padding: 5px 15px;
                    border-radius: 25px;
                    font-weight: 500;
                    letter-spacing: 0.5px;
                }

                .date-display {
                    display: inline-flex;
                    align-items: center;
                    gap: 10px;
                    padding: 10px 20px;
                    background: #f8f9fa;
                    border-radius: 50px;
                    color: #6c757d;
                    font-weight: 500;
                    margin-top: 20px;
                }

                .date-display i {
                    color: #007bff;
                }

                @media (max-width: 768px) {
                    .welcome-title {
                        font-size: 2rem;
                    }
                    
                    .welcome-subtitle {
                        font-size: 1.2rem;
                    }
                    
                    .welcome-message {
                        font-size: 1rem;
                    }
                }
            </style>
        </body>
        HTML;
    }

    private function obtenerTextoSeguro($texto) {
        return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
    }
}

// Inicializar y renderizar la página
$welcomePage = new WelcomePage();
$welcomePage->renderizar();
?>
