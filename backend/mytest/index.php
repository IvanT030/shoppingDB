<?php  
header('Access-Control-Allow-Origin: *'); // Allow all origins (or specify a domain like 'http://localhost:5173')
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS'); // Allowed HTTP methods
header('Access-Control-Allow-Headers: Content-Type, Authorization'); 
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Send a successful response to preflight request (CORS preflight check)
    http_response_code(200);
    exit;
}
require_once __DIR__ . '/config/db.php'; // Include the database connection

$requestUri = str_replace('/mytest', '', $_SERVER['REQUEST_URI']); // Adjust for subfolder

// Parse the URI to extract the path and query
$parsedUrl = parse_url($requestUri);
$path = $parsedUrl['path'];
$query = isset($parsedUrl['query']) ? $parsedUrl['query'] : '';

// Check if the path is for a specific product or general products
if (preg_match('/^\/products\/(\d+)$/', $path, $matches)) {
    // Capture the product ID from the URL
    $productId = $matches[1];

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Handle the GET request for a specific product
        require_once __DIR__ . '/controllers/ProductController.php';
        getProductByIdHandler($pdo, $productId); // Call the function to get the product by ID
    } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        // Handle PUT request for updating the product
        parse_str(file_get_contents("php://input"), $_PUT);
        require_once __DIR__ . '/controllers/ProductController.php';

        updateProductHandler($pdo, $productId, $_PUT); // Call the update function
    } else {
        http_response_code(405); // Method Not Allowed
        echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    }
} elseif ($path === '/products') {
    // Handle general /products routes for GET (all products) or POST (add a new product)
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        require_once __DIR__ . '/controllers/ProductController.php';
        getProductsHandler($pdo); // Directly call the controller function to get all products
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once __DIR__ . '/controllers/ProductController.php';
        addProductHandler($pdo); // Add a new product
    } else {
        http_response_code(405); // Method Not Allowed
        echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    }
} elseif ($path === '/purchases') {
    require_once __DIR__ . '/routes/purchases.php';
} elseif ($path === '/stores') {
    require_once __DIR__ . '/routes/stores.php';
} else {
    http_response_code(404);
    echo json_encode(['status' => 'error', 'message' => '404 Not Found']);
}
?>
