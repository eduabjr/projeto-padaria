<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "cadastro_funcionario";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

