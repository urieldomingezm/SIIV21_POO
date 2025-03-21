
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

  function verifyCaptcha(formId) {
    const form = document.getElementById(formId);
    const userCaptcha = form.querySelector('.captchaInput').value;
    const captchaCode = form.dataset.captchaCode;
  }

  window.onload = function() {
    generateCaptcha('formulario_personal');
    generateCaptcha('formulario_alumno');
    generateCaptcha('formulario_alumnos_session');
    generateCaptcha('formulario_aspirantes_registro');
  }

  // Event listener for clearing aspirant registration form
  document.getElementById('vaciar_aspirantes_registrados').addEventListener('click', function() {
    const formulario = document.getElementById('formulario_aspirantes_registro');
    formulario.reset();
  });

