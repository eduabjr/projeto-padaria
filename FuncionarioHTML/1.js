// Declarar funcionarios no escopo global
let funcionarios = []; // Array para armazenar dados de funcionários
let proximoCodigo = 1; // Variável para gerar o próximo código de funcionário

// Função para permitir apenas letras em determinados campos
function apenasLetras(e) {
    const tecla = e.key;

    // Verifica se a tecla é uma letra, um caractere permitido ou uma tecla de controle
    if (
        (tecla >= 'a' && tecla <= 'z') || // Letras minúsculas
        (tecla >= 'A' && tecla <= 'Z') || // Letras maiúsculas
        tecla === ' ' || // Espaço
        tecla === 'Backspace' || // Backspace
        tecla === 'Delete' || // Delete
        tecla === 'ArrowLeft' || // Seta para a esquerda
        tecla === 'ArrowRight' || // Seta para a direita
        tecla === 'ArrowUp' || // Seta para cima
        tecla === 'ArrowDown' || // Seta para baixo
        tecla === 'Tab' || // Tab
        tecla === '.' || // Ponto
        tecla === '-' || // Traço
        tecla === '(' || // Parêntese esquerdo
        tecla === ')' // Parêntese direito
    ) {
        return true;
    }

    // Impede qualquer outro caractere
    e.preventDefault();
    return false;
}

// Função para permitir apenas números em determinados campos
function apenasNumeros(e) {
    const tecla = e.keyCode || e.which;
    // Permite números no teclado principal e no teclado numérico, além das teclas de controle
    if (
        (tecla >= 48 && tecla <= 57) || // Números no teclado principal
        (tecla >= 96 && tecla <= 105) || // Números no teclado numérico
        tecla === 8 || // Backspace
        tecla === 46 || // Delete
        (tecla >= 37 && tecla <= 40) // Setas direcionais
    ) {
        return true;
    } else {
        e.preventDefault();
        return false;
    }
}

// Função para formatar CPF
function formatarCPF(cpf) {
    cpf = cpf.replace(/\D/g, ""); // Remove todos os caracteres não numéricos
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2"); // Insere um ponto após os três primeiros dígitos
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2"); // Insere um ponto após os seis primeiros dígitos
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2"); // Insere um traço após os nove primeiros dígitos
    return cpf;
}

// Função para formatar telefone
function formatarTelefone(telefone) {
    telefone = telefone.replace(/\D/g, ""); // Remove todos os caracteres não numéricos
    telefone = telefone.replace(/^(\d{2})(\d)/g, "($1) $2"); // Insere parênteses ao redor dos dois primeiros dígitos
    telefone = telefone.replace(/(\d)(\d{4})$/, "$1-$2"); // Insere um traço antes dos últimos quatro dígitos
    return telefone;
}

// Função para formatar o campo CEP
function formatarCEP(cep) {
    cep = cep.replace(/\D/g, ""); // Remove todos os caracteres não numéricos
    cep = cep.replace(/^(\d{5})(\d)/, "$1-$2"); // Formata como 99999-999
    return cep;
}

// Aplica a formatação ao campo de entrada de CEP enquanto o usuário digita
document.getElementById("CEP").addEventListener("input", function(e) {
    e.target.value = formatarCEP(e.target.value); // Aplica a função de formatação ao valor atual do campo CEP
});

// Função para buscar endereço via API com base no CEP
async function buscarEndereco() {
    const cep = document.getElementById("CEP").value.replace(/\D/g, ''); // Remove caracteres não numéricos do CEP
    console.log("CEP:", cep); // Log para verificar o CEP formatado

    if (cep.length !== 8) { // Verifica se o CEP possui 8 dígitos
        alert("CEP inválido. Certifique-se de que o CEP contém 8 dígitos.");
        return;
    }

    try {
        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`); // Requisição à API ViaCEP
        console.log("Resposta da API:", response); // Log para verificar a resposta da API

        if (!response.ok) {
            throw new Error("Erro ao consultar o CEP. Verifique sua conexão.");
        }

        const data = await response.json(); // Converte a resposta para JSON
        console.log("Dados recebidos:", data); // Log para verificar os dados recebidos

        if (data.erro) {
            alert("CEP não encontrado.");
            return;
        }

        // Preenche os campos de endereço com os dados recebidos da API
        document.getElementById("Logradouro").value = data.logradouro || "";
        document.getElementById("Bairro").value = data.bairro || "";
        document.getElementById("Cidade").value = data.localidade || "";
        document.getElementById("Estado").value = data.uf || "";
    } catch (error) {
        console.error("Erro ao buscar o CEP:", error);
        alert("Não foi possível buscar o endereço. Tente novamente mais tarde.");
    }
}

// Função para validar o formulário
function validarFormulario(funcionario) {
    // Campos obrigatórios que devem estar preenchidos
    const camposObrigatorios = [
        funcionario.nome, funcionario.cargo, funcionario.rg, funcionario.cpf,
        funcionario.telefone, funcionario.email, funcionario.endereco.cep,
        funcionario.endereco.logradouro, funcionario.endereco.numero,
        funcionario.endereco.bairro, funcionario.endereco.cidade, funcionario.endereco.estado
    ];
    // Verifica se todos os campos obrigatórios estão preenchidos
    const isValid = camposObrigatorios.every(campo => campo.trim() !== "");

    if (!isValid) {
        alert("Por favor, preencha todos os campos obrigatórios.");
    }
    return isValid;
}

// Função para atualizar os dados de um funcionário existente
async function atualizarFuncionario(codigo) {
    const funcionarioAtualizado = obterDadosFormulario(); // Obtém os dados do formulário

    try {
        const response = await fetch(`http://localhost:3005/funcionarios/${codigo}`, {
            method: 'PUT', // Método de atualização
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(funcionarioAtualizado) // Dados a serem enviados
        });

        if (response.ok) {
            alert("Funcionário atualizado com sucesso!");
            carregarFuncionarios();
            limparCampos();
        } else {
            alert("Erro ao atualizar funcionário.");
        }
    } catch (error) {
        console.error("Erro ao atualizar funcionário:", error);
        alert("Erro ao atualizar o funcionário.");
    }
}

// Função para exibir uma mensagem de erro
function exibirMensagemErro(mensagem) {
    alert(mensagem); // Exibe o erro como um alerta
}

// Função para atualizar a interface, excluindo funcionários inativos
function atualizarInterface() {
    const tabela = document.getElementById("tabelaFuncionarios");
    tabela.innerHTML = ""; // Limpa a tabela

    funcionarios.filter(f => !f.isDeleted).forEach(funcionario => {
        // Código para exibir o funcionário na tabela
        // Por exemplo, criar linhas da tabela com os dados do funcionário
    });
}

// Função para preencher o formulário com dados do funcionário
function preencherFormulario(funcionario) {
    // Preenche cada campo com os dados do funcionário fornecido
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
    document.getElementById("CEP").value = funcionario.cep;
    document.getElementById("Logradouro").value = funcionario.logradouro;
    document.getElementById("Numero").value = funcionario.numero;
    document.getElementById("Bairro").value = funcionario.bairro;
    document.getElementById("Cidade").value = funcionario.cidade;
    document.getElementById("Estado").value = funcionario.estado;
}

// Função para resetar o formulário e redefinir variáveis para um novo cadastro
function resetarFormulario() {
    document.getElementById("formulario").reset(); // Limpa o formulário
    codigoAtual = null; // Indica que estamos no modo de cadastro
}

// Função para editar um funcionário existente
async function editarFuncionario(codigo) {
    try {
        const response = await fetch(`http://localhost:3005/funcionarios/${codigo}`);
        if (response.ok) {
            const funcionario = await response.json();
            preencherFormulario(funcionario); // Preenche o formulário com os dados do funcionário
            codigoAtual = codigo; // Armazena o código do funcionário para atualização
        } else {
            alert("Erro ao buscar funcionário para edição.");
        }
    } catch (error) {
        console.error("Erro ao buscar dados:", error);
    }
}

// Função para consultar um funcionário específico pelo código
async function consultarFuncionario() {
    const codigo = document.getElementById("numeroFuncionario").value;
    if (codigo) {
        try {
            const response = await fetch(`http://localhost:3005/funcionarios/${codigo}`);
            if (response.ok) {
                const funcionario = await response.json();
                preencherFormulario(funcionario);
                codigoAtual = codigo; // Armazena o código para possível edição
            } else {
                alert("Funcionário não encontrado.");
            }
        } catch (error) {
            console.error("Erro ao consultar funcionário:", error);
        }
    } else {
        alert("Por favor, insira um código válido.");
    }
}

// Variável para armazenar o código do funcionário em edição
let codigoAtual = null;

// Variável para controlar o estado de duplicação do CPF
let cpfDuplicado = false;

// Função para capturar dados do formulário
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
        cep: document.getElementById("CEP").value,
        logradouro: document.getElementById("Logradouro").value,
        numero: document.getElementById("Numero").value,
        bairro: document.getElementById("Bairro").value,
        cidade: document.getElementById("Cidade").value,
        estado: document.getElementById("Estado").value
    };
}

// Função para limpar campos do formulário e redefinir variáveis
function limparCampos() {
    document.getElementById("formulario").reset(); // Limpa todos os campos do formulário
    codigoAtual = null; // Redefine o código para indicar que estamos no modo de criação

    // Limpa o campo de ID oculto se houver um no formulário
    if (document.getElementById("funcionarioId")) {
        document.getElementById("funcionarioId").value = "";
    }
}

// Função para excluir um funcionário e limpar o formulário
async function excluirFuncionario(codigo) {
    try {
        const response = await fetch(`http://localhost:3005/funcionarios/${codigo}`, {
            method: 'DELETE'
        });

        if (response.ok) {
            alert("Funcionário excluído com sucesso!");
            carregarFuncionarios();
            limparCampos(); // Limpa o formulário após exclusão
        } else {
            alert("Erro ao excluir funcionário.");
        }
    } catch (error) {
        console.error("Erro ao excluir funcionário:", error);
        alert("Erro ao excluir funcionário.");
    }
}

// Função para capturar e salvar ou atualizar dados do formulário
async function gravarCadastro() {
    const dados = obterDadosFormulario();

    try {
        const url = codigoAtual
            ? `http://localhost:3005/funcionarios/${codigoAtual}` // Atualização de funcionário existente
            : 'http://localhost:3005/funcionarios'; // Cadastro de novo funcionário
        const metodo = codigoAtual ? 'PUT' : 'POST';

        const response = await fetch(url, {
            method: metodo,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(dados)
        });

        if (response.ok) {
            alert(codigoAtual ? "Funcionário atualizado com sucesso!" : "Funcionário cadastrado com sucesso!");
            carregarFuncionarios(); // Atualiza a tabela após cadastro bem-sucedido
            limparCampos(); // Limpa o formulário e redefine o modo de cadastro
        } else {
            alert("Erro ao salvar funcionário. Verifique os dados e tente novamente.");
        }
    } catch (error) {
        console.error("Erro ao enviar dados:", error);
        alert("Erro ao conectar-se com o servidor. Tente novamente mais tarde.");
    }
}

// Função para exibir mensagens de erro no formulário
function resetarFormulario() {
    document.getElementById("formulario").reset();
    codigoAtual = null; // Limpa o código para modo criação
}

// Função assíncrona para carregar a tabela de funcionários ao abrir a página
async function carregarFuncionarios() {
    try {
        const response = await fetch('http://127.0.0.1:3005/funcionarios'); // Certifique-se de que o servidor backend está rodando nessa URL
        if (response.ok) {
            const funcionarios = await response.json();
            renderizarTabela(funcionarios);
        } else {
            console.error("Erro ao buscar funcionários. Status:", response.status);
        }
    } catch (error) {
        console.error("Erro ao buscar dados:", error.message);
    }
}

// Função para renderizar a tabela de funcionários na interface
function renderizarTabela(funcionarios) {
    const tabelaBody = document.getElementById("tabelaFuncionariosBody");
    tabelaBody.innerHTML = "";

    funcionarios.forEach((funcionario) => {
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
            <td>${funcionario.cep}</td>
            <td>${funcionario.logradouro}</td>
            <td>${funcionario.numero}</td>
            <td>${funcionario.bairro}</td>
            <td>${funcionario.cidade}</td>
            <td>${funcionario.estado}</td>
            <td>
                <button onclick="editarFuncionario(${funcionario.codigo})">Editar</button>
                <button onclick="excluirFuncionario(${funcionario.codigo})">Excluir</button>
            </td>
        `;

        tabelaBody.appendChild(row);
    });
}

// Evento para carregar a tabela de funcionários após o carregamento da página
document.addEventListener("DOMContentLoaded", () => {
    carregarFuncionarios().catch(error => console.error("Erro ao carregar funcionários no DOMContentLoaded:", error));
});