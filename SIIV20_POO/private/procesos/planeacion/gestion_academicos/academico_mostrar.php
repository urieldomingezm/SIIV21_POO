<?php
require_once(CONFIG_PATH . 'bd.php');

class AcademicoMostrar
{
    private $db;

    public function __construct()
    {
        // Inicializar conexión usando la clase Database
        $database = new Database();
        $this->db = $database->getConnection();
        if (!$this->db) {
            die("Error: No se pudo establecer la conexión con la base de datos.");
        }
    }

    public function obtenerDatos()
    {
        $query = "SELECT 
                    aia.academica_id,
                    aia.academica_alumno_id,
                    a.alumno_numero_control,
                    ci.carrera_nombre_completo,
                    ci.carrera_clave,
                    aia.academica_semestre,
                    aia.academica_periodo,
                    aia.academica_promedio
                FROM alumnos_info_academica aia
                INNER JOIN alumnos a ON aia.academica_alumno_id = a.alumno_id
                INNER JOIN carreras_institucion ci ON aia.academica_carrera_id = ci.carrera_id";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            error_log("Error en la consulta: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerEstadisticas($resultado)
    {
        $totalAlumnos = 0;
        $alumnosPorSemestre = [];
        $alumnosPorCarrera = [];
        $clavesCarreras = []; // Array para almacenar las claves oficiales
        $promedioGeneral = 0;
        $totalPromedios = 0;

        while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $totalAlumnos++;
            $totalPromedios += $fila['academica_promedio'];

            // Conteo por semestre
            $semestre = $fila['academica_semestre'];
            if (!isset($alumnosPorSemestre[$semestre])) {
                $alumnosPorSemestre[$semestre] = 0;
            }
            $alumnosPorSemestre[$semestre]++;

            // Conteo por carrera y almacenar claves oficiales
            $carrera = $fila['carrera_nombre_completo'];
            $claveCarrera = $fila['carrera_clave'];
            
            if (!isset($alumnosPorCarrera[$carrera])) {
                $alumnosPorCarrera[$carrera] = 0;
                // Almacenar la clave oficial de la carrera
                $clavesCarreras[$carrera] = $claveCarrera;
            }
            $alumnosPorCarrera[$carrera]++;
        }

        $promedioGeneral = $totalAlumnos > 0 ? round($totalPromedios / $totalAlumnos, 2) : 0;

        return [
            'totalAlumnos' => $totalAlumnos,
            'alumnosPorSemestre' => $alumnosPorSemestre,
            'alumnosPorCarrera' => $alumnosPorCarrera,
            'clavesCarreras' => $clavesCarreras, // Incluir las claves oficiales
            'promedioGeneral' => $promedioGeneral
        ];
    }

    public function obtenerAlumnos()
    {
        // Consulta corregida sin GROUP BY innecesario
        $query = "SELECT 
                ap.pagos_alumno_id as alumno_id,
                ap.pagos_numero_control as alumno_numero_control,
                CONCAT(ap.pagos_nombre, ' ', ap.pagos_apellido) as nombre_completo,
                ci.carrera_nombre_completo,
                ci.carrera_clave,
                aia.academica_semestre,
                aia.academica_periodo,
                aia.academica_promedio
            FROM alumnos_pagos ap
            LEFT JOIN alumnos a ON ap.pagos_numero_control = a.alumno_numero_control
            LEFT JOIN alumnos_info_academica aia ON a.alumno_id = aia.academica_alumno_id
            LEFT JOIN carreras_institucion ci ON aia.academica_carrera_id = ci.carrera_id
            WHERE ap.pagos_numero_control IS NOT NULL
            ORDER BY ap.pagos_numero_control";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Debug: Mostrar los datos obtenidos
            error_log('Alumnos obtenidos desde alumnos_pagos: ' . count($result) . ' registros');
            
            return $result;
        } catch (PDOException $e) {
            error_log("Error al obtener alumnos: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerCarreras()
    {
        $query = "SELECT carrera_id, carrera_clave, carrera_nombre_completo FROM carreras_institucion ORDER BY carrera_nombre_completo";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener carreras: " . $e->getMessage());
            return [];
        }
    }
}
?>