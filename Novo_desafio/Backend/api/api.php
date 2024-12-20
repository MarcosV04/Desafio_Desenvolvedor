<?php
// Incluindo os controladores
include_once 'controllers/User_controller.php';
include_once 'controllers/Address_controller.php';
include_once 'controllers/Transaction_controller.php';

// Instanciando os controladores
$userController = new User_controller();
$addressController = new Address_controller();
$transactionController = new Transaction_controller();

// Definindo o tipo de conteúdo da resposta
header("Content-Type: application/json");

// Obtendo os segmentos da URL para definir a rota
$segments = explode('/', $_GET['url'] ?? '');

// Função para validar dados de entrada
function validateInput($data, $requiredFields) {
    foreach ($requiredFields as $field) {
        if (empty($data[$field])) {
            throw new Exception("Campo '$field' é obrigatório.");
        }
    }
}

// Função para validar o formato de dados
function validateEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Email inválido.");
    }
}

function validatePostalCode($postalCode) {
    if (!preg_match("/^\d{5}-\d{3}$/", $postalCode)) {
        throw new Exception("CEP inválido.");
    }
}

try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if ($segments[0] === 'api') {
                if ($segments[1] === 'users') {
                    if (isset($segments[2])) { // Rota: /api/users/{id}
                        $userId = (int)$segments[2];
                        if ($userId <= 0) {
                            throw new Exception("ID do usuário inválido.");
                        }
                        $user = $userController->getUserById($userId);
                        if (!$user) {
                            throw new Exception("Usuário não encontrado.");
                        }
                        echo json_encode($user);
                    } else { // Rota: /api/users
                        $users = $userController->getAllUsers();
                        if (!$users) {
                            echo json_encode(['message' => 'Nenhum usuário encontrado']);
                        } else {
                            echo json_encode($users);
                        }
                    }
                } else {
                    throw new Exception('Rota inválida.');
                }
            }
            break;

        case 'POST':
            if ($segments[0] === 'api') {
                if ($segments[1] === 'users') { // Rota: /api/users
                    $userData = json_decode(file_get_contents("php://input"), true);

                    // Validando os dados recebidos
                    if (!$userData) {
                        throw new Exception("Dados de usuário ausentes.");
                    }

                    // Validação dos campos obrigatórios
                    validateInput($userData, ['name', 'email']);

                    // Validação do email
                    validateEmail($userData['email']);

                    $userController->createUser($userData);
                    echo json_encode(['message' => 'Usuário criado com sucesso']);
                } elseif ($segments[1] === 'users' && isset($segments[2])) {
                    $userId = (int)$segments[2];

                    // Validando ID do usuário
                    if ($userId <= 0) {
                        throw new Exception("ID de usuário inválido.");
                    }

                    if ($segments[3] === 'address') { // Rota: /api/users/{id}/address
                        $addressData = json_decode(file_get_contents("php://input"), true);

                        // Validando os dados do endereço
                        if (!$addressData) {
                            throw new Exception("Dados de endereço ausentes.");
                        }

                        // Validação dos campos obrigatórios
                        validateInput($addressData, ['street', 'city', 'state', 'postal_code']);

                        // Validação do CEP
                        validatePostalCode($addressData['postal_code']);

                        // Criando o endereço
                        $addressController->createAddress($userId, $addressData);
                        echo json_encode(['message' => 'Endereço criado com sucesso']);
                    } elseif ($segments[3] === 'transactions') { // Rota: /api/users/{id}/transactions
                        $transactionData = json_decode(file_get_contents("php://input"), true);

                        // Validando os dados da transação
                        if (!$transactionData) {
                            throw new Exception("Dados de transação ausentes.");
                        }

                        // Validação dos campos obrigatórios
                        validateInput($transactionData, ['amount', 'type']);

                        // Validando o valor da transação
                        if (!is_numeric($transactionData['amount']) || $transactionData['amount'] <= 0) {
                            throw new Exception("O valor da transação deve ser um número positivo.");
                        }

                        // Validação do tipo de transação
                        $validTypes = ['deposit', 'withdrawal'];
                        if (!in_array($transactionData['type'], $validTypes)) {
                            throw new Exception("Tipo de transação inválido.");
                        }

                        // Criando a transação
                        $transactionController->createTransaction($userId, $transactionData);
                        echo json_encode(['message' => 'Transação criada com sucesso']);
                    } else {
                        throw new Exception('Rota inválida.');
                    }
                } else {
                    throw new Exception('Rota inválida.');
                }
            }
            break;

        default:
            http_response_code(405); // Método não permitido
            echo json_encode(['message' => 'Método não permitido']);
            break;
    }
} catch (Exception $e) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => $e->getMessage()]);
}
?>