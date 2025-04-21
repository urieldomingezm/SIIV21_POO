<?php
// Verificar si existe una sesión activa
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'alumno') {
    header('Location: /index.php');
    exit;
}

require_once(CONFIG_PATH . 'bd.php');

// Obtener información del alumno desde la base de datos
$database = new Database();
$conn = $database->getConnection();

$alumno_id = $_SESSION['user_id'];
$numero_control = $_SESSION['numero_control'];

// Consultar información adicional del alumno si es necesario
$query = "SELECT * FROM alumnos WHERE alumno_id = :id";
$stmt = $conn->prepare($query);
$stmt->execute([':id' => $alumno_id]);
$alumno_data = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar si hay adeudos (esto es un ejemplo, ajusta según tu lógica de negocio)
$tiene_adeudos = false; // Cambiar según la lógica real de tu sistema

// Obtener fecha actual para mostrar el semestre correcto
$fecha_actual = new DateTime();
$anio = $fecha_actual->format('Y');
$mes = (int)$fecha_actual->format('m');

// Determinar el semestre actual
$semestre = ($mes >= 7) ? "AGOSTO-DICIEMBRE $anio" : "ENERO-JUNIO $anio";
$proximo_semestre = ($mes >= 7) ? "ENERO-JUNIO " . ($anio + 1) : "AGOSTO-DICIEMBRE $anio";

// Generar correo institucional basado en el número de control
$correo_institucional = "L" . $numero_control . "@cdvictoria.tecnm.mx";
?>

<div class="container py-4">
    <!-- Tarjeta de bienvenida con sombra y bordes redondeados -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body p-4 border-start border-primary border-5">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold text-primary">Bienvenido(a)</h2>
                    <h3 class="display-6 fw-bold"><?php echo $numero_control; ?></h3>
                    
                    <?php if ($tiene_adeudos): ?>
                        <span class="badge bg-danger fs-6 py-2 px-3 mb-3">CON ADEUDOS A LA FECHA</span>
                    <?php else: ?>
                        <span class="badge bg-success fs-6 py-2 px-3 mb-3">SIN ADEUDOS A LA FECHA</span>
                    <?php endif; ?>
                    
                    <h4 class="mt-3 text-dark">PROCESO DE REINSCRIPCIÓN <?php echo $proximo_semestre; ?></h4>
                    <p class="lead fw-bold text-secondary">¡BIENVENIDO NUEVAMENTE A ESTA TU CASA DE ESTUDIOS!</p>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <i class="bi bi-mortarboard-fill text-primary" style="font-size: 5rem;"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Pasos a seguir con iconos y mejor formato -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light py-3">
            <h4 class="mb-0 text-primary"><i class="bi bi-list-check me-2"></i>PASOS A SEGUIR</h4>
        </div>
        <div class="card-body p-4">
            <div class="d-flex mb-4 border-bottom pb-3">
                <div class="flex-shrink-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                    <span class="fw-bold">1</span>
                </div>
                <div>
                    <h5 class="fw-bold">Revisa tus adeudos</h5>
                    <p class="mb-0">Revisa el menu <span class="fw-bold">INSCRIPCIONES -> Horarios Reinscripción</span>, para saber si tienes adeudos.
                    Acude a solventarlos al menos un día antes de tu inscripción para evitar contratiempos.</p>
                </div>
            </div>
            
            <div class="d-flex mb-4 border-bottom pb-3">
                <div class="flex-shrink-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                    <span class="fw-bold">2</span>
                </div>
                <div>
                    <h5 class="fw-bold">Imprime tu ficha de depósito</h5>
                    <p>Imprime la ficha de depósito en la sección <span class="fw-bold">CONCEPTOS DE COBRO</span>.</p>
                    <div class="alert alert-danger py-2">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>IMPORTANTE:</strong> El pago de reinscripción deberá realizarse como máximo 1 día antes de acuerdo con el calendario de las fechas establecidas de reinscripción por carrera o programa, de lo contrario no podrás seleccionar el horario en la fecha establecida para reinscripción.
                    </div>
                </div>
            </div>
            
            <div class="d-flex mb-4">
                <div class="flex-shrink-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                    <span class="fw-bold">3</span>
                </div>
                <div>
                    <h5 class="fw-bold">Selecciona tus materias</h5>
                    <p>Los horarios ya se encuentran disponibles en la sección <span class="fw-bold">INSCRIPCIONES -> GRUPOS DISPONIBLES</span> para que elabores tu prehorario; posteriormente, accede al SII en la fecha y hora indicada (en el PASO 1), selecciona tus materias y registra tu horario.</p>
                </div>
            </div>
            
            <div class="alert alert-primary d-flex align-items-center mt-3">
                <i class="bi bi-calendar-event me-2 fs-4"></i>
                <div>
                    <strong>Fechas de Reinscripción:</strong> del 20 al 22 de ENERO de 2025
                </div>
            </div>
        </div>
    </div>
    
    <!-- Información de correo institucional -->
    <div class="row">
        <div class="col-md-7">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light py-3">
                    <h4 class="mb-0 text-primary"><i class="bi bi-envelope-fill me-2"></i>CORREO INSTITUCIONAL</h4>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-muted">Usuario:</label>
                        <input type="text" class="form-control form-control-lg bg-light" value="<?php echo $correo_institucional; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Contraseña:</label>
                        <input type="text" class="form-control form-control-lg bg-light" value="Bud77684" readonly>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="http://portal.office.com" target="_blank" class="btn btn-primary">
                            <i class="bi bi-box-arrow-up-right me-2"></i>Acceder a Office 365
                        </a>
                    </div>
                    <hr>
                    <div class="alert alert-info mt-3">
                        <p class="mb-0"><i class="bi bi-info-circle-fill me-2"></i>Debes considerar que el uso del correo institucional es <strong>OBLIGATORIO</strong>, ya que es el medio por el cual se pondrán en contacto tus docentes. Además, con esta cuenta podrás descargar Microsoft Office 365 de manera gratuita.</p>
                    </div>
                    <p class="text-muted mt-2">Si tienes alguna duda escribe a <a href="mailto:webmaster@cdvictoria.tecnm.mx">webmaster@cdvictoria.tecnm.mx</a></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-5">
            <!-- Inicio de clases -->
            <div class="card shadow-sm mb-4 bg-primary text-white">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-calendar-check fs-1 mb-3"></i>
                    <h4 class="fw-bold">INICIO DE CLASES</h4>
                    <p class="display-6 fw-bold mb-0">27 DE ENERO DE 2025</p>
                </div>
            </div>
            
            <!-- Otros mensajes -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light py-3">
                    <h4 class="mb-0 text-primary"><i class="bi bi-bell-fill me-2"></i>OTROS MENSAJES</h4>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-warning mb-3">
                        <p class="mb-0">AHORA PUEDES INSCRIBIRTE SI CURSAS 8vo SEMESTRE O POSTERIOR Y NO ALCANZAS EL MÍNIMO DE LOS CRÉDITOS.</p>
                    </div>
                    <div class="alert alert-success">
                        <p class="mb-0"><i class="bi bi-check-circle-fill me-2"></i>Tus Materias Ya Se Encuentran Registradas.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>