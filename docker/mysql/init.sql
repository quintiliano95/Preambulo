CREATE DATABASE IF NOT EXISTS preambulo_db;
USE preambulo_db;

CREATE TABLE IF NOT EXISTS records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    endereco VARCHAR(255),
    bairro VARCHAR(100),
    cidade VARCHAR(100),
    estado VARCHAR(2),
    telefone VARCHAR(20),
    email VARCHAR(255),
    numero_parcela INT,
    contrato VARCHAR(255),
    data_vencimento DATE,
    valor_parcela DECIMAL(10,2)
);
