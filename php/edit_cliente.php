<?php
include 'config/config.php';

// Verifica se o ID foi passado via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Seleciona o cliente pelo ID
    $stmt = $conn->prepare("SELECT * FROM clientes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se o cliente existe
    if ($result->num_rows === 1) {
        $cliente = $result->fetch_assoc();
    } else {
        echo "Cliente não encontrado.";
        exit();
    }

    $stmt->close();
} else {
    echo "ID do cliente não fornecido.";
    exit();
}

// Atualiza o cliente se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
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

    // Prepara a consulta SQL para atualização
    $stmt = $conn->prepare("UPDATE clientes SET nome = ?, email = ?, telefone = ?, endereco = ?, nacionalidade = ?, bairro = ?, cidade = ?, estado = ?, tipo_cliente = ?, rg = ?, cpf = ?, cnpj = ?, sexo = ? WHERE id = ?");
    $stmt->bind_param("sssssssssssssi", $nome, $email, $telefone, $endereco, $nacionalidade, $bairro, $cidade, $estado, $tipo_cliente, $rg, $cpf, $cnpj, $sexo, $id);

    // Executa a atualização e verifica se foi bem-sucedida
    if ($stmt->execute()) {
        echo "Cliente atualizado com sucesso!";
        header("Location: cadastro_cliente.php");
        exit();
    } else {
        echo "Erro ao atualizar cliente: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!-- Formulário para edição do cliente -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
</head>
<body>
    <h1>Editar Cliente</h1>
    <form action="" method="post">
        Nome: <input type="text" name="name" value="<?php echo $cliente['nome']; ?>" required><br>
        Email: <input type="email" name="email" value="<?php echo $cliente['email']; ?>" required><br>
        Telefone: <input type="text" name="phone" value="<?php echo $cliente['telefone']; ?>"><br>
        Endereço: <input type="text" name="address" value="<?php echo $cliente['endereco']; ?>"><br>
        Nacionalidade: <input type="text" name="nationality" value="<?php echo $cliente['nacionalidade']; ?>"><br>
        Bairro: <input type="text" name="neighborhood" value="<?php echo $cliente['bairro']; ?>"><br>
        Cidade: <input type="text" name="city" value="<?php echo $cliente['cidade']; ?>"><br>
        Estado: <input type="text" name="state" value="<?php echo $cliente['estado']; ?>"><br>
        Tipo de Cliente: 
        <select name="clientType">
            <option value="individual" <?php echo ($cliente['tipo_cliente'] === 'individual') ? 'selected' : ''; ?>>Pessoa Física</option>
            <option value="company" <?php echo ($cliente['tipo_cliente'] === 'company') ? 'selected' : ''; ?>>Pessoa Jurídica</option>
        </select><br>
        RG: <input type="text" name="rg" value="<?php echo $cliente['rg']; ?>"><br>
        CPF: <input type="text" name="cpf" value="<?php echo $cliente['cpf']; ?>"><br>
        CNPJ: <input type="text" name="cnpj" value="<?php echo $cliente['cnpj']; ?>"><br>
        Sexo: 
        <select name="gender">
            <option value="M" <?php echo ($cliente['sexo'] === 'M') ? 'selected' : ''; ?>>Masculino</option>
            <option value="F" <?php echo ($cliente['sexo'] === 'F') ? 'selected' : ''; ?>>Feminino</option>
        </select><br>
        <input type="submit" value="Atualizar Cliente">
    </form>
</body>
</html>
