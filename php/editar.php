<?php
include '../config/config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM clientes WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $cliente = mysqli_fetch_assoc($result);
    } else {
        echo "Cliente não encontrado.";
        exit; // Adicionando exit para não continuar o script
    }
} else {
    echo "ID não fornecido.";
    exit; // Adicionando exit para não continuar o script
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <style>
        /* Aqui você pode adicionar estilos semelhantes ao seu formulário de cadastro */
        body {
            font-family: Arial, sans-serif;
            background-color: #aa0202;
            margin: 0;
            padding: 0;
        }
        .form-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #b22222;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, textarea, select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .submit-btn {
            background-color: #b22222;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #a11d1d;
        }
        .conditional-field {
            display: none; /* Esconde os campos inicialmente */
        }
    </style>
    <script>
     
    function toggleFields() {
        const clientType = document.querySelector('select[name="clientType"]').value;
        const cpfField = document.getElementById('cpf-field');
        const cnpjField = document.getElementById('cnpj-field');
        const sexoField = document.getElementById('sexo-field');
        const rgField = document.getElementById('rg-field'); // Adicione o RG

        if (clientType === 'individual') {
            cpfField.style.display = 'block';
            cnpjField.style.display = 'none';
            sexoField.style.display = 'block';
            rgField.style.display = 'block'; // Mostra o campo RG
        } else {
            cpfField.style.display = 'none';
            cnpjField.style.display = 'block';
            sexoField.style.display = 'none';
            rgField.style.display = 'none'; // Esconde o campo RG
        }
    }

    window.onload = toggleFields;

    </script>

</head>
<body>

    <div class="form-container">
        <h1>Editar Cliente</h1>
        
        <form action="update_cliente.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" value="<?php echo $cliente['nome']; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $cliente['email']; ?>" required>
            </div>

            <div class="form-group">
                <label for="phone">Telefone:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo $cliente['telefone']; ?>" required>
            </div>

            <div class="form-group">
                <label for="address">Endereço:</label>
                <textarea id="address" name="address" rows="4" required><?php echo $cliente['endereco']; ?></textarea>
            </div>

            <div class="form-group">
                <label for="nationality">Nacionalidade:</label>
                <input type="text" id="nationality" name="nationality" value="<?php echo $cliente['nacionalidade']; ?>" required>
            </div>

            <div class="form-group">
                <label for="neighborhood">Bairro:</label>
                <input type="text" id="neighborhood" name="neighborhood" value="<?php echo $cliente['bairro']; ?>" required>
            </div>

            <div class="form-group">
                <label for="city">Cidade:</label>
                <input type="text" id="city" name="city" value="<?php echo $cliente['cidade']; ?>" required>
            </div>

            <div class="form-group">
                <label for="state">Estado:</label>
                <input type="text" id="state" name="state" value="<?php echo $cliente['estado']; ?>" required>
            </div>

            <div class="form-group">
                <label>Tipo de Cliente:</label>
                <select name="clientType" onchange="toggleFields()" required>
                    <option value="individual" <?php if ($cliente['tipo_cliente'] == 'individual') echo 'selected'; ?>>Físico</option>
                    <option value="company" <?php if ($cliente['tipo_cliente'] == 'company') echo 'selected'; ?>>Jurídico</option>
                </select>
            </div>

            <div id="sexo-field" class="conditional-field">
                <div class="form-group">
                    <label for="sexo">Sexo:</label>
                    <select name="sexo">
                        <option value="male" <?php if ($cliente['sexo'] == 'masculino') echo 'selected'; ?>>Masculino</option>
                        <option value="female" <?php if ($cliente['sexo'] == 'feminino') echo 'selected'; ?>>Feminino</option>
                    </select>
                </div>
            </div>

                <div id="rg-field" class="conditional-field">
    <div class="form-group">
        <label for="rg">RG:</label>
        <input type="text" id="rg" name="rg" value="<?php echo $cliente['rg']; ?>">
    </div>
</div>

            <div id="cpf-field" class="conditional-field">
                <div class="form-group">
                    <label for="cpf">CPF:</label>
                    <input type="text" id="cpf" name="cpf" value="<?php echo $cliente['cpf']; ?>">
                </div>
            </div>

        

            <div id="cnpj-field" class="conditional-field">
                <div class="form-group">
                    <label for="cnpj">CNPJ:</label>
                    <input type="text" id="cnpj" name="cnpj" value="<?php echo $cliente['cnpj']; ?>">
                </div>
            </div>

            <div class="button-group">
                <input type="submit" value="Atualizar" class="submit-btn">
            </div>
        </form>
    </div>

</body>
</html>