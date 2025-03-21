<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');


// Initialize database connection
$database = new Database();
$conn = $database->getConnection();

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

class LoginSystem
{
  private $db;
  private $curpGenerator;
  private $formValidator;
  private $modalManager;

  public function __construct($db)
  {
    $this->db = $db;
    $this->curpGenerator = new CURPGenerator();
    $this->formValidator = new FormValidator();
    $this->modalManager = new ModalManager();
  }

  public function handleRegistration($postData)
  {
    if (!isset($postData['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $postData['csrf_token'])) {
      return $this->modalManager->showError('Invalid security token.', '/index.php');
    }

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

  private function registerUser($userData, $curp_generada)
  {
    $nip = random_int(1000, 9999); // Using cryptographically secure random number
    $hashed_nip = password_hash($nip, PASSWORD_DEFAULT);
    $curp_final = $curp_generada . substr($userData['curp'], 16, 4);

    try {
      $query = "INSERT INTO aspirantes_registrados (curp_registrada, email, celular, password, rol_id, created_at)
                     VALUES (:curp_registrada, :email, :celular, :password, 3, NOW())";

      $stmt = $this->db->prepare($query);
      $stmt->execute([
        ':curp_registrada' => $curp_final,
        ':email' => filter_var($userData['email'], FILTER_SANITIZE_EMAIL),
        ':celular' => preg_replace('/[^0-9]/', '', $userData['celular']),
        ':password' => $hashed_nip
      ]);

      $_SESSION['ASP'] = $curp_final;
      $_SESSION['last_activity'] = time();
      return $this->modalManager->showSuccess($nip);
    } catch (PDOException $e) {
      error_log("Registration error: " . $e->getMessage());
      return $this->modalManager->showError('Error en el registro. Por favor, intente más tarde.', '/home.php');
    }
  }
}

class CURPGenerator
{
  public function generate($nombre, $apellido_paterno, $apellido_materno, $fecha_nacimiento, $sexo, $entidad)
  {
    // Existing CURP generation logic
    $curp = substr($apellido_paterno, 0, 1);
    $vocal = preg_replace('/[^AEIOU]/', '', substr($apellido_paterno, 1));
    $curp .= substr($vocal, 0, 1);
    // ... rest of the CURP generation logic ...
    return $curp;
  }

  public function validate($curp_enviada, $curp_generada)
  {
    return (substr($curp_enviada, 0, 16) === $curp_generada);
  }
}

class FormValidator
{
  public function validateRequiredFields($data)
  {
    $required_fields = [
      'apellido_paterno',
      'apellido_materno',
      'nombre',
      'fecha_nacimiento',
      'sexo',
      'entidad',
      'curp'
    ];
    foreach ($required_fields as $field) {
      if (empty($data[$field])) return false;
    }
    return true;
  }

  public function sanitizeUserData($data)
  {
    return array_map(function ($value) {
      return is_string($value) ? strtoupper(trim($value)) : $value;
    }, $data);
  }
}

class ModalManager
{
  public function showError($message, $redirect)
  {
    return $this->generateModalScript($message, $redirect);
  }

  public function showSuccess($nip)
  {
    return $this->generateModalScript(
      "Registro exitoso. La CURP es válida.<br>Este es tu NIP (recuerda guardarla o anotarla en algun lugar seguro): $nip",
      '/SIIV20/modulos/aspirantes/index.php'
    );
  }

  private function generateModalScript($message, $redirect)
  {
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
require_once(TEMPLATES_PATH . 'header.php');

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
    <div class="tabs" role="tablist">
      <dd data-target="#Aspirantes" role="tab">
        <a href="#" style="color: black;">ASPIRANTES</a>
      </dd>
      <dd data-target="#Alumnos" role="tab">
        <a href="#" style="color: black;">ALUMNOS</a>
      </dd>
      <dd data-target="#Personal" role="tab">
        <a href="#" style="color: black;">PERSONAL</a>
      </dd>
    </div>

    <div class="tabs-content mt-3">
      <?php
      $sections = ['aspirante', 'alumno', 'personal'];
      foreach ($sections as $section) {
        require_once(CUSTOM_INDEX_LOGIN . "seccion_$section.php");
      }
      ?>
    </div>
  </div>
</section>

<!-- External Resources -->
<style>
  <?php require_once(CUSTOM_INDEX_LOGIN . 'style.css'); ?>
</style>
<script>
  <?php require_once(CUSTOM_INDEX_LOGIN . 'script.js'); ?>
</script>

<?php require_once(TEMPLATES_PATH . 'footer.php'); ?>