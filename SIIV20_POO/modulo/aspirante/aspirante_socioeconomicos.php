<div class="container mt-4">
    <h2 class="text-center mb-4">DATOS SOCIOECONOMICOS</h2>

    <form id="socioeconomicForm" method="POST" class="needs-validation" novalidate>
        <div class="accordion" id="aspiranteAccordion">
            <!-- Datos Generales Section -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="datosGeneralesHeader">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#datosGeneralesCollapse" aria-expanded="false" aria-controls="datosGeneralesCollapse">
                        Datos Generales del Aspirante
                    </button>
                </h2>
                <div id="datosGeneralesCollapse" class="accordion-collapse collapse" aria-labelledby="datosGeneralesHeader">
                    <div class="accordion-body">
                        <div class="row g-3">
                            <!-- First Row -->
                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label">Apellido Paterno</label>
                                <input type="text" class="form-control form-control-sm" name="apellido_paterno" 
                                    pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+" 
                                    minlength="2" 
                                    maxlength="50" 
                                    required>
                                <div class="invalid-feedback">
                                    Por favor ingrese un apellido paterno válido
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label">Apellido Materno</label>
                                <input type="text" class="form-control form-control-sm" name="apellido_materno" 
                                    pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+" 
                                    minlength="2" 
                                    maxlength="50" 
                                    required>
                                <div class="invalid-feedback">
                                    Por favor ingrese un apellido materno válido
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label">Nombre(s)</label>
                                <input type="text" class="form-control form-control-sm" name="nombre" 
                                    pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+" 
                                    minlength="2" 
                                    maxlength="50" 
                                    required>
                                <div class="invalid-feedback">
                                    Por favor ingrese un nombre válido
                                </div>
                            </div>

                            <!-- Second Row -->
                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control form-control-sm" name="fecha_nacimiento" 
                                    max="<?php echo date('Y-m-d', strtotime('-15 years')); ?>"
                                    min="<?php echo date('Y-m-d', strtotime('-70 years')); ?>"
                                    required>
                                <div class="invalid-feedback">
                                    Por favor seleccione una fecha válida
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label">Género</label>
                                <select class="form-select form-select-sm" name="genero" required>
                                    <option value="">Seleccione...</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                                <div class="invalid-feedback">
                                    Por favor seleccione un género
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label">CURP</label>
                                <input type="text" class="form-control form-control-sm" name="curp" 
                                    pattern="^[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[0-9A-Z][0-9]$"
                                    maxlength="18"
                                    required>
                                <div class="invalid-feedback">
                                    Por favor ingrese una CURP válida
                                </div>
                            </div>

                            <!-- Third Row (New Fields) -->
                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="nacionalidad" class="form-label">Nacionalidad</label>
                                <input type="text" class="form-control form-control-sm" 
                                    id="nacionalidad" 
                                    name="nacionalidad_alumno"
                                    pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+" 
                                    required>
                                <div class="invalid-feedback">
                                    Por favor ingrese una nacionalidad válida
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control form-control-sm" 
                                    id="telefono" 
                                    name="telefono_alumno"
                                    pattern="[0-9]{10}"
                                    maxlength="10" 
                                    required>
                                <div class="invalid-feedback">
                                    Por favor ingrese un teléfono válido (10 dígitos)
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="correoElectronico" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control form-control-sm" 
                                    id="correoElectronico" 
                                    name="correo_electronico_alumno"
                                    required>
                                <div class="invalid-feedback">
                                    Por favor ingrese un correo electrónico válido
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preparatoria de Procedencia Section -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="preparatoriaHeader">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#preparatoriaCollapse" aria-expanded="false" aria-controls="preparatoriaCollapse">
                        Preparatoria de Procedencia
                    </button>
                </h2>
                <div id="preparatoriaCollapse" class="accordion-collapse collapse" aria-labelledby="preparatoriaHeader">
                    <div class="accordion-body">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="entidadProcedencia" class="form-label">Entidad federativa</label>
                                <select class="form-select form-select-sm" id="entidadProcedencia" name="estado_prepa_procedencia" required>
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="Tamaulipas">Tamaulipas</option>
                                    <option value="Zacatecas">Zacatecas</option>
                                </select>
                                <div class="invalid-feedback">
                                    Por favor seleccione una entidad federativa
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="municipioProcedencia" class="form-label">Municipio</label>
                                <input type="text" class="form-control form-control-sm" 
                                    id="municipioProcedencia" 
                                    name="municipio_procedencia_prepa"
                                    pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+"
                                    minlength="3"
                                    maxlength="50"
                                    required>
                                <div class="invalid-feedback">
                                    Por favor ingrese un municipio válido
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-4">
                                <label for="escuelaProcedencia" class="form-label">Escuela</label>
                                <input type="text" class="form-control form-control-sm" 
                                    id="escuelaProcedencia" 
                                    name="escuela_procedencia"
                                    pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ0-9\s\.,]+"
                                    minlength="3"
                                    maxlength="100"
                                    required>
                                <div class="invalid-feedback">
                                    Por favor ingrese el nombre de la escuela
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="fechaEgreso" class="form-label">Fecha de egreso</label>
                                <input type="date" class="form-control form-control-sm" 
                                    id="fechaEgreso" 
                                    name="fecha_egreso_procedencia"
                                    value="2020-01-01"
                                    max="<?php echo date('Y-m-d'); ?>"
                                    min="<?php echo date('Y-m-d', strtotime('-10 years')); ?>"
                                    required>
                                <div class="invalid-feedback">
                                    Por favor seleccione una fecha válida
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="promedioGeneral" class="form-label">Promedio general</label>
                                <input type="number" class="form-control form-control-sm" 
                                    id="promedioGeneral" 
                                    name="promedio_general_procedencia"
                                    min="6"
                                    max="10"
                                    step="0.01"
                                    style="width: 80px; text-align: center;"
                                    required>
                                <div class="invalid-feedback">
                                    Por favor ingrese un promedio válido (6-10)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Domicilio Section -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="domicilioHeader">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#domicilioCollapse" aria-expanded="false" aria-controls="domicilioCollapse">
                        Domicilio Actual
                    </button>
                </h2>
                <div id="domicilioCollapse" class="accordion-collapse collapse" aria-labelledby="domicilioHeader">
                   <div class="accordion-body">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="calle" class="form-label">Calle</label>
                                <input type="text" class="form-control form-control-sm" 
                                    id="calle" 
                                    name="calle"
                                    pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ0-9\s\.,]+" 
                                    minlength="5" 
                                    maxlength="100" 
                                    required>
                                <div class="invalid-feedback">
                                    Por favor ingrese una calle válida
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-2">
                                <label for="numeroExterior" class="form-label">Número exterior</label>
                                <input type="text" class="form-control form-control-sm" 
                                    id="numeroExterior" 
                                    name="numero_exterior"
                                    pattern="[0-9A-Za-z\-]+" 
                                    minlength="1" 
                                    maxlength="5" 
                                    required>
                                <div class="invalid-feedback">
                                    Por favor ingrese un número válido
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <label for="codigoPostal" class="form-label">Código Postal</label>
                                <input type="text" class="form-control form-control-sm" 
                                    id="codigoPostal" 
                                    name="codigo_postal"
                                    pattern="[0-9]{5}" 
                                    maxlength="5" 
                                    required>
                                <div class="invalid-feedback">
                                    Ingrese un código postal válido (5 dígitos)
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <label for="colonia" class="form-label">Colonia</label>
                                <input type="text" class="form-control form-control-sm" 
                                    id="colonia" 
                                    name="colonia"
                                    pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ0-9\s\.,]+" 
                                    minlength="3" 
                                    maxlength="50" 
                                    required>
                                <div class="invalid-feedback">
                                    Por favor ingrese una colonia válida
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select form-select-sm" id="estado" name="estado" required>
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="Tamaulipas">Tamaulipas</option>
                                    <option value="Aguascalientes">Aguascalientes</option>
                                    <!-- Add all states here -->
                                </select>
                                <div class="invalid-feedback">
                                    Por favor seleccione un estado
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="municipio" class="form-label">Municipio</label>
                                <input type="text" class="form-control form-control-sm" 
                                    id="municipio" 
                                    name="municipio"
                                    pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+" 
                                    minlength="3"
                                    maxlength="50"
                                    required>
                                <div class="invalid-feedback">
                                    Por favor ingrese un municipio válido
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="padresHeader">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#padresCollapse" aria-expanded="false" aria-controls="padresCollapse">
                        Datos de los Padres
                    </button>
                </h2>
                <div id="padresCollapse" class="accordion-collapse collapse" aria-labelledby="padresHeader">
                    <div class="accordion-body">
                        <!-- Datos del Padre -->
                        <h4 class="text-center mb-4">Datos del Padre</h4>
                        <div class="row g-3">
                            <div class="col-12 col-sm-6 col-md-2">
                                <label for="Estadodepadre" class="form-label">Vive</label>
                                <select class="form-select form-select-sm" id="Estadodepadre" name="Estadodepadre" required>
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="Si">Sí</option>
                                    <option value="No">No</option>
                                </select>
                                <div class="invalid-feedback">Por favor seleccione una opción</div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-2">
                                <label for="apellidoPaternoPadre" class="form-label">Apellido Paterno</label>
                                <input type="text" class="form-control form-control-sm" 
                                    id="apellidoPaternoPadre" 
                                    name="apellido_paterno_padre"
                                    pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+"
                                    minlength="2"
                                    maxlength="50"
                                    required>
                                <div class="invalid-feedback">Por favor ingrese un apellido válido</div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-2">
                                <label for="apellidoMaternoPadre" class="form-label">Apellido Materno</label>
                                <input type="text" class="form-control form-control-sm" 
                                    id="apellidoMaternoPadre" 
                                    name="apellido_materno_padre"
                                    pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+"
                                    minlength="2"
                                    maxlength="50"
                                    required>
                                <div class="invalid-feedback">Por favor ingrese un apellido válido</div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-2">
                                <label for="nombrePadre" class="form-label">Nombre(s)</label>
                                <input type="text" class="form-control form-control-sm" 
                                    id="nombrePadre" 
                                    name="nombre_padre"
                                    pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+"
                                    minlength="2"
                                    maxlength="50"
                                    required>
                                <div class="invalid-feedback">Por favor ingrese un nombre válido</div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-2">
                                <label for="nivelEstudiosPadre" class="form-label">Estudios</label>
                                <select class="form-select form-select-sm" id="nivelEstudiosPadre" name="nivelEstudiosPadre" required>
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="PrimariaTerminada">Educación primaria terminada</option>
                                    <option value="PrimariaNoTerminada">Educación primaria no terminada</option>
                                    <option value="Secundaria">Educación secundaria</option>
                                    <option value="SecundariaNoTerminada">Educación secundaria no terminada</option>
                                    <option value="MediaSuperior">Educación media superior</option>
                                    <option value="MediaSuperiorNoTerminada">Educación media superior no terminada</option>
                                    <option value="Superior">Educación superior</option>
                                    <option value="SuperiorNoTerminada">Educación superior no terminada</option>
                                    <option value="Posgrado">Posgrado</option>
                                </select>
                                <div class="invalid-feedback">Por favor seleccione el nivel de estudios</div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-2">
                                <label for="ocupacionPadre" class="form-label">Ocupación</label>
                                <select class="form-select form-select-sm" id="ocupacionPadre" name="ocupacion_padre" required>
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="empleado">Empleado</option>
                                    <option value="empresario">Empresario</option>
                                    <option value="trabajador_independiente">Trabajador independiente</option>
                                    <option value="jubilado">Jubilado</option>
                                    <option value="ama de casa">Ama de casa</option>
                                    <option value="desempleado">Desempleado</option>
                                    <option value="otro">Otro</option>
                                </select>
                                <div class="invalid-feedback">Por favor seleccione una ocupación</div>
                            </div>
                        </div>

                        <!-- Datos de la Madre -->
                        <h4 class="text-center mb-4 mt-5">Datos de la Madre</h4>
                        <div class="row g-3">
                            <div class="col-12 col-sm-6 col-md-2">
                                <label for="Estadodemadre" class="form-label">Vive</label>
                                <select class="form-select form-select-sm" id="Estadodemadre" name="Estadodemadre" required>
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="Si">Sí</option>
                                    <option value="No">No</option>
                                </select>
                                <div class="invalid-feedback">Por favor seleccione una opción</div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-2">
                                <label for="apellidoPaternoMadre" class="form-label">Apellido Paterno</label>
                                <input type="text" class="form-control form-control-sm" 
                                    id="apellidoPaternoMadre" 
                                    name="apellido_paterno_madre"
                                    pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+"
                                    minlength="2"
                                    maxlength="50"
                                    required>
                                <div class="invalid-feedback">Por favor ingrese un apellido válido</div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-2">
                                <label for="apellidoMaternoMadre" class="form-label">Apellido Materno</label>
                                <input type="text" class="form-control form-control-sm" 
                                    id="apellidoMaternoMadre" 
                                    name="apellido_materno_madre"
                                    pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+"
                                    minlength="2"
                                    maxlength="50"
                                    required>
                                <div class="invalid-feedback">Por favor ingrese un apellido válido</div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-2">
                                <label for="nombreMadre" class="form-label">Nombre(s)</label>
                                <input type="text" class="form-control form-control-sm" 
                                    id="nombreMadre" 
                                    name="nombre_madre"
                                    pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+"
                                    minlength="2"
                                    maxlength="50"
                                    required>
                                <div class="invalid-feedback">Por favor ingrese un nombre válido</div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-2">
                                <label for="nivelEstudiosMadre" class="form-label">Estudios</label>
                                <select class="form-select form-select-sm" id="nivelEstudiosMadre" name="nivelEstudiosMadre" required>
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="PrimariaTerminada">Educación primaria terminada</option>
                                    <option value="PrimariaNoTerminada">Educación primaria no terminada</option>
                                    <option value="Secundaria">Educación secundaria</option>
                                    <option value="SecundariaNoTerminada">Educación secundaria no terminada</option>
                                    <option value="MediaSuperior">Educación media superior</option>
                                    <option value="MediaSuperiorNoTerminada">Educación media superior no terminada</option>
                                    <option value="Superior">Educación superior</option>
                                    <option value="SuperiorNoTerminada">Educación superior no terminada</option>
                                    <option value="Posgrado">Posgrado</option>
                                </select>
                                <div class="invalid-feedback">Por favor seleccione el nivel de estudios</div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-2">
                                <label for="ocupacionMadre" class="form-label">Ocupación</label>
                                <select class="form-select form-select-sm" id="ocupacionMadre" name="ocupacion_madre" required>
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="empleado">Empleada</option>
                                    <option value="empresario">Empresaria</option>
                                    <option value="trabajador_independiente">Trabajadora independiente</option>
                                    <option value="jubilado">Jubilada</option>
                                    <option value="ama de casa">Ama de casa</option>
                                    <option value="desempleado">Desempleada</option>
                                    <option value="otro">Otro</option>
                                </select>
                                <div class="invalid-feedback">Por favor seleccione una ocupación</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="accordion-item">
                <h2 class="accordion-header" id="socioeconomicoHeader">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#socioeconomicoCollapse" aria-expanded="false" aria-controls="socioeconomicoCollapse">
                        Información Socioeconómica
                    </button>
                </h2>
                <div id="socioeconomicoCollapse" class="accordion-collapse collapse" aria-labelledby="socioeconomicoHeader">
                    <div class="accordion-body">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="vivesconquien" class="form-label">¿Con quién vives?</label>
                                <select class="form-select form-select-sm" id="vivesconquien" name="vivesconquien" required>
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="Vivo solo">Solo</option>
                                    <option value="vivo con Familiar">Con un familiar</option>
                                    <option value="Vivo con un amigo">Con un amigo</option>
                                    <option value="Vivo con mi padres">Con mis padres</option>
                                </select>
                                <div class="invalid-feedback">Por favor seleccione una opción</div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="personasCasa" class="form-label">Personas en la casa</label>
                                <select class="form-select form-select-sm" id="personasCasa" name="personas_en_casa" required>
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="1 persona">1 persona</option>
                                    <option value="2 personas">2 personas</option>
                                    <option value="3 personas">3 personas</option>
                                    <option value="4 personas">4 personas</option>
                                    <option value="5 personas">5 personas</option>
                                </select>
                                <div class="invalid-feedback">Por favor seleccione el número de personas</div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="dependenciaEconomica" class="form-label">¿De quién dependes?</label>
                                <select class="form-select form-select-sm" id="dependenciaEconomica" name="dependes" required>
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="De mis padres">De mis padres</option>
                                    <option value="De nadie">De nadie</option>
                                    <option value="tutor">De un tutor</option>
                                    <option value="familiar">De un familiar</option>
                                </select>
                                <div class="invalid-feedback">Por favor seleccione una opción</div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="tipoVivienda" class="form-label">Tipo de vivienda</label>
                                <select class="form-select form-select-sm" id="tipoVivienda" name="vivienda" required>
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="De mis padres">De mis padres</option>
                                    <option value="De nadie">De nadie</option>
                                    <option value="tutor">De un tutor</option>
                                    <option value="familiar">De un familiar</option>
                                </select>
                                <div class="invalid-feedback">Por favor seleccione el tipo de vivienda</div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="cuartosCasa" class="form-label">Nº de cuartos</label>
                                <select class="form-select form-select-sm" id="cuartosCasa" name="numero_cuartos" required>
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="1 cuarto">1 cuarto</option>
                                    <option value="2 cuartos">2 cuartos</option>
                                    <option value="3 cuartos">3 cuartos</option>
                                    <option value="4 cuartos">4 cuartos</option>
                                    <option value="5 cuartos">5 cuartos</option>
                                </select>
                                <div class="invalid-feedback">Por favor seleccione el número de cuartos</div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="dependientesEconomicos" class="form-label">Dependientes</label>
                                <input type="number" class="form-control form-control-sm" 
                                    id="dependientesEconomicos" 
                                    name="dependientes"
                                    min="0"
                                    max="10"
                                    required>
                                <div class="invalid-feedback">Por favor ingrese un número válido</div>
                            </div>
                        </div>

                        <h4 class="text-center mb-4 mt-5">Ingresos familiares mensuales</h4>
                        <div class="row g-3">
                            <div class="col-12 col-sm-6 col-md-3">
                                <label for="ingresosFamiliarespadre" class="form-label">Padre</label>
                                <input type="number" class="form-control form-control-sm" 
                                    id="ingresosFamiliarespadre" 
                                    name="ingreso_padre"
                                    min="0"
                                    step="100"
                                    oninput="sumarIngresos()"
                                    required>
                                <div class="invalid-feedback">Por favor ingrese un monto válido</div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <label for="ingresosFamiliaresmadre" class="form-label">Madre</label>
                                <input type="number" class="form-control form-control-sm" 
                                    id="ingresosFamiliaresmadre" 
                                    name="ingreso_madre"
                                    min="0"
                                    step="100"
                                    oninput="sumarIngresos()"
                                    required>
                                <div class="invalid-feedback">Por favor ingrese un monto válido</div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-2">
                                <label for="ingresosFamiliareshermanos" class="form-label">Hermanos</label>
                                <input type="number" class="form-control form-control-sm" 
                                    id="ingresosFamiliareshermanos" 
                                    name="ingreso_hermanos"
                                    min="0"
                                    step="100"
                                    oninput="sumarIngresos()"
                                    required>
                                <div class="invalid-feedback">Por favor ingrese un monto válido</div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-2">
                                <label for="ingresosPropios" class="form-label">Propios</label>
                                <input type="number" class="form-control form-control-sm" 
                                    id="ingresosPropios" 
                                    name="ingresos_propios"
                                    min="0"
                                    step="100"
                                    oninput="sumarIngresos()"
                                    required>
                                <div class="invalid-feedback">Por favor ingrese un monto válido</div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-2">
                                <label for="ingresosTotales" class="form-label">Total</label>
                                <input type="number" class="form-control form-control-sm" 
                                    id="ingresosTotales" 
                                    name="ingresos_totales"
                                    readonly
                                    style="background-color: #e9ecef;">
                            </div>
                        </div>

                        <script>
                            function sumarIngresos() {
                                const padre = Number(document.getElementById('ingresosFamiliarespadre').value) || 0;
                                const madre = Number(document.getElementById('ingresosFamiliaresmadre').value) || 0;
                                const hermanos = Number(document.getElementById('ingresosFamiliareshermanos').value) || 0;
                                const propios = Number(document.getElementById('ingresosPropios').value) || 0;
                                
                                const total = padre + madre + hermanos + propios;
                                document.getElementById('ingresosTotales').value = total;
                            }
                        </script>
                    </div>
                </div>
            </div>

            

            <!-- Datos de Emergencia Section -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="emergenciaHeader">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#emergenciaCollapse" aria-expanded="false" aria-controls="emergenciaCollapse">
                        Datos de Emergencia
                    </button>
                </h2>
                <div id="emergenciaCollapse" class="accordion-collapse collapse" aria-labelledby="emergenciaHeader">
                    <div class="accordion-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Tipo de sangre</label>
                                <select class="form-select" name="tipo_sangre" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Nose">No sé</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                                <div class="invalid-feedback">
                                    Por favor seleccione su tipo de sangre
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Contacto de Emergencia</label>
                                <input type="text" class="form-control" name="contactoEmergencia" 
                                    pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+" 
                                    minlength="3" 
                                    maxlength="100" 
                                    required>
                                <div class="invalid-feedback">
                                    Por favor ingrese un nombre válido
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Calle y número</label>
                                <input type="text" class="form-control" name="callenumeroemergencia" 
                                    minlength="5" 
                                    maxlength="100" 
                                    required>
                                <div class="invalid-feedback">
                                    Por favor ingrese una dirección válida
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Colonia</label>
                                <input type="text" class="form-control" name="coloniaLocalidademergencia" 
                                    minlength="3" 
                                    maxlength="50" 
                                    required>
                                <div class="invalid-feedback">
                                    Por favor ingrese una colonia válida
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Código Postal</label>
                                <input type="text" class="form-control" name="codigoPostalemergencia" 
                                    pattern="[0-9]{5}" 
                                    maxlength="5" 
                                    required>
                                <div class="invalid-feedback">
                                    Ingrese un código postal válido (5 dígitos)
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Estado</label>
                                <select class="form-select" name="estado_emergencia" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Tamaulipas">Tamaulipas</option>
                                    <option value="Aguascalientes">Aguascalientes</option>
                                    <option value="Baja California">Baja California</option>
                                    <option value="Baja California Sur">Baja California Sur</option>
                                    <option value="Campeche">Campeche</option>
                                    <option value="Chiapas">Chiapas</option>
                                    <option value="Chihuahua">Chihuahua</option>
                                    <option value="Ciudad de México">Ciudad de México</option>
                                    <option value="Coahuila">Coahuila</option>
                                    <option value="Colima">Colima</option>
                                    <option value="Durango">Durango</option>
                                    <option value="Estado de México">Estado de México</option>
                                    <option value="Guanajuato">Guanajuato</option>
                                    <option value="Guerrero">Guerrero</option>
                                    <option value="Hidalgo">Hidalgo</option>
                                    <option value="Jalisco">Jalisco</option>
                                    <option value="Michoacán">Michoacán</option>
                                    <option value="Morelos">Morelos</option>
                                    <option value="Nayarit">Nayarit</option>
                                    <option value="Nuevo León">Nuevo León</option>
                                    <option value="Oaxaca">Oaxaca</option>
                                    <option value="Puebla">Puebla</option>
                                    <option value="Querétaro">Querétaro</option>
                                    <option value="Quintana Roo">Quintana Roo</option>
                                    <option value="San Luis Potosí">San Luis Potosí</option>
                                    <option value="Sinaloa">Sinaloa</option>
                                    <option value="Sonora">Sonora</option>
                                    <option value="Tabasco">Tabasco</option>
                                    <option value="Tlaxcala">Tlaxcala</option>
                                    <option value="Veracruz">Veracruz</option>
                                    <option value="Yucatán">Yucatán</option>
                                    <option value="Zacatecas">Zacatecas</option>
                                </select>
                                <div class="invalid-feedback">
                                    Por favor seleccione un estado
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Municipio</label>
                                <input type="text" class="form-control" name="municipio_emergencia" 
                                    minlength="3" 
                                    maxlength="50" 
                                    required>
                                <div class="invalid-feedback">
                                    Por favor ingrese un municipio válido
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" name="telefono_emergencia" 
                                    pattern="[0-9]{10}" 
                                    maxlength="10" 
                                    required>
                                <div class="invalid-feedback">
                                    Ingrese un número telefónico válido (10 dígitos)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-grid gap-2 col-6 mx-auto mt-4">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-check-circle-fill me-2"></i>Guardar Información
            </button>
        </div>
    </form>
</div>