<?php
require_once(CONFIG_PATH . 'bd.php');

class PagoEditar {
    private $db;
    private const PRECIO_BASE = 3200;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        
        if (!$this->db) {
            throw new Exception("Error: No se pudo establecer la conexión con la base de datos.");
        }
    }
    
    public function editarPago($pago_id, $datos) {
        try {
            // Validar que el pago existe
            if (!$this->existePago($pago_id)) {
                throw new Exception("El pago especificado no existe.");
            }
            
            // Validar datos
            $this->validarDatos($datos);
            
            // Calcular nuevo total si se cambió el descuento
            $total = isset($datos['descuento']) ? $this->calcularTotal($datos['descuento']) : null;
            
            // Construir la consulta dinámicamente
            $campos = [];
            $valores = [];
            
            if (isset($datos['nombre'])) {
                $campos[] = "pagos_nombre = :nombre";
                $valores[':nombre'] = $datos['nombre'];
            }
            
            if (isset($datos['apellido'])) {
                $campos[] = "pagos_apellido = :apellido";
                $valores[':apellido'] = $datos['apellido'];
            }
            
            if (isset($datos['carrera'])) {
                $campos[] = "pagos_carrera = :carrera";
                $valores[':carrera'] = $datos['carrera'];
            }
            
            if (isset($datos['semestre'])) {
                $campos[] = "pagos_semestre = :semestre";
                $valores[':semestre'] = $datos['semestre'];
            }
            
            if (isset($datos['periodo'])) {
                $campos[] = "pagos_periodo = :periodo";
                $valores[':periodo'] = $datos['periodo'];
            }
            
            if (isset($datos['descuento'])) {
                $campos[] = "pagos_descuento = :descuento";
                $valores[':descuento'] = $datos['descuento'];
                $campos[] = "pagos_total = :total";
                $valores[':total'] = $total;
            }
            
            if (isset($datos['realizado'])) {
                $campos[] = "pagos_realizado = :realizado";
                $valores[':realizado'] = $datos['realizado'];
            }
            
            if (empty($campos)) {
                throw new Exception("No se proporcionaron datos para actualizar.");
            }
            
            // Agregar fecha de modificación
            $campos[] = "pagos_fecha_modificacion = NOW()";
            
            $query = "UPDATE alumnos_pagos SET " . implode(", ", $campos) . " WHERE pagos_id = :pago_id";
            
            $stmt = $this->db->prepare($query);
            
            // Bind de parámetros
            foreach ($valores as $param => $valor) {
                $stmt->bindValue($param, $valor);
            }
            $stmt->bindParam(':pago_id', $pago_id, PDO::PARAM_INT);
            
            $stmt->execute();
            
            return [
                'success' => true,
                'message' => 'Pago actualizado exitosamente.',
                'total_calculado' => $total
            ];
            
        } catch (PDOException $e) {
            error_log("Error al editar pago: " . $e->getMessage());
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
    
    public function obtenerPago($pago_id) {
        try {
            $query = "SELECT ap.*, a.alumno_numero_control 
                     FROM alumnos_pagos ap 
                     INNER JOIN alumnos a ON ap.pagos_alumno_id = a.alumno_id 
                     WHERE ap.pagos_id = :pago_id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':pago_id', $pago_id, PDO::PARAM_INT);
            $stmt->execute();
            
            $pago = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$pago) {
                return [
                    'success' => false,
                    'message' => 'Pago no encontrado.'
                ];
            }
            
            return [
                'success' => true,
                'data' => $pago
            ];
            
        } catch (PDOException $e) {
            error_log("Error al obtener pago: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error en la base de datos: ' . $e->getMessage()
            ];
        }
    }
    
    private function validarDatos($datos) {
        // Validar descuento si se proporciona
        if (isset($datos['descuento'])) {
            $descuento = (int)$datos['descuento'];
            if ($descuento < 0 || $descuento > 100) {
                throw new Exception("El descuento debe estar entre 0 y 100.");
            }
        }
        
        // Validar semestre si se proporciona
        if (isset($datos['semestre'])) {
            $semestre = (int)$datos['semestre'];
            if ($semestre < 1 || $semestre > 12) {
                throw new Exception("El semestre debe estar entre 1 y 12.");
            }
        }
        
        // Validar campos de texto no vacíos
        $camposTexto = ['nombre', 'apellido', 'carrera', 'periodo'];
        foreach ($camposTexto as $campo) {
            if (isset($datos[$campo]) && empty(trim($datos[$campo]))) {
                throw new Exception("El campo {$campo} no puede estar vacío.");
            }
        }
    }
    
    private function existePago($pago_id) {
        $query = "SELECT COUNT(*) FROM alumnos_pagos WHERE pagos_id = :pago_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':pago_id', $pago_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }
    
    private function calcularTotal($descuento = 0) {
        $descuentoDecimal = $descuento / 100;
        $descuentoAplicado = self::PRECIO_BASE * $descuentoDecimal;
        return self::PRECIO_BASE - $descuentoAplicado;
    }
}
?>