<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente</title>
    <style>
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
        h1, h2 {
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
        .form-group {
            margin-bottom: 15px;
        }
        .form-group .radio-group {
            display: flex;
            align-items: center;
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
        .button-group {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        /* Estilos para a tabela */
        .table-container {
            max-width: 100%;
            overflow-x: auto; /* Adiciona rolagem horizontal */
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 14px;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        button {
            background-color: #b22222;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
        }
        button:hover {
            background-color: #a11d1d;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@latest/dist/cleave.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@latest/dist/addons/cleave-phone.br.js"></script>
</head>
<body>

    <div class="form-container">
        <h1>Cadastro de Cliente</h1>
        
        <form id="customerForm" action="process_form.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" required pattern="[A-Za-z\s]+">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="phone">Telefone:</label>
                <input type="tel" id="phone" name="phone" maxlength="15" placeholder="(99) 99999-9999" required />
            </div>

            <div class="form-group">
                <label for="address">Endereço:</label>
                <textarea id="address" name="address" rows="4" pattern="[A-Za-z0-9\s,.-]+" required></textarea>
            </div>

            <div class="form-group">
                <label for="nationality">Nacionalidade:</label>
                <input type="text" id="nationality" name="nationality" pattern="[A-Za-z\s]+" required>
            </div>

            <div class="form-group">
                <label for="neighborhood">Bairro:</label>
                <input type="text" id="neighborhood" name="neighborhood" pattern="[A-Za-z\s]+" required>
            </div>

            <div class="form-group">
                <label for="city">Cidade:</label>
                <input type="text" id="city" name="city" pattern="[A-Za-z\s]+" required>
            </div>

            <div class="form-group">
                <label for="state">Estado:</label>
                <input type="text" id="state" name="state" pattern="[A-Za-z\s]+" required>
            </div>

            <div class="form-group">
                <label>Tipo de Cliente:</label>
                <div class="radio-group">
                    <input type="radio" id="individual" name="clientType" value="individual" required>
                    <label for="individual">Físico</label>
                    <input type="radio" id="company" name="clientType" value="company">
                    <label for="company">Jurídico</label>
                </div>
            </div>

            <div class="form-group" id="rgContainer" style="display:none;">
                <label for="rg">RG:</label>
                <input type="text" id="rg" name="rg" placeholder="12.345.678-9">
            </div>

            <div class="form-group" id="cpfCnpjContainer">
                <label for="cpf" id="cpfLabel" style="display:none;">CPF:</label>
                <input type="text" id="cpf" name="cpf" placeholder="123.456.789-00" style="display:none;">
                <label for="cnpj" id="cnpjLabel" style="display:none;">CNPJ:</label>
                <input type="text" id="cnpj" name="cnpj" placeholder="12.345.678/0001-90" style="display:none;">
            </div>

            <div class="form-group" id="genderContainer" style="display:none;">
                <label>Sexo:</label>
                <div class="radio-group">
                    <input type="radio" id="male" name="gender" value="male">
                    <label for="male">Masculino</label>
                    <input type="radio" id="female" name="gender" value="female">
                    <label for="female">Feminino</label>
                </div>
            </div>

            <div class="button-group">
                <input type="submit" value="Cadastrar" class="submit-btn">
            </div>
        </form>
        <h2>Clientes Cadastrados</h2>
        <div class="table-container">
        <table border="1" width="100%" style="border-collapse: collapse; margin-top: 20px;">
        <thead>
    <tr>
        <th>ID</th> 
        <th>Nome</th>
        <th>Email</th>
        <th>Telefone</th>
        <th>Endereço</th>
        <th>Nacionalidade</th>
        <th>Bairro</th>
        <th>Cidade</th>
        <th>Estado</th>
        <th>Tipo de Cliente</th>
        <th>RG</th>
        <th>CPF</th>
        <th>CNPJ</th>
        <th>Sexo</th>
        <th>Ações</th>
    </tr>
</thead>
<tbody>
    <?php
    include 'config/config.php';

    $sql = "SELECT * FROM clientes";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nome']}</td>
                <td>{$row['email']}</td>
                <td>{$row['telefone']}</td>
                <td>{$row['endereco']}</td>
                <td>{$row['nacionalidade']}</td>
                <td>{$row['bairro']}</td>
                <td>{$row['cidade']}</td>
                <td>{$row['estado']}</td>
                <td>{$row['tipo_cliente']}</td>
                <td>{$row['rg']}</td>
                <td>{$row['cpf']}</td>
                <td>{$row['cnpj']}</td>
                <td>{$row['sexo']}</td>
                <td>
                    <a href='editar.php?id={$row['id']}' class='edit-button'>
                        <button type='button'>Editar</button>
                    </a>
                    <form style='display:inline;' method='POST' action='deletar_cliente.php'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <input type='hidden' name='redirect' value='cadastro_cliente.php'>
                        <button type='submit'>Excluir</button>
                    </form>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='15'>Nenhum cliente cadastrado.</td></tr>";
    }

    mysqli_close($conn);
    ?>
</tbody>


        </table>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rgContainer = document.getElementById('rgContainer');
            const cpfCnpjContainer = document.getElementById('cpfCnpjContainer');
            const cpfLabel = document.getElementById('cpfLabel');
            const cnpjLabel = document.getElementById('cnpjLabel');
            const genderContainer = document.getElementById('genderContainer');
            const clientTypeRadios = document.getElementsByName('clientType');

            new Cleave('#phone', {
                delimiters: ['(', ') ', '-', '-'],
                blocks: [0, 2, 5, 4],
                numericOnly: true
            });

            new Cleave('#cpf', {
                delimiters: ['.', '.', '-'],
                blocks: [3, 3, 3, 2],
                numericOnly: true
            });

            new Cleave('#cnpj', {
                delimiters: ['.', '.', '/', '-'],
                blocks: [2, 3, 3, 4, 2],
                numericOnly: true
            });

            new Cleave('#rg', {
                blocks: [2, 3, 3, 1],
                delimiter: '.',
                numericOnly: true
            });

            clientTypeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'individual') {
                        cpfLabel.style.display = 'block';
                        document.getElementById('cpf').style.display = 'block';
                        cnpjLabel.style.display = 'none';
                        document.getElementById('cnpj').style.display = 'none';
                        genderContainer.style.display = 'block';
                        rgContainer.style.display = 'block';
                    } else {
                        cpfLabel.style.display = 'none';
                        document.getElementById('cpf').style.display = 'none';
                        cnpjLabel.style.display = 'block';
                        document.getElementById('cnpj').style.display = 'block';
                        genderContainer.style.display = 'none';
                        rgContainer.style.display = 'none';
                    }
                });
            });
        });
    </script>

</body>
</html>