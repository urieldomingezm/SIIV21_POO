<?php

$database = new Database();
$conn = $database->getConnection();

if (!function_exists('password_hash')) {
    function password_hash($password, $algo, $options = array())
    {
        return crypt($password, '$2y$10$' . substr(str_replace('+', '.', base64_encode(openssl_random_pseudo_bytes(22))), 0, 22));
    }
}

if (!function_exists('password_verify')) {
    function password_verify($password, $hash)
    {
        return crypt($password, $hash) === $hash;
    }
}

if (empty($_SESSION['csrf_token'])) {
    if (function_exists('random_bytes')) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    } else {
        $bytes = openssl_random_pseudo_bytes(32);
        $_SESSION['csrf_token'] = bin2hex($bytes);
    }
}

class CURPGenerator
{
    public function generate($apellido_paterno, $apellido_materno, $nombre, $fecha_nacimiento, $sexo, $entidad)
    {
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

    private function getPrimeraConsonante($texto)
    {
        $consonantes = preg_replace('/[AEIOU\s]/', '', $texto);
        return substr($consonantes, 0, 1);
    }
}

// registro aspirante handler
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form_type']) && $_POST['form_type'] === 'aspirante_registro') {
    try {
        // Polyfill for hash_equals for PHP < 5.6
        if (!function_exists('hash_equals')) {
            function hash_equals($str1, $str2)
            {
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

require_once('login_aspirante.php');
require_once('login_alumno.php');
require_once('login_personal.php');
