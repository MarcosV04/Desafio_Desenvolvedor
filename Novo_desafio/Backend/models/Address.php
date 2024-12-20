<?php
class Address {
    public $id;
    public $user_id;
    public $street;
    public $neighborhood;
    public $city;
    public $state;
    public $postal_code;

    public function __construct($id, $user_id, $street, $neighborhood, $city, $state, $postal_code) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->street = $street;
        $this->neighborhood = $neighborhood;
        $this->city = $city;
        $this->state = $state;
        $this->postal_code = $postal_code;
    }

    public static function getAll() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM Addresses");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function update($id, $data) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO Addresses (street, neighborhood, city, state, postal_code ) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$data['street'], $data['neighborhood'], $data['city'], $data['state'], $data['postal_code'], $id]);
    }

    public static function delete($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM Addresses WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>
