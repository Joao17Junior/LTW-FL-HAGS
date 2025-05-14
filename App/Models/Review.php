<?php
    require_once __DIR__ . '/../Core/Dbh.php';

    class Review extends Dbh {
        private $service_id;
        private $client_id;
        private $rating;
        private $comment;

        public function __construct($service_id = null, $client_id = null, $rating = null, $comment = null) {
            $this->service_id = $service_id;
            $this->client_id = $client_id;
            $this->rating = $rating;
            $this->comment = $comment;
        }

        private function checkReviewExists() {
            $query = "SELECT * FROM Review WHERE service_id = :service_id AND client_id = :client_id";
            $stmt = $this->connect()->prepare($query);
            $stmt->bindParam(":service_id", $this->service_id);
            $stmt->bindParam(":client_id", $this->client_id);
            $stmt->execute();

            return ($stmt->rowCount() > 0); // Review already exists
        }

        private function insertReview() {
            $query = "INSERT INTO Review (service_id, client_id, rating, comment) 
                      VALUES (:service_id, :client_id, :rating, :comment)";
            $stmt = $this->connect()->prepare($query);
            $stmt->bindParam(":service_id", $this->service_id);
            $stmt->bindParam(":client_id", $this->client_id);
            $stmt->bindParam(":rating", $this->rating);
            $stmt->bindParam(":comment", $this->comment);
            return $stmt->execute();
        }

        public function createReview() {
            if ($this->checkReviewExists()) {
                return -1; // Review already exists
            } else {
                $this->insertReview();
                return 0; // Service created successfully
            }
        }

        public function getReviews($service_id) {
            $query = "SELECT * FROM Review WHERE service_id = :service_id";
            $stmt = $this->connect()->prepare($query);
            $stmt->bindParam(":service_id", $service_id);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        public function getAverageRating($service_id) {
            $query = "SELECT AVG(rating) as average_rating FROM Review WHERE service_id = :service_id";
            $stmt = $this->connect()->prepare($query);
            $stmt->bindParam(":service_id", $service_id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC)['average_rating'];
        }
    }
?>