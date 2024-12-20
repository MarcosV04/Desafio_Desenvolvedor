<?php
class Database {
    private $host = "localhost";  // Substitua pelo endereço do servidor
    private $db_name = "novo_desafio";  // Nome do banco de dados
    private $username = "root";  // Usuário do banco
    private $password = "Marcos231104@";  // Senha do banco
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            if ($this->conn->connect_error) {
                die("Erro de conexão com o banco: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            echo "Erro: " . $e->getMessage();
        }

        return $this->conn;
    }
}
?>
