<?php
// Configuração do banco de dados
$host = "localhost";
$user = "root";  // Seu usuário do MySQL
$password = "";  // Sua senha do MySQL
$dbname = "cadastro_funcionario";  // Nome do banco de dados

// Conectar ao banco de dados
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obter dados do formulário (por exemplo, via POST)
$nome = $_POST['nome'];
$sexo = $_POST['sexo'];
$estadoCivil = $_POST['estadoCivil'];
$nacionalidade = $_POST['nacionalidade'];
$turno = $_POST['turno'];
$cargo = $_POST['cargo'];
$rg = $_POST['rg'];
$cpf = $_POST['cpf'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$cep = $_POST['cep'];
$logradouro = $_POST['logradouro'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$foto = $_POST['foto'];  // Aqui você pode capturar a foto como base64 ou o caminho da imagem

// Preparar a consulta SQL para inserir os dados
$sql = "INSERT INTO funcionarios (nome, sexo, estado_civil, nacionalidade, turno, cargo, rg, cpf, telefone, email, cep, logradouro, numero, bairro, cidade, estado, foto)
VALUES ('$nome', '$sexo', '$estadoCivil', '$nacionalidade', '$turno', '$cargo', '$rg', '$cpf', '$telefone', '$email', '$cep', '$logradouro', '$numero', '$bairro', '$cidade', '$estado', '$foto')";

// Executar a consulta
if ($conn->query($sql) === TRUE) {
    echo "Novo funcionário cadastrado com sucesso!";
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
}

// Fechar a conexão
$conn->close();
?>
