CREATE DATABASE fornecedores_db;
USE fornecedores_db;

CREATE TABLE suppliers (
    supplierID VARCHAR(5) PRIMARY KEY,
    supplierName VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    address TEXT
);
