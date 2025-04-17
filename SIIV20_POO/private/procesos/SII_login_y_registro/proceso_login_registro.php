<?php

// Initialize database connection
$database = new Database();
$conn = $database->getConnection();

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

class CURPGenerator {
    public function generate($apellido_paterno, $apellido_materno, $nombre, $fecha_nacimiento, $sexo, $entidad) {
        // Limpiar y convertir a mayúsculas
        $apellido_paterno = strtoupper(trim($apellido_paterno));
        $apellido_materno = strtoupper(trim($apellido_materno));
        $nombre = strtoupper(trim($nombre));
        
        // Primera letra del apellido paterno y primera vocal interna
        $curp = substr($apellido_paterno, 0, 1);
        $vocales = preg_replace('/[^AEIOU]/', '', substr($apellido_paterno, 1));
        $curp .= substr($vocales, 0, 1);
        
        // Primera letra del apellido materno
        $curp .= substr($apellido_materno, 0, 1);
        
        // Primera letra del nombre
        $curp .= substr($nombre, 0, 1);
        
        // Fecha de nacimiento (YYMMDD)
        $fecha = new DateTime($fecha_nacimiento);
        $curp .= $fecha->format('ymd');
        
        // Sexo
        $curp .= $sexo;
        
        // Entidad federativa
        $curp .= $entidad;
        
        // Primeras consonantes internas
        $curp .= $this->getPrimeraConsonante(substr($apellido_paterno, 1));
        $curp .= $this->getPrimeraConsonante(substr($apellido_materno, 1));
        $curp .= $this->getPrimeraConsonante(substr($nombre, 1));
        
        return $curp;
    }
    
    private function getPrimeraConsonante($texto) {
        $consonantes = preg_replace('/[AEIOU\s]/', '', $texto);
        return substr($consonantes, 0, 1);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form_type']) && $_POST['form_type'] === 'aspirante_registro') {
    try {
        // Validar CSRF token
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            throw new Exception('Invalid CSRF token');
        }

        // Validar campos requeridos
        $required_fields = [
            'primera_vez_apellido_paterno',
            'primera_vez_apellido_materno',
            'primera_vez_nombre',
            'primera_vez_fecha_nacimiento',
            'primera_vez_sexo',
            'primera_vez_entidad',
            'primera_vez_curp',
            'primera_vez_celular',
            'primera_vez_email'
        ];

        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception('Todos los campos son requeridos');
            }
        }

        // Generar CURP
        $curpGenerator = new CURPGenerator();
        $curp_generada = $curpGenerator->generate(
            $_POST['primera_vez_apellido_paterno'],
            $_POST['primera_vez_apellido_materno'],
            $_POST['primera_vez_nombre'],
            $_POST['primera_vez_fecha_nacimiento'],
            $_POST['primera_vez_sexo'],
            $_POST['primera_vez_entidad']
        );

        // Validar CURP
        if (substr($_POST['primera_vez_curp'], 0, 16) !== $curp_generada) {
            throw new Exception('La CURP proporcionada no coincide con los datos ingresados');
        }

        // Generar NIP aleatorio
        $nip = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        $hashed_nip = password_hash($nip, PASSWORD_DEFAULT);

        // Insertar en la base de datos
        $query = "INSERT INTO aspirantes (
            apellido_paterno, apellido_materno, nombre, 
            fecha_nacimiento, sexo, curp, celular, 
            email, nip, fecha_registro
        ) VALUES (
            :apellido_paterno, :apellido_materno, :nombre,
            :fecha_nacimiento, :sexo, :curp, :celular,
            :email, :nip, NOW()
        )";

        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':apellido_paterno' => strtoupper($_POST['primera_vez_apellido_paterno']),
            ':apellido_materno' => strtoupper($_POST['primera_vez_apellido_materno']),
            ':nombre' => strtoupper($_POST['primera_vez_nombre']),
            ':fecha_nacimiento' => $_POST['primera_vez_fecha_nacimiento'],
            ':sexo' => $_POST['primera_vez_sexo'],
            ':curp' => $_POST['primera_vez_curp'],
            ':celular' => $_POST['primera_vez_celular'],
            ':email' => strtolower($_POST['primera_vez_email']),
            ':nip' => $hashed_nip
        ]);

        // Mostrar NIP al usuario
        $response = [
            'status' => 'success',
            'title' => '¡Registro Exitoso!',
            'message' => "Tu registro se ha completado correctamente.<br><br>" .
                        "<strong>Tu NIP es: " . $nip . "</strong><br><br>" .
                        "Por favor, guarda este NIP en un lugar seguro. Lo necesitarás para iniciar sesión.",
            'icon' => 'success'
        ];
        echo json_encode($response);
        exit;

    } catch (Exception $e) {
        $response = [
            'status' => 'error',
            'title' => 'Error en el Registro',
            'message' => htmlspecialchars($e->getMessage()),
            'icon' => 'error'
        ];
        echo json_encode($response);
        exit;
    }
}

// Add this after the existing aspirante_registro handler
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form_type']) && $_POST['form_type'] === 'aspirante_login') {
    try {
        // Validate required fields
        if (empty($_POST['iniciar_session_aspirante_curp']) || empty($_POST['iniciar_session_aspirante_password'])) {
            throw new Exception('CURP y NIP son requeridos');
        }

        $curp = strtoupper(trim($_POST['iniciar_session_aspirante_curp']));
        $nip = $_POST['iniciar_session_aspirante_password'];

        // Query to get aspirante
        $query = "SELECT id, curp, nip FROM aspirantes WHERE curp = :curp";
        $stmt = $conn->prepare($query);
        $stmt->execute([':curp' => $curp]);
        $aspirante = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$aspirante || !password_verify($nip, $aspirante['nip'])) {
            throw new Exception('CURP o NIP incorrectos');
        }

        // Set session variables
        $_SESSION['aspirante_id'] = $aspirante['id'];
        $_SESSION['aspirante_curp'] = $aspirante['curp'];
        $_SESSION['user_type'] = 'aspirante';

        $response = [
            'status' => 'success',
            'title' => '¡Inicio de Sesión Exitoso!',
            'message' => 'Redireccionando al panel de aspirante...',
            'icon' => 'success',
            'redirect' => '/modulo/'
        ];
        echo json_encode($response);
        exit;

    } catch (Exception $e) {
        $response = [
            'status' => 'error',
            'title' => 'Error de Inicio de Sesión',
            'message' => htmlspecialchars($e->getMessage()),
            'icon' => 'error'
        ];
        echo json_encode($response);
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form_type']) && $_POST['form_type'] === 'alumno_login') {
    try {
        // Validate required fields
        if (empty($_POST['numero_control']) || empty($_POST['password'])) {
            throw new Exception('Número de control y NIP son requeridos');
        }

        $numero_control = trim($_POST['numero_control']);
        $password = $_POST['password'];

        // Query to get user
        $query = "SELECT id, numero_control, password, tipo_usuario, activo 
                 FROM usuarios 
                 WHERE numero_control = :numero_control 
                 AND tipo_usuario = 'alumno'";
        $stmt = $conn->prepare($query);
        $stmt->execute([':numero_control' => $numero_control]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            throw new Exception('Número de control o NIP incorrectos');
        }

        if (!$usuario['activo']) {
            throw new Exception('Usuario inactivo. Contacte al administrador.');
        }

        if (!password_verify($password, $usuario['password'])) {
            throw new Exception('Número de control o NIP incorrectos');
        }

        // Update last access
        $update_query = "UPDATE usuarios SET ultimo_acceso = NOW() WHERE id = :id";
        $stmt = $conn->prepare($update_query);
        $stmt->execute([':id' => $usuario['id']]);

        // Set session variables
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['numero_control'] = $usuario['numero_control'];
        $_SESSION['user_type'] = $usuario['tipo_usuario'];

        $response = [
            'status' => 'success',
            'title' => '¡Inicio de Sesión Exitoso!',
            'message' => 'Redireccionando al panel de alumno...',
            'icon' => 'success',
            'redirect' => '/modulo/'
        ];
        echo json_encode($response);
        exit;

    } catch (Exception $e) {
        $response = [
            'status' => 'error',
            'title' => 'Error de Inicio de Sesión',
            'message' => htmlspecialchars($e->getMessage()),
            'icon' => 'error'
        ];
        echo json_encode($response);
        exit;
    }
}

// Add this after the existing login handlers
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form_type']) && $_POST['form_type'] === 'personal_login') {
    try {
        // Validate required fields
        if (empty($_POST['numero_control']) || empty($_POST['password'])) {
            throw new Exception('Usuario y contraseña son requeridos');
        }

        $numero_control = trim($_POST['numero_control']);
        $password = $_POST['password'];

        // Query to get user
        $query = "SELECT id, numero_control, password, tipo_usuario, activo 
                 FROM usuarios 
                 WHERE numero_control = :numero_control 
                 AND tipo_usuario = 'personal'";
        $stmt = $conn->prepare($query);
        $stmt->execute([':numero_control' => $numero_control]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            throw new Exception('Usuario o contraseña incorrectos');
        }

        if (!$usuario['activo']) {
            throw new Exception('Usuario inactivo. Contacte al administrador.');
        }

        if (!password_verify($password, $usuario['password'])) {
            throw new Exception('Usuario o contraseña incorrectos');
        }

        // Update last access
        $update_query = "UPDATE usuarios SET ultimo_acceso = NOW() WHERE id = :id";
        $stmt = $conn->prepare($update_query);
        $stmt->execute([':id' => $usuario['id']]);

        // Set session variables
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['numero_control'] = $usuario['numero_control'];
        $_SESSION['user_type'] = $usuario['tipo_usuario'];

        $response = [
            'status' => 'success',
            'title' => '¡Inicio de Sesión Exitoso!',
            'message' => 'Redireccionando al panel de personal...',
            'icon' => 'success',
            'redirect' => '/modulo/'
        ];
        echo json_encode($response);
        exit;

    } catch (Exception $e) {
        $response = [
            'status' => 'error',
            'title' => 'Error de Inicio de Sesión',
            'message' => htmlspecialchars($e->getMessage()),
            'icon' => 'error'
        ];
        echo json_encode($response);
        exit;
    }
}
?>