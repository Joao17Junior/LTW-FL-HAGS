<?php
require_once __DIR__ . '/Dbh.php';

class Signin extends Dbh {
    private $username;
    private $password;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function signinUser() {
        $query = "SELECT * FROM User WHERE username = :username";
        $stmt = parent::connect()->prepare($query);
        $stmt->bindParam(":username", $this->username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return -1; // User does not exist
        }

        if (password_verify($this->password, $user['password'])) {
            return 0; // Password is correct
        } else {
            return 1; // Password is incorrect
        }
    }
}
?>