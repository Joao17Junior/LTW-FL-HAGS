<?php
namespace App\Models;

use App\Core\Database;

class Service {
    public static function all() {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM Service");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>
