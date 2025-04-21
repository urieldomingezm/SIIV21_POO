// Script para validar el formulario de datos socioeconómicos mediante multiple steps
// y actualizar el progreso de la barra de progreso

document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.step-form');
    const progressBar = document.querySelector('.progress-bar');
    const accordionItems = document.querySelectorAll('.accordion-item');
    const totalSteps = forms.length;
    let completedSteps = 0;

    // Check for completed steps in localStorage
    const checkCompletedSteps = () => {
        forms.forEach((form, index) => {
            const isCompleted = localStorage.getItem(`step_${index}_completed`);
            if (isCompleted === 'true') {
                completedSteps++;
                markStepCompleted(accordionItems[index]);
            }
        });
        updateProgress();
    };

    // Update progress bar
    const updateProgress = () => {
        const progress = (completedSteps / totalSteps) * 100;
        progressBar.style.width = `${progress}%`;
        progressBar.setAttribute('aria-valuenow', progress);
    };

    // Mark step as completed
    const markStepCompleted = (accordionItem) => {
        const button = accordionItem.querySelector('.accordion-button');
        const icon = button.querySelector('.step-icon');
        button.classList.add('completed');
        icon.classList.remove('bi-circle');
        icon.classList.add('bi-check-circle-fill');
        icon.style.color = '#198754';
    };

    // Move to next section
    const moveToNextSection = (currentAccordionItem) => {
        const nextAccordionItem = currentAccordionItem.nextElementSibling;
        if (nextAccordionItem) {
            const nextCollapse = nextAccordionItem.querySelector('.accordion-collapse');
            const currentCollapse = currentAccordionItem.querySelector('.accordion-collapse');
            
            new bootstrap.Collapse(currentCollapse).hide();
            new bootstrap.Collapse(nextCollapse).show();
        }
    };

    // Handle form submissions
    forms.forEach((form, index) => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!form.checkValidity()) {
                e.stopPropagation();
                form.classList.add('was-validated');
                return;
            }

            const formData = new FormData(form);
            formData.append('form_type', form.id);
            const accordionItem = form.closest('.accordion-item');
            
            fetch('guardar_datos_socioeconomicos.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    localStorage.setItem(`step_${index}_completed`, 'true');
                    completedSteps++;
                    updateProgress();
                    markStepCompleted(accordionItem);
                    
                    if (index < totalSteps - 1) {
                        moveToNextSection(accordionItem);
                    }
                    
                    Swal.fire({
                        icon: 'success',
                        title: '¡Guardado!',
                        text: data.message || 'Información guardada correctamente',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    if (index === totalSteps - 1) {
                        setTimeout(() => {
                            window.location.href = 'dashboard.php';
                        }, 1500);
                    }
                } else {
                    throw new Error(data.message || 'Error al guardar');
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message
                });
            });
        });
    });

    // Check completed steps on page load
    checkCompletedSteps();
});