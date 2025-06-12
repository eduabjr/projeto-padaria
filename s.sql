DROP DATABASE IF EXISTS s;
CREATE DATABASE s;
USE s;

CREATE TABLE funcionarios (
    codigo INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    sexo ENUM('Masculino', 'Feminino') NOT NULL,
    estadoCivil ENUM('Solteiro', 'Casado', 'Divorciado', 'Viúvo') NOT NULL,
    nacionalidade VARCHAR(100) NOT NULL,
    turno ENUM('Matutino', 'Vespertino', 'Noturno') NOT NULL,
    cargo ENUM('Gerente', 'Supervisor', 'Entregador', 'Atendente', 'Caixa', 'Limpeza', 'Manutenção') NOT NULL,
    rg VARCHAR(20) NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    telefone VARCHAR(15),
    email VARCHAR(255) UNIQUE,
    cep VARCHAR(9),
    logradouro VARCHAR(255),
    numero VARCHAR(10),
    bairro VARCHAR(100),
    cidade VARCHAR(100),
    estado VARCHAR(2),
    isDeleted BOOLEAN DEFAULT 0  -- Adicionando o campo para soft delete
);

-- Consulta para exibir todos os dados da tabela "funcionarios", útil para confirmar que a tabela foi criada corretamente e está vazia
SELECT * FROM funcionarios;

-- Consulta para exibir apenas funcionários excluídos logicamente (isDeleted = 1)
SELECT * FROM funcionarios WHERE isDeleted = 1;

-- Consulta para exibir todos os funcionários ordenados alfabeticamente pelo campo "nome"
SELECT * FROM funcionarios ORDER BY nome ASC;

-- Consulta para selecionar todos os funcionários que residem na cidade "Santo André"
SELECT * FROM funcionarios WHERE cidade = 'Santo André';

-- Consulta para exibir apenas o nome e o email dos funcionários que possuem um email registrado (não nulo)
SELECT nome, email FROM funcionarios WHERE email IS NOT NULL;

SET SQL_SAFE_UPDATES = 0;
DELETE FROM funcionarios;
SET SQL_SAFE_UPDATES = 1;


-- Criação da trigger "verificar_cpf_duplicado"
DELIMITER //

DELIMITER //

CREATE TRIGGER verificar_cpf_duplicado
BEFORE INSERT ON funcionarios
FOR EACH ROW
BEGIN
    DECLARE msg VARCHAR(255);
    -- Verifica se o CPF já existe na tabela apenas para registros não excluídos
    IF EXISTS (SELECT 1 FROM funcionarios WHERE cpf = NEW.cpf AND isDeleted = 0) THEN
        SET msg = 'CPF duplicado: o CPF informado já está registrado para um funcionário ativo.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = msg;
    END IF;
END //

DELIMITER ;


