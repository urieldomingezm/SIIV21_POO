<?php
require_once(CONFIG_PATH . 'bd.php');

class PagoEliminar {
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        
        if (!$this->db) {
            throw new Exception("Error: No se pudo establecer la conexión con la base de datos.");
        }
    }
    
    public function eliminarPago($pago_id) {
        try {
            // Validar que el pago existe
            $pagoInfo = $this->obtenerInfoPago($pago_id);
            if (!$pagoInfo) {
                throw new Exception("El pago especificado no existe.");
            }
            
            // Verificar si el pago ya fue realizado (opcional: prevenir eliminación)
            if ($pagoInfo['pagos_realizado']) {
                throw new Exception("No se puede eliminar un pago que ya ha sido realizado.");
            }
            
            // Iniciar transacción para seguridad
            $this->db->beginTransaction();
            
            // Eliminar el pago
            $query = "DELETE FROM alumnos_pagos WHERE pagos_id = :pago_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':pago_id', $pago_id, PDO::PARAM_INT);
            $stmt->execute();
            
            // Verificar que se eliminó correctamente
            if ($stmt->rowCount() === 0) {
                throw new Exception("No se pudo eliminar el pago.");
            }
            
            // Confirmar transacción
            $this->db->commit();
            
            return [
                'success' => true,
                'message' => 'Pago eliminado exitosamente.',
                'pago_eliminado' => $pagoInfo
            ];
            
        } catch (PDOException $e) {
            // Revertir transacción en caso de error
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            
            error_log("Error al eliminar pago: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error en la base de datos: ' . $e->getMessage()
            ];
        } catch (Exception $e) {
            // Revertir transacción en caso de error
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function eliminarPagosSoft($pago_id) {
        try {
            // Alternativa: eliminación suave (marcar como eliminado)
            if (!$this->existePago($pago_id)) {
                throw new Exception("El pago especificado no existe.");
            }
            
            $query = "UPDATE alumnos_pagos 
                     SET pagos_eliminado = 1, pagos_fecha_eliminacion = NOW() 
                     WHERE pagos_id = :pago_id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':pago_id', $pago_id, PDO::PARAM_INT);
            $stmt->execute();
            
            return [
                'success' => true,
                'message' => 'Pago marcado como eliminado exitosamente.'
            ];
            
        } catch (PDOException $e) {
            error_log("Error al eliminar pago (soft): " . $e->getMessage());
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
    
    public function eliminarMultiplesPagos($pagos_ids) {
        try {
            if (empty($pagos_ids) || !is_array($pagos_ids)) {
                throw new Exception("Se debe proporcionar al menos un ID de pago válido.");
            }
            
            // Validar que todos los IDs son números
            foreach ($pagos_ids as $id) {
                if (!is_numeric($id)) {
                    throw new Exception("Todos los IDs deben ser números válidos.");
                }
            }
            
            $this->db->beginTransaction();
            
            $eliminados = 0;
            $errores = [];
            
            foreach ($pagos_ids as $pago_id) {
                $resultado = $this->eliminarPago($pago_id);
                if ($resultado['success']) {
                    $eliminados++;
                } else {
                    $errores[] = "ID {$pago_id}: " . $resultado['message'];
                }
            }
            
            $this->db->commit();
            
            return [
                'success' => true,
                'message' => "Se eliminaron {$eliminados} pagos exitosamente.",
                'eliminados' => $eliminados,
                'errores' => $errores
            ];
            
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    
    private function obtenerInfoPago($pago_id) {
        try {
            $query = "SELECT * FROM alumnos_pagos WHERE pagos_id = :pago_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':pago_id', $pago_id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener info del pago: " . $e->getMessage());
            return false;
        }
    }
    
    private function existePago($pago_id) {
        $query = "SELECT COUNT(*) FROM alumnos_pagos WHERE pagos_id = :pago_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':pago_id', $pago_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }
}
?>