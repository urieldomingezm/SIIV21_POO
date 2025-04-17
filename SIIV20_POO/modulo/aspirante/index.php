<?php
ob_start(); // Start output buffering
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');

// Check session before any output
if (!isset($_SESSION['curp'])) {
    ob_end_clean(); // Clean the buffer
    header('Location: /');
    exit;
}

require_once(MENU_PATH . 'menu_aspirante.php'); 
require_once(TEMPLATES_PATH . 'header.php');
require_once(CONFIG_PATH . 'bd.php');

// Initialize database connection
$database = new Database();
$conn = $database->getConnection();
$curp = $_SESSION['curp'];

ob_end_flush(); // Flush the buffer
?>

<!-- Content for personal panel -->
<div class="container mt-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white py-3">
            <h4 class="mb-0"><i class="bi bi-person-check-fill me-2"></i>Bienvenido(a) Aspirante</h4>
        </div>
        <div class="card-body">
            <div class="alert alert-info mb-4">
                <h5 class="alert-heading">
                    <i class="bi bi-info-circle me-2"></i>
                    Bienvenido(a): <?php 
                        $stmt = $conn->prepare("SELECT nombre, apellido_paterno, apellido_materno FROM aspirantes WHERE curp = ?");
                        $stmt->execute([$curp]);
                        $aspirante = $stmt->fetch();
                        
                        if ($aspirante) {
                            echo htmlspecialchars($aspirante['nombre'] . ' ' . $aspirante['apellido_paterno'] . ' ' . $aspirante['apellido_materno']);
                        } else {
                            echo "Usuario no encontrado";
                        }
                    ?>
                </h5>
                <p class="mb-0">CURP: <?php echo htmlspecialchars($curp); ?></p>
            </div>

            <h5 class="text-primary mb-3">Recomendaciones</h5>
            <p class="lead">El Instituto Tecnológico de Cd. Victoria te da la más cordial bienvenida. En este momento eres ASPIRANTE a ingresar a éste INSTITUTO.</p>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-title text-primary">El proceso de llenado consta de cuatro pasos:</h6>
                    <ol class="list-group list-group-numbered mt-3">
                        <li class="list-group-item">Llenar la solicitud de ficha de examen de selección con datos generales y escolares.</li>
                        <li class="list-group-item">Llenar el formulario de datos socioeconómicos.</li>
                        <li class="list-group-item">Imprimir la solicitud al terminar la captura.</li>
                        <li class="list-group-item">Generar ficha de depósito para realizar el pago en el banco.</li>
                    </ol>
                </div>
            </div>

            <div class="alert alert-warning">
                <h6 class="alert-heading"><i class="bi bi-exclamation-triangle me-2"></i>Importante:</h6>
                <p class="mb-0">DEBERÁS LLENAR EL MÁXIMO DE DATOS QUE SE TE PIDEN, EL PROGRAMA NO TE DEJARÁ SEGUIR SI NO LO HACES ASÍ.</p>
            </div>

            <div class="card bg-light">
                <div class="card-body">
                    <h6 class="text-primary mb-3">Requisitos de información necesaria:</h6>
                    <ul class="list-unstyled mb-0">
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Datos personales completos</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>CURP</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Información académica</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Datos socioeconómicos</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Información de contacto de emergencia</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once(TEMPLATES_PATH . 'footer.php'); ?>