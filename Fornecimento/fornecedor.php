<?php
// Definindo uma variável para armazenar os fornecedores
session_start(); // Inicia a sessão para armazenar os dados de fornecedores

if (!isset($_SESSION['suppliers'])) {
    $_SESSION['suppliers'] = []; // Inicializa o array de fornecedores na sessão, caso ainda não tenha sido definido
}

// Função para adicionar ou atualizar um fornecedor
function addOrUpdateSupplier($id, $name, $phone, $email, $address, $editIndex = -1) {
    if ($editIndex === -1) {
        // Adiciona um novo fornecedor
        $_SESSION['suppliers'][] = [
            'supplierID' => $id,
            'supplierName' => $name,
            'phone' => $phone,
            'email' => $email,
            'address' => $address
        ];
    } else {
        // Atualiza um fornecedor existente
        $_SESSION['suppliers'][$editIndex] = [
            'supplierID' => $id,
            'supplierName' => $name,
            'phone' => $phone,
            'email' => $email,
            'address' => $address
        ];
    }
}

// Função para excluir o último fornecedor
function deleteLastSupplier() {
    array_pop($_SESSION['suppliers']);
}

// Função para editar um fornecedor
function editSupplier($index) {
    return $_SESSION['suppliers'][$index];
}

// Verificando se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $supplierID = $_POST['supplierID'];
    $supplierName = $_POST['supplierName'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Verifica se está editando um fornecedor existente
    if (isset($_POST['editIndex']) && $_POST['editIndex'] !== '') {
        $editIndex = $_POST['editIndex'];
        addOrUpdateSupplier($supplierID, $supplierName, $phone, $email, $address, $editIndex);
    } else {
        addOrUpdateSupplier($supplierID, $supplierName, $phone, $email, $address);
    }
}

// Lógica de exclusão
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    deleteLastSupplier();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Fornecedor</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #b22222;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #b22222;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group textarea {
            height: 100px;
        }

        .form-group button {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-group button:hover {
            background-color: #a52a2a;
        }

        .error-message {
            display: none;
            padding: 10px;
            background-color: #fdd;
            border: 1px solid #d9534f;
            border-radius: 4px;
            color: #d9534f;
            font-size: 14px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            margin-top: 5px;
        }

        .error-message.visible {
            display: block;
        }

        .hidden {
            display: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastro de Fornecedor</h1>
        <form id="supplierForm" action="fornecedor.php" method="POST">
            <div class="form-group">
                <label for="supplierID">ID do Fornecedor:</label>
                <input type="text" id="supplierID" name="supplierID" placeholder="Digite o ID do fornecedor" required>
                <div id="idMessage" class="error-message">O ID deve conter apenas números em 5 dígitos.</div>
            </div>

            <div class="form-group">
                <label for="supplierName">Nome do Fornecedor:</label>
                <input type="text" id="supplierName" name="supplierName" placeholder="Digite o nome do fornecedor" required>
            </div>

            <div class="form-group">
                <label for="phone">Telefone:</label>
                <input type="tel" id="phone" name="phone" placeholder="Digite o telefone" required>
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" placeholder="Digite o e-email" required>
                <div id="emailMessage" class="error-message">O E-mail deve conter o caractere '@'.</div>
            </div>

            <div class="form-group">
                <label for="address">Endereço:</label>
                <textarea id="address" name="address" placeholder="Digite o endereço completo"></textarea>
            </div>

            <div class="form-group">
                <button type="submit">Cadastrar</button>
                <button type="button" id="clearButton">Limpar</button>
            </div>
            <input type="hidden" name="editIndex" id="editIndex">
        </form>

        <table id="supplierTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Endereço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['suppliers'] as $index => $supplier): ?>
                    <tr>
                        <td><?= htmlspecialchars($supplier['supplierID']) ?></td>
                        <td><?= htmlspecialchars($supplier['supplierName']) ?></td>
                        <td><?= htmlspecialchars($supplier['phone']) ?></td>
                        <td><?= htmlspecialchars($supplier['email']) ?></td>
                        <td><?= htmlspecialchars($supplier['address']) ?></td>
                        <td>
                            <a href="index.php?action=edit&index=<?= $index ?>">Alterar</a>
                            <a href="index.php?action=delete">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        const suppliers = <?php echo json_encode($_SESSION['suppliers']); ?>; // Carrega os fornecedores do PHP para o JS

        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById('supplierForm');
            
            const editIndex = new URLSearchParams(window.location.search).get('index');
            if (editIndex !== null) {
                const supplier = suppliers[editIndex];
                document.getElementById('supplierID').value = supplier.supplierID;
                document.getElementById('supplierName').value = supplier.supplierName;
                document.getElementById('phone').value = supplier.phone;
                document.getElementById('email').value = supplier.email;
                document.getElementById('address').value = supplier.address;
                document.getElementById('editIndex').value = editIndex;
            }
        });
    </script>
</body>
</html>
