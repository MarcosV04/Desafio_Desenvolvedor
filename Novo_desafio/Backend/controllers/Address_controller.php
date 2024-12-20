<?php
class Address_controller {
    private $db;

    public function __construct() {
        // Conecte-se ao banco de dados
        $this->db = new PDO('mysql:host=localhost;dbname=mydb', 'user', 'password');
    }

    public function createAddress($userId, $addressData) {
        // Cria um endereço vinculado ao usuário
        $stmt = $this->db->prepare("INSERT INTO addresses (user_id, street, city) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $addressData['street'], $addressData['city']]);
    }
}
?>
