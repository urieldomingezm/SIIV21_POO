<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow border-0 rounded-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="text-center my-4">
                        <i class="bi bi-person-workspace me-2"></i>
                        Panel de Personal Docente
                    </h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="display-4 text-primary mb-3">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <h4 class="mb-3">¡Bienvenido(a)!</h4>
                        <p class="h5">
                            Usuario: <span class="badge bg-primary"><?php echo htmlspecialchars($_SESSION['numero_control']); ?></span>
                        </p>
                    </div>
                    
                    <div class="row g-4 mt-2">
                        <div class="col-md-4">
                            <div class="card h-100 border-start border-primary border-4">
                                <div class="card-body text-center">
                                    <i class="bi bi-calendar-check text-primary fs-1 mb-3"></i>
                                    <h5 class="card-title">Horario</h5>
                                    <p class="card-text text-muted">Gestiona tu horario de clases</p>
                                    <a href="#" class="btn btn-outline-primary">Ver Horario</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card h-100 border-start border-success border-4">
                                <div class="card-body text-center">
                                    <i class="bi bi-people text-success fs-1 mb-3"></i>
                                    <h5 class="card-title">Grupos</h5>
                                    <p class="card-text text-muted">Administra tus grupos</p>
                                    <a href="#" class="btn btn-outline-success">Ver Grupos</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card h-100 border-start border-info border-4">
                                <div class="card-body text-center">
                                    <i class="bi bi-clipboard-check text-info fs-1 mb-3"></i>
                                    <h5 class="card-title">Calificaciones</h5>
                                    <p class="card-text text-muted">Registro de evaluaciones</p>
                                    <a href="#" class="btn btn-outline-info">Ver Calificaciones</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>