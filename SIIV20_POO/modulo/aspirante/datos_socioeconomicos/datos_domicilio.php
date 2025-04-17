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