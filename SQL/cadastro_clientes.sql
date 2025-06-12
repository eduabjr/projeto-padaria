CREATE DATABASE cadastro_clientes;

USE cadastro_clientes;

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefone VARCHAR(15),
    endereco TEXT,
    nacionalidade VARCHAR(50),
    bairro VARCHAR(50),
    cidade VARCHAR(50),
    estado VARCHAR(50),
    tipo_cliente ENUM('individual', 'company'),
    rg VARCHAR(15),
    cpf VARCHAR(14),
    cnpj VARCHAR(18),
    sexo ENUM('male', 'female')
);

SELECT * FROM clientes;


