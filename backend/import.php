<?php
include 'config.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csv_file"])) {
    $file = $_FILES["csv_file"]["tmp_name"];

    if (($handle = fopen($file, "r")) !== FALSE) {
        fgetcsv($handle); 

        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) { 
            if (count($data) !== 12) {
                echo "Erro: O arquivo CSV deve ter exatamente 12 colunas.";
                continue;
            }

            list($nome, $cpf, $endereco, $bairro, $cidade, $estado, $telefone, 
                 $email, $numero_parcela, $contrato, $data_vencimento, 
                 $valor_parcela) = $data;

            $data_vencimento = !empty($data_vencimento) ? date("Y-m-d", strtotime(str_replace('/', '-', $data_vencimento))) : NULL;

            $numero_parcela = intval($numero_parcela);
            $valor_parcela = floatval(str_replace(',', '.', $valor_parcela)); 
            $stmt = $pdo->prepare("INSERT INTO records 
                (nome, cpf, endereco, bairro, cidade, estado, telefone, email, numero_parcela, contrato, data_vencimento, valor_parcela) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            try {
                $stmt->execute([$nome, $cpf, $endereco, $bairro, $cidade, $estado, $telefone, 
                                $email, $numero_parcela, $contrato, $data_vencimento, 
                                $valor_parcela]);
                echo "Registro inserido: $nome - $cpf <br>";
            } catch (PDOException $e) {
                echo "Erro ao inserir registro: " . $e->getMessage() . "<br>";
            }
        }
        fclose($handle);
        echo "Importação concluída!";
    } else {
        echo "Erro ao abrir o arquivo.";
    }
}
?>
