<?php
require_once __DIR__ . '/../Core/Dbh.php';
class Signin extends Dbh {
    private $username;
    private $password;
    private $email;
    private $name;

    public function __construct($name, $username, $email, $password) {
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    private function checkUserExists() {
        $query = "SELECT * FROM users WHERE username = :username OR email = :email";
        $stmt = parent::connect()->prepare($query);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        return ($stmt->rowCount() > 0); // User already exists
    }

    private function insertUser() {
        $query = "INSERT INTO users (name, username, email, password) VALUES (:name, :username, :email, :password)";
        $stmt = parent::connect()->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        return $stmt->execute();
    }

    public function signupUser() {
        if ($this->checkUserExists()) {
            return "User already exists";
        } else if (empty($this->username) || empty($this->password) || empty($this->email)) {
            return "Please fill in all fields";
        } else {
            if ($this->insertUser()) {
                return "User registered successfully";
            } else {
                return "Error registering user";
            }
        }
    }
}
?>