<?php
$host = "db";              // Nome do serviço MySQL no docker-compose
$dbname = "preambulo_db";   // Nome do banco conforme configurado
$username = "root";         // Usuário root
$password = "xamds";             // Senha vazia

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
