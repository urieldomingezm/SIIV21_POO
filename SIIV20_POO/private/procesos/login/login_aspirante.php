<?php
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
?>