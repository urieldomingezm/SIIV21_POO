<?php
require_once(CONFIG_PATH . 'bd.php');

class PagoMostrar
{
    private $db;
    private const PRECIO_BASE = 3200; // Precio base de reinscripción

    public function __construct()
    {
        // Inicializar conexión usando la clase Database
        $database = new Database();
        $this->db = $database->getConnection();
        if (!$this->db) {
            die("Error: No se pudo establecer la conexión con la base de datos.");
        }
    }

    public function obtenerBadgePago($estado)
    {
        return $estado ?
            '<span class="badge bg-success">Pagado</span>' :
            '<span class="badge bg-danger">Pendiente</span>';
    }

    public function obtenerBadgeDescuento($descuento)
    {
        if ($descuento > 0) {
            return sprintf('<span class="badge bg-info">%d%% Descuento</span>', $descuento);
        }
        return '<span class="badge bg-secondary">Sin descuento</span>';
    }

    public function calcularTotal($descuento)
    {
        $descuentoDecimal = $descuento / 100;
        $descuentoAplicado = self::PRECIO_BASE * $descuentoDecimal;
        return self::PRECIO_BASE - $descuentoAplicado;
    }

    public function obtenerBadgeTotal($total)
    {
        return sprintf('<span class="badge bg-primary">$%.2f MXN</span>', $total);
    }

    public function obtenerDatos()
    {
        $query = "SELECT 
                    ap.pagos_id,
                    ap.pagos_alumno_id,
                    a.alumno_numero_control,
                    ap.pagos_nombre,
                    ap.pagos_apellido,
                    ap.pagos_carrera,
                    ap.pagos_semestre,
                    ap.pagos_periodo,
                    ap.pagos_realizado,
                    ap.pagos_descuento,
                    ap.pagos_total
                FROM alumnos_pagos ap
                INNER JOIN alumnos a ON ap.pagos_alumno_id = a.alumno_id";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            error_log("Error en la consulta: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerEstadisticas($datos)
    {
        $totalAlumnos = 0;
        $alumnosPagados = 0;
        $totalRecaudado = 0;
        $totalDescuentos = 0;
        $descuentosPorcentaje = [];
        $pagosPorCarrera = [];
        
        foreach ($datos as $fila) {
            $totalAlumnos++;
            if ($fila['pagos_realizado']) {
                $alumnosPagados++;
                $totalRecaudado += $fila['pagos_total'];
            }
            $totalDescuentos += $fila['pagos_descuento'];
            
            // Conteo de descuentos por porcentaje
            $descuento = $fila['pagos_descuento'];
            $descuentosPorcentaje[$descuento] = ($descuentosPorcentaje[$descuento] ?? 0) + 1;
            
            // Conteo de pagos por carrera
            $carrera = $fila['pagos_carrera'];
            if (!isset($pagosPorCarrera[$carrera])) {
                $pagosPorCarrera[$carrera] = ['total' => 0, 'pagados' => 0];
            }
            $pagosPorCarrera[$carrera]['total']++;
            if ($fila['pagos_realizado']) {
                $pagosPorCarrera[$carrera]['pagados']++;
            }
        }

        return [
            'totalAlumnos' => $totalAlumnos,
            'alumnosPagados' => $alumnosPagados,
            'totalRecaudado' => $totalRecaudado,
            'totalDescuentos' => $totalDescuentos,
            'descuentosPorcentaje' => $descuentosPorcentaje,
            'pagosPorCarrera' => $pagosPorCarrera
        ];
    }

    public function getPrecioBase()
    {
        return self::PRECIO_BASE;
    }
}
?>