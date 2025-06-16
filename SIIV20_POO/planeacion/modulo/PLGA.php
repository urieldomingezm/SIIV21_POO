<?php
require_once(CONFIG_PATH . 'bd.php');

class GestionAcademica
{
    private $db;

    public function __construct()
    {
        // Verificar sesión
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar autenticación
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'personal') {
            header('Location: /login.php');
            exit;
        }

        // Inicializar conexión usando la clase Database
        $database = new Database();
        $this->db = $database->getConnection();
        if (!$this->db) {
            die("Error: No se pudo establecer la conexión con la base de datos.");
        }
    }

    private function obtenerDatos()
    {
        $query = "SELECT 
                    aia.academica_id,
                    aia.academica_alumno_id,
                    a.alumno_numero_control,
                    ci.carrera_nombre_completo,
                    ci.carrera_clave,
                    aia.academica_semestre,
                    aia.academica_periodo,
                    aia.academica_promedio
                FROM alumnos_info_academica aia
                INNER JOIN alumnos a ON aia.academica_alumno_id = a.alumno_id
                INNER JOIN carreras_institucion ci ON aia.academica_carrera_id = ci.carrera_id";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            error_log("Error en la consulta: " . $e->getMessage());
            return false;
        }
    }

    private function obtenerEstadisticas($resultado)
    {
        $totalAlumnos = 0;
        $alumnosPorSemestre = [];
        $alumnosPorCarrera = [];
        $clavesCarreras = []; // Array para almacenar las claves oficiales
        $promedioGeneral = 0;
        $totalPromedios = 0;

        while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $totalAlumnos++;
            $totalPromedios += $fila['academica_promedio'];

            // Conteo por semestre
            $semestre = $fila['academica_semestre'];
            if (!isset($alumnosPorSemestre[$semestre])) {
                $alumnosPorSemestre[$semestre] = 0;
            }
            $alumnosPorSemestre[$semestre]++;

            // Conteo por carrera y almacenar claves oficiales
            $carrera = $fila['carrera_nombre_completo'];
            $claveCarrera = $fila['carrera_clave'];
            
            if (!isset($alumnosPorCarrera[$carrera])) {
                $alumnosPorCarrera[$carrera] = 0;
                // Almacenar la clave oficial de la carrera
                $clavesCarreras[$carrera] = $claveCarrera;
            }
            $alumnosPorCarrera[$carrera]++;
        }

        $promedioGeneral = $totalAlumnos > 0 ? round($totalPromedios / $totalAlumnos, 2) : 0;

        return [
            'totalAlumnos' => $totalAlumnos,
            'alumnosPorSemestre' => $alumnosPorSemestre,
            'alumnosPorCarrera' => $alumnosPorCarrera,
            'clavesCarreras' => $clavesCarreras, // Incluir las claves oficiales
            'promedioGeneral' => $promedioGeneral
        ];
    }

    private function obtenerAlumnos()
    {
        // Consulta corregida sin GROUP BY innecesario
        $query = "SELECT 
                ap.pagos_alumno_id as alumno_id,
                ap.pagos_numero_control as alumno_numero_control,
                CONCAT(ap.pagos_nombre, ' ', ap.pagos_apellido) as nombre_completo,
                ci.carrera_nombre_completo,
                ci.carrera_clave,
                aia.academica_semestre,
                aia.academica_periodo,
                aia.academica_promedio
            FROM alumnos_pagos ap
            LEFT JOIN alumnos a ON ap.pagos_numero_control = a.alumno_numero_control
            LEFT JOIN alumnos_info_academica aia ON a.alumno_id = aia.academica_alumno_id
            LEFT JOIN carreras_institucion ci ON aia.academica_carrera_id = ci.carrera_id
            WHERE ap.pagos_numero_control IS NOT NULL
            ORDER BY ap.pagos_numero_control";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Debug: Mostrar los datos obtenidos
            error_log('Alumnos obtenidos desde alumnos_pagos: ' . count($result) . ' registros');
            
            return $result;
        } catch (PDOException $e) {
            error_log("Error al obtener alumnos: " . $e->getMessage());
            return [];
        }
    }

    private function obtenerCarreras()
    {
        $query = "SELECT carrera_id, carrera_clave, carrera_nombre_completo FROM carreras_institucion ORDER BY carrera_nombre_completo";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener carreras: " . $e->getMessage());
            return [];
        }
    }

    public function renderizar()
    {
        $resultado = $this->obtenerDatos();
        if (!$resultado) {
            echo "<div class='alert alert-danger'>Error al obtener los datos académicos.</div>";
            return;
        }

        // Obtener estadísticas
        $estadisticas = $this->obtenerEstadisticas($resultado);
        $resultado->execute(); // Reiniciar el cursor para la tabla

        // Obtener datos para los modales
        $alumnos = $this->obtenerAlumnos();
        $carreras = $this->obtenerCarreras();
?>

<div class="container py-4" style="max-width: 1400px;">
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <button class="btn btn-link w-100 text-start text-white fw-bold text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#estadisticasCollapse">
                   Estadísticas Académicas
                </button>
            </h5>
        </div>
        <div id="estadisticasCollapse" class="collapse show">
            <div class="card-body">
                <!-- Tarjetas de estadísticas mejoradas -->
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
                                                // Usar la clave oficial de la carrera
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

    <!-- Tabla mejorada -->
    <div class="card shadow mt-5">
        <div class="card-header bg-primary text-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h3 class="card-title mb-0">Gestión de Información Académica</h3>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-md-end gap-2 flex-wrap">
                        <button class="btn btn-sm btn-light" id="btnRegistrar" title="Registrar Nueva Información">
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

<!-- Pasar datos a JavaScript usando vanilla JS -->
<script>
// Datos globales para los modales (vanilla JS)
window.alumnos = <?php echo json_encode($alumnos); ?>;
window.carreras = <?php echo json_encode($carreras); ?>;

// Debug: Verificar que los datos se cargaron correctamente
console.log('Alumnos cargados:', window.alumnos);
console.log('Carreras cargadas:', window.carreras);

// Función para mostrar alertas (vanilla JS)
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
        
        // Auto-remover después de 5 segundos
        setTimeout(() => {
            if (alertaDiv.parentNode) {
                alertaDiv.remove();
            }
        }, 5000);
    }
}

// Función para buscar alumno por número de control (vanilla JS)
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

// Función para limpiar formulario del modal (vanilla JS)
function limpiarFormularioModal() {
    const inputs = document.querySelectorAll('#modalRegistrarAcademica input, #modalRegistrarAcademica select');
    inputs.forEach(input => {
        if (input.type === 'hidden') return;
        input.value = '';
    });
}

// Inicialización cuando el DOM esté listo (vanilla JS)
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar DataTable
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

    // Inicializar funciones de exportación
    if (typeof initializeExportFunctions === 'function') {
        initializeExportFunctions('tablaAcademica', 'gestion-informacion-academica');
    }

    // Event listener para el botón Registrar (vanilla JS)
    const btnRegistrar = document.getElementById('btnRegistrar');
    if (btnRegistrar) {
        btnRegistrar.addEventListener('click', function() {
            limpiarFormularioModal();
            const modal = new bootstrap.Modal(document.getElementById('modalRegistrarAcademica'));
            modal.show();
        });
    }

    // Event listeners para botones Editar (vanilla JS)
    const botonesEditar = document.querySelectorAll('.editar-registro');
    botonesEditar.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const row = this.closest('tr');
            
            // Obtener datos de la fila
            const cells = row.querySelectorAll('td');
            const academicaId = cells[0].textContent.trim();
            const alumnoId = cells[1].textContent.trim();
            const numeroControl = cells[2].textContent.trim();
            const carrera = cells[3].textContent.trim();
            const semestre = cells[4].textContent.trim();
            const periodo = cells[5].textContent.trim();
            const promedio = cells[6].textContent.trim();
            
            // Llenar el modal de edición
            const editId = document.getElementById('editId');
            const numeroControlSpan = document.getElementById('numeroControl');
            const nombreAlumnoSpan = document.getElementById('nombreAlumno');
            const editSemestre = document.getElementById('editSemestre');
            const editPeriodo = document.getElementById('editPeriodo');
            const editPromedio = document.getElementById('editPromedio');
            
            if (editId) editId.value = academicaId;
            if (numeroControlSpan) numeroControlSpan.textContent = numeroControl;
            if (nombreAlumnoSpan) nombreAlumnoSpan.textContent = `ID: ${alumnoId}`;
            if (editSemestre) editSemestre.value = semestre;
            if (editPeriodo) editPeriodo.value = periodo;
            if (editPromedio) editPromedio.value = promedio;
            
            // Buscar y seleccionar la carrera en el select por nombre completo
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

    // Event listeners para botones Eliminar (vanilla JS)
    const botonesEliminar = document.querySelectorAll('.eliminar-registro');
    botonesEliminar.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const row = this.closest('tr');
            
            // Obtener datos de la fila
            const cells = row.querySelectorAll('td');
            const academicaId = cells[0].textContent.trim();
            const alumnoId = cells[1].textContent.trim();
            const numeroControl = cells[2].textContent.trim();
            const carrera = cells[3].textContent.trim();
            const semestre = cells[4].textContent.trim();
            const periodo = cells[5].textContent.trim();
            const promedio = cells[6].textContent.trim();
            
            // Llenar el modal de eliminación
            const eliminarId = document.getElementById('eliminarId');
            const eliminarNumero = document.getElementById('eliminarNumero');
            const eliminarNombre = document.getElementById('eliminarNombre');
            const eliminarCarrera = document.getElementById('eliminarCarrera');
            const eliminarPromedio = document.getElementById('eliminarPromedio');
            const eliminarSemestre = document.getElementById('eliminarSemestre');
            const eliminarPeriodo = document.getElementById('eliminarPeriodo');
            
            if (eliminarId) eliminarId.value = academicaId;
            if (eliminarNumero) eliminarNumero.textContent = numeroControl;
            if (eliminarNombre) eliminarNombre.textContent = `ID Alumno: ${alumnoId}`;
            if (eliminarCarrera) eliminarCarrera.textContent = carrera;
            if (eliminarPromedio) eliminarPromedio.textContent = promedio;
            if (eliminarSemestre) eliminarSemestre.textContent = `${semestre}° Semestre`;
            if (eliminarPeriodo) eliminarPeriodo.textContent = periodo;
            
            console.log('Eliminando registro - Número de Control:', numeroControl);
            const modal = new bootstrap.Modal(document.getElementById('modalEliminarAcademica'));
            modal.show();
        });
    });
});
</script>

<?php
// Incluir los modales
require_once('modales/modal_registrar_usuario.php');
require_once('modales/modal_editar_usuario.php');
require_once('modales/modal_eliminar_usuario.php');
?>

<?php
    }
}

$gestionAcademica = new GestionAcademica();
$gestionAcademica->renderizar();
?>