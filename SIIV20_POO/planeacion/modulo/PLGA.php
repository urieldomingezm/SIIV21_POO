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

            // Conteo por carrera
            $carrera = $fila['carrera_nombre_completo'];
            if (!isset($alumnosPorCarrera[$carrera])) {
                $alumnosPorCarrera[$carrera] = 0;
            }
            $alumnosPorCarrera[$carrera]++;
        }

        $promedioGeneral = $totalAlumnos > 0 ? round($totalPromedios / $totalAlumnos, 2) : 0;

        return [
            'totalAlumnos' => $totalAlumnos,
            'alumnosPorSemestre' => $alumnosPorSemestre,
            'alumnosPorCarrera' => $alumnosPorCarrera,
            'promedioGeneral' => $promedioGeneral
        ];
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
?>

        <body>
            <div class="container mt-5">
                <!-- Dashboard -->
                <div class="row g-3 mb-4">
                    <!-- Total de Alumnos -->
                    <div class="col-md-3">
                        <div class="card bg-primary text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title mb-0">Total Alumnos</h6>
                                        <h2 class="mb-0"><?php echo $estadisticas['totalAlumnos']; ?></h2>
                                    </div>
                                    <i class="bi bi-people fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Promedio General -->
                    <div class="col-md-3">
                        <div class="card bg-success text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title mb-0">Promedio General</h6>
                                        <h2 class="mb-0"><?php echo $estadisticas['promedioGeneral']; ?></h2>
                                    </div>
                                    <i class="bi bi-graph-up fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Distribución por Semestre -->
                    <div class="col-md-3">
                        <div class="card bg-info text-white h-100">
                            <div class="card-body">
                                <h6 class="card-title">Alumnos por Semestre</h6>
                                <div style="max-height: 100px; overflow-y: auto;">
                                    <?php foreach ($estadisticas['alumnosPorSemestre'] as $semestre => $cantidad): ?>
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <small>Semestre <?php echo $semestre; ?></small>
                                            <span class="badge bg-white text-info"><?php echo $cantidad; ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Distribución por Carrera -->
                    <div class="col-md-3">
                        <div class="card bg-warning text-dark h-100">
                            <div class="card-body">
                                <h6 class="card-title">Alumnos por Carrera</h6>
                                <div style="max-height: 100px; overflow-y: auto;">
                                    <?php foreach ($estadisticas['alumnosPorCarrera'] as $carrera => $cantidad): ?>
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <small><?php echo substr($carrera, 0, 20) . '...'; ?></small>
                                            <span class="badge bg-white text-warning"><?php echo $cantidad; ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla existente -->
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Gestión de Información Académica</h3>
                        <div class="d-flex align-items-center gap-2">
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
                });
            </script>
        </body>
<?php
    }
}

$gestionAcademica = new GestionAcademica();
$gestionAcademica->renderizar();
?>