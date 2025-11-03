<?php
// processes.php - Processes API for Break Management
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Database configuration
include('../../../config/config.php');

class ProcessAPI {
    private $conn;
    
    public function __construct() {
        // Create database connection
        $this->conn = new mysqli($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);
        
        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Main function to handle all requests
    public function handleRequest() {
        $method = $_SERVER['REQUEST_METHOD'];
        
        // Get endpoint from query string
        $endpoint = $_GET['action'] ?? '';

        switch ($method) {
            case 'GET':
                return $this->handleGetRequest($endpoint);
            default:
                return $this->response(['success' => false, 'message' => 'Method not allowed'], 405);
        }
    }

    private function handleGetRequest($endpoint) {
        switch ($endpoint) {
            case 'getProcesses':
                return $this->getAllProcesses();
            default:
                return $this->response(['success' => false, 'message' => 'Invalid endpoint'], 404);
        }
    }

    // Get all processes from process_details table
    private function getAllProcesses() {
        $query = "SELECT sno as id, process as name FROM process_details WHERE active = 'Y' ORDER BY process";
        $result = $this->conn->query($query);
        
        if (!$result) {
            return $this->response(['success' => false, 'message' => 'Database error: ' . $this->conn->error], 500);
        }
        
        $processes = array();
        while ($row = $result->fetch_assoc()) {
            $processes[] = $row;
        }
        
        return $this->response(['success' => true, 'data' => $processes]);
    }

    // Helper function to send JSON response
    private function response($data, $status_code = 200) {
        http_response_code($status_code);
        return json_encode($data);
    }
}

// Create API instance and handle request
$api = new ProcessAPI();
echo $api->handleRequest();
?>