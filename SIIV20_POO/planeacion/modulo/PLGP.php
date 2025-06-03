<?php
require_once(CONFIG_PATH . 'bd.php');

class GestionPagos
{
    private $db;
    private const PRECIO_BASE = 3200; // Precio base de reinscripción

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'personal') {
            header('Location: /login.php');
            exit;
        }

        $database = new Database();
        $this->db = $database->getConnection();
        if (!$this->db) {
            die("Error: No se pudo establecer la conexión con la base de datos.");
        }
    }

    private function obtenerBadgePago($estado)
    {
        return $estado ?
            '<span class="badge bg-success">Pagado</span>' :
            '<span class="badge bg-danger">Pendiente</span>';
    }

    private function obtenerBadgeDescuento($descuento)
    {
        if ($descuento > 0) {
            return sprintf('<span class="badge bg-info">%d%% Descuento</span>', $descuento);
        }
        return '<span class="badge bg-secondary">Sin descuento</span>';
    }

    private function calcularTotal($descuento)
    {
        $descuentoDecimal = $descuento / 100;
        $descuentoAplicado = self::PRECIO_BASE * $descuentoDecimal;
        return self::PRECIO_BASE - $descuentoAplicado;
    }

    private function obtenerBadgeTotal($total)
    {
        return sprintf('<span class="badge bg-primary">$%.2f MXN</span>', $total);
    }

    private function obtenerDatos()
    {
        $query = "SELECT 
                    ap.pagos_id,
                    ap.pagos_alumno_id,
                    a.alumno_numero_control,
                    ap.pagos_nombre,
                    ap.pagos_apellido,
                    ap.pagos_carrera,
                    ap.pagos_semestre,
                    ap.pagos_periodo,
                    ap.pagos_realizado,
                    ap.pagos_descuento,
                    ap.pagos_total
                FROM alumnos_pagos ap
                INNER JOIN alumnos a ON ap.pagos_alumno_id = a.alumno_id";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            error_log("Error en la consulta: " . $e->getMessage());
            return false;
        }
    }

    public function renderizar()
    {
        $resultado = $this->obtenerDatos();
        if (!$resultado) {
            echo "<div class='alert alert-danger'>Error al obtener los datos de pagos.</div>";
            return;
        }

        // Obtener todos los datos en un array
        $datos = $resultado->fetchAll(PDO::FETCH_ASSOC);

        // Preparar datos para el dashboard
        $totalAlumnos = 0;
        $alumnosPagados = 0;
        $totalRecaudado = 0;
        $totalDescuentos = 0;
        $descuentosPorcentaje = [];
        $pagosPorCarrera = [];

        foreach ($datos as $fila) {
            $totalAlumnos++;
            if ($fila['pagos_realizado']) {
                $alumnosPagados++;
                $totalRecaudado += $fila['pagos_total'];
            }
            $totalDescuentos += $fila['pagos_descuento'];

            // Conteo de descuentos por porcentaje
            $descuento = $fila['pagos_descuento'];
            $descuentosPorcentaje[$descuento] = ($descuentosPorcentaje[$descuento] ?? 0) + 1;

            // Conteo de pagos por carrera
            $carrera = $fila['pagos_carrera'];
            if (!isset($pagosPorCarrera[$carrera])) {
                $pagosPorCarrera[$carrera] = ['total' => 0, 'pagados' => 0];
            }
            $pagosPorCarrera[$carrera]['total']++;
            if ($fila['pagos_realizado']) {
                $pagosPorCarrera[$carrera]['pagados']++;
            }
        }
?>

        <body>
            <div class="container-fluid py-4">
                <!-- Tarjetas de estadísticas con diseño mejorado -->
                <div class="row g-3 mb-4">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <h6 class="card-title text-muted mb-1">Total Alumnos</h6>
                                        <h2 class="mb-2"><?php echo $totalAlumnos; ?></h2>
                                        <p class="card-text text-success mb-0">
                                            <i class="bi bi-arrow-up me-1"></i>
                                            <span>12% incremento</span>
                                        </p>
                                    </div>
                                    <div class="p-2 bg-primary bg-opacity-10 rounded">
                                        <i class="bi bi-people-fill text-primary fs-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <h6 class="card-title text-muted mb-1">Alumnos Pagados</h6>
                                        <h2 class="mb-2"><?php echo $alumnosPagados; ?></h2>
                                        <p class="card-text text-success mb-0">
                                            <i class="bi bi-arrow-up me-1"></i>
                                            <span>8% incremento</span>
                                        </p>
                                    </div>
                                    <div class="p-2 bg-success bg-opacity-10 rounded">
                                        <i class="bi bi-check-circle text-success fs-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <h6 class="card-title text-muted mb-1">Total Recaudado</h6>
                                        <h2 class="mb-2">$<?php echo number_format($totalRecaudado, 2); ?></h2>
                                        <p class="card-text text-danger mb-0">
                                            <i class="bi bi-arrow-down me-1"></i>
                                            <span>3% decremento</span>
                                        </p>
                                    </div>
                                    <div class="p-2 bg-info bg-opacity-10 rounded">
                                        <i class="bi bi-currency-dollar text-info fs-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <h6 class="card-title text-muted mb-1">Promedio Descuentos</h6>
                                        <h2 class="mb-2"><?php echo number_format($totalDescuentos / $totalAlumnos, 1); ?>%</h2>
                                        <p class="card-text text-success mb-0">
                                            <i class="bi bi-arrow-up me-1"></i>
                                            <span>15% incremento</span>
                                        </p>
                                    </div>
                                    <div class="p-2 bg-warning bg-opacity-10 rounded">
                                        <i class="bi bi-percent text-warning fs-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráficas y Actividades -->
                <div class="row g-4 mb-4">

                    <!-- Gráfica de Estado de Pagos -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="card-subtitle text-muted">Estado de Pagos</h6>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-link text-muted" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Detalles</a></li>
                                            <li><a class="dropdown-item" href="#">Exportar</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="chart-container" style="position: relative; height: 200px;">
                                    <canvas id="pagosPieChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Gráfica de Descuentos -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="card-subtitle text-muted">Distribución de Descuentos</h6>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-link text-muted" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Detalles</a></li>
                                            <li><a class="dropdown-item" href="#">Exportar</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="chart-container" style="position: relative; height: 200px;">
                                    <canvas id="descuentosChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Gráfica de Pagos por Carrera -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="card-subtitle text-muted">Pagos por Carrera</h6>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-link text-muted" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Detalles</a></li>
                                            <li><a class="dropdown-item" href="#">Exportar</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="chart-container" style="position: relative; height: 200px;">
                                    <canvas id="carrerasChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resto del contenido (tabla) -->
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Gestión de Pagos y Descuentos</h3>
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-sm btn-light" id="btnRegistrar" title="Registrar Nuevo Pago">
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
                            <span class="badge bg-light text-primary ms-2">Precio Base: $<?php echo number_format(self::PRECIO_BASE, 2); ?> MXN</span>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="tablaPagos">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Número de Control</th>
                                        <th>Nombre Completo</th>
                                        <th>Carrera</th>
                                        <th>Semestre</th>
                                        <th>Periodo</th>
                                        <th>Descuento</th>
                                        <th>Total a Pagar</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($datos as $fila):
                                        $total = $fila['pagos_total'] ?? $this->calcularTotal($fila['pagos_descuento']);
                                    ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($fila['pagos_id']); ?></td>
                                            <td><?php echo htmlspecialchars($fila['alumno_numero_control']); ?></td>
                                            <td>
                                                <?php echo htmlspecialchars($fila['pagos_nombre'] . ' ' . $fila['pagos_apellido']); ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($fila['pagos_carrera']); ?></td>
                                            <td><?php echo htmlspecialchars($fila['pagos_semestre']); ?></td>
                                            <td><?php echo htmlspecialchars($fila['pagos_periodo']); ?></td>
                                            <td><?php echo $this->obtenerBadgeDescuento($fila['pagos_descuento']); ?></td>
                                            <td><?php echo $this->obtenerBadgeTotal($total); ?></td>
                                            <td><?php echo $this->obtenerBadgePago($fila['pagos_realizado']); ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning editar-registro"
                                                    data-id="<?php echo $fila['pagos_id']; ?>"
                                                    data-descuento="<?php echo $fila['pagos_descuento']; ?>"
                                                    data-total="<?php echo $total; ?>">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger eliminar-registro"
                                                    data-id="<?php echo $fila['pagos_id']; ?>">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Configuración de DataTable
                    const dataTable = new simpleDatatables.DataTable("#tablaPagos", {
                        searchable: true,
                        fixedHeight: true,
                        labels: {
                            placeholder: "Buscar...",
                            perPage: "Registros por página",
                            noRows: "No hay registros para mostrar",
                            info: "Mostrando {start} a {end} de {rows} registros",
                        }
                    });

                    // Agregar evento para calcular total al editar
                    document.querySelectorAll('.editar-registro').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const descuento = parseFloat(this.dataset.descuento);
                            const precioBase = <?php echo self::PRECIO_BASE; ?>;
                            const total = precioBase - (precioBase * (descuento / 100));
                            // Aquí puedes agregar la lógica para actualizar el total en la base de datos
                        });
                    });

                    // Configuración común para todas las gráficas
                    Chart.defaults.font.size = 11;
                    Chart.defaults.plugins.legend.position = 'bottom';
                    Chart.defaults.plugins.legend.labels.boxWidth = 12;
                    Chart.defaults.plugins.legend.labels.padding = 4;

                    // Gráfica de Pie - Estado de Pagos
                    new Chart(document.getElementById('pagosPieChart').getContext('2d'), {
                        type: 'pie',
                        data: {
                            labels: ['Pagados', 'Pendientes'],
                            datasets: [{
                                data: [<?php echo $alumnosPagados; ?>, <?php echo $totalAlumnos - $alumnosPagados; ?>],
                                backgroundColor: ['#198754', '#dc3545']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: true
                                }
                            }
                        }
                    });

                    // Gráfica de Barras - Distribución de Descuentos
                    new Chart(document.getElementById('descuentosChart').getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: <?php echo json_encode(array_keys($descuentosPorcentaje)); ?>,
                            datasets: [{
                                label: 'Número de Alumnos',
                                data: <?php echo json_encode(array_values($descuentosPorcentaje)); ?>,
                                backgroundColor: '#0dcaf0'
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });

                    // Gráfica de Barras - Pagos por Carrera
                    new Chart(document.getElementById('carrerasChart').getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: <?php echo json_encode(array_keys($pagosPorCarrera)); ?>,
                            datasets: [{
                                label: 'Total Alumnos',
                                data: <?php echo json_encode(array_map(function ($c) {
                                            return $c['total'];
                                        }, $pagosPorCarrera)); ?>,
                                backgroundColor: '#0d6efd'
                            }, {
                                label: 'Pagados',
                                data: <?php echo json_encode(array_map(function ($c) {
                                            return $c['pagados'];
                                        }, $pagosPorCarrera)); ?>,
                                backgroundColor: '#198754'
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                });
            </script>
        </body>
<?php
    }
}

$gestionPagos = new GestionPagos();
$gestionPagos->renderizar();
?>