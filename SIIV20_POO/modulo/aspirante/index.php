<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(MENU_PATH . 'menu_aspirante.php'); 

require_once(TEMPLATES_PATH . 'header.php');
?>

<div class="page-container">
        <div class="container mt-5 mb-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <?php
                    if (isset($_GET['q']) && !empty($_GET['q'])) {
                        $query = strtolower(trim($_GET['q']));
                        // Funcion de buscar
                        $pages = [
                            'GSTM.php' => 'gestion_de_tiempo',
                            'USR.php' => 'inicio',
                            'PRUS.php' => 'ver_perfil',
                            'CRSS.php' => 'cerrar_session',
                            'RQPG.php' => 'Requisitos_paga',
                            'GSAS.php' => 'gestion_ascenso',
                            'GVE.php' => 'Pendiente',
                            'GVP.php' => 'Pendiente',
                            'MEMS.php' => 'membresias',
                            'GTPS.php' => 'gestion_de_pagas',
                            'GEPS.php' => 'grafico de pagas',
                            'VTM.php' => 'ventas_membresias',
                            'VTR.php' => 'venta_rangos',
                            'GEDV.php' => 'total_ventas',
                        ];

                        $results = [];

                        foreach ($pages as $file => $title) {
                            if (file_exists($file)) {
                                $content = file_get_contents($file);
                                preg_match('/<meta name="keywords" content="([^"]+)"/', $content, $matches);

                                if (!empty($matches[1])) {
                                    $keywords = explode(',', strtolower($matches[1]));
                                    foreach ($keywords as $keyword) {
                                        similar_text($query, $keyword, $percentage);
                                        if ($percentage > 60 || strpos($keyword, $query) !== false) {
                                            $results[] = ['title' => $title, 'url' => 'index.php?page=' . urlencode($title)];
                                            break;
                                        }
                                    }
                                }
                            }
                        }

                        echo '<div class="search-results-container">';
                        echo '<div class="card shadow-lg border-0 rounded-lg">';
                        echo '<div class="card-header bg-gradient-primary">';
                        echo '<h4 class="text-dark mb-0"><i class="fas fa-search me-2"></i>Resultados para: "' . htmlspecialchars($query) . '"</h4>';
                        echo '</div>';
                        echo '<div class="card-body">';

                        if (!empty($results)) {
                            echo '<div class="results-list">';
                            foreach ($results as $result) {
                                echo '<a href="' . $result['url'] . '" class="result-item">';
                                echo '<div class="d-flex align-items-center p-3 border-bottom transition-hover">';
                                echo '<i class="fas fa-link me-3 text-primary"></i>';
                                echo '<div>';
                                echo '<h5 class="mb-0">' . ucfirst($result['title']) . '</h5>';
                                echo '</div>';
                                echo '<i class="fas fa-chevron-right ms-auto text-muted"></i>';
                                echo '</div>';
                                echo '</a>';
                            }
                            echo '</div>';
                        } else {
                            echo '<div class="text-center p-4">';
                            echo '<i class="fas fa-search-minus fa-3x text-muted mb-3"></i>';
                            echo '<div class="alert alert-warning mb-0">';
                            echo '<h5 class="alert-heading">No se encontraron resultados</h5>';
                            echo '<p class="mb-0">Intenta con otros términos de búsqueda</p>';
                            echo '</div>';
                            echo '</div>';
                        }

                        echo '</div></div></div>';
                    } else {
                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                            $validPages = [
                                'gestion_de_tiempo' => ['file' => 'GSTM.php', 'roles' => ['personal']],
                                'inicio' => ['file' => 'USR.php', 'roles' => ['personal', 'alumno', 'aspirante']],
                                'ver_perfil' => ['file' => 'PRUS.php', 'roles' => ['personal', 'alumno', 'aspirante']],
                                'cerrar_session' => ['file' => 'CRSS.php', 'roles' => ['personal', 'alumno', 'aspirante']],
                                'requisitos_paga' => ['file' => 'RQPG.php', 'roles' => ['personal', 'alumno', 'aspirante']],
                                'gestion_ascenso' => ['file' => 'GSAS.php', 'roles' => ['personal']],
                                'gestion_de_pagas' => ['file' => 'GTPS.php', 'roles' => ['personal']],
                                'grafico de pagas' => ['file' => 'GEPS.php', 'roles' => ['personal']],
                                'ventas_membresias' => ['file' => 'VTM.php', 'roles' => ['personal']],
                                'venta_rangos' => ['file' => 'VTR.php', 'roles' => ['personal']],
                                'verificar_usuarios' => ['file' => 'VER.php', 'roles' => ['personal']],
                                'gestionar_usuarios' => ['file' => 'GEUS.php', 'roles' => ['personal']],
                                'total_ventas' => ['file' => 'GEDV.php', 'roles' => ['personal']],
                            ];


                            $userRango = '';
                            if (isset($_SESSION['user_id'])) {
                                require_once(CONFIG_PATH . 'bd.php');
                                $database = new Database();
                                $conn = $database->getConnection();

                                try {
                                    $query = "SELECT rango FROM registro_usuario WHERE id = :user_id";
                                    $stmt = $conn->prepare($query);
                                    $stmt->bindParam(':user_id', $_SESSION['user_id']);
                                    $stmt->execute();

                                    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $userRango = $row['rango'];
                                        $_SESSION['rango'] = $userRango;
                                    }
                                } catch (PDOException $e) {
                                    error_log("Error en la consulta: " . $e->getMessage());
                                    echo '<div class="alert alert-danger">Error al verificar permisos</div>';
                                    exit();
                                }
                            }

                            // Resto del código de validación
                            if (array_key_exists($page, $validPages) && in_array($userRango, $validPages[$page]['roles'])) {
                                include $validPages[$page]['file'];
                            } else {
                                echo '<div class="alert alert-danger text-center mt-5">';
                                echo '<h4 class="alert-heading">Acceso Denegado</h4>';
                                echo '<p>No tienes los permisos necesarios para acceder a esta página u la pagina no existe.</p>';
                                echo '<p>Tu rango actual es: ' . htmlspecialchars($userRango) . '</p>';
                                echo '<p>Redirigiendo a la página principal...</p>';
                                echo '</div>';
                                echo '<meta http-equiv="refresh" content="3;url=index.php">';
                                exit();
                            }
                        } else {
                            include 'USR.php';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>



<?php require_once(TEMPLATES_PATH . 'footer.php'); ?>
            
           