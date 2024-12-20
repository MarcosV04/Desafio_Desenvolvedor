<?php
// models/Transaction.php
class Transaction {
    private $id;
    private $user_id;
    private $type;
    private $amount;
    private $date;
    private $monthly_yield;

    public function __construct($id, $user_id, $type, $amount, $date, $monthly_yield) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->type = $type;
        $this->amount = $amount;
        $this->date = $date;
        $this->monthly_yield = $monthly_yield;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getType() {
        return $this->type;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getDate() {
        return $this->date;
    }

    public function getMonthlyYield() {
        return $this->monthly_yield;
    }
}
?>
