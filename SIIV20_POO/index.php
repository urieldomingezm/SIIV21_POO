<?php
session_start();

// Initialize database connection
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

$database = new Database();
$conn = $database->getConnection();

class LoginSystem {
    private $db;
    private $curpGenerator;
    private $formValidator;
    private $modalManager;

    public function __construct($db) {
        $this->db = $db;
        $this->curpGenerator = new CURPGenerator();
        $this->formValidator = new FormValidator();
        $this->modalManager = new ModalManager();
    }

    public function handleRegistration($postData) {
        if (!$this->formValidator->validateRequiredFields($postData)) {
            return $this->modalManager->showError('Por favor, complete todos los campos.', '/modulos/alumnos/home.php');
        }

        $userData = $this->formValidator->sanitizeUserData($postData);
        $curp_generada = $this->curpGenerator->generate(
            $userData['nombre'],
            $userData['apellido_paterno'],
            $userData['apellido_materno'],
            $userData['fecha_nacimiento'],
            $userData['sexo'],
            $userData['entidad']
        );

        if (!$this->curpGenerator->validate($userData['curp'], $curp_generada)) {
            return $this->modalManager->showError('La CURP proporcionada no coincide con los datos ingresados.', '/ruta/error.php');
        }

        return $this->registerUser($userData, $curp_generada);
    }

    private function registerUser($userData, $curp_generada) {
        $nip = rand(1000, 9999);
        $hashed_nip = password_hash($nip, PASSWORD_DEFAULT);
        $curp_final = $curp_generada . substr($userData['curp'], 16, 4);

        try {
            $query = "INSERT INTO aspirantes_registrados (curp_registrada, email, celular, password, rol_id)
                     VALUES (:curp_registrada, :email, :celular, :password, 3)";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':curp_registrada' => $curp_final,
                ':email' => $userData['email'],
                ':celular' => $userData['celular'],
                ':password' => $hashed_nip
            ]);

            $_SESSION['ASP'] = $curp_final;
            return $this->modalManager->showSuccess($nip);
        } catch (PDOException $e) {
            return $this->modalManager->showError($e->getMessage(), '/home.php');
        }
    }
}

class CURPGenerator {
    public function generate($nombre, $apellido_paterno, $apellido_materno, $fecha_nacimiento, $sexo, $entidad) {
        // Existing CURP generation logic
        $curp = substr($apellido_paterno, 0, 1);
        $vocal = preg_replace('/[^AEIOU]/', '', substr($apellido_paterno, 1));
        $curp .= substr($vocal, 0, 1);
        // ... rest of the CURP generation logic ...
        return $curp;
    }

    public function validate($curp_enviada, $curp_generada) {
        return (substr($curp_enviada, 0, 16) === $curp_generada);
    }
}

class FormValidator {
    public function validateRequiredFields($data) {
        $required_fields = ['apellido_paterno', 'apellido_materno', 'nombre', 
                          'fecha_nacimiento', 'sexo', 'entidad', 'curp'];
        foreach ($required_fields as $field) {
            if (empty($data[$field])) return false;
        }
        return true;
    }

    public function sanitizeUserData($data) {
        return array_map(function($value) {
            return is_string($value) ? strtoupper(trim($value)) : $value;
        }, $data);
    }
}

class ModalManager {
    public function showError($message, $redirect) {
        return $this->generateModalScript($message, $redirect);
    }

    public function showSuccess($nip) {
        return $this->generateModalScript(
            "Registro exitoso. La CURP es válida.<br>Este es tu NIP (recuerda guardarla o anotarla en algun lugar seguro): $nip",
            '/SIIV20/modulos/aspirantes/index.php'
        );
    }

    private function generateModalScript($message, $redirect) {
        return "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var modalBody = document.getElementById('modal-body-content');
                modalBody.innerHTML = '$message';
                var redirectButton = document.getElementById('modal-redirect');
                redirectButton.href = '$redirect';
                var modal = new bootstrap.Modal(document.getElementById('registroModal'));
                modal.show();
            });
        </script>";
    }
}

// Initialize the system
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(TEMPLATES_PATH . 'header.php');
require_once(CONFIG_PATH . 'bd.php');

// Initialize the system with the database connection
$loginSystem = new LoginSystem($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo $loginSystem->handleRegistration($_POST);
}

?>

<!-- MODAL PARA ALERT -->
<?php require_once(MODALES_INICIO_SESSION_PATH . 'modal_session.php'); ?>

<!--SECCION DE LOGIN GENERAL-->

<section class="accordion-demo">
  <div class="container mt-1">
    <br>
    <h3 class="text-center">INICIO DE SESIÓN GENERAL</h3>
    <div class="tabs">
      <dd data-target="#Aspirantes">
        <a style="color: black;">ASPIRANTE</a>
      </dd>
      <dd data-target="#Alumnos">
        <a style="color: black;">ALUMNO</a>
      </dd>
      <dd data-target="#Personal">
        <a style="color: black;">PERSONAL</a>
      </dd>
    </div>

    <style>
      @media (max-width: 1168px) {
        .tabs dd a {
          display: block;
          font-size: 1.2rem;
          padding: 1rem 0;
          /* Tamaño más pequeño para móviles */
        }
      }

      @media (max-width: 1168px) {
        .btn-dos {}
      }

      .accordion-demo {
        margin: -1.1rem 0;
      }

      .tabs {
        display: flex;
        width: 100%;
      }

      .tabs dd {
        background: #f7fcff;
        border: 2px solid #1B396A;
        border-left: none;
        display: block;
        flex: 1;
        padding-top: 1rem;
        text-align: center;
        transition: all 0.25s ease;
        border-radius: 3px;
      }

      .tabs dd:hover {
        background: #e8f7ff;
      }

      .tabs dd:first-of-type {
        border-left: 2px solid #1B396A;
      }

      .tabs dd.active {
        background: white;
        border-top: 1.5rem solid #1B396A;
        border-bottom: none;
        font-weight: bold;
      }

      .tabs dd.active a {
        color: #0076b5;
      }

      .tabs dd a {
        display: block;
        font-size: 1.1rem;
        padding: 1rem 0;
      }

      .tabs-content {
        background: white;
      }

      .tabs-content .content {
        border: 2px solid #1B396A;
        color: #00659b;
        display: none;
        margin-top: -65px;
        padding: 4rem;
        border-radius: 7px;
      }

      .tabs-content .content.active {
        display: block;
      }

      .tabs-content .content p {
        margin: 0;
      }
    </style>



    <div class="tabs-content mt-3">
      <div class="content" id="Aspirantes">
        <div class="accordion accordion-flush" id="accordionFlushExample">
          <!-- Acordeón 1: Registro por primera vez -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
              <button class="accordion-button collapsed" style="background-color: #8ac9db; color: black;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                Registro por primera vez
              </button>
            </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">
                <div id="container">
                  <form id="formulario_aspirantes_registro" class="was-validated rounded" method="POST">

                    <div class="row mb-3 justify-content-center">
                      <!-- Apellido Paterno -->
                      <div class="col-md-2 mb-3">
                        <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
                        <input type="text" class="form-control form-control-sm" id="apellido_paterno" name="apellido_paterno" required>
                      </div>

                      <!-- Apellido Materno -->
                      <div class="col-md-2 mb-3 ">
                        <label for="apellido_materno" class="form-label">Apellido Materno</label>
                        <input type="text" class="form-control form-control-sm" id="apellido_materno" name="apellido_materno" required>
                      </div>

                      <!-- Nombre del Aspirante -->
                      <div class="col-md-2 mb-3">
                        <label for="nombre" class="form-label">Nombre(S)</label>
                        <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" required>
                      </div>

                      <!-- Fecha de Nacimiento -->
                      <div class="col-md-2 mb-3">
                        <label for="fecha_nacimiento" class="form-label">Fecha Nacimiento</label>
                        <input type="date" class="form-control form-control-sm" id="fecha_nacimiento" name="fecha_nacimiento" value="2003-01-01">
                      </div>

                      <!-- Sexo -->
                      <div class="col-md-2 mb-3">
                        <label for="sexo" class="form-label">Sexo</label>
                        <select class="form-select form-select-sm" id="sexo" name="sexo" required>
                          <option value="" disabled selected>Selecciona</option>
                          <option value="H">Masculino</option>
                          <option value="F">Femenino</option>
                        </select>
                      </div>


                      <!-- Entidad Federativa -->
                      <div class="col-md-2 mb-3">
                        <label for="entidad" class="form-label">Estado</label>
                        <select class="form-select form-select-sm" id="entidad" name="entidad" required>
                          <option value="TS">Tamaulipas</option>
                          <option value="AS">Aguascalientes</option>
                          <option value="BC">Baja California</option>
                          <option value="BS">Baja California Sur</option>
                          <option value="CC">Campeche</option>
                          <option value="CL">Coahuila</option>
                          <option value="CM">Colima</option>
                          <option value="CS">Chiapas</option>
                          <option value="CH">Chihuahua</option>
                          <option value="DF">Ciudad de México</option>
                          <option value="DG">Durango</option>
                          <option value="GT">Guanajuato</option>
                          <option value="GR">Guerrero</option>
                          <option value="HG">Hidalgo</option>
                          <option value="JC">Jalisco</option>
                          <option value="MC">Estado de México</option>
                          <option value="MN">Michoacán</option>
                          <option value="MS">Morelos</option>
                          <option value="NT">Nayarit</option>
                          <option value="NL">Nuevo León</option>
                          <option value="OC">Oaxaca</option>
                          <option value="PL">Puebla</option>
                          <option value="QT">Querétaro</option>
                          <option value="QR">Quintana Roo</option>
                          <option value="SP">San Luis Potosí</option>
                          <option value="SL">Sinaloa</option>
                          <option value="SR">Sonora</option>
                          <option value="TC">Tabasco</option>
                          <option value="TL">Tlaxcala</option>
                          <option value="VZ">Veracruz</option>
                          <option value="YN">Yucatán</option>
                          <option value="ZS">Zacatecas</option>
                        </select>
                      </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                      <!-- CURP -->
                      <div class="col-lg-3 mb-3">
                        <label for="curp" class="form-label">CURP</label>
                        <input type="text" class="form-control form-control-sm" maxlength="18" id="curp" name="curp" required>
                      </div>

                      <!-- CELULAR -->
                      <div class="col-lg-2 mb-3">
                        <label for="celular" class="form-label">Celular</label>
                        <input type="text" class="form-control form-control-sm" id="celular" maxlength="10" name="celular" required>
                      </div>

                      <div class="col-md-2 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control form-control-sm" id="email" name="email" required>
                      </div>

                      <!-- CAPTCHA -->
                      <div class="col-lg-4 mb-3">
                        <label for="aspirante_registro_captcha" class="form-label">Captcha</label>
                        <div class="d-flex align-items-center">
                          <input type="text" class="form-control form-control-sm" id="aspirante_registro_captcha" name="aspirante_registro_captcha" maxlength="5" required>
                          <canvas class="captchaCanvas" width="128" height="40" class="ms-2"></canvas>
                          <button type="button" class="btn btn-secondary me-1 ms-2" onclick="generateCaptcha('formulario_aspirantes_registro')">
                            <i class="bi bi-arrow-clockwise"></i></button>
                        </div>
                      </div>
                    </div>

                    <!-- Botones -->
                    <div class="text-center">
                      <button type="button" id="vaciar_aspirantes_registrados" class="btn btn-secondary btn-dos btn-lg">VACIAR</button>
                      <button type="submit" class="btn btn-primary btn-dos btn-lg">GUARDAR</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>


          <!--FUNCION PARA ELIMINAR PARA ASPIRANTE DE NUEVO REGISTRO-->
          <script>
            document.getElementById('vaciar_aspirantes_registrados').addEventListener('click', function() {
              const formulario = document.getElementById('formulario_aspirantes_registro');
              formulario.reset();
            });
          </script>

          <br>

          <!-- Acordeón 2: Iniciar sesión -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingTwo">
              <button class="accordion-button collapsed" style="background-color: #8ac9db; color: black;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                Iniciar sesión
              </button>
            </h2>
            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">
                <form id="formulario_alumnos_session" action="private/procesos/login_aspirantes.php" method="POST" class="was-validated rounded">

                  <div class="row justify-content-center">

                    <!-- CURP -->
                    <div class="col-lg-4 mb-3">
                      <label for="aspirante_curp" class="form-label">CURP</label>
                      <input type="text" class="form-control form-control-lg" id="aspirante_curp" maxlength="18" name="aspirante_curp" required>
                    </div>

                    <!-- Contraseña (NIP) -->
                    <div class="col-lg-3 mb-3">
                      <label for="aspirante_password" class="form-label">NIP</label>
                      <div class="d-flex align-items-center">
                        <input
                          type="password"
                          class="form-control form-control-lg passwordInput"
                          id="aspirante_password"
                          name="aspirante_password"
                          maxlength="4"
                          required>
                        <button
                          type="button"
                          class="btn btn-secondary ms-2 togglePassword"
                          onclick="togglePasswordVisibility('aspirante_password', this)">
                          <i class="bi bi-eye-slash"></i>
                        </button>
                      </div>
                    </div>

                    <!-- CAPTCHA -->
                    <div class="col-lg-5 mb-3">
                      <label for="aspirante_captcha" class="form-label">CAPTCHA</label>
                      <div class="d-flex align-items-center">
                        <input type="text" class="form-control form-control-lg captchaInput" id="aspirante_captcha" name="aspirante_captcha" maxlength="5" required>
                        <canvas class="captchaCanvas ms-2" width="128" height="40"></canvas>
                        <button type="button" class="btn btn-secondary me-1 ms-2" onclick="generateCaptcha('formulario_alumnos_session')">
                          <i class="bi bi-arrow-clockwise"></i></button>
                      </div>
                    </div>

                  </div>

                  <br>
                  <div class="d-flex justify-content-center">
                    <br>
                    <button type="submit" class="btn btn-primary btn-lg">Iniciar Sesión</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--ALUMNOS-->

      <div class="content" id="Alumnos">
        <form id="formulario_alumno" action="private/procesos/login_alumnos_personal.php" method="POST" class="was-validated rounded">
          <br>
          <div class="row justify-content-center">

            <!-- Número de Control -->
            <div class="col-lg-3 mb-3">
              <label for="alumno_numero_control" class="form-label">NUMERO DE CONTROL</label>
              <input type="text" class="form-control form-control-lg" id="alumno_numero_control" name="usuario" required>
            </div>

            <!-- Contraseña (NIP) -->
            <div class="col-lg-3 mb-3">
              <label for="alumno_password" class="form-label">NIP</label>
              <div class="d-flex align-items-center">
                <input
                  type="password"
                  class="form-control form-control-lg passwordInput"
                  id="alumno_password"
                  name="password"
                  maxlength="4"
                  required>
                <button
                  type="button"
                  class="btn btn-secondary ms-2 togglePassword"
                  onclick="togglePasswordVisibility('alumno_password', this)">
                  <i class="bi bi-eye-slash"></i>
                </button>
              </div>
            </div>

            <!-- CAPTCHA -->
            <div class="col-lg-4 mb-3">
              <label for="alumno_captcha" class="form-label">CAPTCHA</label>
              <div class="d-flex align-items-center">
                <input type="text" class="form-control form-control-lg captchaInput" id="alumno_captcha" name="alumno_captcha" maxlength="5" required>
                <canvas class="captchaCanvas" width="128" height="40" class="ms-2"></canvas>
                <button type="button" class="btn btn-secondary me-1 ms-2" onclick="generateCaptcha('formulario_alumno')">
                  <i class="bi bi-arrow-clockwise"></i></button>
              </div>
            </div>
          </div>

          <br>
          <div class="d-flex justify-content-center">
            <br>
            <br>
            <button type="submit" class="btn btn-primary btn-lg">Iniciar Sesión</button>
          </div>
        </form>
      </div>

      <!--PERSONAL ACADEMICO-->

      <div class="content" id="Personal">
        <form id="formulario_personal" action="private/procesos/login_alumnos_personal.php" method="POST" class="was-validated rounded">
          <br>
          <div class="row justify-content-center">

            <!-- Usuario -->
            <div class="col-lg-5 mb-4">
              <label for="personal_usuario" class="form-label">USUARIO</label>
              <input type="text" class="form-control form-control-lg" id="personal_usuario" maxlength="20" name="usuario" required>
            </div>

            <!-- Contraseña -->
            <div class="col-lg-3 mb-4">
              <label for="personal_password" class="form-label">CONTRASEÑA</label>
              <div class="d-flex align-items-center">
                <input
                  type="password"
                  class="form-control form-control-lg passwordInput"
                  id="personal_password"
                  name="password"
                  required>
                <button
                  type="button"
                  class="btn btn-secondary ms-2 togglePassword"
                  onclick="togglePasswordVisibility('personal_password', this)">
                  <i class="bi bi-eye-slash"></i>
                </button>
              </div>
            </div>

            <!-- CAPTCHA -->
            <div class="col-lg-4 mb-3">
              <label for="personal_captcha" class="form-label">CAPTCHA</label>
              <div class="d-flex align-items-center">
                <input type="text" class="form-control form-control-lg captchaInput" id="personal_captcha" name="personal_captcha" maxlength="5" required>
                <canvas class="captchaCanvas" width="128" height="44" class="ms-2"></canvas>
                <button type="button" class="btn btn-secondary me-1 ms-2" onclick="generateCaptcha('formulario_personal')">
                  <i class="bi bi-arrow-clockwise"></i></button>
              </div>
            </div>
          </div>

          <br>
          <div class="d-flex justify-content-center">
            <br>
            <br>
            <button type="submit" class="btn btn-primary btn-lg">Iniciar Sesión</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<style>
  @media (max-width: 855px) {
    .mb-3 {
      width: 100%;
    }
  }

  @media (max-width: 855px) {

    .col-md-4 {
      width: 45%;
    }
  }

  @media (max-width: 855px) {

    .col-md-3 {
      width: 39%;
    }
  }
</style>

<style>
  .mt-3 {
    margin-top: -1rem !important;
  }
</style>

<script>
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

  // Función para generar el CAPTCHA para un formulario específico
  function generateCaptcha(formId) {
    const characters = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ123456789';
    let captchaCode = '';

    for (let i = 0; i < 5; i++) {
      captchaCode += characters.charAt(Math.floor(Math.random() * characters.length));
    }

    // Almacenar el código CAPTCHA en un atributo de datos en el formulario específico
    document.getElementById(formId).dataset.captchaCode = captchaCode;

    // Obtener el canvas específico del formulario y su contexto de dibujo
    const canvas = document.getElementById(formId).querySelector('.captchaCanvas');
    const ctx = canvas.getContext('2d');

    // Limpiar el lienzo antes de dibujar un nuevo CAPTCHA
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Dibujar el CAPTCHA en el lienzo
    ctx.font = '30px Arial';
    ctx.fillStyle = 'black';
    ctx.textBaseline = 'middle';
    ctx.fillText(captchaCode, 20, canvas.height / 2);

    // Añadir ruido con líneas aleatorias
    for (let i = 0; i < 5; i++) {
      ctx.strokeStyle = 'gray';
      ctx.beginPath();
      ctx.moveTo(Math.random() * canvas.width, Math.random() * canvas.height);
      ctx.lineTo(Math.random() * canvas.width, Math.random() * canvas.height);
      ctx.stroke();
    }
  }

  // Función para verificar el CAPTCHA ingresado en un formulario específico
  function verifyCaptcha(formId) {
    const form = document.getElementById(formId);
    const userCaptcha = form.querySelector('.captchaInput').value;
    const captchaCode = form.dataset.captchaCode;
  }

  // Generar CAPTCHA al cargar la página para cada formulario
  window.onload = function() {
    generateCaptcha('formulario_personal');
    generateCaptcha('formulario_alumno');
    generateCaptcha('formulario_alumnos_session');
    generateCaptcha('formulario_aspirantes_registro');
  }
</script>



<?php require_once(TEMPLATES_PATH . 'footer.php'); ?>