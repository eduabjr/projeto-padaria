create database funcionarios;
use funcionarios;

CREATE TABLE funcionarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(20),
    nome VARCHAR(100),
    sexo VARCHAR(20),
    estado_civil VARCHAR(20),
    nacionalidade VARCHAR(50),
    turno VARCHAR(20),
    cargo VARCHAR(50),
    rg VARCHAR(20),
    cpf VARCHAR(20),
    telefone VARCHAR(20),
    email VARCHAR(100),
    cep VARCHAR(10),
    logradouro VARCHAR(100),
    numero VARCHAR(10),
    bairro VARCHAR(50),
    cidade VARCHAR(50),
    estado VARCHAR(50)
);
