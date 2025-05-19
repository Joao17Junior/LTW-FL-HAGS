<?php
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Service.php';
require_once __DIR__ . '/../Models/Demand.php';
require_once __DIR__ . '/../Models/Conversation.php';

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: /_PROJ/App/Controllers/signInController.php");
    exit;
}

$user = new User($_SESSION['username']);
$msg = "";

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    try {
        if (!empty($_POST['username'])) $user->setUsername($_POST['username']);
        if (!empty($_POST['email'])) $user->setEmail($_POST['email']);
        if (!empty($_POST['name'])) $user->setName($_POST['name']);
        if (!empty($_POST['password'])) $user->setPassword($_POST['password']);
        // Redirect to user profile/dashboard after update
        header("Location: /_PROJ/App/Controllers/UserController.php?updated=1");
        exit;
    } catch (Exception $e) {
        if ($e->getCode() == -1) {
            $msg = "Username or email already exists.";
        } else {
            $msg = "An error occurred: " . $e->getMessage();
        }
    }
    
}

// Fetch user data
$userData = [
    'username' => $user->getUsername(),
    'email' => $user->getEmail(),
    'name' => $user->getName(),
];

// Fetch user-related data
$serviceModel = new Service();
$myServices = $serviceModel->getFreelancerServices($user->getID());

$demandModel = new Demand();
$demandsToMyServices = []; // Fill with $demandModel->getDemandsByService($service_id) for each service

$myRequestedDemands = []; // Fill with $demandModel->getDemandsByClient($user->getID())

$conversationModel = new Conversation();
$conversations = []; // Fill with $conversationModel->getConversationsByUser($user->getID())

include __DIR__ . '/../Views/edit_profile_view.php';
?>