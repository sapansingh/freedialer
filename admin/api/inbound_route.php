<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('../../config/config.php');

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed: " . $conn->connect_error
    ]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

// Utility: send JSON response
function sendResponse($success, $message = "", $data = null) {
    echo json_encode([
        "success" => $success,
        "message" => $message,
        "data" => $data
    ]);
    exit;
}

// Sanitize input data
function sanitize($data) {
    if (is_array($data)) {
        return array_map('sanitize', $data);
    }
    return htmlspecialchars(stripslashes(trim($data)));
}

switch ($method) {

    // ========================
    // GET - Get all routes / single route / stats
    // ========================
    case 'GET':
        if (isset($_GET['id'])) {
            // Get single route
            $id = intval($_GET['id']);
            $query = "SELECT * FROM xpress_routes WHERE Route_Id = $id";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                sendResponse(true, "Route found", $result->fetch_assoc());
            } else {
                sendResponse(false, "Route not found");
            }

        } elseif (isset($_GET['action']) && $_GET['action'] === 'stats') {
            // Get route statistics
            $query = "SELECT 
                COUNT(*) as total_routes,
                COALESCE(SUM(CASE WHEN Active = 'Y' THEN 1 ELSE 0 END), 0) as active_routes,
                COALESCE(SUM(CASE WHEN Active = 'N' THEN 1 ELSE 0 END), 0) as inactive_routes
                FROM xpress_routes";
            $result = $conn->query($query);
            
            if ($result) {
                $stats = $result->fetch_assoc();
                // Ensure all values are integers
                $stats['total_routes'] = (int)$stats['total_routes'];
                $stats['active_routes'] = (int)$stats['active_routes'];
                $stats['inactive_routes'] = (int)$stats['inactive_routes'];
                sendResponse(true, "Statistics fetched", $stats);
            } else {
                sendResponse(false, "Failed to fetch statistics: " . $conn->error);
            }

        } else {
            // Get all routes
            $query = "SELECT * FROM xpress_routes ORDER BY Route_Id DESC";
            $result = $conn->query($query);

            if ($result) {
                $routes = [];
                while ($row = $result->fetch_assoc()) {
                    $routes[] = $row;
                }
                sendResponse(true, "Routes fetched", $routes);
            } else {
                sendResponse(false, "Failed to fetch routes: " . $conn->error);
            }
        }
        break;


    // ========================
    // POST - Create or update route
    // ========================
    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true);

        if (!$input) {
            sendResponse(false, "Invalid input");
        }

        // Sanitize input data
        $input = sanitize($input);

        // Validate required fields
        if (!isset($input['route_name']) || empty($input['route_name']) || 
            !isset($input['did_num']) || empty($input['did_num']) || 
            !isset($input['application_value']) || empty($input['application_value'])) {
            sendResponse(false, "Missing required fields");
        }

        // Extract and sanitize data
        $route_name = $conn->real_escape_string($input['route_name']);
        $active = isset($input['active']) ? $conn->real_escape_string($input['active']) : 'Y';
        $application_type = isset($input['application_type']) ? $conn->real_escape_string($input['application_type']) : 'process';
        $application_value = $conn->real_escape_string($input['application_value']);
        $did_num = $conn->real_escape_string($input['did_num']);
        $channels = isset($input['channels']) ? intval($input['channels']) : 0;
        $schedule = isset($input['schedule']) ? $conn->real_escape_string($input['schedule']) : 'No';
        $call_forward_route_id = isset($input['call_forward_route_id']) ? intval($input['call_forward_route_id']) : 0;

        // Update route
        if (isset($input['route_id']) && !empty($input['route_id'])) {
            $route_id = intval($input['route_id']);
            
            $query = "UPDATE xpress_routes SET 
                Route_Name = '$route_name', 
                Active = '$active', 
                Application_Type = '$application_type', 
                Application_Value = '$application_value', 
                did_num = '$did_num', 
                Channels = $channels, 
                Schedule = '$schedule', 
                call_forward_route_id = $call_forward_route_id 
                WHERE Route_Id = $route_id";
            
            if ($conn->query($query)) {
                sendResponse(true, "Route updated successfully");
            } else {
                sendResponse(false, "Failed to update route: " . $conn->error);
            }

        } else {
            // Create route
            $query = "INSERT INTO xpress_routes (
                Route_Name, Active, Application_Type, Application_Value, 
                did_num, Channels, Schedule, call_forward_route_id
            ) VALUES (
                '$route_name', 
                '$active', 
                '$application_type', 
                '$application_value', 
                '$did_num', 
                $channels, 
                '$schedule', 
                $call_forward_route_id
            )";

            if ($conn->query($query)) {
                sendResponse(true, "Route created successfully", ["route_id" => $conn->insert_id]);
            } else {
                sendResponse(false, "Failed to create route: " . $conn->error);
            }
        }
        break;


    // ========================
    // DELETE - Delete route
    // ========================
    case 'DELETE':
        $input = json_decode(file_get_contents("php://input"), true);
        
        if (!$input || !isset($input['id'])) {
            sendResponse(false, "Missing route ID");
        }

        $id = intval($input['id']);
        $query = "DELETE FROM xpress_routes WHERE Route_Id = $id";
        
        if ($conn->query($query)) {
            if ($conn->affected_rows > 0) {
                sendResponse(true, "Route deleted successfully");
            } else {
                sendResponse(false, "Route not found");
            }
        } else {
            sendResponse(false, "Failed to delete route: " . $conn->error);
        }
        break;


    // ========================
    // OPTIONS - Preflight request
    // ========================
    case 'OPTIONS':
        sendResponse(true, "OK");
        break;


    // ========================
    // Default
    // ========================
    default:
        sendResponse(false, "Method not allowed");
        break;
}

// Close connection
$conn->close();
?>