<?php
// Get student data from session or database
$studentData = [
    'control_number' => '20380597',
    'full_name' => 'ANGEL URIEL DOMÍNGUEZ MEDINA',
    'email' => 'L20380597@cdvictoria.tecnm.mx',
    'password' => 'Bud77684'
];
?>
<meta name="mb_post_title" content="inicio de session">

<div class="container mt-4 text-center">
    <!-- Welcome Section -->
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title text-primary">
                <i class="bi bi-person-circle me-2"></i>Bienvenido(a)
            </h2>
            <h3 class="text-secondary"><?php echo $studentData['control_number']; ?></h3>
            <h4 class="text-dark"><?php echo $studentData['full_name']; ?></h4>
            
            <div class="alert alert-success mt-3">
                <i class="bi bi-check-circle-fill me-2"></i>SIN ADEUDOS A LA FECHA
            </div>
            
            <div class="alert alert-info">
                <h5>PROCESO DE REINSCRIPCIÓN ENERO-JUNIO 2025</h5>
                <p>¡BIENVENIDO NUEVAMENTE A ESTA TU CASA DE ESTUDIOS!</p>
            </div>
        </div>
    </div>

    <!-- Steps Section -->
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title text-primary">
                <i class="bi bi-list-check me-2"></i>PASOS A SEGUIR
            </h4>
            
            <div class="steps mt-3">
                <div class="step mb-4">
                    <h5><span class="badge bg-primary me-2">PASO 1</span>Revisión de Adeudos</h5>
                    <p>Revisa el menu INSCRIPCIONES -> Horarios Reinscripción, para saber si tienes adeudos.
                    Acude a solventarlos al menos un día antes de tu inscripción para evitar contratiempos.</p>
                </div>

                <div class="step mb-4">
                    <h5><span class="badge bg-primary me-2">PASO 2</span>Pago de Reinscripción</h5>
                    <p>Imprime la ficha de depósito en la sección CONCEPTOS DE COBRO.</p>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>IMPORTANTE:</strong> El pago de reinscripción deberá realizarse como máximo 1 día antes de acuerdo con el calendario de las fechas establecidas de reinscripción por carrera o programa, de lo contrario no podrán seleccionar el horario en la fecha establecida para reinscripción.
                    </div>
                </div>

                <div class="step mb-4">
                    <h5><span class="badge bg-primary me-2">PASO 3</span>Selección de Horario</h5>
                    <p>Los horarios ya se encuentran disponibles en la sección (INSCRIPCIONES -> GRUPOS DISPONIBLES) para que elabores tu prehorario; posteriormente, accede al SII en la fecha y hora indicada (en el PASO 1), selecciona tus materias y registra tu horario.</p>
                    <p class="text-primary"><strong>Fechas de Reinscripción: del 20 al 22 de ENERO de 2025</strong></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Institutional Email Section -->
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title text-primary">
                <i class="bi bi-envelope-fill me-2"></i>CORREO INSTITUCIONAL
            </h4>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Usuario:</strong> <?php echo $studentData['email']; ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Contraseña:</strong> <?php echo $studentData['password']; ?></p>
                </div>
            </div>
            <p>Accede desde <a href="http://portal.office.com" target="_blank">http://portal.office.com</a></p>
            <div class="alert alert-info">
                <p>Debes considerar que el uso del correo institucional es OBLIGATORIO, ya que es el medio por el cual se pondrán en contacto tus docentes. Además, con esta cuenta podrás descargar Microsoft Office 365 de manera gratuita.</p>
                <p>Si tienes alguna duda escribe a <a href="mailto:webmaster@cdvictoria.tecnm.mx">webmaster@cdvictoria.tecnm.mx</a></p>
            </div>
        </div>
    </div>

    <!-- Important Dates and Messages -->
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="text-primary mb-4">INICIO DE CLASES: 27 DE ENERO DE 2025</h4>
            
            <h5 class="text-secondary">OTROS MENSAJES</h5>
            <ul class="list-group">
                <li class="list-group-item">
                    <i class="bi bi-info-circle-fill me-2 text-primary"></i>
                    AHORA PUEDES INSCRIBIRTE SI CURSAS 8vo SEMESTRE O POSTERIOR Y NO ALCANZAS EL MÍNIMO DE LOS CRÉDITOS.
                </li>
                <li class="list-group-item">
                    <i class="bi bi-check-circle-fill me-2 text-success"></i>
                    Tus Materias Ya Se Encuentran Registradas.
                </li>
            </ul>
        </div>
    </div>
</div>