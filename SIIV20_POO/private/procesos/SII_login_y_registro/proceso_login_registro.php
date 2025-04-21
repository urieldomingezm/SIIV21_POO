<?php

$database = new Database();
$conn = $database->getConnection();

if (empty($_SESSION['csrf_token'])) {
    if (function_exists('random_bytes')) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    } else {
        $bytes = openssl_random_pseudo_bytes(32);
        $_SESSION['csrf_token'] = bin2hex($bytes);
    }
}

class CURPGenerator {
    public function generate($apellido_paterno, $apellido_materno, $nombre, $fecha_nacimiento, $sexo, $entidad) {
        $apellido_paterno = strtoupper(trim($apellido_paterno));
        $apellido_materno = strtoupper(trim($apellido_materno));
        $nombre = strtoupper(trim($nombre));
        $curp = substr($apellido_paterno, 0, 1);
        $vocales = preg_replace('/[^AEIOU]/', '', substr($apellido_paterno, 1));
        $curp .= substr($vocales, 0, 1);
        $curp .= substr($apellido_materno, 0, 1);  
        $curp .= substr($nombre, 0, 1);
        $fecha = new DateTime($fecha_nacimiento);
        $curp .= $fecha->format('ymd');
        $curp .= $sexo;
        $curp .= $entidad;
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

// registro aspirante handler
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form_type']) && $_POST['form_type'] === 'aspirante_registro') {
    try {
        // Polyfill for hash_equals for PHP < 5.6
        if (!function_exists('hash_equals')) {
            function hash_equals($str1, $str2) {
                if (strlen($str1) != strlen($str2)) {
                    return false;
                } else {
                    $res = $str1 ^ $str2;
                    $ret = 0;
                    for ($i = strlen($res) - 1; $i >= 0; $i--) {
                        $ret |= ord($res[$i]);
                    }
                    return !$ret;
                }
            }
        }
        
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            throw new Exception('Invalid CSRF token');
        }

        $required_fields = array(
            'primera_vez_apellido_paterno',
            'primera_vez_apellido_materno',
            'primera_vez_nombre',
            'primera_vez_fecha_nacimiento',
            'primera_vez_sexo',
            'primera_vez_entidad',
            'primera_vez_curp',
            'primera_vez_celular',
            'primera_vez_email'
        );

        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception('Todos los campos son requeridos');
            }
        }

        $curpGenerator = new CURPGenerator();
        $curp_generada = $curpGenerator->generate(
            $_POST['primera_vez_apellido_paterno'],
            $_POST['primera_vez_apellido_materno'],
            $_POST['primera_vez_nombre'],
            $_POST['primera_vez_fecha_nacimiento'],
            $_POST['primera_vez_sexo'],
            $_POST['primera_vez_entidad']
        );

        if (substr($_POST['primera_vez_curp'], 0, 16) !== $curp_generada) {
            throw new Exception('La CURP proporcionada no coincide con los datos ingresados');
        }

        // Generar NIP aleatorio compatible con PHP 5.3
        if (function_exists('random_int')) {
            $nip = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        } else {
            $nip = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
        }
        $hashed_nip = password_hash($nip, PASSWORD_DEFAULT);

        $query = "INSERT INTO aspirantes (
            aspirante_apellido_paterno, aspirante_apellido_materno, aspirante_nombre, 
            aspirante_fecha_nacimiento, aspirante_sexo, aspirante_curp, aspirante_celular, 
            aspirante_email, aspirante_nip, aspirante_fecha_registro
        ) VALUES (
            :apellido_paterno, :apellido_materno, :nombre,
            :fecha_nacimiento, :sexo, :curp, :celular,
            :email, :nip, NOW()
        )";
    
        $stmt = $conn->prepare($query);
        $params = array(
            ':apellido_paterno' => strtoupper($_POST['primera_vez_apellido_paterno']),
            ':apellido_materno' => strtoupper($_POST['primera_vez_apellido_materno']),
            ':nombre' => strtoupper($_POST['primera_vez_nombre']),
            ':fecha_nacimiento' => $_POST['primera_vez_fecha_nacimiento'],
            ':sexo' => $_POST['primera_vez_sexo'],
            ':curp' => $_POST['primera_vez_curp'],
            ':celular' => $_POST['primera_vez_celular'],
            ':email' => strtolower($_POST['primera_vez_email']),
            ':nip' => $hashed_nip
        );
        $stmt->execute($params);

        $response = array(
            'status' => 'success',
            'title' => '¡Registro Exitoso!',
            'message' => "Tu registro se ha completado correctamente.<br><br>" .
                        "<strong>Tu NIP es: " . $nip . "</strong><br><br>" .
                        "Por favor, guarda este NIP en un lugar seguro. Lo necesitarás para iniciar sesión.",
            'icon' => 'success'
        );
        echo json_encode($response);
        exit;

    } catch (Exception $e) {
        $response = array(
            'status' => 'error',
            'title' => 'Error en el Registro',
            'message' => htmlspecialchars($e->getMessage()),
            'icon' => 'error'
        );
        echo json_encode($response);
        exit;
    }
}

// login aspirante login handler
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form_type']) && $_POST['form_type'] === 'aspirante_login') {
    try {
        if (empty($_POST['iniciar_session_aspirante_curp']) || empty($_POST['iniciar_session_aspirante_password'])) {
            throw new Exception('CURP y NIP son requeridos');
        }

        $curp = strtoupper(trim($_POST['iniciar_session_aspirante_curp']));
        $nip = $_POST['iniciar_session_aspirante_password'];

        $query = "SELECT aspirante_id, aspirante_curp, aspirante_nip FROM aspirantes WHERE aspirante_curp = :curp";
        $stmt = $conn->prepare($query);
        $stmt->execute(array(':curp' => $curp));
        $aspirante = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$aspirante || !password_verify($nip, $aspirante['aspirante_nip'])) {
            throw new Exception('CURP o NIP incorrectos');
        }

        $_SESSION['aspirante_id'] = $aspirante['aspirante_id'];
        $_SESSION['aspirante_curp'] = $aspirante['aspirante_curp'];
        $_SESSION['user_type'] = 'aspirante';

        $response = array(
            'status' => 'success',
            'title' => '¡Inicio de Sesión Exitoso!',
            'message' => 'Redireccionando al panel de aspirante...',
            'icon' => 'success',
            'redirect' => '/modulo/'
        );
        echo json_encode($response);
        exit;

    } catch (Exception $e) {
        $response = array(
            'status' => 'error',
            'title' => 'Error de Inicio de Sesión',
            'message' => htmlspecialchars($e->getMessage()),
            'icon' => 'error'
        );
        echo json_encode($response);
        exit;
    }
}


// login alumno login handler
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form_type']) && $_POST['form_type'] === 'alumno_login') {
    try {
        if (empty($_POST['alumno_numero_control']) || empty($_POST['alumno_password'])) {
            throw new Exception('Número de control y NIP son requeridos');
        }

        $numero_control = trim($_POST['alumno_numero_control']);
        $password = $_POST['alumno_password'];

        $query = "SELECT alumno_id, alumno_numero_control, alumno_password, alumno_rol 
                 FROM alumnos 
                 WHERE alumno_numero_control = :numero_control";
        $stmt = $conn->prepare($query);
        $stmt->execute(array(':numero_control' => $numero_control));
        $alumno = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$alumno) {
            throw new Exception('Número de control o NIP incorrectos');
        }

        if (!password_verify($password, $alumno['alumno_password'])) {
            throw new Exception('Número de control o NIP incorrectos');
        }

        $update_query = "UPDATE alumnos SET alumno_ultimo_acceso = NOW() WHERE alumno_id = :id";
        $stmt = $conn->prepare($update_query);
        $stmt->execute(array(':id' => $alumno['alumno_id']));

        $_SESSION['user_id'] = $alumno['alumno_id'];
        $_SESSION['numero_control'] = $alumno['alumno_numero_control'];
        $_SESSION['user_type'] = 'alumno';
        $_SESSION['rol'] = $alumno['alumno_rol'];

        $response = array(
            'status' => 'success',
            'title' => '¡Inicio de Sesión Exitoso!',
            'message' => 'Redireccionando al panel de alumno...',
            'icon' => 'success',
            'redirect' => '/modulo/'
        );
        echo json_encode($response);
        exit;

    } catch (Exception $e) {
        $response = array(
            'status' => 'error',
            'title' => 'Error de Inicio de Sesión',
            'message' => htmlspecialchars($e->getMessage()),
            'icon' => 'error'
        );
        echo json_encode($response);
        exit;
    }
}

// login personal login handler
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form_type']) && $_POST['form_type'] === 'personal_login') {
    try {
        if (empty($_POST['personal_usuario']) || empty($_POST['personal_password'])) {
            throw new Exception('Usuario y contraseña son requeridos');
        }

        $usuario = trim($_POST['personal_usuario']);
        $password = $_POST['personal_password'];

        $query = "SELECT personal_id, personal_usuario, personal_password, personal_rol, personal_activo 
                 FROM personal 
                 WHERE personal_usuario = :usuario";
        $stmt = $conn->prepare($query);
        $stmt->execute(array(':usuario' => $usuario));
        $personal = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$personal) {
            throw new Exception('Usuario o contraseña incorrectos');
        }

        if (!$personal['personal_activo']) {
            throw new Exception('Usuario inactivo. Contacte al administrador.');
        }

        if (!password_verify($password, $personal['personal_password'])) {
            throw new Exception('Usuario o contraseña incorrectos');
        }

        $update_query = "UPDATE personal SET personal_ultimo_acceso = NOW() WHERE personal_id = :id";
        $stmt = $conn->prepare($update_query);
        $stmt->execute(array(':id' => $personal['personal_id']));

        $_SESSION['user_id'] = $personal['personal_id'];
        $_SESSION['usuario'] = $personal['personal_usuario'];
        $_SESSION['user_type'] = 'personal';
        $_SESSION['rol'] = $personal['personal_rol'];

        $response = array(
            'status' => 'success',
            'title' => '¡Inicio de Sesión Exitoso!',
            'message' => 'Redireccionando al panel de personal...',
            'icon' => 'success',
            'redirect' => '/modulo/'
        );
        echo json_encode($response);
        exit;

    } catch (Exception $e) {
        $response = array(
            'status' => 'error',
            'title' => 'Error de Inicio de Sesión',
            'message' => htmlspecialchars($e->getMessage()),
            'icon' => 'error'
        );
        echo json_encode($response);
        exit;
    }
}
?>