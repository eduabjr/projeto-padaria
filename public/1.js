// Declarar funcionarios no escopo global
let funcionarios = [];
let proximoCodigo = 1;

// Funções de validação e formatação
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
    console.log("CEP:", cep); // Verificar o CEP formatado
    
    if (cep.length !== 8) {
        alert("CEP inválido. Certifique-se de que o CEP contém 8 dígitos.");
        return;
    }

    try {
        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        console.log("Resposta da API:", response); // Verificar a resposta

        if (!response.ok) {
            throw new Error("Erro ao consultar o CEP. Verifique sua conexão.");
        }

        const data = await response.json();
        console.log("Dados recebidos:", data); // Verificar os dados recebidos

        if (data.erro) {
            alert("CEP não encontrado.");
            return;
        }

        document.getElementById("Logradouro").value = data.logradouro || "";
        document.getElementById("Bairro").value = data.bairro || "";
        document.getElementById("Cidade").value = data.localidade || "";
        document.getElementById("Estado").value = data.uf || "";
    } catch (error) {
        console.error("Erro ao buscar o CEP:", error);
        alert("Não foi possível buscar o endereço. Tente novamente mais tarde.");
    }
}




// Função para validar formulário
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

// Função para limpar campos do formulário
function limparCampos() {
    document.getElementById("formulario").reset();
    document.getElementById("funcionarioId").value = ""; // Limpa o campo oculto de ID
}
                                                        

// Função para atualizar um funcionário
async function atualizarFuncionario(codigo) {
    const funcionarioAtualizado = obterDadosFormulario();

    try {
        const response = await fetch(`http://localhost:3001/funcionarios/${codigo}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(funcionarioAtualizado)
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


// Função para excluir um funcionário
async function excluirFuncionario(codigo) {
    try {
        const response = await fetch(`http://localhost:3001/funcionarios/${codigo}`, {
            method: 'DELETE'
        });

        if (response.ok) {
            alert("Funcionário excluído com sucesso!");
            carregarFuncionarios();
        } else {
            alert("Erro ao excluir funcionário.");
        }
    } catch (error) {
        console.error("Erro ao excluir funcionário:", error);
        alert("Erro ao excluir o funcionário.");
    }
}


// Função para exibir mensagem de erro
function exibirMensagemErro(mensagem) {
    alert(mensagem); // Exibir erro via alerta (opcionalmente, poderia ser um elemento HTML para feedback visual)
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


 
function cadastrarFuncionario(novoFuncionario) {
    if (verificarCPFDuplicado(novoFuncionario.cpf)) {
        alert("CPF duplicado: o CPF informado já está registrado para um funcionário ativo.");
        return;
    }

    // Caso não haja duplicidade, adiciona o novo funcionário
    novoFuncionario.codigo = proximoCodigo++;
    novoFuncionario.isDeleted = false; // Define o funcionário como ativo
    funcionarios.push(novoFuncionario);
    alert("Funcionário cadastrado com sucesso!");
}


// Função para preencher o formulário com dados do funcionário
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
    document.getElementById("CEP").value = funcionario.cep;
    document.getElementById("Logradouro").value = funcionario.logradouro;
    document.getElementById("Numero").value = funcionario.numero;
    document.getElementById("Bairro").value = funcionario.bairro;
    document.getElementById("Cidade").value = funcionario.cidade;
    document.getElementById("Estado").value = funcionario.estado;
}


// Função para resetar o formulário e mensagens de erro
function resetarFormulario() {
    document.getElementById("formulario").reset();
    codigoAtual = null; // Volta para modo de cadastro
}

// Função para editar o funcionário selecionado
async function editarFuncionario(codigo) {
    try {
        const response = await fetch(`http://localhost:3001/funcionarios/${codigo}`);
        if (response.ok) {
            const funcionario = await response.json();
            preencherFormulario(funcionario);
            codigoAtual = codigo; // Define o código para indicar modo de edição
        } else {
            alert("Erro ao buscar funcionário para edição.");
        }
    } catch (error) {
        console.error("Erro ao buscar dados:", error);
    }
}

// Função para consultar um funcionário pelo código inserido no campo
async function consultarFuncionario() {
    const codigo = document.getElementById("numeroFuncionario").value;
    if (codigo) {
        try {
            const response = await fetch(`http://localhost:3001/funcionarios/${codigo}`);
            if (response.ok) {
                const funcionario = await response.json();
                preencherFormulario(funcionario);
                codigoAtual = codigo; // Define o código para edição se o usuário quiser atualizar
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



// Função para excluir um funcionário por completo do banco de dados
async function excluirFuncionarioCompleto(idFuncionario) {
    try {
        const response = await fetch(`http://localhost:3001/funcionarios/${idFuncionario}`, {
            method: 'DELETE',
        });
        
        if (response.ok) {
            console.log("Funcionário excluído permanentemente do banco de dados.");
            atualizarInterface(); // Atualiza a interface após a exclusão
        } else {
            console.error("Erro ao tentar excluir o funcionário permanentemente.");
        }
    } catch (error) {
        console.error("Erro ao conectar com o servidor para excluir o funcionário:", error);
    }
}





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

// Função para salvar o funcionário (cadastrar ou atualizar)
async function gravarCadastro() {
    const dados = obterDadosFormulario();

    // Verificar se o CPF já existe (apenas em novos cadastros)
    if (!codigoAtual) {
        const cpfExiste = await verificarCPFExistente(dados.cpf);
        if (cpfExiste) {
            exibirMensagemErro("O CPF informado já está registrado. Use um CPF diferente.");
            return; // Interrompe o processo de cadastro se o CPF já estiver registrado
        }
    }

    try {
        const url = codigoAtual
            ? `http://localhost:3001/funcionarios/${codigoAtual}` // Atualização de funcionário existente
            : 'http://localhost:3001/funcionarios'; // Cadastro de novo funcionário
        const metodo = codigoAtual ? 'PUT' : 'POST';

        const response = await fetch(url, {
            method: metodo,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(dados)
        });

        if (response.ok) {
            alert(codigoAtual ? "Funcionário atualizado com sucesso!" : "Funcionário cadastrado com sucesso!");
            carregarFuncionarios(); // Atualiza a tabela após cadastro bem-sucedido
            resetarFormulario(); // Limpa o formulário e redefine o modo de cadastro
        } else {
            exibirMensagemErro("Erro ao salvar funcionário. Verifique os dados e tente novamente.");
        }
    } catch (error) {
        console.error("Erro ao enviar dados:", error);
        exibirMensagemErro("Erro ao conectar-se com o servidor. Tente novamente mais tarde.");
    }
}

// Função para resetar o formulário
function resetarFormulario() {
    document.getElementById("formulario").reset();
    codigoAtual = null; // Limpa o código para modo criação
}

// Função para carregar e renderizar a tabela de funcionários
async function carregarFuncionarios() {
    try {
        const response = await fetch('http://localhost:3001/funcionarios');
        if (response.ok) {
            const funcionarios = await response.json();
            renderizarTabela(funcionarios);
        } else {
            console.error("Erro ao buscar funcionários.");
        }
    } catch (error) {
        console.error("Erro ao buscar dados:", error);
    }
}

// Função para renderizar a tabela
function renderizarTabela(funcionarios) {
    const tbody = document.getElementById("tabelaFuncionariosBody");
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
        tbody.appendChild(row);
    });
}

// Função para inicializar a tabela ao carregar a página
document.addEventListener("DOMContentLoaded", carregarFuncionarios);

