<?php
class LoginController
{
    private $sections;

    public function __construct()
    {
        session_start();
        $this->sections = array('aspirante', 'alumno', 'personal');
        $this->loadDependencies();
    }

    private function loadDependencies()
    {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
        require_once(CONFIG_PATH . 'bd.php');
        require_once(LOGIN_PATH . 'proceso_login_registro.php');
        require_once(TEMPLATES_PATH . 'header.php');
    }

    public function render()
    {
        $this->renderMainSection();
        $this->renderRegistrationModal();
        $this->includeResources();
        require_once(TEMPLATES_PATH . 'footer.php');
    }

    private function renderMainSection()
    {
        echo '<section class="bg-light py-5">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12 text-center mb-5">
                        <h2 class="display-5 fw-bold text-primary text-uppercase mb-0">Inicio de Sesión General</h2>
                        <div class="border-bottom border-primary border-2 w-25 mx-auto mt-3"></div>
                    </div>
                    <div class="col-12" id="mainContent">
                        <div class="row g-4">
                            <!-- Columna principal con las pestañas y contenido -->
                            <div class="col-12 col-lg-8" id="loginSection">
                                <!-- Nuevo diseño de pestañas horizontal con texto negro -->
                                <div class="nav-scroller mb-4">
                                    <nav class="nav nav-pills nav-fill bg-white rounded-3 shadow-sm p-2">
                                        <a class="nav-link active rounded-pill d-flex align-items-center justify-content-center text-black" 
                                           id="aspirantes-tab" 
                                           data-bs-toggle="tab" 
                                           href="#Aspirantes" 
                                           role="tab">
                                            <i class="bi bi-person-plus-fill fs-5 me-2"></i>
                                            <span class="d-none d-sm-inline">Aspirantes</span>
                                        </a>
                                        <a class="nav-link rounded-pill d-flex align-items-center justify-content-center text-black" 
                                           id="alumnos-tab" 
                                           data-bs-toggle="tab" 
                                           href="#Alumnos" 
                                           role="tab">
                                            <i class="bi bi-mortarboard-fill fs-5 me-2"></i>
                                            <span class="d-none d-sm-inline">Alumnos</span>
                                        </a>
                                        <a class="nav-link rounded-pill d-flex align-items-center justify-content-center text-black" 
                                           id="personal-tab" 
                                           data-bs-toggle="tab" 
                                           href="#Personal" 
                                           role="tab">
                                            <i class="bi bi-person-badge-fill fs-5 me-2"></i>
                                            <span class="d-none d-sm-inline">Personal</span>
                                        </a>
                                    </nav>
                                </div>

                                <!-- Contenido de las pestañas -->
                                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                                    <div class="card-body p-4">
                                        <div class="tab-content" id="loginTabsContent">';

        $this->renderLoginSections();

        echo '                </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Columna del acordeón de admisión (visible en todas las pestañas) -->
                            <div class="col-12 col-lg-4" id="admisionInfo">
                                <div class="card shadow-sm rounded mb-4 mt-4 mt-lg-0">
                                    <div class="card-header bg-primary text-white py-3">
                                        <h5 class="mb-0">Conoce los procesos de admisión</h5>
                                    </div>
                                    <div class="card-body bg-light p-4">
                                        
                                        <!-- Etapas Accordion -->
                                        <div class="accordion custom-accordion" id="etapasAccordion">
                                            <!-- Etapa 1 -->
                                            <div class="accordion-item mb-3 border rounded overflow-hidden">
                                                <h2 class="accordion-header" id="headingEtapa1">
                                                    <button class="accordion-button custom-accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEtapa1" aria-expanded="false" aria-controls="collapseEtapa1">
                                                        <i class="bi bi-1-circle-fill me-2 text-primary"></i>
                                                        <strong>Registro y Pago</strong>
                                                    </button>
                                                </h2>
                                                <div id="collapseEtapa1" class="accordion-collapse collapse" aria-labelledby="headingEtapa1" data-bs-parent="#etapasAccordion">
                                                    <div class="accordion-body p-3">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <i class="bi bi-calendar-event text-primary me-2"></i>
                                                            <h6 class="mb-0">4 FEBRERO AL 15 DE ABRIL DE 2025</h6>
                                                        </div>
                                                        <div class="ps-4">
                                                            <ol class="list-group list-group-flush list-group-numbered">
                                                                Regístrate en el SII: <a href="http://sii.cdvictoria.tecnm.mx/sistema/" target="_blank" class="text-primary">http://sii.cdvictoria.tecnm.mx/sistema/</a></li>
                                                                Realiza tu test de perfil vocacional en tu sesión del SIIE</li>
                                                                
                                                                    <strong class="d-block mb-2">Costos:</strong>
                                                                    <ul class="list-unstyled ps-3">
                                                                        <li class="mb-2"><i class="bi bi-dot"></i>Ficha de aspirante: $700</li>
                                                                        <li><i class="bi bi-dot"></i>Curso propedéutico: $1,300</li>
                                                                    </ul>
                                                                </li>
                                                                
                                                                    <strong class="d-block mb-2">Opciones de pago:</strong>
                                                                    <ul class="list-unstyled ps-3">
                                                                        <li class="mb-2"><i class="bi bi-bank me-2 text-primary"></i>Ventanilla bancaria</li>
                                                                        <li class="mb-2"><i class="bi bi-cash-coin me-2 text-primary"></i>Recursos Financieros</li>
                                                                        <li><i class="bi bi-arrow-left-right me-2 text-primary"></i>Transferencia bancaria</li>
                                                                    </ul>
                                                                </li>
                                                            </ol>
                                                        </div>
                                                        <div class="alert alert-warning mt-3 mb-0 py-2">
                                                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                                            <small>El pago de este trámite no garantiza el ingreso a la institución.</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Etapa 2 -->
                                            <div class="accordion-item mb-3 border rounded overflow-hidden">
                                                <h2 class="accordion-header" id="headingEtapa2">
                                                    <button class="accordion-button custom-accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEtapa2" aria-expanded="false" aria-controls="collapseEtapa2">
                                                        <i class="bi bi-2-circle-fill me-2 text-primary"></i>
                                                        <strong>Examen de admisión</strong>
                                                    </button>
                                                </h2>
                                                <div id="collapseEtapa2" class="accordion-collapse collapse" aria-labelledby="headingEtapa2" data-bs-parent="#etapasAccordion">
                                                    <div class="accordion-body p-3">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <i class="bi bi-calendar-event text-primary me-2"></i>
                                                            <h6 class="mb-0">18 Y 19 DE JUNIO DE 2025</h6>
                                                        </div>
                                                        <div class="alert alert-info mb-0">
                                                            <i class="bi bi-info-circle-fill me-2"></i>
                                                            Paso obligatorio: Realiza el examen presencial EVALUATEC. Es requisito traer laptop.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Etapa 3 -->
                                            <div class="accordion-item mb-3 border rounded overflow-hidden">
                                                <h2 class="accordion-header" id="headingEtapa3">
                                                    <button class="accordion-button custom-accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEtapa3" aria-expanded="false" aria-controls="collapseEtapa3">
                                                        <i class="bi bi-3-circle-fill me-2 text-primary"></i>
                                                        <strong>Curso Propedéutico</strong>
                                                    </button>
                                                </h2>
                                                <div id="collapseEtapa3" class="accordion-collapse collapse" aria-labelledby="headingEtapa3" data-bs-parent="#etapasAccordion">
                                                    <div class="accordion-body p-3">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <i class="bi bi-calendar-event text-primary me-2"></i>
                                                            <h6 class="mb-0">25 DE JUNIO AL 23 DE JULIO DE 2025</h6>
                                                        </div>
                                                        <div class="alert alert-info mb-0">
                                                            <i class="bi bi-info-circle-fill me-2"></i>
                                                            Paso obligatorio: Consulta en el grupo de Facebook Aspirantes TEC2025 tu horario y aula asignada.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Etapa 4 -->
                                            <div class="accordion-item mb-3 border rounded overflow-hidden">
                                                <h2 class="accordion-header" id="headingEtapa4">
                                                    <button class="accordion-button custom-accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEtapa4" aria-expanded="false" aria-controls="collapseEtapa4">
                                                        <i class="bi bi-4-circle-fill me-2 text-primary"></i>
                                                        <strong>Publicación de listas</strong>
                                                    </button>
                                                </h2>
                                                <div id="collapseEtapa4" class="accordion-collapse collapse" aria-labelledby="headingEtapa4" data-bs-parent="#etapasAccordion">
                                                    <div class="accordion-body p-3">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <i class="bi bi-calendar-event text-primary me-2"></i>
                                                            <h6 class="mb-0">28 DE JULIO 2025</h6>
                                                        </div>
                                                        <div class="alert alert-info mb-0">
                                                            <i class="bi bi-info-circle-fill me-2"></i>
                                                            Consulta en la cuenta oficial de la institución el listado de los aspirantes aceptados.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Contacto -->
                                            <div class="accordion-item border rounded overflow-hidden">
                                                <h2 class="accordion-header" id="headingContacto">
                                                    <button class="accordion-button custom-accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseContacto" aria-expanded="false" aria-controls="collapseContacto">
                                                        <i class="bi bi-headset me-2 text-primary"></i>
                                                        <strong>Contacto</strong>
                                                    </button>
                                                </h2>
                                                <div id="collapseContacto" class="accordion-collapse collapse" aria-labelledby="headingContacto" data-bs-parent="#etapasAccordion">
                                                    <div class="accordion-body p-3">
                                                        <div class="list-group list-group-flush">
                                                            <div class="list-group-item border-0 px-0">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="bi bi-telephone-fill text-primary me-3"></i>
                                                                    <div>
                                                                        <small class="text-muted d-block">Problemas con el SIIE</small>
                                                                        <strong class="text-primary">(867) 555-0123</strong>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>';
    }

    private function renderLoginSections()
    {
        $sectionIds = ['Aspirantes', 'Alumnos', 'Personal'];
        foreach ($this->sections as $index => $section) {
            $isActive = $index === 0 ? ' show active' : '';
            echo "<div class='tab-pane fade{$isActive}' id='{$sectionIds[$index]}' role='tabpanel' aria-labelledby='{$section}-tab'>";
            require_once(CUSTOM_INDEX_LOGIN . "seccion_$section.php");
            echo '</div>';
        }
    }

    private function renderRegistrationModal()
    {
        echo '<div class="modal fade" id="registroModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="registroModalLabel">Registro de Aspirante</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="modal-body-content" class="text-black"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
                    </div>
                </div>
            </div>
        </div>';
    }

    private function includeResources()
    {
        echo '<script>
        function togglePasswordVisibility(inputId, button) {
            const passwordInput = document.getElementById(inputId);
            const icon = button.querySelector("i");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            }
        }

        function generateCaptcha(formId) {
            const characters = "abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ123456789";
            let captchaCode = "";

            for (let i = 0; i < 5; i++) {
                captchaCode += characters.charAt(Math.floor(Math.random() * characters.length));
            }

            document.getElementById(formId).dataset.captchaCode = captchaCode;

            let canvas = document.getElementById(formId).querySelector(".captchaCanvas");
            if (!canvas) {
                canvas = document.getElementById(formId).querySelector(".captcha-canvas");
            }
            
            if (!canvas) {
                console.error("No se encontró canvas para el formulario:", formId);
                return;
            }

            const ctx = canvas.getContext("2d");
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.font = "24px Arial";
            ctx.fillStyle = "#333";
            ctx.textBaseline = "middle";
            ctx.textAlign = "center";
            ctx.fillText(captchaCode, canvas.width / 2, canvas.height / 2);

            for (let i = 0; i < 3; i++) {
                ctx.strokeStyle = "#ccc";
                ctx.lineWidth = 1;
                ctx.beginPath();
                ctx.moveTo(Math.random() * canvas.width, Math.random() * canvas.height);
                ctx.lineTo(Math.random() * canvas.width, Math.random() * canvas.height);
                ctx.stroke();
            }
        }

        function verifyCaptcha(formId) {
            const form = document.getElementById(formId);
            let userCaptcha;
            
            const captchaInput = form.querySelector(".captchaInput") || 
                                form.querySelector("input[name*=\"captcha\"]") ||
                                form.querySelector("#" + formId.replace("formulario_", "") + "_captcha");
            
            if (captchaInput) {
                userCaptcha = captchaInput.value;
            }
            
            const captchaCode = form.dataset.captchaCode;
            
            if (!userCaptcha || userCaptcha !== captchaCode) {
                const existingModal = bootstrap.Modal.getInstance(document.getElementById("registroModal"));
                if (existingModal) {
                    existingModal.dispose();
                }
                
                showModalMessage("Error de CAPTCHA", "Por favor ingrese el código CAPTCHA correctamente", "error");
                generateCaptcha(formId);
                return false;
            }
            return true;
        }

        function showModalMessage(title, message, status) {
            const modalElement = document.getElementById("registroModal");
            const modalTitle = document.getElementById("registroModalLabel");
            const modalBody = document.getElementById("modal-body-content");
            
            const existingModal = bootstrap.Modal.getInstance(modalElement);
            if (existingModal) {
                existingModal.dispose();
            }
            
            modalTitle.textContent = title;
            modalBody.innerHTML = message;
            
            if (status === "success") {
                modalBody.classList.add("text-success");
                modalBody.classList.remove("text-danger");
            } else {
                modalBody.classList.add("text-danger");
                modalBody.classList.remove("text-success");
            }
            
            const modal = new bootstrap.Modal(modalElement, {
                backdrop: "static",
                keyboard: false
            });
            
            modalElement.addEventListener("hidden.bs.modal", function () {
                modal.dispose();
                const backdrops = document.getElementsByClassName("modal-backdrop");
                while(backdrops.length > 0) {
                    backdrops[0].remove();
                }
            }, { once: true });
            
            modal.show();
        }

        document.addEventListener("DOMContentLoaded", function() {
            const admisionInfo = document.getElementById("admisionInfo");
            const loginSection = document.getElementById("loginSection");
            const tabs = document.querySelectorAll(".nav-link");
            
            function toggleAdmisionInfo(tabId) {
                if (tabId === "aspirantes-tab") {
                    admisionInfo.style.display = "block";
                    loginSection.classList.remove("col-lg-12");
                    loginSection.classList.add("col-lg-8");
                } else {
                    admisionInfo.style.display = "none";
                    loginSection.classList.remove("col-lg-8");
                    loginSection.classList.add("col-lg-12");
                }
            }
            
            tabs.forEach(tab => {
                tab.addEventListener("click", function() {
                    toggleAdmisionInfo(this.id);
                    
                    if (this.id !== "aspirantes-tab") {
                        this.classList.add("small", "px-2");
                        const icon = this.querySelector("i");
                        if (icon) {
                            icon.classList.remove("me-2");
                            icon.classList.add("me-1");
                        }
                    } else {
                        this.classList.remove("small", "px-2");
                        const icon = this.querySelector("i");
                        if (icon) {
                            icon.classList.remove("me-1");
                            icon.classList.add("me-2");
                        }
                    }
                });
            });

            // Inicializar captchas
            const formularios = [
                "formulario_personal",
                "formulario_alumno", 
                "formulario_iniciar_session_aspirante",
                "formulario_primera_vez_aspirantes_registro"
            ];
            
            formularios.forEach(formId => {
                if (document.getElementById(formId)) {
                    generateCaptcha(formId);
                }
            });

            // Manejar botón vaciar para formulario de aspirantes
            const vaciarBtn = document.getElementById("vaciar_aspirantes_registrados");
            if (vaciarBtn) {
                vaciarBtn.addEventListener("click", function() {
                    const formulario = document.getElementById("formulario_primera_vez_aspirantes_registro");
                    if (formulario) {
                        formulario.reset();
                        generateCaptcha("formulario_primera_vez_aspirantes_registro");
                    }
                });
            }

            // Manejar envío de formularios
            const formRegistro = document.getElementById("formulario_primera_vez_aspirantes_registro");
            if (formRegistro) {
                formRegistro.addEventListener("submit", function(e) {
                    e.preventDefault();
                    
                    if (!verifyCaptcha("formulario_primera_vez_aspirantes_registro")) return;
                    
                    let formData = new FormData(this);
                    formData.append("form_type", "aspirante_registro");
                    
                    fetch(window.location.href, {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        const modalTitle = document.getElementById("registroModalLabel");
                        const modalBody = document.getElementById("modal-body-content");
                        
                        modalTitle.textContent = data.title;
                        modalBody.innerHTML = data.message;
                        
                        if (data.status === "success") {
                            modalBody.classList.add("text-success");
                            modalBody.classList.remove("text-danger");
                            this.reset();
                        } else {
                            modalBody.classList.add("text-danger");
                            modalBody.classList.remove("text-success");
                        }
                        
                        const modal = new bootstrap.Modal(document.getElementById("registroModal"));
                        modal.show();
                        generateCaptcha("formulario_primera_vez_aspirantes_registro");
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        showModalMessage("Error", "Error en el sistema. Por favor, intente más tarde.", "error");
                    });
                });
            }
            
            const formLogin = document.getElementById("formulario_iniciar_session_aspirante");
            if (formLogin) {
                formLogin.addEventListener("submit", function(e) {
                    e.preventDefault();
                    
                    if (!verifyCaptcha("formulario_iniciar_session_aspirante")) return;
                    
                    let formData = new FormData(this);
                    formData.append("form_type", "aspirante_login");
                    
                    fetch(window.location.href, {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        const modalTitle = document.getElementById("registroModalLabel");
                        const modalBody = document.getElementById("modal-body-content");
                        
                        modalTitle.textContent = data.title;
                        modalBody.innerHTML = data.message;
                        
                        if (data.status === "success") {
                            modalBody.classList.add("text-success");
                            modalBody.classList.remove("text-danger");
                            
                            const modal = new bootstrap.Modal(document.getElementById("registroModal"));
                            modal.show();
                            
                            if (data.redirect) {
                                setTimeout(() => {
                                    window.location.href = data.redirect;
                                }, 2000);
                            }
                        } else {
                            modalBody.classList.add("text-danger");
                            modalBody.classList.remove("text-success");
                            const modal = new bootstrap.Modal(document.getElementById("registroModal"));
                            modal.show();
                            generateCaptcha("formulario_iniciar_session_aspirante");
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        showModalMessage("Error", "Error en el sistema. Por favor, intente más tarde.", "error");
                    });
                });
            }
        });
        </script>';
    }
}

$loginController = new LoginController();
$loginController->render();
