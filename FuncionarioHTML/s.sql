CREATE DATABASE s; -- Cria um novo banco de dados chamado "s"
USE s; -- Define o banco de dados atual como "s" para as próximas operações

-- Cria a tabela "funcionarios" com as colunas e restrições especificadas
CREATE TABLE funcionarios (
    codigo INT AUTO_INCREMENT PRIMARY KEY, -- Coluna de código com incremento automático e chave primária
    nome VARCHAR(255) NOT NULL, -- Coluna de nome com limite de 255 caracteres, não nula
    sexo ENUM('Masculino', 'Feminino') NOT NULL, -- Coluna de sexo com valores restritos a 'Masculino' ou 'Feminino'
    estadoCivil ENUM('Solteiro', 'Casado', 'Divorciado', 'Viúvo') NOT NULL, -- Coluna de estado civil com valores restritos
    nacionalidade VARCHAR(100) NOT NULL, -- Coluna de nacionalidade com limite de 100 caracteres, não nula
    turno ENUM('Matutino', 'Vespertino', 'Noturno') NOT NULL, -- Coluna de turno com valores restritos
    cargo ENUM('Gerente', 'Supervisor', 'Entregador', 'Atendente', 'Caixa', 'Limpeza', 'Manutenção') NOT NULL, -- Coluna de cargo com valores específicos
    rg VARCHAR(20) NOT NULL, -- Coluna de RG com limite de 20 caracteres, não nula
    cpf VARCHAR(14) NOT NULL, -- Coluna de CPF com limite de 14 caracteres, não nula
    telefone VARCHAR(15), -- Coluna de telefone com limite de 15 caracteres, pode ser nula
    email VARCHAR(255) UNIQUE, -- Coluna de email com limite de 255 caracteres, deve ser única
    cep VARCHAR(9), -- Coluna de CEP com limite de 9 caracteres, pode ser nula
    logradouro VARCHAR(255), -- Coluna de logradouro com limite de 255 caracteres, pode ser nula
    numero VARCHAR(10), -- Coluna de número com limite de 10 caracteres, pode ser nula
    bairro VARCHAR(100), -- Coluna de bairro com limite de 100 caracteres, pode ser nula
    cidade VARCHAR(100), -- Coluna de cidade com limite de 100 caracteres, pode ser nula
    estado VARCHAR(2) -- Coluna de estado com limite de 2 caracteres, pode ser nula
);

SELECT * FROM funcionarios; -- Consulta para exibir todos os dados da tabela "funcionarios", útil para confirmar que a tabela foi criada corretamente e está vazia
SELECT * FROM funcionarios ORDER BY nome ASC; -- Consulta para exibir todos os funcionários ordenados alfabeticamente pelo campo "nome"
SELECT * FROM funcionarios WHERE cidade = 'Santo André'; -- Consulta para selecionar todos os funcionários que residem na cidade "Santo André"
SELECT nome, email FROM funcionarios WHERE email IS NOT NULL; -- Consulta para exibir apenas o nome e o email dos funcionários que possuem um email registrado (não nulo)
