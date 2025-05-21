<?php

class allServiceController {

    public function index() {
        session_start();
        require_once __DIR__ . '/../Models/Service.php';
        require_once __DIR__ . '/../Models/Category.php';
        require_once __DIR__ . '/../Models/Service_Media.php';
        require_once __DIR__ . '/../Models/Review.php';

        $username = $_SESSION['username'] ?? 'Guest';

        // Fetch categories
        $categoryModel = new Category();
        $categories = $categoryModel->getAllCategories();

        // Get filter/search params
        $selectedCategory = $_GET['category'] ?? 'all';
        $minPrice = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
        $maxPrice = isset($_GET['max_price']) ? floatval($_GET['max_price']) : 1000;
        $minRating = isset($_GET['min_rating']) ? floatval($_GET['min_rating']) : 0;
        $sort = $_GET['sort'] ?? 'asc';

        // Fetch services with filters
        $serviceModel = new Service();
        $services = $serviceModel->filterServices($selectedCategory, $minPrice, $maxPrice, $minRating, $sort);

        // Prepare category options HTML
        $categoryOptions = '<option value="all"' . ($selectedCategory === 'all' ? ' selected' : '') . '>All Categories</option>';
        foreach ($categories as $cat) {
            $selected = $selectedCategory == $cat['category_id'] ? ' selected' : '';
            $categoryOptions .= '<option value="' . htmlspecialchars($cat['category_id']) . '"' . $selected . '>' . htmlspecialchars($cat['name']) . '</option>';
        }

        // Prepare service cards HTML
        $serviceCards = '';
        foreach ($services as $service) {
            $media = Service_Media::getMediaByService($service['service_id']);
            $image = $media && count($media) > 0 ? $media[0]['path'] : '/assets/img/default_service.png';

            $rating = (new Review())->getAverageRating($service['service_id']);
            $ratingText = $rating ? number_format($rating, 1) . ' ★' : 'No rating';

            $serviceCards .= '
                <div class="service-card">
                    <img src="' . htmlspecialchars($image) . '" alt="Service Image" class="service-img">
                    <h2>' . htmlspecialchars($service['title']) . '</h2>
                    <div class="service-meta">
                        <span class="service-price">€ ' . htmlspecialchars($service['base_price']) . '</span>
                        <span class="service-rating">' . $ratingText . '</span>
                    </div>
                    <a href="index.php?page=service&service_id=' . $service['service_id'] . '" class="main-btn">View</a>
                </div>
            ';
        }

        include __DIR__ . '/../Views/all_service_view.php';
    }
}
?>