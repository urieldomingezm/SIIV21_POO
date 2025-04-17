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