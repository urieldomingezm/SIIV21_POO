document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.step-form');
    const progressBar = document.querySelector('.progress-bar');
    const totalSteps = forms.length;
    // Already exists in your code:
    const endpoints = {
        'datosGeneralesForm': '/private/procesos/aspirante/socioeconomicos/captura_datos_generales.php',
        'preparatoriaForm': '/private/procesos/aspirante/socioeconomicos/captura_datos_preparatoria.php',
        'domicilioForm': '/private/procesos/aspirante/socioeconomicos/captura_datos_domicilio.php',
        'padresForm': '/private/procesos/aspirante/socioeconomicos/captura_datos_padres.php',
        'socioeconomicoForm': '/private/procesos/aspirante/socioeconomicos/captura_socioeconomico.php',
        'emergenciaForm': '/private/procesos/aspirante/socioeconomicos/captura_datos_emergencias.php'
    };

    forms.forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }

            const formData = new FormData(this);
            formData.append('form_type', this.id);
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...';

            try {
                const response = await fetch(endpoints[this.id], {
                    method: 'POST',
                    body: formData
                });
                
                // Verificar primero el estado de la respuesta
                if (!response.ok) {
                    throw new Error(`Error HTTP! estado: ${response.status}`);
                }
                
                // Verificar que la respuesta es JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    const text = await response.text();
                    throw new Error(`El servidor respondió con formato incorrecto: ${text.substring(0, 100)}`);
                }
                
                const result = await response.json();
                
                if (result.status === 'success') {
                    // Mark as completed in localStorage
                    localStorage.setItem(`form_${this.id}_completed`, 'true');
                    
                    this.dataset.completed = 'true';
                    updateProgress();
                    
                    // Show success feedback
                    submitBtn.innerHTML = '<i class="bi bi-check-circle"></i> Registrado';
                    submitBtn.classList.remove('btn-primary');
                    submitBtn.classList.add('btn-success');
                    
                    const nextSection = this.closest('.accordion-collapse').nextElementSibling;
                    if (nextSection) {
                        const nextButton = nextSection.querySelector('.accordion-button');
                        bootstrap.Collapse.getOrCreateInstance(nextSection).show();
                        nextButton.focus();
                    }
                } else {
                    throw new Error(result.message || 'Error desconocido del servidor');
                }
            } catch (error) {
                console.error('Error en el formulario:', error);
                submitBtn.innerHTML = 'Guardar y Continuar';
                
                // Show error in modal
                const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                document.getElementById('errorModalMessage').textContent = error.message;
                errorModal.show();
                
                // Re-enable button
                submitBtn.disabled = false;
                submitBtn.innerHTML = this.id === 'emergenciaForm' ? 'Finalizar Registro' : 'Guardar y Continuar';
            }
        });
    });

    function updateProgress() {
        const completedSteps = document.querySelectorAll('.step-form[data-completed="true"]').length;
        const progress = Math.round((completedSteps / totalSteps) * 100);
        
        progressBar.style.width = `${progress}%`;
        progressBar.setAttribute('aria-valuenow', progress);
        progressBar.textContent = `${progress}%`;
        
        // Update step icons
        document.querySelectorAll('.step-icon').forEach((icon, index) => {
            const form = forms[index];
            if (form.dataset.completed === 'true') {
                icon.classList.remove('bi-circle');
                icon.classList.add('bi-check-circle', 'text-success');
            } else {
                icon.classList.remove('bi-check-circle', 'text-success');
                icon.classList.add('bi-circle');
            }
        });
    }

    // On page load, check localStorage for completed forms
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.step-form');
        forms.forEach(form => {
            if (localStorage.getItem(`form_${form.id}_completed`)) {
                form.dataset.completed = 'true';
                const icon = form.closest('.accordion-item').querySelector('.step-icon');
                icon.classList.remove('bi-circle');
                icon.classList.add('bi-check-circle', 'text-success');
                
                const btn = form.querySelector('button[type="submit"]');
                btn.innerHTML = '<i class="bi bi-check-circle"></i> Registrado';
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-success');
            }
        });
        updateProgress();
    });
});