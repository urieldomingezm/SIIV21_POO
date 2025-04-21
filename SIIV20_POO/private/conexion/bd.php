<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;
    
    // Sybase connection parameters
    private $sybase_host;
    private $sybase_db_name;
    private $sybase_username;
    private $sybase_password;

    public function __construct() {
        // MySQL connection parameters
        $this->host = getenv('MYSQL_HOST') ?: 'localhost';
        $this->db_name = getenv('MYSQL_DATABASE') ?: 'instituto_tecnologico';
        $this->username = getenv('MYSQL_USER') ?: 'root';
        $this->password = getenv('MYSQL_PASSWORD') ?: '';

        // Sybase connection parameters
        $this->sybase_host = getenv('SYBASE_HOST') ?: 'sybase_server';
        $this->sybase_db_name = getenv('SYBASE_DATABASE') ?: 'instituto_tecnologico_sybase';
        $this->sybase_username = getenv('SYBASE_USER') ?: 'sa';
        $this->sybase_password = getenv('SYBASE_PASSWORD') ?: '';

        if (!$this->host || !$this->db_name || !$this->username || !$this->password) {
            error_log("Error: Algunas variables de entorno MySQL no están definidas.");
        }
        
        if (!$this->sybase_host || !$this->sybase_db_name || !$this->sybase_username) {
            error_log("Error: Algunas variables de entorno Sybase no están definidas.");
        }
    }

    public function getConnection() {
        $this->conn = null;

        // Try MySQL connection first
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch(PDOException $exception) {
            error_log("Error de conexión MySQL: " . $exception->getMessage() . ". Intentando conexión Sybase...");
            
            // Try Sybase connection as fallback
            try {
                // For Sybase ASE
                $dsn = "dblib:host=" . $this->sybase_host . ";dbname=" . $this->sybase_db_name;
                $this->conn = new PDO($dsn, $this->sybase_username, $this->sybase_password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                error_log("Conexión exitosa a Sybase (Plan B)");
                return $this->conn;
            } catch(PDOException $sybase_exception) {
                error_log("Error de conexión Sybase: " . $sybase_exception->getMessage());
                echo "Error de conexión a la base de datos (MySQL y Sybase)";
                return null;
            }
        }
    }
    
    // Method to explicitly connect to Sybase
    public function getSybaseConnection() {
        try {
            $dsn = "dblib:host=" . $this->sybase_host . ";dbname=" . $this->sybase_db_name;
            $conn = new PDO($dsn, $this->sybase_username, $this->sybase_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $exception) {
            error_log("Error de conexión directa a Sybase: " . $exception->getMessage());
            echo "Error de conexión a la base de datos Sybase.";
            return null;
        }
    }
}
?>
