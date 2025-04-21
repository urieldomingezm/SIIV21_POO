<?php
class ReticularProgress
{
    private $studentData = [
        'control_number' => '20380597',
        'name' => 'DOMÍNGUEZ MEDINA ANGEL URIEL',
        'semester' => '10',
        'period' => 'ENE-JUN/2025',
        'average' => '75.82',
        'career' => 'INGENIERÍA INFORMATICA',
        'specialty' => 'TECNOLOGÍAS BASADAS EN LA NUBE PARA EL ANÁLISIS DE'
    ];

    private $subjects = [
        1 => [ // Primer Semestre
            [
                'code' => 'J111',
                'name' => 'FUNDAMENTOS DE INVESTIGACION',
                'status' => 'OO',
                'grade' => '82',
                'credits' => 4,
                'prerequisite' => null
            ],
            [
                'code' => 'J113',
                'name' => 'FUNDAMENTOS DE PROGRAMACION',
                'status' => 'OO',
                'grade' => '100',
                'credits' => 5,
                'prerequisite' => null
            ],
            [
                'code' => 'J114',
                'name' => 'TALLER DE ETICA',
                'status' => 'OO',
                'grade' => '100',
                'credits' => 4,
                'prerequisite' => null
            ],
            [
                'code' => 'J115',
                'name' => 'CALCULO DIFERENCIAL',
                'status' => 'OO',
                'grade' => '88',
                'credits' => 5,
                'prerequisite' => null
            ],
            [
                'code' => 'J121',
                'name' => 'ADMINISTRACION PARA INFORMATICA',
                'status' => 'OO',
                'grade' => '90',
                'credits' => 4,
                'prerequisite' => null
            ],
            [
                'code' => 'J166',
                'name' => 'DESARROLLO SUSTENTABLE',
                'status' => 'OO',
                'grade' => '97',
                'credits' => 5,
                'prerequisite' => null
            ]
        ],
        2 => [
            ['code' => 'J141', 'name' => 'ADM. DE LOS RECUR. Y FUNCIÓN I', 'status' => 'OO', 'grade' => '92'],
            ['code' => 'J122', 'name' => 'FISICA PARA INFORMATICA', 'status' => 'OO', 'grade' => '90'],
            ['code' => 'J123', 'name' => 'PROGRAMACION ORIENTADA A OBJET', 'status' => 'OO', 'grade' => '97'],
            ['code' => 'J124', 'name' => 'CONTABILIDAD FINANCIERA', 'status' => 'OO', 'grade' => '100'],
            ['code' => 'J125', 'name' => 'CALCULO INTEGRAL', 'status' => 'OO', 'grade' => '90'],
        ],
        3 => [
            ['code' => 'J131', 'name' => 'ALGEBRA LINEAL', 'status' => 'OO', 'grade' => '95'],
            ['code' => 'J132', 'name' => 'ESTRUCTURA DE DATOS', 'status' => 'OO', 'grade' => '88'],
            ['code' => 'J133', 'name' => 'MATEMATICAS DISCRETAS', 'status' => 'OO', 'grade' => '92'],
            ['code' => 'J134', 'name' => 'PROBABILIDAD Y ESTADISTICA', 'status' => 'OO', 'grade' => '87'],
            ['code' => 'J135', 'name' => 'SISTEMAS OPERATIVOS', 'status' => 'OO', 'grade' => '94'],
        ],
        4 => [
            ['code' => 'J141', 'name' => 'INVESTIGACION DE OPERACIONES', 'status' => 'OO', 'grade' => '89'],
            ['code' => 'J142', 'name' => 'FUNDAMENTOS DE BASE DE DATOS', 'status' => 'OO', 'grade' => '96'],
            ['code' => 'J143', 'name' => 'SIMULACION', 'status' => 'OO', 'grade' => '91'],
            ['code' => 'J144', 'name' => 'ARQUITECTURA DE COMPUTADORAS', 'status' => 'OO', 'grade' => '88'],
            ['code' => 'J145', 'name' => 'PROGRAMACION WEB', 'status' => 'OO', 'grade' => '95'],
        ],
        5 => [
            ['code' => 'J151', 'name' => 'ANALISIS DE SEÑALES', 'status' => 'OO', 'grade' => '87'],
            ['code' => 'J152', 'name' => 'REDES DE COMPUTADORAS', 'status' => 'OO', 'grade' => '93'],
            ['code' => 'J153', 'name' => 'TALLER DE BASE DE DATOS', 'status' => 'OO', 'grade' => '94'],
            ['code' => 'J154', 'name' => 'INGENIERIA DE SOFTWARE', 'status' => 'OO', 'grade' => '92'],
            ['code' => 'J155', 'name' => 'LENGUAJES Y AUTOMATAS I', 'status' => 'OO', 'grade' => '88'],
        ],
        6 => [
            ['code' => 'J161', 'name' => 'LENGUAJES Y AUTOMATAS II', 'status' => 'OO', 'grade' => '91'],
            ['code' => 'J162', 'name' => 'CONMUTACION Y ENRUTAMIENTO', 'status' => 'OO', 'grade' => '89'],
            ['code' => 'J163', 'name' => 'TALLER DE INGENIERIA SOFTWARE', 'status' => 'OO', 'grade' => '95'],
            ['code' => 'J164', 'name' => 'SISTEMAS PROGRAMABLES', 'status' => 'OO', 'grade' => '87'],
            ['code' => 'J165', 'name' => 'PROGRAMACION LOGICA Y FUNCIONAL', 'status' => 'OO', 'grade' => '90'],
        ],
        7 => [
            ['code' => 'J171', 'name' => 'INTELIGENCIA ARTIFICIAL', 'status' => 'OO', 'grade' => '93'],
            ['code' => 'J172', 'name' => 'ADMINISTRACION DE REDES', 'status' => 'OO', 'grade' => '88'],
            ['code' => 'J173', 'name' => 'DESARROLLO DE APLICACIONES', 'status' => 'OO', 'grade' => '94'],
            ['code' => 'J174', 'name' => 'SISTEMAS DISTRIBUIDOS', 'status' => 'OO', 'grade' => '91'],
        ],
        8 => [
            ['code' => 'J181', 'name' => 'COMPUTO EN LA NUBE', 'status' => 'OO', 'grade' => '92'],
            ['code' => 'J182', 'name' => 'ANALISIS DE DATOS', 'status' => 'OO', 'grade' => '89'],
            ['code' => 'J183', 'name' => 'DESARROLLO MOVIL NATIVO', 'status' => 'OO', 'grade' => '95'],
        ],
        9 => [
            ['code' => 'J191', 'name' => 'SERVICIO SOCIAL', 'status' => 'OO', 'grade' => '100'],
            ['code' => 'J192', 'name' => 'RESIDENCIAS PROFESIONALES', 'status' => 'RO', 'grade' => '0'],
        ]
    ];

    private $colorCodes = [
        'OO' => 'bg-success text-white', // Acreditada
        'RO' => 'bg-info text-white',    // Cursando
        'RP' => 'bg-warning',            // Cursada Sin Acreditar
        'OC' => 'bg-danger text-white',  // A Curso Especial
        'CR' => 'bg-dark text-white',    // Curso Esp. Reprobado
        'PS' => 'bg-secondary',          // Materia posible
        'NP' => 'bg-light'              // Materia no permitida
    ];

    public function render()
    {
        $this->renderHeader();
        $this->renderReticular();
        $this->renderSchedule();
        $this->renderColorGuide();
    }

    private function renderHeader()
    {
        echo '<div class="container-fluid mt-4">
                <div class="card shadow border-0">
                    <div class="card-body bg-gradient">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-person-circle fs-1 text-primary me-3"></i>
                                    <div>
                                        <h5 class="text-primary mb-1">No. Control: ' . htmlspecialchars($this->studentData['control_number']) . '</h5>
                                        <h2 class="mb-0 fw-bold">' . htmlspecialchars($this->studentData['name']) . '</h2>
                                    </div>
                                </div>
                                <div class="card bg-light border-0 p-3">
                                    <p class="mb-2"><i class="bi bi-mortarboard-fill text-primary me-2"></i><strong>Carrera:</strong> ' . htmlspecialchars($this->studentData['career']) . '</p>
                                    <p class="mb-0"><i class="bi bi-book-fill text-primary me-2"></i><strong>Especialidad:</strong> ' . htmlspecialchars($this->studentData['specialty']) . '</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm bg-primary bg-gradient text-white">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="bi bi-info-circle fs-3 me-2"></i>
                                            <h5 class="mb-0">Información Académica</h5>
                                        </div>
                                        <p class="mb-2"><i class="bi bi-bookmark-fill me-2"></i>Semestre: ' . htmlspecialchars($this->studentData['semester']) . '</p>
                                        <p class="mb-2"><i class="bi bi-calendar-fill me-2"></i>Periodo: ' . htmlspecialchars($this->studentData['period']) . '</p>
                                        <p class="mb-0">
                                            <i class="bi bi-star-fill me-2"></i>Promedio: 
                                            <span class="badge bg-white text-primary fs-5 ms-2">' . htmlspecialchars($this->studentData['average']) . '</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
    }

    private function renderReticular()
    {
        $totalSubjects = array_sum(array_map('count', $this->subjects));
        $completedSubjects = 0;
        foreach ($this->subjects as $semester) {
            foreach ($semester as $subject) {
                if ($subject['status'] === 'OO') {
                    $completedSubjects++;
                }
            }
        }
        $progress = ($totalSubjects > 0) ? round(($completedSubjects / $totalSubjects) * 100) : 0;

        echo '<div class="card shadow-sm border-0 mt-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">
                            <i class="bi bi-grid-3x3-gap-fill text-primary me-2"></i>Avance Reticular
                        </h4>
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <span>' . $completedSubjects . ' / ' . $totalSubjects . ' Materias</span>
                            </div>
                            <div class="progress" style="width: 200px; height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: ' . $progress . '%"></div>
                            </div>
                            <span class="badge bg-success">' . $progress . '% Completado</span>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="bg-primary bg-gradient text-white">
                                <tr>';

        for ($i = 1; $i <= 9; $i++) {
            echo '<th class="text-center py-3">
                    <div class="d-flex flex-column align-items-center">
                        <span class="fs-6">Semestre</span>
                        <span class="fs-4">' . $i . '</span>
                    </div>
                  </th>';
        }
        echo '</tr></thead><tbody>';

        $maxSubjects = max(array_map('count', $this->subjects));

        for ($row = 0; $row < $maxSubjects; $row++) {
            echo '<tr>';
            for ($sem = 1; $sem <= 9; $sem++) {
                echo '<td class="p-2">';
                if (isset($this->subjects[$sem][$row])) {
                    $subject = $this->subjects[$sem][$row];
                    $statusClass = $this->colorCodes[$subject['status']] ?? '';
                    echo "<div class='subject-card p-3 rounded-3 {$statusClass} shadow-sm hover-effect' 
                               style='transition: all 0.3s ease'>
                            <div class='d-flex justify-content-between align-items-center mb-2'>
                                <span class='badge bg-dark'>" . htmlspecialchars($subject['code']) . "</span>
                                <div class='d-flex gap-2 align-items-center'>
                                    <span class='badge " . ($subject['grade'] >= 70 ? 'bg-success' : 'bg-danger') . "'>
                                        <i class='bi " . ($subject['grade'] >= 70 ? 'bi-check-circle' : 'bi-x-circle') . " me-1'></i>" .
                        htmlspecialchars($subject['grade']) . "
                                    </span>
                                    " . (isset($subject['credits']) ? "<span class='badge bg-primary'>{$subject['credits']} Cr</span>" : "") . "
                                </div>
                            </div>
                            <div class='subject-name mb-2'>" . htmlspecialchars($subject['name']) . "</div>
                            <div class='progress' style='height: 4px;'>
                                <div class='progress-bar bg-" . ($subject['status'] === 'OO' ? 'success' : 'secondary') . "' 
                                     style='width: " . ($subject['grade'] > 0 ? $subject['grade'] : 0) . "%'></div>
                            </div>
                          </div>";
                }
                echo '</td>';
            }
            echo '</tr>';
        }
        echo '</tbody></table></div></div></div>';
    }

    private $currentSubjects = [
        [
            'code' => 'J185',
            'name' => 'DES. DE APLICACIONES MÓVILES',
            'professor' => 'FERNANDEZ BONILLA OSVALDO DANIEL',
            'email' => 'osvaldo.fb@cdvictoria.tecnm.mx',
            'group' => '31',
            'credits' => '5',
            'type' => 'N',
            'schedule' => [
                'Lunes' => ['13:00-14:00', 'LS8'],
                'Martes' => ['13:00-14:00', 'LS8'],
                'Miércoles' => ['13:00-14:00', 'G3'],
                'Jueves' => ['13:00-14:00', 'LS7'],
                'Viernes' => ['13:00-14:00', 'LS7']
            ]
        ],
        [
            'code' => 'J194',
            'name' => 'RESIDENCIAS PROFESIONALES',
            'professor' => 'Sin profesor asignado aún',
            'email' => '',
            'group' => '31',
            'credits' => '10',
            'type' => 'N',
            'schedule' => [
                'Lunes' => ['20:00-21:00', 'G3']
            ]
        ]
    ];

    private function renderSchedule()
    {
        echo '<div class="card shadow-sm mt-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">
                            <i class="bi bi-calendar3-week text-primary me-2"></i>Horario Actual
                        </h4>
                        <span class="badge bg-primary">Total Créditos: 15</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="text-center">
                                    <th style="min-width: 250px">Materia</th>
                                    <th style="min-width: 200px">Profesor</th>
                                    <th>Grupo</th>
                                    <th>Cr</th>
                                    <th>Lunes</th>
                                    <th>Martes</th>
                                    <th>Miércoles</th>
                                    <th>Jueves</th>
                                    <th>Viernes</th>
                                </tr>
                            </thead>
                            <tbody>';

        foreach ($this->currentSubjects as $subject) {
            echo "<tr>
                    <td>
                        <div class='d-flex flex-column'>
                            <span class='fw-bold text-primary'>{$subject['code']}</span>
                            <span>{$subject['name']}</span>
                            " . ($subject['email'] ? "<span class='small text-muted'>{$subject['email']}</span>" : "") . "
                        </div>
                    </td>
                    <td>{$subject['professor']}</td>
                    <td class='text-center'>{$subject['group']}</td>
                    <td class='text-center'>{$subject['credits']}</td>";

            foreach (['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'] as $day) {
                echo "<td class='text-center" . (isset($subject['schedule'][$day]) ? " bg-light" : "") . "'>";
                if (isset($subject['schedule'][$day])) {
                    echo "<div class='fw-bold'>{$subject['schedule'][$day][0]}</div>
                          <div class='small text-muted'>{$subject['schedule'][$day][1]}</div>";
                }
                echo "</td>";
            }
            echo "</tr>";
        }

        echo '</tbody></table></div></div></div>';
    }

    private function renderColorGuide()
    {
        echo '<div class="card shadow-sm mt-4 mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">
                            <i class="bi bi-info-circle text-primary me-2"></i>Códigos de Estado
                        </h4>
                    </div>
                    <div class="d-flex flex-wrap gap-3">';

        $descriptions = [
            'OO' => 'Acreditada',
            'RO' => 'Cursando',
            'RP' => 'Sin Acreditar',
            'OC' => 'Curso Especial',
            'CR' => 'C.E. Reprobado',
            'PS' => 'Seleccionable',
            'NP' => 'No Permitida'
        ];

        foreach ($this->colorCodes as $type => $class) {
            echo "<div class='p-3 rounded-3 {$class} shadow-sm hover-effect' style='min-width: 170px'>
                    <div class='d-flex justify-content-between align-items-center'>
                        <strong>{$type}</strong>
                        <span>" . htmlspecialchars($descriptions[$type]) . "</span>
                    </div>
                  </div>";
        }

        echo '</div></div></div>';
    }
}

$reticularProgress = new ReticularProgress();
$reticularProgress->render();
?>

<style>
    .hover-effect {
        transition: all 0.3s ease !important;
    }

    .hover-effect:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15) !important;
        cursor: pointer;
    }

    .bg-gradient {
        background: linear-gradient(120deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .card {
        overflow: hidden;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .progress {
        border-radius: 10px;
        overflow: hidden;
        background-color: rgba(0, 0, 0, 0.05);
    }

    .badge {
        padding: 0.5em 1em;
        border-radius: 6px;
        font-weight: 500;
    }

    .table th {
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .subject-card {
        min-height: 120px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .subject-name {
        font-size: 0.85rem;
        line-height: 1.2;
        font-weight: 500;
    }

    .table td {
        padding: 0.5rem;
        vertical-align: middle;
    }

    .table th {
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 0;
    }

    .hover-effect:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15) !important;
    }

    .progress {
        background-color: rgba(0, 0, 0, 0.1);
    }

    .badge {
        font-weight: 500;
        padding: 0.5em 0.8em;
    }
</style>