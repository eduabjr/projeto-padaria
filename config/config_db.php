<?php
/**
 * Arquivo de Configuração Unificado do Banco de Dados
 * Centraliza todas as conexões utilizadas no sistema
 */

// Configurações do servidor MySQL
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Nomes dos bancos de dados
define('DB_CLIENTES', 'cadastro_clientes');
define('DB_FUNCIONARIOS', 'funcionarios');
define('DB_FUNCIONARIOS_MYSQLI', 'cadastro_funcionario');
define('DB_PRODUTOS', 'produtos');
define('DB_ENTREGA', 'entrega');
define('DB_FEEDBACK', 'feedback');

/**
 * Função para obter conexão PDO
 * @param string $database Nome do banco de dados
 * @return PDO|false Retorna a conexão PDO ou false em caso de erro
 */
function getPDOConnection($database) {
    static $connections = [];
    
    if (isset($connections[$database])) {
        return $connections[$database];
    }
    
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . $database . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        $conn = new PDO($dsn, DB_USER, DB_PASS, $options);
        $connections[$database] = $conn;
        return $conn;
    } catch (PDOException $e) {
        error_log("Erro na conexão PDO com $database: " . $e->getMessage());
        return false;
    }
}

/**
 * Função para obter conexão MySQLi
 * @param string $database Nome do banco de dados
 * @return mysqli|false Retorna a conexão MySQLi ou false em caso de erro
 */
function getMySQLiConnection($database) {
    static $connections = [];
    
    if (isset($connections[$database])) {
        return $connections[$database];
    }
    
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, $database);
        
        if ($conn->connect_error) {
            error_log("Erro na conexão MySQLi com $database: " . $conn->connect_error);
            return false;
        }
        
        $conn->set_charset(DB_CHARSET);
        $connections[$database] = $conn;
        return $conn;
    } catch (Exception $e) {
        error_log("Erro na conexão MySQLi com $database: " . $e->getMessage());
        return false;
    }
}

// Conexões específicas para compatibilidade com código existente
// Conexão de clientes (MySQLi)
$conn_clientes = getMySQLiConnection(DB_CLIENTES);

// Conexão de funcionários (PDO)
$conn_funcionarios_pdo = getPDOConnection(DB_FUNCIONARIOS);

// Conexão de funcionários (MySQLi - para compatibilidade)
$conn_funcionarios = getMySQLiConnection(DB_FUNCIONARIOS_MYSQLI);

// Conexão de produtos (PDO)
$pdo_produtos = getPDOConnection(DB_PRODUTOS);

?>
