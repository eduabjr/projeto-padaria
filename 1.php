<!DOCTYPE html> 
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário Funcionário</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #612502; /* Cor de fundo */
            margin: 0;
            padding: 0;
        }
        .form-container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fdf5e6;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        h1 {
            text-align: center;
            color: #b22222;
        }
        .photo-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .photo-box {
            width: 100px;
            height: 140px;
            border: 1px solid #b22222;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            margin-right: 20px;
        }
        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ajusta a imagem para cobrir a área do contêiner */
        }
        .photo-buttons {
            display: flex;
            flex-direction: column;
        }
        .photo-buttons button {
            margin-bottom: 10px;
            background-color: #b22222;
            color: #fff;
            border: none;
            padding: 5px;
            border-radius: 5px;
            cursor: pointer;
        }
        .photo-buttons button:hover {
            background-color: #a11d1d;
        }
        .section {
            background-color: #949494; /* Cinza claro para o fundo */
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .section h2 {
            margin-top: 0;
            color: #fff;
        }
        .form-group {
            margin-bottom: 20px; /* Maior margem inferior para separar os grupos */
        }
        .form-group label {
            display: block;
            margin-bottom: 5px; /* Espaço entre o rótulo e o campo de entrada */
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: calc(100% - 20px); /* Ajusta a largura para caber dentro do container */
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd; /* Fundo das caixas de texto */
            border-radius: 5px;
        }
        .form-group .inline-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px; /* Espaço entre os campos dentro de um grupo */
        }
        .form-group .inline-group > div {
            flex: 1;
        }
        .submit-btn, .clear-btn {
            background-color: #b22222;
            color: #fff;
            border: none;
            padding: 10px 20px; /* Ajuste o padding para aumentar a largura e a altura */
            border-radius: 5px; /* Mantém um leve arredondamento nos cantos */
            cursor: pointer;
            width: auto; /* Define a largura como automática para que se ajuste ao conteúdo */
            height: 35px; /* Define uma altura fixa para os botões */
            display: inline-block; /* Permite que o botão mantenha suas dimensões */
            margin-right: 10px;
            text-align: center; /* Centraliza o texto dentro do botão */
            font-size: 16px; /* Tamanho da fonte do texto */
        }
        .submit-btn:hover, .clear-btn:hover {
            background-color: #a11d1d;
        }
        .number-box {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            align-items: center;
        }
        .number-box input {
            width: 100px;
            padding: 5px;
        }
        .number-box button {
            margin-left: 10px;
            background-color: #b22222;
            color: #fff;
            border: none;
            padding: 5px;
            border-radius: 5px;
            cursor: pointer;
        }
        .number-box button:hover {
            background-color: #a11d1d;
        }
        #tabelaFuncionarios {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fdf5e6;
            border-radius: 10px;
        }
        #tabelaFuncionarios th, #tabelaFuncionarios td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        #tabelaFuncionarios th {
            background-color: #b22222;
            color: #fff;
        }
    
        .form-buttons {
        display: flex; /* Usar flexbox para o contêiner principal */
        justify-content: space-between; /* Distribui o espaço entre os botões */
        margin-top: 20px; /* Adiciona um espaçamento superior se necessário */
    }
    
    .button-container {
        flex: 1; /* Para que cada botão ocupe o mesmo espaço */
        display: flex; /* Usar flexbox para o contêiner do botão */
        justify-content: flex-start; /* Alinha o botão à esquerda */
    }
    
    .button-container:last-child {
        justify-content: flex-end; /* Alinha o último botão à direita */
    }
    

    /* Contêiner com barra de rolagem */
    .tabela-container {
        max-height: 300px; /* Altura máxima da tabela */
        overflow-y: auto; /* Rolagem vertical */
        margin-top: 20px;
    }

    /* Estilos da tabela */
    #tabelaFuncionarios {
        width: 100%;
        border-collapse: collapse;
    }

    #tabelaFuncionarios th, #tabelaFuncionarios td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        font-size: 14px;
    }

    #tabelaFuncionarios th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #tabelaFuncionarios tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #tabelaFuncionarios tr:hover {
        background-color: #e9e9e9;
    }

    /* Responsividade para telas menores */
    @media (max-width: 768px) {
        #tabelaFuncionarios, #tabelaFuncionarios th, #tabelaFuncionarios td {
            font-size: 12px;
        }
        #tabelaFuncionarios th, #tabelaFuncionarios td {
            padding: 8px;
        }
    }


    
    </style>

<script>
    window.onload = function() {
        document.getElementById("nome").addEventListener("keypress", apenasLetras);
        document.getElementById("nacionalidade").addEventListener("keypress", apenasLetras);
        document.getElementById("Cargo").addEventListener("keypress", apenasLetras);
        document.getElementById("Bairro").addEventListener("keypress", apenasLetras);
        document.getElementById("Cidade").addEventListener("keypress", apenasLetras);
        document.getElementById("Estado").addEventListener("keypress", apenasLetras);

        document.getElementById("CPF").addEventListener("input", function(event) {
            event.target.value = formatarCPF(event.target.value);
        });

        document.getElementById("Telefone").addEventListener("input", function(event) {
            event.target.value = formatarTelefone(event.target.value);
        });

        document.getElementById("CEP").addEventListener("input", function(event) {
            event.target.value = formatarCEP(event.target.value);
            buscarEndereco();  // Chama a função para buscar o endereço pelo CEP
        });

        document.getElementById("RG").addEventListener("keypress", apenasNumeros);
        document.getElementById("CPF").addEventListener("keypress", apenasNumeros);
        document.getElementById("Telefone").addEventListener("keypress", apenasNumeros);
        document.getElementById("CEP").addEventListener("keypress", apenasNumeros);
        document.getElementById("Numero").addEventListener("keypress", apenasNumeros);
        
        document.getElementById("botaoAdicionar").onclick = gravarCadastro;  // Botão para adicionar funcionário
    };

    function apenasLetras(e) {
        const tecla = e.keyCode || e.which;
        if ((tecla >= 65 && tecla <= 90) || (tecla >= 97 && tecla <= 122) || tecla == 32) {
            return true;
        } else {
            e.preventDefault();
            return false;
        }
    }

    function apenasNumeros(e) {
        const tecla = e.keyCode || e.which;
        if (!(tecla >= 48 && tecla <= 57)) {
            e.preventDefault();
            return false;
        }
    }

    function formatarCPF(cpf) {
        cpf = cpf.replace(/\D/g, "");
        cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
        cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
        cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
        return cpf;
    }

    function formatarTelefone(telefone) {
        telefone = telefone.replace(/\D/g, "");
        telefone = telefone.replace(/^(\d{2})(\d)/g, "($1) $2");
        telefone = telefone.replace(/(\d)(\d{4})$/, "$1-$2");
        return telefone;
    }

    function formatarCEP(cep) {
        cep = cep.replace(/\D/g, "");
        cep = cep.replace(/^(\d{5})(\d)/, "$1-$2");
        return cep;
    }

    async function buscarEndereco() {
        const cep = document.getElementById("CEP").value.replace(/\D/g, '');
        if (cep.length === 8) {
            try {
                const response = await fetch(https://viacep.com.br/ws/${cep}/json/);
                const data = await response.json();
                if (!data.erro) {
                    document.getElementById("Logradouro").value = data.logradouro;
                    document.getElementById("Bairro").value = data.bairro;
                    document.getElementById("Cidade").value = data.localidade;
                    document.getElementById("Estado").value = data.uf;
                } else {
                    alert("CEP não encontrado.");
                }
            } catch (error) {
                console.error("Erro ao buscar o CEP:", error);
            }
        } else {
            alert("CEP inválido.");
        }
    }

    let funcionarios = [];
    let proximoCodigo = 1;
    let funcionarioAtual = null;

    function adicionarFoto() {
        const fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.accept = 'image/*';
        fileInput.onchange = function () {
            const file = fileInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    const photoBox = document.getElementById('photoBox');
                    photoBox.innerHTML = '';
                    photoBox.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        };
        fileInput.click();
    }

    function removerFoto() {
        document.getElementById('photoBox').innerHTML = '';
    }

    function alterarFoto() {
        adicionarFoto();  // Reaproveitando a função para adicionar foto
    }

    function editarFuncionario(codigo) {
        funcionarioAtual = funcionarios.find(f => f.codigo === codigo);
        if (funcionarioAtual) {
            preencherFormulario(funcionarioAtual);
            document.getElementById("botaoSalvar").onclick = function () {
                const funcionarioEditado = obterDadosFormulario();
                if (validarFormulario(funcionarioEditado)) {
                    Object.assign(funcionarioAtual, funcionarioEditado);
                    renderizarTabela();
                    alert("Funcionário editado com sucesso!");
                    limparCampos();
                    funcionarioAtual = null;
                }
            };
        }
    }

      // Excluir o onclick do botão "Gravar" do formulário para evitar chamadas duplas.
      document.getElementById("botaoAdicionar").onclick = function() {
        const novoFuncionario = obterDadosFormulario();
        if (validarFormulario(novoFuncionario)) {
            // Enviar dados para o servidor ao invés de adicionar na lista local
            fetch('process_form2.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(novoFuncionario) // Envia os dados do novo funcionário
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if(data.success) {
                    // Recarrega a tabela após a adição
                    funcionarios.push(novoFuncionario); // Adiciona o funcionário na lista local
                    renderizarTabela();
                    limparCampos();
                }
            })
            .catch(error => console.error('Erro:', error));
        }
    };

    // Modifique a função excluirFuncionario para chamar diretamente a função do servidor
    async function excluirFuncionario(codigo) {
        const response = await fetch('process_form2.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: codigo }),
        });
        const result = await response.json();
        alert(result.message);
        if(result.success) {
            // Recarregar a tabela após a exclusão
            funcionarios = funcionarios.filter(f => f.codigo !== codigo);
            renderizarTabela();
        }
    }

    function excluirFuncionario(codigo) {
        funcionarios = funcionarios.filter(f => f.codigo !== codigo);
        renderizarTabela();
    }
    
    function renderizarTabela() {
    const tbody = document.querySelector("#tabelaFuncionarios tbody");
    tbody.innerHTML = "";
    funcionarios.forEach(funcionario => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${funcionario.codigo}</td>
            <td>${funcionario.nome}</td>
            <td>${funcionario.sexo}</td>
            <td>${funcionario.estadoCivil}</td>
            <td>${funcionario.nacionalidade}</td>
            <td>${funcionario.turno}</td>
            <td>${funcionario.cargo}</td>
            <td>${funcionario.rg}</td>
            <td>${funcionario.cpf}</td>
            <td>${funcionario.telefone}</td>
            <td>${funcionario.email}</td>
            <td>${funcionario.endereco.cep}</td>
            <td>${funcionario.endereco.logradouro}</td>
            <td>${funcionario.endereco.numero}</td>
            <td>${funcionario.endereco.bairro}</td>
            <td>${funcionario.endereco.cidade}</td>
            <td>${funcionario.endereco.estado}</td>
            <td>${funcionario.foto}</td>
            <td>
                <button onclick="editarFuncionario(${funcionario.codigo})">Editar</button>
                <button onclick="salvarFuncionario(${funcionario.codigo})">Salvar</button>
                <button onclick="excluirFuncionario(${funcionario.codigo})">Excluir</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}


    function limparCampos() {
        document.getElementById("formulario").reset();
        removerFoto();
        document.getElementById("botaoSalvar").onclick = null;  // Limpa a função do botão
        funcionarioAtual = null;  // Limpa a referência do funcionário atual
    }

    function obterDadosFormulario() {
        return {
            nome: document.getElementById("nome").value,
            sexo: document.getElementById("Sexo").value,
            estadoCivil: document.getElementById("EstadoCivil").value,
            nacionalidade: document.getElementById("nacionalidade").value,
            turno: document.getElementById("Turno").value,
            cargo: document.getElementById("Cargo").value,
            rg: document.getElementById("RG").value,
            cpf: document.getElementById("CPF").value,
            telefone: document.getElementById("Telefone").value,
            email: document.getElementById("Email").value,
            endereco: {
                cep: document.getElementById("CEP").value,
                logradouro: document.getElementById("Logradouro").value,
                numero: document.getElementById("Numero").value,
                bairro: document.getElementById("Bairro").value,
                cidade: document.getElementById("Cidade").value,
                estado: document.getElementById("Estado").value
            },
            foto: document.getElementById("photoBox").innerHTML
        };
    }

    function preencherFormulario(funcionario) {
        document.getElementById("nome").value = funcionario.nome;
        document.getElementById("Sexo").value = funcionario.sexo;
        document.getElementById("EstadoCivil").value = funcionario.estadoCivil;
        document.getElementById("nacionalidade").value = funcionario.nacionalidade;
        document.getElementById("Turno").value = funcionario.turno;
        document.getElementById("Cargo").value = funcionario.cargo;
        document.getElementById("RG").value = funcionario.rg;
        document.getElementById("CPF").value = funcionario.cpf;
        document.getElementById("Telefone").value = funcionario.telefone;
        document.getElementById("Email").value = funcionario.email;
        document.getElementById("CEP").value = funcionario.endereco.cep;
        document.getElementById("Logradouro").value = funcionario.endereco.logradouro;
        document.getElementById("Numero").value = funcionario.endereco.numero;
        document.getElementById("Bairro").value = funcionario.endereco.bairro;
        document.getElementById("Cidade").value = funcionario.endereco.cidade;
        document.getElementById("Estado").value = funcionario.endereco.estado;
        
        // Exibir a foto se existir
        const photoBox = document.getElementById('photoBox');
        photoBox.innerHTML = funcionario.foto || '';
    }

    function validarFormulario(funcionario) {
        const camposObrigatorios = [
            funcionario.nome, funcionario.cargo, funcionario.rg, funcionario.cpf,
            funcionario.telefone, funcionario.email, funcionario.endereco.cep,
            funcionario.endereco.logradouro, funcionario.endereco.numero,
            funcionario.endereco.bairro, funcionario.endereco.cidade, funcionario.endereco.estado
        ];

        const isValid = camposObrigatorios.every(campo => campo.trim() !== "");

        if (!isValid) {
            alert("Por favor, preencha todos os campos obrigatórios.");
        }

        return isValid;
    }

    
    function consultarFuncionario() {
        const codigoFuncionario = document.getElementById("numeroFuncionario").value;
        const funcionario = funcionarios.find(f => f.codigo === parseInt(codigoFuncionario, 10));

        if (funcionario) {
            preencherFormulario(funcionario);
        } else {
            alert("Funcionário não encontrado.");
        }
    }

    function salvarFuncionario(codigo) {
            const funcionarioEditado = obterDadosFormulario();
            if (validarFormulario(funcionarioEditado)) {
                const index = funcionarios.findIndex(f => f.codigo === codigo);
                if (index !== -1) {
                    funcionarios[index] = { ...funcionarios[index], ...funcionarioEditado };
                    renderizarTabela();
                    alert("Funcionário salvo com sucesso!");
                    limparCampos();
                }
            }
        }

    function gravarCadastro() {
        const novoFuncionario = obterDadosFormulario();
        if (validarFormulario(novoFuncionario)) {
            novoFuncionario.codigo = proximoCodigo++;
            funcionarios.push(novoFuncionario);
            renderizarTabela();
            alert("Funcionário adicionado com sucesso!");
            limparCampos();
        }
    }
</script>

</head>
<body> 
    <div class="form-container">
        <h1>Cadastro de Funcionário</h1>
        <form id="formulario" method="POST" action="process_form2.php" enctype="multipart/form-data"> 
        <div class="photo-container">
            <div class="photo-box" id="photoBox" name="photoBox" accept="image/*" required>
                <!-- Imagem da foto do funcionário -->
            </div>

            <div class="photo-buttons">
                <button type="button" onclick="adicionarFoto()">Adicionar Foto</button>
                <button type="button" onclick="removerFoto()">Remover Foto</button>
                <button type="button" onclick="alterarFoto()">Alterar Foto</button>
            </div>
        </div>


        <div class="number-box">
            <label>Cód. Funcionário:</label>
            <input type="text" id="numeroFuncionario" name="numeroFuncionario">
            <button type="button" onclick="consultarFuncionario()">🔍</button>
        </div>

        
            <div class="section">
                <h2>Dados Pessoais</h2>
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" onkeypress="return apenasLetras(event)" required>
                </div>
                <div class="form-group inline-group">
                    <div>
                        <label for="Sexo">Sexo</label>
                        <select id="Sexo" required>
                            <option value="">Selecione</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Feminino">Feminino</option>
                        </select>
                    </div>
                    <div>
                        <label for="EstadoCivil">Estado Civil</label>
                        <select id="EstadoCivil" required>
                            <option value="">Selecione</option>
                            <option value="Solteiro">Solteiro</option>
                            <option value="Casado">Casado</option>
                            <option value="Divorciado">Divorciado</option>
                            <option value="Viúvo">Viúvo</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nacionalidade">Nacionalidade</label>
                    <input type="text" id="nacionalidade" onkeypress="return apenasLetras(event)" required>
                </div>
                <div class="form-group inline-group">
                    <div>
                        <label for="Turno">Turno</label>
                        <select id="Turno" required>
                            <option value="">Selecione</option>
                            <option value="Matutino">Matutino</option>
                            <option value="Vespertino">Vespertino</option>
                            <option value="Noturno">Noturno</option>
                        </select>
                    </div>
                    <div>
                        <label for="Cargo">Cargo</label>
                        <select id="Cargo" name="Cargo">
                            <option value="">Selecione...</option>
                            <option value="Gerente">Gerente</option>
                            <option value="Supervisor">Supervisor</option>
                            <option value="Entregador">Entregador</option>
                            <option value="Atendente">Atendente</option>
                            <option value="Caixa">Caixa</option>
                            <option value="Limpeza">Limpeza</option>
                            <option value="Manutenção">Manutenção</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="RG">RG</label>
                    <input type="text" id="RG" required maxlength="10" placeholder="9999999999"/>
                </div>
                <div class="form-group">
                    <label for="CPF">CPF</label>
                    <input type="text" id="CPF" oninput="this.value = formatarCPF(this.value)" required maxlength="14" placeholder="999.999.999-99"/>
                </div>
            </div>

            <div class="section">
                <h2>Dados de Contato</h2>
                <div class="form-group">
                    <label for="Telefone">Telefone</label>
                    <input type="text" id="Telefone" maxlength="15" placeholder="(99) 99999-9999"/>
                </div>
                <div class="form-group">
                    <label for="Email">Email</label>
                    <input type="email" id="Email" required placeholder="email@gmail.com"/>
                </div>
            </div>

            <div class="section">
                <h2>Dados de Endereço</h2>
                <div class="form-group">
                    <label for="CEP">CEP</label>
                    <input type="text" id="CEP" onblur="buscarEndereco()" required maxlength="9" placeholder="99999-999"/>
                </div>
                <div class="form-group">
                    <label for="Logradouro">Logradouro</label>
                    <input type="text" id="Logradouro" required>
                </div>
                <div class="form-group">
                    <label for="Numero">Número</label>
                    <input type="text" id="Numero" required>
                </div>
                <div class="form-group">
                    <label for="Bairro">Bairro</label>
                    <input type="text" id="Bairro" required>
                </div>
                <div class="form-group">
                    <label for="Cidade">Cidade</label>
                    <input type="text" id="Cidade" required>
                </div>
                <div class="form-group">
                    <label for="Estado">Estado</label>
                    <input type="text" id="Estado" required>
                </div>
            </div>

            <div class="form-buttons">
                <button type="button" class="submit-btn" onclick="gravarCadastro()">Gravar</button>
                <button type="button" class="clear-btn" onclick="limparCampos()">Limpar</button>

            </div>
        </form>


        <div class="tabela-container">
            <h2>Funcionários Cadastrados</h2>
            <table id="tabelaFuncionarios">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Sexo</th>
                        <th>Estado Civil</th>
                        <th>Nacionalidade</th>
                        <th>Turno</th>
                        <th>Cargo</th>
                        <th>RG</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>CEP</th>
                        <th>Logradouro</th>
                        <th>Número</th>
                        <th>Bairro</th>
                        <th>Cidade</th>
                        <th>Estado</th>
                        <th>Foto</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php
    include 'config2.php'; // Arquivo com a conexão ao banco de dados

    // Consulta para pegar todos os funcionários cadastrados
    $sql = "SELECT * FROM funcionarios"; // A tabela 'funcionarios' deve estar no banco de dados
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$row['codigo']}</td>
                <td>{$row['nome']}</td>
                <td>{$row['sexo']}</td>
                <td>{$row['estado_civil']}</td>
                <td>{$row['nacionalidade']}</td>
                <td>{$row['turno']}</td>
                <td>{$row['cargo']}</td>
                <td>{$row['rg']}</td>
                <td>{$row['cpf']}</td>
                <td>{$row['telefone']}</td>
                <td>{$row['email']}</td>
                <td>{$row['cep']}</td>
                <td>{$row['logradouro']}</td>
                <td>{$row['numero']}</td>
                <td>{$row['bairro']}</td>
                <td>{$row['cidade']}</td>
                <td>{$row['estado']}</td>
                <td><img src='{$row['foto']}' alt='Foto' style='width:50px;height:auto;'></td>
                <td>
                    <!-- Botão de Editar -->
                    <a href='editar_funcionario.php?id={$row['codigo']}' class='edit-button'>
                        <button type='button'>Editar</button>
                    </a>
                    <!-- Formulário para Deletar -->
                    <form style='display:inline;' method='POST' action='excluir_funcionario.php'>
                        <input type='hidden' name='id' value='{$row['codigo']}'>
                        <button type='submit' onclick='return confirm(\"Tem certeza que deseja excluir?\");'>Excluir</button>
                    </form>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='18'>Nenhum funcionário cadastrado.</td></tr>";
    }

    mysqli_close($conn); // Fecha a conexão com o banco de dados
    ?>
        
                </tbody>
            </table>
        </div>
        

    
</body>


</html>