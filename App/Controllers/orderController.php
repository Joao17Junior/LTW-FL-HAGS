<?php
class orderController {
    public function index() {
        session_start();
        require_once __DIR__ . '/../Models/Demand.php';
        require_once __DIR__ . '/../Models/Service.php';
        require_once __DIR__ . '/../Models/User.php';
        require_once __DIR__ . '/../Models/Service_Media.php';
        require_once __DIR__ . '/../Models/Review.php';
        
        $order_id = $_SESSION['order_id'];

        $demandModel = new Demand();
        $order = $demandModel->getDemandById($order_id);

        // Verifica se o usuário logado é o cliente da order
        if (!$order || $order['client_id'] != $_SESSION['user_id']) {
            header('Location: index.php?page=user');
            exit;
        }

        // Só permite avaliar se completed = 1
        $canReview = ($order['completed'] == 1);

        $serviceModel = new Service();
        $service = $serviceModel->getService($order['service_id']);

        $freelancer = new User();
        $freelancerName = User::getNameById($service['freelancer_id']);

        $mediaModel = new Service_Media();
        $images = $mediaModel->getAllImages($service['service_id']);

        $reviewModel = new Review();
        $existingReview = $reviewModel->getUserReviewForService($_SESSION['user_id'], $service['service_id']);

        include __DIR__ . '/../Views/order_view.php';
    }
}