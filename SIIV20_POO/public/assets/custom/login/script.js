
function togglePasswordVisibility(inputId, button) {
    const passwordInput = document.getElementById(inputId);
    const icon = button.querySelector('i');

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    } else {
        passwordInput.type = "password";
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    }
}

// Función mejorada para manejar tabs de Bootstrap
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tabs de Bootstrap
    const triggerTabList = document.querySelectorAll('#loginTabs button[data-bs-toggle="tab"]');
    triggerTabList.forEach(triggerEl => {
        const tabTrigger = new bootstrap.Tab(triggerEl);
        
        triggerEl.addEventListener('click', event => {
            event.preventDefault();
            tabTrigger.show();
        });
    });
});

function generateCaptcha(formId) {
    const characters = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ123456789';
    let captchaCode = '';

    for (let i = 0; i < 5; i++) {
        captchaCode += characters.charAt(Math.floor(Math.random() * characters.length));
    }

    document.getElementById(formId).dataset.captchaCode = captchaCode;

    // Buscar canvas tanto con clase .captchaCanvas como .captcha-canvas
    let canvas = document.getElementById(formId).querySelector('.captchaCanvas');
    if (!canvas) {
        canvas = document.getElementById(formId).querySelector('.captcha-canvas');
    }
    
    if (!canvas) {
        console.error('No se encontró canvas para el formulario:', formId);
        return;
    }

    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Configurar estilo del texto
    ctx.font = '24px Arial';
    ctx.fillStyle = '#333';
    ctx.textBaseline = 'middle';
    ctx.textAlign = 'center';
    
    // Dibujar el código captcha
    ctx.fillText(captchaCode, canvas.width / 2, canvas.height / 2);

    // Agregar líneas de ruido
    for (let i = 0; i < 3; i++) {
        ctx.strokeStyle = '#ccc';
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
    
    // Buscar input de captcha con diferentes selectores
    const captchaInput = form.querySelector('.captchaInput') || 
                        form.querySelector('input[name*="captcha"]') ||
                        form.querySelector('#' + formId.replace('formulario_', '') + '_captcha');
    
    if (captchaInput) {
        userCaptcha = captchaInput.value;
    }
    
    const captchaCode = form.dataset.captchaCode;
    
    if (!userCaptcha || userCaptcha !== captchaCode) {
        // Asegurarse de que cualquier modal previo esté cerrado
        const existingModal = bootstrap.Modal.getInstance(document.getElementById('registroModal'));
        if (existingModal) {
            existingModal.dispose();
        }
        
        showModalMessage('Error de CAPTCHA', 'Por favor ingrese el código CAPTCHA correctamente', 'error');
        generateCaptcha(formId);
        return false;
    }
    return true;
}

function showModalMessage(title, message, status) {
    const modalElement = document.getElementById('registroModal');
    const modalTitle = document.getElementById('registroModalLabel');
    const modalBody = document.getElementById('modal-body-content');
    
    // Limpiar cualquier instancia previa del modal
    const existingModal = bootstrap.Modal.getInstance(modalElement);
    if (existingModal) {
        existingModal.dispose();
    }
    
    modalTitle.textContent = title;
    modalBody.innerHTML = message;
    
    if (status === 'success') {
        modalBody.classList.add('text-success');
        modalBody.classList.remove('text-danger');
    } else {
        modalBody.classList.add('text-danger');
        modalBody.classList.remove('text-success');
    }
    
    // Crear nueva instancia del modal
    const modal = new bootstrap.Modal(modalElement, {
        backdrop: 'static',
        keyboard: false
    });
    
    // Agregar evento para limpiar el modal cuando se cierre
    modalElement.addEventListener('hidden.bs.modal', function () {
        modal.dispose();
        // Remover el backdrop manualmente si aún existe
        const backdrops = document.getElementsByClassName('modal-backdrop');
        while(backdrops.length > 0) {
            backdrops[0].remove();
        }
    }, { once: true });
    
    modal.show();
}

// Inicializar captchas cuando la página carga
window.addEventListener('load', function() {
    // Generar captchas para todos los formularios
    const formularios = [
        'formulario_personal',
        'formulario_alumno', 
        'formulario_iniciar_session_aspirante',
        'formulario_primera_vez_aspirantes_registro'
    ];
    
    formularios.forEach(formId => {
        if (document.getElementById(formId)) {
            generateCaptcha(formId);
        }
    });
});

// Event listener para limpiar formulario de aspirantes
document.addEventListener('DOMContentLoaded', function() {
    const vaciarBtn = document.getElementById('vaciar_aspirantes_registrados');
    if (vaciarBtn) {
        vaciarBtn.addEventListener('click', function() {
            const formulario = document.getElementById('formulario_primera_vez_aspirantes_registro');
            if (formulario) {
                formulario.reset();
                generateCaptcha('formulario_primera_vez_aspirantes_registro');
            }
        });
    }
});

// Manejadores de formularios
document.addEventListener('DOMContentLoaded', function() {
    // Formulario de registro de aspirantes
    const formRegistro = document.getElementById('formulario_primera_vez_aspirantes_registro');
    if (formRegistro) {
        formRegistro.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!verifyCaptcha('formulario_primera_vez_aspirantes_registro')) return;
            
            let formData = new FormData(this);
            formData.append('form_type', 'aspirante_registro');
            
            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const modalTitle = document.getElementById('registroModalLabel');
                const modalBody = document.getElementById('modal-body-content');
                
                modalTitle.textContent = data.title;
                modalBody.innerHTML = data.message;
                
                if (data.status === 'success') {
                    modalBody.classList.add('text-success');
                    modalBody.classList.remove('text-danger');
                    this.reset();
                } else {
                    modalBody.classList.add('text-danger');
                    modalBody.classList.remove('text-success');
                }
                
                const modal = new bootstrap.Modal(document.getElementById('registroModal'));
                modal.show();
                generateCaptcha('formulario_primera_vez_aspirantes_registro');
            })
            .catch(error => {
                console.error('Error:', error);
                showModalMessage('Error', 'Error en el sistema. Por favor, intente más tarde.', 'error');
            });
        });
    }
    
    // Formulario de login de aspirantes
    const formLogin = document.getElementById('formulario_iniciar_session_aspirante');
    if (formLogin) {
        formLogin.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!verifyCaptcha('formulario_iniciar_session_aspirante')) return;
            
            let formData = new FormData(this);
            formData.append('form_type', 'aspirante_login');
            
            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const modalTitle = document.getElementById('registroModalLabel');
                const modalBody = document.getElementById('modal-body-content');
                
                modalTitle.textContent = data.title;
                modalBody.innerHTML = data.message;
                
                if (data.status === 'success') {
                    modalBody.classList.add('text-success');
                    modalBody.classList.remove('text-danger');
                    
                    const modal = new bootstrap.Modal(document.getElementById('registroModal'));
                    modal.show();
                    
                    if (data.redirect) {
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 2000);
                    }
                } else {
                    modalBody.classList.add('text-danger');
                    modalBody.classList.remove('text-success');
                    const modal = new bootstrap.Modal(document.getElementById('registroModal'));
                    modal.show();
                    generateCaptcha('formulario_iniciar_session_aspirante');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showModalMessage('Error', 'Error en el sistema. Por favor, intente más tarde.', 'error');
            });
        });
    }
});

// Agregar al final del archivo script.js

// REEMPLAZAR TODO EL CÓDIGO DE ACORDEONES (líneas 270-321) CON ESTO:

// Manejar el colapso de acordeones al cambiar de tab
document.addEventListener('DOMContentLoaded', function() {
    // Función para cerrar todos los acordeones
    function closeAllAccordions() {
        const accordions = document.querySelectorAll('#accordionFlushExample .accordion-collapse');
        accordions.forEach(accordion => {
            if (accordion.classList.contains('show')) {
                const bsCollapse = bootstrap.Collapse.getInstance(accordion);
                if (bsCollapse) {
                    bsCollapse.hide();
                } else {
                    // Forzar el cierre si no hay instancia
                    accordion.classList.remove('show');
                }
            }
        });
    }
    
    // Escuchar eventos de cambio de tab
    const tabButtons = document.querySelectorAll('#loginTabs button[data-bs-toggle="tab"]');
    
    tabButtons.forEach(button => {
        // Evento cuando se muestra la pestaña
        button.addEventListener('shown.bs.tab', function(event) {
            const targetTab = event.target.getAttribute('data-bs-target');
            
            // Cerrar acordeones si NO estamos en la pestaña de Aspirantes
            if (targetTab !== '#Aspirantes') {
                closeAllAccordions();
            }
        });
        
        // Evento adicional al hacer clic
        button.addEventListener('click', function(event) {
            const targetTab = event.target.getAttribute('data-bs-target');
            
            // Cerrar acordeones inmediatamente si no es Aspirantes
            if (targetTab !== '#Aspirantes') {
                setTimeout(closeAllAccordions, 50);
            }
        });
    });
});

