<?php
namespace App\Controllers;

use App\Models\Service;

class ServiceController {
    public static function index() {
        $services = Service::all();
        include __DIR__ . '/../Views/service_list.php';
    }
}
?>
