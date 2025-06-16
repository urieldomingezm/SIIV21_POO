<!-- Modal Registrar Información Académica -->
<div class="modal fade" id="modalRegistrarAcademica" tabindex="-1" aria-labelledby="modalRegistrarLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalRegistrarLabel">
                    <i class="bi bi-plus-circle me-2"></i>Registrar Nueva Información Académica
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formRegistrar" class="needs-validation" novalidate>
                    <!-- Búsqueda por Número de Control -->
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="alert alert-info" role="alert">
                                <h6 class="mb-2"><i class="bi bi-search me-2"></i>Búsqueda Rápida</h6>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="buscarNumeroControl" placeholder="Ingrese número de control del alumno">
                                    <button class="btn btn-outline-primary" type="button" id="btnBuscarAlumno">
                                        <i class="bi bi-search"></i> Buscar
                                    </button>
                                </div>
                                <small class="text-muted">Al buscar se llenarán automáticamente los datos del alumno</small>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Alumno -->
                    <div class="row g-3">
                        <!-- Campo oculto para almacenar el ID del alumno encontrado -->
                        <input type="hidden" id="alumno_id" name="alumno_id" required>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="numeroControlMostrar" readonly>
                                <label for="numeroControlMostrar">Número de Control</label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nombreAlumnoMostrar" readonly>
                                <label for="nombreAlumnoMostrar">Nombre del Alumno</label>
                            </div>
                        </div>
                        
                        <!-- Información Académica -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <select class="form-select" id="carrera_id" name="carrera_id" required>
                                    <option value="">Seleccione una carrera</option>
                                    <?php if(isset($carreras) && !empty($carreras)): ?>
                                        <?php foreach($carreras as $carrera): ?>
                                            <option value="<?php echo htmlspecialchars($carrera['carrera_id']); ?>">
                                                <?php echo htmlspecialchars($carrera['carrera_clave'] . ' - ' . $carrera['carrera_nombre_completo']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="1">INFO - Ingeniería en Informática</option>
                                        <option value="2">CIVIL - Ingeniería Civil</option>
                                        <option value="3">SIST - Ingeniería en Sistemas Computacionales</option>
                                        <option value="4">INDUS - Ingeniería Industrial</option>
                                        <option value="5">EMP - Ingeniería Empresarial</option>
                                        <option value="6">MEC - Ingeniería Mecánica</option>
                                        <option value="7">BIO - Licenciatura en Biología</option>
                                        <option value="8">ELEC - Ingeniería Electrónica</option>
                                        <option value="9">ENER - Ingeniería en Energías Renovables</option>
                                    <?php endif; ?>
                                </select>
                                <label for="carrera_id">Carrera</label>
                                <div class="invalid-feedback">Por favor seleccione una carrera</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="semestre" name="semestre" required>
                                    <option value="">Seleccione el semestre</option>
                                    <?php for($i=1; $i<=12; $i++): ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?>° Semestre</option>
                                    <?php endfor; ?>
                                </select>
                                <label for="semestre">Semestre</label>
                                <div class="invalid-feedback">Por favor seleccione un semestre</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="periodo" name="periodo" required>
                                    <option value="">Seleccione el periodo</option>
                                    <option value="ENE-JUN">Enero - Junio</option>
                                    <option value="AGO-DIC">Agosto - Diciembre</option>
                                    <option value="ENE-MAY">Enero - Mayo</option>
                                    <option value="SEP-DIC">Septiembre - Diciembre</option>
                                    <option value="FEB-JUN">Febrero - Junio</option>
                                    <option value="JUL-NOV">Julio - Noviembre</option>
                                </select>
                                <label for="periodo">Periodo</label>
                                <div class="invalid-feedback">Por favor seleccione un periodo</div>
                            </div>
                        </div>

                        <!-- Promedio -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="promedio" name="promedio" min="0" max="100" step="0.01" required>
                                <label for="promedio">Promedio</label>
                                <div class="invalid-feedback">El promedio debe estar entre 0 y 100</div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button type="submit" class="btn btn-primary" form="formRegistrar">
                    Registrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// JavaScript vanilla para la funcionalidad de búsqueda dinámica
document.addEventListener('DOMContentLoaded', function() {
    const btnBuscarAlumno = document.getElementById('btnBuscarAlumno');
    const inputNumeroControl = document.getElementById('buscarNumeroControl');
    
    if (btnBuscarAlumno && inputNumeroControl) {
        btnBuscarAlumno.addEventListener('click', function() {
            const numeroControl = inputNumeroControl.value.trim();
            if (numeroControl) {
                buscarAlumnoPorNumeroControl(numeroControl);
            } else {
                alert('Por favor ingrese un número de control');
            }
        });
        
        // Buscar al presionar Enter
        inputNumeroControl.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                btnBuscarAlumno.click();
            }
        });
    }
    
    // Limpiar campos cuando se abre el modal
    const modal = document.getElementById('modalRegistrarAcademica');
    if (modal) {
        modal.addEventListener('show.bs.modal', function() {
            limpiarFormulario();
        });
    }
});

function limpiarFormulario() {
    document.getElementById('buscarNumeroControl').value = '';
    document.getElementById('alumno_id').value = '';
    document.getElementById('numeroControlMostrar').value = '';
    document.getElementById('nombreAlumnoMostrar').value = '';
    document.getElementById('carrera_id').value = '';
    document.getElementById('semestre').value = '';
    document.getElementById('periodo').value = '';
    document.getElementById('promedio').value = '';
    
    // Remover alertas existentes
    const alertasExistentes = document.querySelectorAll('.alert-success, .alert-danger');
    alertasExistentes.forEach(alerta => {
        if (alerta.parentNode) {
            alerta.remove();
        }
    });
}

function buscarAlumnoPorNumeroControl(numeroControl) {
    // Debug: verificar que los datos estén disponibles
    console.log('Buscando número de control:', numeroControl);
    console.log('Array de alumnos disponible:', typeof window.alumnos !== 'undefined' ? window.alumnos : 'NO DISPONIBLE');
    
    // Verificar que el array de alumnos esté disponible
    if (typeof window.alumnos === 'undefined' || !Array.isArray(window.alumnos)) {
        console.error('El array de alumnos no está disponible');
        mostrarAlerta('Error: Los datos de alumnos no están disponibles', 'danger');
        return;
    }
    
    // Buscar en el array de alumnos (comparación más flexible)
    const alumnoEncontrado = window.alumnos.find(alumno => {
        // Convertir ambos a string y comparar
        const numeroControlAlumno = String(alumno.alumno_numero_control).trim();
        const numeroControlBusqueda = String(numeroControl).trim();
        
        console.log('Comparando:', numeroControlAlumno, 'con', numeroControlBusqueda);
        
        return numeroControlAlumno === numeroControlBusqueda;
    });
    
    console.log('Alumno encontrado:', alumnoEncontrado);
    
    if (alumnoEncontrado) {
        // Llenar los campos con los datos encontrados
        document.getElementById('alumno_id').value = alumnoEncontrado.alumno_id;
        document.getElementById('numeroControlMostrar').value = alumnoEncontrado.alumno_numero_control;
        document.getElementById('nombreAlumnoMostrar').value = alumnoEncontrado.nombre_completo;
        
        // Mostrar mensaje de éxito
        mostrarAlerta(`¡Alumno encontrado! ${alumnoEncontrado.nombre_completo}`, 'success');
        
    } else {
        // Limpiar campos si no se encuentra
        document.getElementById('alumno_id').value = '';
        document.getElementById('numeroControlMostrar').value = '';
        document.getElementById('nombreAlumnoMostrar').value = '';
        
        mostrarAlerta('No se encontró un alumno con ese número de control', 'danger');
    }
}

function mostrarAlerta(mensaje, tipo) {
    // Remover alertas existentes
    const alertasExistentes = document.querySelectorAll('.alert-success, .alert-danger');
    alertasExistentes.forEach(alerta => {
        if (alerta.parentNode) {
            alerta.remove();
        }
    });
    
    // Crear nueva alerta
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${tipo} alert-dismissible fade show mt-2`;
    alertDiv.innerHTML = `
        <strong>${tipo === 'success' ? '¡Éxito!' : 'Error:'}</strong> ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    const searchAlert = document.querySelector('.alert-info');
    if (searchAlert && searchAlert.parentNode) {
        searchAlert.parentNode.insertBefore(alertDiv, searchAlert.nextSibling);
    }
    
    // Remover el mensaje después de 5 segundos
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}
</script>