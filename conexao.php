<?php
$host = '127.0.0.1'; // Endereço do servidor MySQL
$dbname = 'funcionarios'; // Nome do banco de dados
$username = 'root'; // Nome de usuário do banco
$password = ''; // Senha do banco

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>
