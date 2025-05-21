<?php
require_once __DIR__ . '/../Core/Dbh.php';

class Admin extends Dbh {
    private $id;

    public function __construct($id) {
        $this->id = $id;
    }

    // Check if a user is an admin
    public function isAdmin($user_id) {
        $query = "SELECT 1 FROM Admin WHERE id = :id";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();
        if ($stmt->fetchColumn() == false) {
            $stmt = null;
            return false; // User is an admin
        } else {
            $stmt = null;
            return true; // User is not an admin
        }
    }

    // Elevate a user to admin status
    public function elevateUser($user_id) {
        $query = "INSERT OR IGNORE INTO Admin (id) VALUES (:id)";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();
        $stmt = null;
    }

    // Add a new service category
    public function addCategory($name) {
        $category = new Category($name);
        $category->insertCategory();
    }

    // Get all users
    public static function getAllUsers() {
        $query = "SELECT * FROM User";
        $stmt = (new self(null))->connect()->prepare($query);
        $stmt->execute();
        $allUs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
        return $allUs;
    }

    // Get all services
    public static function getAllServices() {
        $query = "SELECT * FROM Service";
        $stmt = (new self(null))->connect()->prepare($query);
        $stmt->execute();
        $allSrv = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
        return $allSrv;
    }

    // Get all conversations
    public static function getAllConversations() {
        $query = "SELECT * FROM Conversation";
        $stmt = (new self(null))->connect()->prepare($query);
        $stmt->execute();
        $allConv = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
        return $allConv;
    }

    // Ban an user
    public function banUser($user_id) {
        if (self::isAdmin($user_id)) return -1; // Cannot ban an admin
        $query = "DELETE FROM User WHERE id = :id";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();
        $stmt = null;
        return 0; // User banned successfully
    }
}
?>