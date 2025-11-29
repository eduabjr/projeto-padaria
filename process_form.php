<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recebe todos os dados do formulário
    $nome = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $telefone = $_POST['phone'] ?? null;
    $endereco = $_POST['address'] ?? null;
    $nacionalidade = $_POST['nationality'] ?? null;
    $bairro = $_POST['neighborhood'] ?? null;
    $cidade = $_POST['city'] ?? null;
    $estado = $_POST['state'] ?? null;
    $tipo_cliente = $_POST['clientType'] ?? null;
    $rg = ($tipo_cliente === 'individual') ? ($_POST['rg'] ?? null) : null;
    $cpf = ($tipo_cliente === 'individual') ? ($_POST['cpf'] ?? null) : null;
    $cnpj = ($tipo_cliente === 'company') ? ($_POST['cnpj'] ?? null) : null;
    $sexo = ($tipo_cliente === 'individual') ? ($_POST['gender'] ?? null) : null;

    // Prepara a consulta SQL usando prepared statements para maior segurança
    $stmt = $conn->prepare("INSERT INTO clientes (nome, email, telefone, endereco, nacionalidade, bairro, cidade, estado, tipo_cliente, rg, cpf, cnpj, sexo)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssss", $nome, $email, $telefone, $endereco, $nacionalidade, $bairro, $cidade, $estado, $tipo_cliente, $rg, $cpf, $cnpj, $sexo);

    // Executa a consulta e verifica se houve sucesso
    if ($stmt->execute()) {
        // Redireciona para a página de cadastro após o sucesso
        header("Location: cadastro_cliente.php");
        exit();
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    // Fecha a declaração e a conexão
    $stmt->close();
    $conn->close();
} else {
    // Redireciona para o formulário se o acesso foi direto
    header("Location: /SitePadariaUPDATE/formulario.html");
    exit();
}

