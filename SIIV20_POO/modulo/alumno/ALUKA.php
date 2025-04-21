<?php
class StudentKardex
{
    private $studentInfo = [
        'control_number' => '20380597',
        'name' => 'ANGEL URIEL DOMÍNGUEZ MEDINA',
        'study_plan' => 'IINF-2010-220',
        'semester' => '10',
        'career' => 'ING. INFORMATICA',
        'specialty' => 'TECNOLOGÍAS BASADAS EN LA NUBE PARA EL ANÁLISIS DE'
    ];

    private $semesters = [
        'AGO-DIC/2020' => [
            ['code' => 'J111', 'name' => 'FUNDAMENTOS DE INVESTIGACION', 'credits' => 4, 'grade' => 82, 'evaluation' => 'Ev. Ord.'],
            ['code' => 'J113', 'name' => 'FUNDAMENTOS DE PROGRAMACION', 'credits' => 5, 'grade' => 100, 'evaluation' => 'Ev. Ord.'],
            ['code' => 'J114', 'name' => 'TALLER DE ETICA', 'credits' => 4, 'grade' => 100, 'evaluation' => 'Ev. Ord.'],
            ['code' => 'J115', 'name' => 'CALCULO DIFERENCIAL', 'credits' => 5, 'grade' => 88, 'evaluation' => 'Ev. Ord.'],
            ['code' => 'J121', 'name' => 'ADMINISTRACION PARA INFORMATIC', 'credits' => 4, 'grade' => 90, 'evaluation' => 'Ev. Ord.'],
            ['code' => 'J166', 'name' => 'DESARROLLO SUSTENTABLE', 'credits' => 5, 'grade' => 97, 'evaluation' => 'Ev. Ord.']
        ],
        // Add other semesters similarly
    ];

    private function renderSemesters()
    {
        foreach ($this->semesters as $period => $subjects) {
            $totalCredits = array_sum(array_column($subjects, 'credits'));
            $totalGrades = array_sum(array_column($subjects, 'grade'));
            $average = round($totalGrades / count($subjects), 2);

            echo '<div class="container-fluid">
                    <div class="card shadow-sm border-0 semester-card">
                        <div class="card-body">
                            <div class="semester-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="bi bi-calendar3"></i> 
                                    ' . htmlspecialchars($period) . '
                                </h5>
                                <div class="d-flex gap-3">
                                    <span class="badge bg-primary">Promedio: ' . $average . '</span>
                                    <span class="badge bg-success">Créditos: ' . $totalCredits . '</span>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Código</th>
                                            <th>Materia</th>
                                            <th class="text-center">Créditos</th>
                                            <th class="text-center">Calificación</th>
                                            <th>Evaluación</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

            foreach ($subjects as $index => $subject) {
                $gradeClass = $subject['grade'] >= 70 ? 'bg-success' : 'bg-danger';

                echo '<tr>
                        <td>' . ($index + 1) . '</td>
                        <td><strong>' . htmlspecialchars($subject['code']) . '</strong></td>
                        <td>' . htmlspecialchars($subject['name']) . '</td>
                        <td class="text-center">' . $subject['credits'] . '</td>
                        <td class="text-center">
                            <span class="grade-badge ' . $gradeClass . ' text-white">
                                ' . $subject['grade'] . '
                            </span>
                        </td>
                        <td>' . htmlspecialchars($subject['evaluation']) . '</td>
                    </tr>';
            }

            echo '</tbody></table>
                </div>
            </div>
        </div>
    </div>';
        }
    }

    public function render()
    {
        $this->renderHeader();
        $this->renderSemesters();
        $this->renderSummary();
    }

    private function renderHeader()
    {
        echo '
        <div class="container-fluid py-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <div class="text-center">
                        <h4 class="mb-1">Instituto Tecnológico de Cd. Victoria</h4>
                        <p class="mb-0">Departamento de Servicios Escolares</p>
                    </div>
                </div>
                <div class="card-body">
                    <h3 class="text-center mb-4">Seguimiento del Alumno</h3>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">No. de Control</h6>
                                    <h5 class="mb-0">' . htmlspecialchars($this->studentInfo['control_number']) . '</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">Nombre</h6>
                                    <h5 class="mb-0">' . htmlspecialchars($this->studentInfo['name']) . '</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h6 class="text-muted mb-2">Semestre</h6>
                                            <h5 class="mb-0">' . htmlspecialchars($this->studentInfo['semester']) . '</h5>
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="text-muted mb-2">Carrera</h6>
                                            <h5 class="mb-0">' . htmlspecialchars($this->studentInfo['career']) . '</h5>
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="text-muted mb-2">Plan de Estudios</h6>
                                            <h5 class="mb-0">' . htmlspecialchars($this->studentInfo['study_plan']) . '</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }

    private function renderSummary()
    {
        // Calculate overall statistics
        $totalCredits = 0;
        $totalGrades = 0;
        $totalSubjects = 0;
        $approvedCredits = 0;

        foreach ($this->semesters as $subjects) {
            foreach ($subjects as $subject) {
                $totalCredits += $subject['credits'];
                $totalGrades += $subject['grade'];
                $totalSubjects++;
                if ($subject['grade'] >= 70) {
                    $approvedCredits += $subject['credits'];
                }
            }
        }

        $averageGrade = round($totalGrades / $totalSubjects, 2);
        $progressPercentage = round(($approvedCredits / $totalCredits) * 100);

        echo '<div class="container-fluid mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body summary-card">
                        <h4 class="card-title mb-4">
                            <i class="bi bi-graph-up"></i> Resumen Académico
                        </h4>
                        <div class="row g-4">
                            <div class="col-md-3">
                                <div class="card bg-white">
                                    <div class="card-body text-center">
                                        <h6 class="text-muted mb-2">Promedio General</h6>
                                        <h3 class="mb-0 text-primary">' . $averageGrade . '</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-white">
                                    <div class="card-body text-center">
                                        <h6 class="text-muted mb-2">Créditos Cursados</h6>
                                        <h3 class="mb-0 text-primary">' . $totalCredits . '</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-white">
                                    <div class="card-body text-center">
                                        <h6 class="text-muted mb-2">Créditos Aprobados</h6>
                                        <h3 class="mb-0 text-success">' . $approvedCredits . '</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-white">
                                    <div class="card-body text-center">
                                        <h6 class="text-muted mb-2">Porcentaje de Avance</h6>
                                        <h3 class="mb-0 text-success">' . $progressPercentage . '%</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="progress mt-4" style="height: 10px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: ' . $progressPercentage . '%"></div>
                        </div>
                    </div>
                </div>
            </div>';
    }
}
?>

<style>
    .card {
        border-radius: 15px;
        overflow: hidden;
    }

    .bg-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%) !important;
    }

    .card-header {
        border-bottom: none;
    }

    .bg-light {
        background: #f8f9fa !important;
    }

    .text-muted {
        color: #6c757d !important;
    }

    .table th {
        font-weight: 600;
        background: #f8f9fa;
    }

    .table td {
        vertical-align: middle;
    }

    .semester-card {
        margin-bottom: 2rem;
    }

    .semester-header {
        background: #e9ecef;
        padding: 1rem;
        border-radius: 10px;
        margin-bottom: 1rem;
    }

    .grade-badge {
        padding: 0.5em 1em;
        border-radius: 6px;
        font-weight: 500;
    }

    .summary-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }
</style>