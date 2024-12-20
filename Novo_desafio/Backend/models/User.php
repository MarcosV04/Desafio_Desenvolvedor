<?php
// models/User.php
class User {
    private $id;
    private $name;
    private $email;
    private $phone;

    public function __construct($id, $name, $email, $phone) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
    }

    public static function getAll() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM users");
        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User($row['id'], $row['name'], $row['email'], $row['phone']);
        }
        return $users;
    }

    public static function create($data) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO users (name, email, phone) VALUES (?, ?, ?)");
        $stmt->execute([$data['name'], $data['email'], $data['phone']]);
        return $pdo->lastInsertId();
    }

    public static function update($id, $data) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?");
        $stmt->execute([$data['name'], $data['email'], $data['phone'], $id]);
    }

    public static function delete($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>
