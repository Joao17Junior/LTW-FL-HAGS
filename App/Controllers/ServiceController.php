<?php

require_once __DIR__ . '/../Models/Service.php';

class serviceController {
    public function index() {
        require_once __DIR__ . '/../Models/Service_Media.php';
        require_once __DIR__ . '/../Models/User.php';

        $serviceModel = new Service();
        $service = $serviceModel->getService($service_id);

        if (!$service) {
            echo "Service not found.";
            exit;
        }

        $media = Service_Media::getMediaByService($service_id);
        $freelancer_id = $service['freelancer_id'];
        $freelancer = new User(null);
        // You may need to add a method to get user by ID if not present
        $freelancerName = $freelancer->getNameById($freelancer_id);

        include __DIR__ . '/../Views/service_view.php';
    }
}
?>
