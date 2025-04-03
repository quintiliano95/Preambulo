<?php
include 'config.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Permitir requisições OPTIONS para CORS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

try {
    if ($action == 'list') {
        if (isset($_GET['id'])) {
            $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
            if (!$id) {
                echo json_encode(["message" => "ID inválido"]);
                http_response_code(400);
                exit();
            }
            $stmt = $pdo->prepare("SELECT * FROM records WHERE id = ?");
            $stmt->execute([$id]);
            $record = $stmt->fetch(PDO::FETCH_ASSOC);

            echo json_encode($record ?: ["message" => "Registro não encontrado"]);
        } else {
            $stmt = $pdo->query("SELECT * FROM records");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }

    } elseif ($action == 'delete' && isset($_GET['id'])) {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        if (!$id) {
            echo json_encode(["message" => "ID inválido"]);
            http_response_code(400);
            exit();
        }

        $stmt = $pdo->prepare("DELETE FROM records WHERE id = ?");
        $stmt->execute([$id]);

        echo json_encode(["message" => "Registro excluído"]);

    } elseif ($action == 'update') {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        // Salvar log da requisição
        file_put_contents('log.txt', "[" . date("Y-m-d H:i:s") . "] Recebido: " . json_encode($data, JSON_PRETTY_PRINT) . "\n", FILE_APPEND);

        if (!isset($data['id']) || empty($data['id'])) {
            echo json_encode(["message" => "ID não informado"]);
            http_response_code(400);
            exit();
        }

        $id = filter_var($data['id'], FILTER_VALIDATE_INT);
        if (!$id) {
            echo json_encode(["message" => "ID inválido"]);
            http_response_code(400);
            exit();
        }

        // Verifica se todas as chaves necessárias existem antes de atualizar
        $required_fields = ['nome', 'cpf', 'endereco', 'bairro', 'cidade', 'estado', 'telefone', 'email', 'numero_parcela', 'contrato', 'data_vencimento', 'valor_parcela'];
        foreach ($required_fields as $field) {
            if (!isset($data[$field])) {
                echo json_encode(["message" => "Campo '$field' está ausente"]);
                http_response_code(400);
                exit();
            }
        }

        $stmt = $pdo->prepare("UPDATE records SET 
            nome = ?, cpf = ?, endereco = ?, bairro = ?, cidade = ?, 
            estado = ?, telefone = ?, email = ?, numero_parcela = ?, 
            contrato = ?, data_vencimento = ?, valor_parcela = ? 
            WHERE id = ?");

        $result = $stmt->execute([
            $data['nome'], $data['cpf'], $data['endereco'], $data['bairro'], $data['cidade'],  
            $data['estado'], $data['telefone'], $data['email'], $data['numero_parcela'], 
            $data['contrato'], $data['data_vencimento'], $data['valor_parcela'], $id
        ]);

        if ($result) {
            echo json_encode(["message" => "Registro atualizado com sucesso"]);
        } else {
            echo json_encode(["message" => "Erro ao atualizar registro"]);
            http_response_code(500);
        }
    } else {
        echo json_encode(["message" => "Ação inválida"]);
        http_response_code(400);
    }
} catch (Exception $e) {
    // Captura erros e salva no log
    file_put_contents('log.txt', "[" . date("Y-m-d H:i:s") . "] Erro: " . $e->getMessage() . "\n", FILE_APPEND);
    echo json_encode(["message" => "Erro interno no servidor"]);
    http_response_code(500);
}
?>
