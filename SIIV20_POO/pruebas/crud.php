<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(TEMPLATES_PATH . 'header.php');
require_once(MENU_PATH . 'menu_personal.php');
?>

<div class="container-fluid mt-4">
    <!-- <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card border-primary">
                <div class="card-body">
                    <h6 class="card-title text-primary">Total Alumnos</h6>
                    <h2 class="mb-0">2</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card border-success">
                <div class="card-body">
                    <h6 class="card-title text-success">Promedio General</h6>
                    <h2 class="mb-0">85.5</h2>
                </div>
            </div>
        </div>
    </div> -->

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">Lista de Alumnos</h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-success btn-sm" onclick="exportToExcel()">
                        <i class="bi bi-file-earmark-excel me-1"></i>Excel
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="exportToPDF()">
                        <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                    </button>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#agregarAlumnoModal">
                        <i class="bi bi-plus-circle me-1"></i>Nuevo Alumno
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="tablaAlumnos" class="table table-hover">
                    <thead style="background-color: #1B396A; color: white;">
                        <tr>
                            <th>No. Control</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Promedio</th>
                            <th>Carrera</th>
                            <th>Observaciones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>19680123</td>
                            <td>Juan</td>
                            <td>Pérez García</td>
                            <td>85</td>
                            <td>Ingeniería en Sistemas</td>
                            <td>Ninguna</td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="editarAlumno('19680123')" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="eliminarAlumno('19680123')" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>19680124</td>
                            <td>María</td>
                            <td>López Sánchez</td>
                            <td>86</td>
                            <td>Ingeniería Industrial</td>
                            <td>Egresado</td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="editarAlumno('19680124')" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="eliminarAlumno('19680124')" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    const dataTable = new simpleDatatables.DataTable("#tablaAlumnos", {
        searchable: true,
        fixedHeight: true,
        labels: {
            placeholder: "Buscar...",
            perPage: "Registros por página",
            noRows: "No hay registros",
            info: "Mostrando {start} a {end} de {rows} registros",
        }
    });

    function editarAlumno(numeroControl) {
        // Aquí iría la lógica para editar
        console.log('Editando alumno:', numeroControl);
    }

    function eliminarAlumno(numeroControl) {
        if(confirm('¿Está seguro de eliminar este registro?')) {
            console.log('Eliminando alumno:', numeroControl);
        }
    }
</script>

<?php require_once(TEMPLATES_PATH . 'footer.php'); ?>

<style>
    #tablaAlumnos thead {
        background-color: #1B396A;
        color: white;
    }
</style>