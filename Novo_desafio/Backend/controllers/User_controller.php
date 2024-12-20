<?php
class User_controller {
    private $db;

    public function __construct() {
        // Aqui você conecta ao banco de dados
        $this->db = new PDO('mysql:host=localhost;dbname=mydb', 'user', 'password');
    }

    public function getUserById($id) {
        // Obtém um usuário pelo ID
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers() {
        // Obtém todos os usuários
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser($userData) {
        // Cria um novo usuário
        $stmt = $this->db->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        $stmt->execute([$userData['name'], $userData['email']]);
    }
}
?>
