<?php
require_once(CONFIG_PATH . 'bd.php');

class PagoRegistrar {
    private $db;
    private const PRECIO_BASE = 3200;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        
        if (!$this->db) {
            throw new Exception("Error: No se pudo establecer la conexión con la base de datos.");
        }
    }
    
    public function registrarPago($datos) {
        try {
            // Validar datos requeridos
            $this->validarDatos($datos);
            
            // Verificar si el alumno existe
            if (!$this->verificarAlumno($datos['alumno_id'])) {
                throw new Exception("El alumno especificado no existe.");
            }
            
            // Verificar si ya existe un pago para este alumno en el periodo
            if ($this->existePago($datos['alumno_id'], $datos['periodo'])) {
                throw new Exception("Ya existe un pago registrado para este alumno en el periodo especificado.");
            }
            
            // Calcular el total basado en el descuento
            $total = $this->calcularTotal($datos['descuento']);
            
            // Preparar la consulta de inserción
            $query = "INSERT INTO alumnos_pagos (
                        pagos_alumno_id, 
                        pagos_nombre, 
                        pagos_apellido, 
                        pagos_carrera, 
                        pagos_semestre, 
                        pagos_periodo, 
                        pagos_descuento, 
                        pagos_total, 
                        pagos_realizado,
                        pagos_fecha_registro
                    ) VALUES (
                        :alumno_id, 
                        :nombre, 
                        :apellido, 
                        :carrera, 
                        :semestre, 
                        :periodo, 
                        :descuento, 
                        :total, 
                        :realizado,
                        NOW()
                    )";
            
            $stmt = $this->db->prepare($query);
            
            // Bind de parámetros
            $stmt->bindParam(':alumno_id', $datos['alumno_id'], PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':apellido', $datos['apellido'], PDO::PARAM_STR);
            $stmt->bindParam(':carrera', $datos['carrera'], PDO::PARAM_STR);
            $stmt->bindParam(':semestre', $datos['semestre'], PDO::PARAM_INT);
            $stmt->bindParam(':periodo', $datos['periodo'], PDO::PARAM_STR);
            $stmt->bindParam(':descuento', $datos['descuento'], PDO::PARAM_INT);
            $stmt->bindParam(':total', $total, PDO::PARAM_STR);
            $stmt->bindParam(':realizado', $datos['realizado'], PDO::PARAM_BOOL);
            
            $stmt->execute();
            
            return [
                'success' => true,
                'message' => 'Pago registrado exitosamente.',
                'pago_id' => $this->db->lastInsertId(),
                'total_calculado' => $total
            ];
            
        } catch (PDOException $e) {
            error_log("Error al registrar pago: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error en la base de datos: ' . $e->getMessage()
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    
    private function validarDatos($datos) {
        $camposRequeridos = ['alumno_id', 'nombre', 'apellido', 'carrera', 'semestre', 'periodo'];
        
        foreach ($camposRequeridos as $campo) {
            if (!isset($datos[$campo]) || empty(trim($datos[$campo]))) {
                throw new Exception("El campo {$campo} es requerido.");
            }
        }
        
        // Validar descuento
        if (isset($datos['descuento'])) {
            $descuento = (int)$datos['descuento'];
            if ($descuento < 0 || $descuento > 100) {
                throw new Exception("El descuento debe estar entre 0 y 100.");
            }
        }
        
        // Validar semestre
        $semestre = (int)$datos['semestre'];
        if ($semestre < 1 || $semestre > 12) {
            throw new Exception("El semestre debe estar entre 1 y 12.");
        }
    }
    
    private function verificarAlumno($alumno_id) {
        $query = "SELECT COUNT(*) FROM alumnos WHERE alumno_id = :alumno_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':alumno_id', $alumno_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }
    
    private function existePago($alumno_id, $periodo) {
        $query = "SELECT COUNT(*) FROM alumnos_pagos WHERE pagos_alumno_id = :alumno_id AND pagos_periodo = :periodo";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':alumno_id', $alumno_id, PDO::PARAM_INT);
        $stmt->bindParam(':periodo', $periodo, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }
    
    private function calcularTotal($descuento = 0) {
        $descuentoDecimal = $descuento / 100;
        $descuentoAplicado = self::PRECIO_BASE * $descuentoDecimal;
        return self::PRECIO_BASE - $descuentoAplicado;
    }
    
    public function obtenerAlumnos() {
        try {
            $query = "SELECT alumno_id, alumno_numero_control, alumno_nombre, alumno_apellido 
                     FROM alumnos 
                     ORDER BY alumno_numero_control";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener alumnos: " . $e->getMessage());
            return [];
        }
    }
}
?>