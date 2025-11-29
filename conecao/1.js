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
    if (cep.length === 8) {
        try {
            const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
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

async function gravarCadastro() {
    const novoFuncionario = obterDadosFormulario();
    if (validarFormulario(novoFuncionario)) {
        try {
            const response = await fetch('https://jsonplaceholder.typicode.com/posts', { 
                method: 'POST', 
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(novoFuncionario)
            });

            if (response.ok) {
                const data = await response.json();

                novoFuncionario.codigo = data.id || proximoCodigo++;
                funcionarios.push(novoFuncionario);

                renderizarTabela();
                alert("Funcionário adicionado com sucesso!");
                limparCampos();
            } else {
                alert("Erro ao cadastrar funcionário no banco de dados.");
            }
        } catch (error) {
            console.error("Erro:", error);
            alert("Erro ao enviar dados ao servidor.");
        }
    }
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
        }
    };
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

function limparCampos() {
    document.getElementById("formulario").reset();
}

function renderizarTabela() {
    const tbody = document.querySelector("#tabelaFuncionarios tbody");
    tbody.innerHTML = "";  // Limpa a tabela antes de renderizar

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
            <td>
                <button onclick="editarFuncionario(${funcionario.codigo})">Editar</button>
                <button onclick="excluirFuncionario(${funcionario.codigo})">Excluir</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

// Funções de edição e exclusão
function editarFuncionario(codigo) {
    const funcionario = funcionarios.find(f => f.codigo === codigo);
    if (funcionario) {
        preencherFormulario(funcionario);
        excluirFuncionario(codigo);
    }
}

function excluirFuncionario(codigo) {
    funcionarios = funcionarios.filter(f => f.codigo !== codigo);
    renderizarTabela();
}

// Função de consulta com requisição ao banco de dados
async function consultarFuncionario() {
    const codigoFuncionario = document.getElementById("numeroFuncionario").value.trim();
    
    if (!codigoFuncionario) {
        alert("Por favor, insira o código do funcionário.");
        return;
    }

    try {
        const response = await fetch(`https://jsonplaceholder.typicode.com/posts/${codigoFuncionario}`);
        
        if (response.ok) {
            const funcionario = await response.json();
            preencherFormulario(funcionario); // Preenche o formulário com os dados recebidos
        } else {
            alert("Funcionário não encontrado.");
            preencherFormulario({
                nome: "Nome Exemplo",
                sexo: "Sexo Exemplo",
                estadoCivil: "Estado Civil Exemplo",
                nacionalidade: "Nacionalidade Exemplo",
                turno: "Turno Exemplo",
                cargo: "Cargo Exemplo",
                rg: "RG Exemplo",
                cpf: "CPF Exemplo",
                telefone: "Telefone Exemplo",
                email: "Email Exemplo",
                endereco: {
                    cep: "CEP Exemplo",
                    logradouro: "Logradouro Exemplo",
                    numero: "Número Exemplo",
                    bairro: "Bairro Exemplo",
                    cidade: "Cidade Exemplo",
                    estado: "Estado Exemplo"
                }
            });
        }
    } catch (error) {
        console.error("Erro:", error);
        alert("Erro ao consultar o funcionário.");
    }
}

// Função para preencher o formulário com os dados do funcionário
function preencherFormulario(funcionario) {
    document.getElementById("nome").value = funcionario.nome || "Nome Exemplo";
    document.getElementById("Sexo").value = funcionario.sexo || "Sexo Exemplo";
    document.getElementById("EstadoCivil").value = funcionario.estadoCivil || "Estado Civil Exemplo";
    document.getElementById("nacionalidade").value = funcionario.nacionalidade || "Nacionalidade Exemplo";
    document.getElementById("Turno").value = funcionario.turno || "Turno Exemplo";
    document.getElementById("Cargo").value = funcionario.cargo || "Cargo Exemplo";
    document.getElementById("RG").value = funcionario.rg || "RG Exemplo";
    document.getElementById("CPF").value = funcionario.cpf || "CPF Exemplo";
    document.getElementById("Telefone").value = funcionario.telefone || "Telefone Exemplo";
    document.getElementById("Email").value = funcionario.email || "Email Exemplo";
    document.getElementById("CEP").value = funcionario.endereco?.cep || "CEP Exemplo";
    document.getElementById("Logradouro").value = funcionario.endereco?.logradouro || "Logradouro Exemplo";
    document.getElementById("Numero").value = funcionario.endereco?.numero || "Número Exemplo";
    document.getElementById("Bairro").value = funcionario.endereco?.bairro || "Bairro Exemplo";
    document.getElementById("Cidade").value = funcionario.endereco?.cidade || "Cidade Exemplo";
    document.getElementById("Estado").value = funcionario.endereco?.estado || "Estado Exemplo";
}

document.addEventListener("DOMContentLoaded", function() {
    ["nome", "nacionalidade", "Cargo", "Bairro", "Cidade", "Estado"].forEach(id => addEventById(id, "keypress", apenasLetras));
    ["RG", "CPF", "Telefone", "CEP", "Numero"].forEach(id => addEventById(id, "keypress", apenasNumeros));

    addEventById("CPF", "input", function(event) {
        event.target.value = formatarCPF(event.target.value);
    });
    
    addEventById("Telefone", "input", function(event) {
        event.target.value = formatarTelefone(event.target.value);
    });

    addEventById("CEP", "input", function(event) {
        event.target.value = formatarCEP(event.target.value);
        buscarEndereco();
    });

    document.getElementById("formulario").addEventListener("submit", async function(event) {
        event.preventDefault();
        await gravarCadastro();
    });
});

// Função para adicionar evento em elementos existentes
function addEventById(id, event, callback) {
    const element = document.getElementById(id);
    if (element) {
        element.addEventListener(event, callback);
    } else {
        console.warn(`Elemento com ID "${id}" não encontrado`);
    }
}
