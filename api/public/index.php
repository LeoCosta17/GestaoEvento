<?php

// CORS Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Simple Autoloader
spl_autoload_register(function ($class_name) {
    // Convert 'App\' prefix to 'api/src/'
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../src/';
    
    // Check Config
    if (strpos($class_name, 'App\\Config\\') === 0) {
        $base_dir = __DIR__ . '/../config/';
        $class_name = str_replace('App\\Config\\', '', $class_name);
    } else {
        $len = strlen($prefix);
        if (strncmp($prefix, $class_name, $len) !== 0) {
            return;
        }
        $class_name = substr($class_name, $len);
    }
    
    $file = $base_dir . str_replace('\\', '/', $class_name) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

use App\Config\Database;
use App\Repositories\UserRepository;
use App\Repositories\EventRepository;
use App\Repositories\SubscriptionRepository;
use App\Services\AuthService;
use App\Services\EventService;
use App\Controllers\AuthController;
use App\Controllers\EventController;
use App\Controllers\SubscriptionController;
use App\Utils\JwtHandler;
use App\Utils\Response;

// Instantiations
$db = (new Database())->getConnection();

$userRepo = new UserRepository($db);
$eventRepo = new EventRepository($db);
$subscriptionRepo = new SubscriptionRepository($db);

$authService = new AuthService($userRepo);
$eventService = new EventService($eventRepo, $subscriptionRepo);

$authController = new AuthController($authService);
$eventController = new EventController($eventService);
$subscriptionController = new SubscriptionController($subscriptionRepo);

// Helper function for Auth
function authenticate() {
    $headers = apache_request_headers();
    if (!isset($headers['Authorization'])) {
        Response::json(401, null, 'Authorization header missing');
    }
    
    $authHeader = $headers['Authorization'];
    $token = str_replace('Bearer ', '', $authHeader);
    
    $payload = JwtHandler::decode($token);
    if (!$payload) {
        Response::json(401, null, 'Invalid or expired token');
    }
    
    return $payload;
}

// Basic Router
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Remove trailing slash for consistency
$uri = rtrim($uri, '/');
if (empty($uri)) $uri = '/';

// When running php built-in server from api/public, /index.php gets added sometimes
$uri = str_replace('/index.php', '', $uri);
if (empty($uri)) $uri = '/';

switch (true) {
    case ($uri === '/login' && $method === 'POST'):
        $authController->login();
        break;
        
    case ($uri === '/register' && $method === 'POST'):
        $authController->register();
        break;
        
    case ($uri === '/events' && $method === 'GET'):
        $eventController->index();
        break;
        
    case ($uri === '/events' && $method === 'POST'):
        $user = authenticate();
        $eventController->create($user);
        break;
        
    case ($uri === '/my-events' && $method === 'GET'):
        $user = authenticate();
        $eventController->myEvents($user);
        break;
        
    case ($uri === '/subscriptions' && $method === 'GET'):
        $user = authenticate();
        $subscriptionController->index($user);
        break;
        
    case (preg_match('/^\/events\/(\d+)\/subscribe$/', $uri, $matches) && $method === 'POST'):
        $user = authenticate();
        $subscriptionController->subscribe($user, $matches[1]);
        break;
        
    case (preg_match('/^\/events\/(\d+)\/unsubscribe$/', $uri, $matches) && $method === 'POST'):
        $user = authenticate();
        $subscriptionController->unsubscribe($user, $matches[1]);
        break;
        
    default:
        Response::json(404, null, 'Route not found');
        break;
}
