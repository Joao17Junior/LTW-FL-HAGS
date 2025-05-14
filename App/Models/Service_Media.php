<?php
require_once __DIR__ . '/../Core/Dbh.php';

class Service_Media extends Dbh {
    private $id;
    private $service_id;
    private $type;
    private $path;

    public function __construct($service_id = null, $type = null, $path = null) {
        $this->service_id = $service_id;
        $this->type = $type;
        $this->path = $path;
    }

    public function addMedia() {
        $query = "INSERT INTO Service_Media (service_id, type, path) VALUES (:service_id, :type, :path)";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(':service_id', $this->service_id);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':path', $this->path);
        $stmt->execute();
        $this->id = $this->connect()->lastInsertId();
        return $this->id;
    }

    public static function getMediaByService($service_id) {
        $db = new self();
        $query = "SELECT * FROM Service_Media WHERE service_id = :service_id";
        $stmt = $db->connect()->prepare($query);
        $stmt->bindParam(':service_id', $service_id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>