<?php
require_once __DIR__ . '/../Core/Dbh.php';

class User extends Dbh {
    private $username;
    private $password;
    private $email;
    private $name;
    private $userID;

    public function __construct($username) {
        $this->username = $username;

        $query = "SELECT * FROM User WHERE username = :username";
        $stmt = parent::connect()->prepare($query);
        $stmt->bindParam(":username", $this->username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC); 
        $stmt = null;
        
        if (!$user) {
            return -1; // User not found
        }

        $this->email = $user['email'];
        $this->name = $user['name'];
        $this->password = $user['password'];
        $this->userID = $user['id'];
    }

    # Getters
    public function getUsername() {
        return $this->username;
    }
    public function getName() {
        return $this->name;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getID() {
        return $this->userID;
    }

    # Setters
    public function setUsername($newUsername) {
        $query = "SELECT * FROM User WHERE username = :newUsername";
        $stmt = parent::connect()->prepare($query);
        $stmt->bindParam(":newUsername", $newUsername);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $stmt = null;
            return -1; // Username already exists
        }
        $stmt = null;

        $query2 = "UPDATE User SET username = :newUsername WHERE id = :id";
        $stmt2 = parent::connect()->prepare($query2);
        $stmt2->bindParam(":newUsername", $newUsername);
        $stmt2->bindParam(":id", $this->userID);
        $stmt2->execute();
        $stmt2 = null;

        $this->username = $newUsername;
    }
    public function setName($newName) {
        $query = "UPDATE User SET name = :newName WHERE id = :id";
        $stmt = parent::connect()->prepare($query);
        $stmt->bindParam(":newName", $newName);
        $stmt->bindParam(":id", $this->userID);
        $stmt->execute();
        $stmt = null;

        $this->name = $newName;
    }
    public function setEmail($newEmail) {
        $query = "SELECT * FROM User WHERE email = :newEmail";
        $stmt = parent::connect()->prepare($query);
        $stmt->bindParam(":newEmail", $newEmail);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $stmt = null;
            return -1; // Username already exists
        }
        $stmt = null;

        $query2 = "UPDATE User SET email = :newEmail WHERE id = :id";
        $stmt2 = parent::connect()->prepare($query2);
        $stmt2->bindParam(":newEmail", $newEmail);
        $stmt2->bindParam(":id", $this->userID);
        $stmt2->execute();
        $stmt2 = null;

        $this->email = $newEmail;
    }
    public function setPassword($newPassword) {
        $nPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $query = "UPDATE User SET password = :newPassword WHERE id = :id";
        $stmt = parent::connect()->prepare($query);
        $stmt->bindParam(":newPassword", $nPassword);
        $stmt->bindParam(":id", $this->userID);
        $stmt->execute();
        $stmt = null;

        $this->password = $nPassword;
    }
}
?>