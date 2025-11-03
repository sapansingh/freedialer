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
    // GET - Get all routes / single route / stats / trunks
    // ========================
    case 'GET':
        if (isset($_GET['id'])) {
            // Get single route
            $id = intval($_GET['id']);
            $query = "SELECT * FROM outbound_routes WHERE route_id = $id";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                $route = $result->fetch_assoc();
                sendResponse(true, "Route found", $route);
            } else {
                sendResponse(false, "Route not found");
            }

        } elseif (isset($_GET['action']) && $_GET['action'] === 'stats') {
            // Get route statistics
            $query = "SELECT 
                COUNT(*) as total_routes,
                COALESCE(SUM(CASE WHEN route_active = 'Y' THEN 1 ELSE 0 END), 0) as active_routes,
                COALESCE(SUM(CASE WHEN route_active = 'N' THEN 1 ELSE 0 END), 0) as inactive_routes
                FROM outbound_routes";
            $result = $conn->query($query);
            
            if ($result) {
                $stats = $result->fetch_assoc();
                $stats['total_routes'] = (int)$stats['total_routes'];
                $stats['active_routes'] = (int)$stats['active_routes'];
                $stats['inactive_routes'] = (int)$stats['inactive_routes'];
                sendResponse(true, "Statistics fetched", $stats);
            } else {
                sendResponse(false, "Failed to fetch statistics: " . $conn->error);
            }

        } elseif (isset($_GET['action']) && $_GET['action'] === 'trunks') {
            // Get available trunks - using sample data as per your requirement
            $sampleTrunks = [
                ['trunk_id' => 1, 'trunk_name' => 'ConVox_OutBound_Trunk', 'trunk_type' => 'Direct-IP'],
                ['trunk_id' => 2, 'trunk_name' => 'tata', 'trunk_type' => 'VOIP'],
                ['trunk_id' => 3, 'trunk_name' => 'Bsnl', 'trunk_type' => 'VOIP'],
                ['trunk_id' => 4, 'trunk_name' => 'TATA_from19', 'trunk_type' => 'VOIP'],
                ['trunk_id' => 5, 'trunk_name' => 'airtel', 'trunk_type' => 'VOIP'],
                ['trunk_id' => 7, 'trunk_name' => 'airtel1', 'trunk_type' => 'VOIP']
            ];
            sendResponse(true, "Trunks fetched", $sampleTrunks);

        } else {
            // Get all routes
            $query = "SELECT * FROM outbound_routes ORDER BY route_id DESC";
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
        if (!isset($input['route_name']) || empty($input['route_name'])) {
            sendResponse(false, "Route Name is required");
        }

        // Extract and sanitize data
        $route_name = $conn->real_escape_string($input['route_name']);
        $route_description = isset($input['route_description']) ? $conn->real_escape_string($input['route_description']) : '';
        $route_active = isset($input['route_active']) ? $conn->real_escape_string($input['route_active']) : 'Y';
        $route_method = isset($input['route_method']) ? $conn->real_escape_string($input['route_method']) : 'Serial';
        $add_digits = isset($input['add_digits']) ? $conn->real_escape_string($input['add_digits']) : '';
        
        // Handle selected trunks (convert array to comma-separated string)
        $selected_trunks = '';
        if (isset($input['selected_trunks']) && is_array($input['selected_trunks'])) {
            $selected_trunks = $conn->real_escape_string(implode(',', $input['selected_trunks']));
        }

        // Update route
        if (isset($input['route_id']) && !empty($input['route_id'])) {
            $route_id = intval($input['route_id']);
            
            $query = "UPDATE outbound_routes SET 
                route_name = '$route_name', 
                route_description = '$route_description', 
                route_active = '$route_active', 
                selected_trunks = '$selected_trunks', 
                route_method = '$route_method', 
                add_digits = '$add_digits'
                WHERE route_id = $route_id";
            
            if ($conn->query($query)) {
                sendResponse(true, "Route updated successfully");
            } else {
                sendResponse(false, "Failed to update route: " . $conn->error);
            }

        } else {
            // Create route
            $query = "INSERT INTO outbound_routes (
                route_name, route_description, route_active, 
                selected_trunks, route_method, add_digits
            ) VALUES (
                '$route_name', 
                '$route_description', 
                '$route_active', 
                '$selected_trunks', 
                '$route_method', 
                '$add_digits'
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
        $query = "DELETE FROM outbound_routes WHERE route_id = $id";
        
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