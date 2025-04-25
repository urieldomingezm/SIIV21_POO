
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

  document.querySelectorAll('.tabs dd').forEach(tab => {
    tab.addEventListener('click', function() {
      document.querySelectorAll('.tabs dd').forEach(t => t.classList.remove('active'));
      this.classList.add('active');
      document.querySelectorAll('.tabs-content .content').forEach(content => {
        content.classList.remove('active');
      });
      const targetId = this.getAttribute('data-target');
      document.querySelector(targetId).classList.add('active');
    });
  });

  function generateCaptcha(formId) {
    const characters = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ123456789';
    let captchaCode = '';

    for (let i = 0; i < 5; i++) {
      captchaCode += characters.charAt(Math.floor(Math.random() * characters.length));
    }

    document.getElementById(formId).dataset.captchaCode = captchaCode;

    const canvas = document.getElementById(formId).querySelector('.captchaCanvas');
    const ctx = canvas.getContext('2d');

    ctx.clearRect(0, 0, canvas.width, canvas.height);

    ctx.font = '30px Arial';
    ctx.fillStyle = 'black';
    ctx.textBaseline = 'middle';
    ctx.fillText(captchaCode, 20, canvas.height / 2);

    for (let i = 0; i < 5; i++) {
      ctx.strokeStyle = 'gray';
      ctx.beginPath();
      ctx.moveTo(Math.random() * canvas.width, Math.random() * canvas.height);
      ctx.lineTo(Math.random() * canvas.width, Math.random() * canvas.height);
      ctx.stroke();
    }
  }

  // Add this at the top of your script.js
  function verifyCaptcha(formId) {
      const form = document.getElementById(formId);
      const userCaptcha = form.querySelector('.captchaInput').value;
      const captchaCode = form.dataset.captchaCode;
      
      if (!userCaptcha || userCaptcha !== captchaCode) {
          showModalMessage('Error de CAPTCHA', 'Por favor ingrese el código CAPTCHA correctamente', 'error');
          generateCaptcha(formId); // Regenerate CAPTCHA on error
          return false;
      }
      return true;
  }
  
  function showModalMessage(title, message, status) {
      const modalTitle = document.getElementById('registroModalLabel');
      const modalBody = document.getElementById('modal-body-content');
      
      modalTitle.textContent = title;
      modalBody.innerHTML = message;
      
      if (status === 'success') {
          modalBody.classList.add('text-success');
          modalBody.classList.remove('text-danger');
      } else {
          modalBody.classList.add('text-danger');
          modalBody.classList.remove('text-success');
      }
      
      const modal = new bootstrap.Modal(document.getElementById('registroModal'));
      modal.show();
  }

  window.onload = function() {
    generateCaptcha('formulario_personal');
    generateCaptcha('formulario_alumno');
    generateCaptcha('formulario_iniciar_session_aspirante');
    generateCaptcha('formulario_primera_vez_aspirantes_registro');
  }

  // Event listener for clearing aspirant registration form
  document.getElementById('vaciar_aspirantes_registrados').addEventListener('click', function() {
    const formulario = document.getElementById('formulario_primera_vez_aspirantes_registro');
    formulario.reset();
  });

  // Add this to your existing script.js
  document.getElementById('formulario_primera_vez_aspirantes_registro').addEventListener('submit', function(e) {
      e.preventDefault();
      
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
              this.reset(); // Reset form on success
          } else {
              modalBody.classList.add('text-danger');
              modalBody.classList.remove('text-success');
          }
          
          const modal = new bootstrap.Modal(document.getElementById('registroModal'));
          modal.show();
      })
      .catch(error => {
          console.error('Error:', error);
          const modalBody = document.getElementById('modal-body-content');
          modalBody.innerHTML = 'Error en el sistema. Por favor, intente más tarde.';
          modalBody.classList.add('text-danger');
          const modal = new bootstrap.Modal(document.getElementById('registroModal'));
          modal.show();
      });
  });
  // Add this alongside your existing form handlers
  document.getElementById('formulario_alumno').addEventListener('submit', function(e) {
      e.preventDefault();
      
      if (!verifyCaptcha('formulario_alumno')) return;
      
      let formData = new FormData(this);
      
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
              
              // Show success message in modal
              const modal = new bootstrap.Modal(document.getElementById('registroModal'));
              modal.show();
              
              // Redirect after 2 seconds if redirect URL is provided
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
              
              // Regenerate CAPTCHA on error
              generateCaptcha('formulario_alumno');
          }
      })
      .catch(error => {
          console.error('Error:', error);
          const modalBody = document.getElementById('modal-body-content');
          modalBody.innerHTML = 'Error en el sistema. Por favor, intente más tarde.';
          modalBody.classList.add('text-danger');
          const modal = new bootstrap.Modal(document.getElementById('registroModal'));
          modal.show();
      });
  });
  document.getElementById('formulario_iniciar_session_aspirante').addEventListener('submit', function(e) {
      e.preventDefault();
      
      if (!verifyCaptcha('formulario_iniciar_session_aspirante')) return;
      
      let formData = new FormData(this);
      formData.append('csrf_token', document.querySelector('input[name="csrf_token"]').value);
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
              
              // Show success message in modal
              const modal = new bootstrap.Modal(document.getElementById('registroModal'));
              modal.show();
              
              // Redirect after 2 seconds
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
          }
      })
      .catch(error => {
          console.error('Error:', error);
          const modalBody = document.getElementById('modal-body-content');
          modalBody.innerHTML = 'Error en el sistema. Por favor, intente más tarde.';
          modalBody.classList.add('text-danger');
          const modal = new bootstrap.Modal(document.getElementById('registroModal'));
          modal.show();
      });
  });
  // Add this alongside your existing form handlers
  document.getElementById('formulario_personal').addEventListener('submit', function(e) {
      e.preventDefault();
      
      if (!verifyCaptcha('formulario_personal')) return;
      
      let formData = new FormData(this);
      
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
              
              // Show success message in modal
              const modal = new bootstrap.Modal(document.getElementById('registroModal'));
              modal.show();
              
              // Redirect after 2 seconds if redirect URL is provided
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
          }
      })
      .catch(error => {
          console.error('Error:', error);
          const modalBody = document.getElementById('modal-body-content');
          modalBody.innerHTML = 'Error en el sistema. Por favor, intente más tarde.';
          modalBody.classList.add('text-danger');
          const modal = new bootstrap.Modal(document.getElementById('registroModal'));
          modal.show();
      });
  });

