<?php
require_once(GESTION_ACADEMICOS_PATH . 'academico_mostrar.php');

class GestionAcademica
{
    private $academicoMostrar;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'personal') {
            header('Location: /login.php');
            exit;
        }

        $this->academicoMostrar = new AcademicoMostrar();
    }

    public function renderizar()
    {
        $resultado = $this->academicoMostrar->obtenerDatos();
        if (!$resultado) {
            echo "<div class='alert alert-danger'>Error al obtener los datos académicos.</div>";
            return;
        }

        $estadisticas = $this->academicoMostrar->obtenerEstadisticas($resultado);
        $resultado->execute();
        $alumnos = $this->academicoMostrar->obtenerAlumnos();
        $carreras = $this->academicoMostrar->obtenerCarreras();
?>

<div class="container py-4" style="max-width: 1400px;">
    <div class="card mb-4">
        <div class="accordion-item">
            <h2 class="accordion-header" id="estadisticasHeader">
                <button class="accordion-button bg-primary text-white fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#estadisticasCollapse" aria-expanded="true" aria-controls="estadisticasCollapse">
                    Estadísticas Académicas
                </button>
            </h2>
        </div>
        <div id="estadisticasCollapse" class="collapse show">
            <div class="card-body">
                <div class="row g-3 mb-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="card h-100 border-primary">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <h6 class="card-title text-muted mb-1">Total Alumnos</h6>
                                        <h2 class="mb-2"><?php echo $estadisticas['totalAlumnos']; ?></h2>
                                        <p class="card-text text-success mb-0">
                                            <i class="bi bi-arrow-up me-1"></i>
                                            <span>Activos en sistema</span>
                                        </p>
                                    </div>
                                    <div class="p-2 bg-primary bg-opacity-10 rounded">
                                        <i class="bi bi-people-fill text-primary fs-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card h-100 border-success">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <h6 class="card-title text-muted mb-1">Promedio General</h6>
                                        <h2 class="mb-2"><?php echo $estadisticas['promedioGeneral']; ?></h2>
                                        <p class="card-text text-success mb-0">
                                            <i class="bi bi-arrow-up me-1"></i>
                                            <span>Rendimiento académico</span>
                                        </p>
                                    </div>
                                    <div class="p-2 bg-success bg-opacity-10 rounded">
                                        <i class="bi bi-graph-up text-success fs-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card h-100 border-info">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="flex-grow-1 me-2">
                                        <h6 class="card-title text-muted mb-1">Por Semestre</h6>
                                        <div style="max-height: 90px; overflow-y: auto; padding-right: 5px;">
                                            <?php foreach ($estadisticas['alumnosPorSemestre'] as $semestre => $cantidad): ?>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <small class="text-truncate" style="max-width: 70px;">Sem. <?php echo $semestre; ?></small>
                                                    <span class="badge bg-info text-white" style="font-size: 0.7rem;"><?php echo $cantidad; ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="p-2 bg-info bg-opacity-10 rounded align-self-start">
                                        <i class="bi bi-bar-chart text-info fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card h-100 border-warning">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="flex-grow-1 me-2">
                                        <h6 class="card-title text-muted mb-1">Por Carrera</h6>
                                        <div style="max-height: 90px; overflow-y: auto; padding-right: 5px;">
                                            <?php foreach ($estadisticas['alumnosPorCarrera'] as $carrera => $cantidad): 
                                                $claveCarrera = isset($estadisticas['clavesCarreras'][$carrera]) 
                                                    ? $estadisticas['clavesCarreras'][$carrera] 
                                                    : substr($carrera, 0, 3);
                                            ?>
                                                <div class="d-flex justify-content-between align-items-center mb-1" title="<?php echo htmlspecialchars($carrera); ?>">
                                                    <small class="text-truncate fw-bold" style="max-width: 70px; font-size: 0.75rem;"><?php echo htmlspecialchars($claveCarrera); ?></small>
                                                    <span class="badge bg-warning text-dark" style="font-size: 0.7rem;"><?php echo $cantidad; ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="p-2 bg-warning bg-opacity-10 rounded align-self-start">
                                        <i class="bi bi-mortarboard text-warning fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mt-5">
        <div class="card-header bg-primary text-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h3 class="card-title mb-0">Gestión de Información Académica</h3>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-md-end gap-2 flex-wrap">
                        <button class="btn btn-sm btn-light" id="btnRegistrarAcademico" title="Registrar Nueva Información Académica">
                            <i class="bi bi-plus-circle"></i> Registrar
                        </button>
                        <button class="btn btn-sm btn-light" id="btnExcel" title="Exportar a Excel">
                            <i class="bi bi-file-earmark-excel"></i>
                        </button>
                        <button class="btn btn-sm btn-light" id="btnPDF" title="Exportar a PDF">
                            <i class="bi bi-file-earmark-pdf"></i>
                        </button>
                        <button class="btn btn-sm btn-light" id="btnImprimir" title="Imprimir">
                            <i class="bi bi-printer"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="tablaAcademica">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ID Alumno</th>
                            <th>Número de Control</th>
                            <th>Carrera</th>
                            <th>Semestre</th>
                            <th>Periodo</th>
                            <th>Promedio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($fila['academica_id']); ?></td>
                                <td><?php echo htmlspecialchars($fila['academica_alumno_id']); ?></td>
                                <td><?php echo htmlspecialchars($fila['alumno_numero_control']); ?></td>
                                <td><?php echo htmlspecialchars($fila['carrera_nombre_completo']); ?></td>
                                <td><?php echo htmlspecialchars($fila['academica_semestre']); ?></td>
                                <td><?php echo htmlspecialchars($fila['academica_periodo']); ?></td>
                                <td><?php echo htmlspecialchars($fila['academica_promedio']); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-warning editar-registro"
                                        data-id="<?php echo $fila['academica_id']; ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger eliminar-registro"
                                        data-id="<?php echo $fila['academica_id']; ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
window.alumnos = <?php echo json_encode($alumnos); ?>;
window.carreras = <?php echo json_encode($carreras); ?>;

console.log('Alumnos cargados:', window.alumnos);
console.log('Carreras cargadas:', window.carreras);

function mostrarAlerta(mensaje, tipo = 'info') {
    const alertaDiv = document.createElement('div');
    alertaDiv.className = `alert alert-${tipo} alert-dismissible fade show`;
    alertaDiv.innerHTML = `
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    const container = document.querySelector('.container');
    if (container) {
        container.insertBefore(alertaDiv, container.firstChild);
        
        setTimeout(() => {
            if (alertaDiv.parentNode) {
                alertaDiv.remove();
            }
        }, 5000);
    }
}

function buscarAlumnoPorNumeroControl(numeroControl) {
    console.log('Buscando alumno con número de control:', numeroControl);
    console.log('Array de alumnos disponible:', window.alumnos);
    
    if (!window.alumnos || !Array.isArray(window.alumnos)) {
        console.error('Array de alumnos no está disponible');
        mostrarAlerta('Error: Los datos de alumnos no están disponibles', 'danger');
        return null;
    }
    
    if (!numeroControl || numeroControl.trim() === '') {
        console.log('Número de control vacío');
        return null;
    }
    
    const numeroLimpio = numeroControl.toString().trim();
    console.log('Número de control limpio:', numeroLimpio);
    
    const alumnoEncontrado = window.alumnos.find(alumno => {
        const numeroAlumno = alumno.alumno_numero_control ? alumno.alumno_numero_control.toString().trim() : '';
        console.log('Comparando:', numeroLimpio, 'con', numeroAlumno);
        return numeroAlumno === numeroLimpio;
    });
    
    if (alumnoEncontrado) {
        console.log('Alumno encontrado:', alumnoEncontrado);
        return alumnoEncontrado;
    } else {
        console.log('No se encontró alumno con número de control:', numeroLimpio);
        mostrarAlerta('No se encontró un alumno con ese número de control', 'warning');
        return null;
    }
}

function limpiarFormularioModal() {
    const inputs = document.querySelectorAll('#modalRegistrarAcademica input, #modalRegistrarAcademica select');
    inputs.forEach(input => {
        if (input.type === 'hidden') return;
        input.value = '';
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const dataTable = new simpleDatatables.DataTable("#tablaAcademica", {
        searchable: true,
        fixedHeight: true,
        labels: {
            placeholder: "Buscar...",
            perPage: "Registros por página",
            noRows: "No hay registros para mostrar",
            info: "Mostrando {start} a {end} de {rows} registros",
        }
    });

    if (typeof initializeExportFunctions === 'function') {
        initializeExportFunctions('tablaAcademica', 'gestion-informacion-academica');
    }

    // Botón Registrar
    const btnRegistrarAcademico = document.getElementById('btnRegistrarAcademico');
    if (btnRegistrarAcademico) {
        btnRegistrarAcademico.addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('modalRegistrarAcademica'));
            modal.show();
        });
    }

    const botonesEditar = document.querySelectorAll('.editar-registro');
    botonesEditar.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const row = this.closest('tr');
            
            const cells = row.querySelectorAll('td');
            const academicaId = cells[0].textContent.trim();
            const alumnoId = cells[1].textContent.trim();
            const numeroControl = cells[2].textContent.trim();
            const carrera = cells[3].textContent.trim();
            const semestre = cells[4].textContent.trim();
            const periodo = cells[5].textContent.trim();
            const promedio = cells[6].textContent.trim();
            
            const editId = document.getElementById('editId');
            const numeroControlSpan = document.getElementById('editNumeroControl');
            const nombreAlumnoSpan = document.getElementById('editNombreAlumno');
            const registroIdSpan = document.getElementById('editRegistroId');
            const editSemestre = document.getElementById('editSemestre');
            const editPeriodo = document.getElementById('editPeriodo');
            const editPromedio = document.getElementById('editPromedio');
            
            if (editId) editId.value = academicaId;
            if (numeroControlSpan) numeroControlSpan.textContent = numeroControl;
            if (nombreAlumnoSpan) nombreAlumnoSpan.textContent = `ID: ${alumnoId}`;
            if (registroIdSpan) registroIdSpan.textContent = academicaId;
            if (editSemestre) editSemestre.value = semestre;
            if (editPeriodo) editPeriodo.value = periodo;
            if (editPromedio) editPromedio.value = promedio;
            
            const selectCarrera = document.getElementById('editCarrera');
            if (selectCarrera) {
                const options = selectCarrera.querySelectorAll('option');
                options.forEach(option => {
                    if (option.textContent.includes(carrera)) {
                        option.selected = true;
                    }
                });
            }
            
            console.log('Editando registro - Número de Control:', numeroControl);
            const modal = new bootstrap.Modal(document.getElementById('modalEditarAcademica'));
            modal.show();
        });
    });

    const botonesEliminar = document.querySelectorAll('.eliminar-registro');
    botonesEliminar.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const row = this.closest('tr');
            
            const cells = row.querySelectorAll('td');
            const academicaId = cells[0].textContent.trim();
            const alumnoId = cells[1].textContent.trim();
            const numeroControl = cells[2].textContent.trim();
            const carrera = cells[3].textContent.trim();
            const semestre = cells[4].textContent.trim();
            const periodo = cells[5].textContent.trim();
            const promedio = cells[6].textContent.trim();
            
            const eliminarId = document.getElementById('eliminarId');
            const eliminarNumero = document.getElementById('eliminarNumero');
            const eliminarNombre = document.getElementById('eliminarNombre');
            const eliminarCarrera = document.getElementById('eliminarCarrera');
            const eliminarPromedio = document.getElementById('eliminarPromedio');
            const eliminarSemestre = document.getElementById('eliminarSemestre');
            const eliminarPeriodo = document.getElementById('eliminarPeriodo');
            const eliminarRegistroId = document.getElementById('eliminarRegistroId');
            
            if (eliminarId) eliminarId.value = academicaId;
            if (eliminarNumero) eliminarNumero.textContent = numeroControl;
            if (eliminarNombre) eliminarNombre.textContent = `ID Alumno: ${alumnoId}`;
            if (eliminarCarrera) eliminarCarrera.textContent = carrera;
            if (eliminarPromedio) eliminarPromedio.textContent = promedio;
            if (eliminarSemestre) eliminarSemestre.textContent = `${semestre}° Semestre`;
            if (eliminarPeriodo) eliminarPeriodo.textContent = periodo;
            if (eliminarRegistroId) eliminarRegistroId.textContent = academicaId;
            
            console.log('Eliminando registro - Número de Control:', numeroControl);
            const modal = new bootstrap.Modal(document.getElementById('modalEliminarAcademica'));
            modal.show();
        });
    });
});
</script>

<?php
require_once(PRIVATE_PATH . 'modales/modal_planeacion/gestion_academica/modal_registrar.php');
require_once(PRIVATE_PATH . 'modales/modal_planeacion/gestion_academica/modal_editar.php');
require_once(PRIVATE_PATH . 'modales/modal_planeacion/gestion_academica/modal_eliminar.php');
?>

<?php
    }
}

$gestionAcademica = new GestionAcademica();
$gestionAcademica->renderizar();
?>