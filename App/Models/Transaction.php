<?php

require_once __DIR__ . '/../Core/Dbh.php';

class Transaction extends Dbh {
    private $order_id;
    private $amount;

    public function __construct($order_id = null, $amount = null) {
        $this->order_id = $order_id;
        $this->amount = $amount;
    }

    public static function createTransaction($order_id, $amount) {
        try {
            $db = new self();
            $query = "INSERT INTO UserTransaction (order_id, amount) VALUES (:order_id, :amount)";
            $stmt = $db->connect()->prepare($query);
            $stmt->bindParam(':order_id', $order_id);
            $stmt->bindParam(':amount', $amount);
            $stmt->execute();
            $stmt = null;

            $query = "SELECT * FROM Demand WHERE order_id = :order_id";
            $stmt = $db->connect()->prepare($query);
            $stmt->bindParam(':order_id', $order_id);
            $stmt->execute();
            $demand = $stmt->fetch(\PDO::FETCH_ASSOC);
            $stmt = null;
            $client_id = $demand['client_id'];

            $query = "SELECT * FROM Service WHERE id = :id";
            $stmt = $db->connect()->prepare($query);
            $stmt->bindParam(':id', $demand['service_id']);
            $stmt->execute();
            $service = $stmt->fetch(\PDO::FETCH_ASSOC);
            $stmt = null;
            $freelancer_id = $service['freelancer_id'];

            $tst = User::subBalance($client_id, $amount);
            if ($tst == -1) {
                return -1; // Insufficient balance from client
            }
            User::addBalance($freelancer_id, $amount);
            
            
            $dmd = new Demand($order_id);
            $dmd->finishDemand(); // The plan is that the demand and payment are finished right when the service is done, in person!
        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public static function createTransactionRequest($order_id, $amount, $desc) {
        $db = new self();
        $query = "INSERT INTO UserTransaction (order_id, amount, description, requested, paid) VALUES (:order_id, :amount, :description, 1, 0)";
        $stmt = $db->connect()->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':description', $desc);
        $stmt->execute();
        $stmt = null;
    }

    public static function getTransactionRequest($order_id) {
        $db = new self();
        $query = "SELECT * FROM UserTransaction WHERE order_id = :order_id AND requested = 1 ORDER BY id DESC LIMIT 1";
        $stmt = $db->connect()->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        $stmt = null;
        return $result;
    }
}