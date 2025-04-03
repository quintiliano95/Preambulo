<?php
include 'config.php';

$sql = "CREATE TABLE IF NOT EXISTS records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255),
    cpf VARCHAR(14),
    endereco VARCHAR(255),
    bairro VARCHAR(255),
    cidade VARCHAR(100),
    estado VARCHAR(2),
    telefone VARCHAR(15),
    email VARCHAR(255),
    numero_parcela INT,
    contrato VARCHAR(20),
    data_vencimento DATE,
    valor_parcela DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

try {
    $pdo->exec($sql);
    echo "Tabela 'records' criada com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao criar tabela: " . $e->getMessage();
}
?>
