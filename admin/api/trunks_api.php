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
    // GET - Get all trunks / single trunk / stats
    // ========================
    case 'GET':
        if (isset($_GET['id'])) {
            // Get single trunk
            $id = intval($_GET['id']);
            $query = "SELECT * FROM trunks WHERE trunk_id = $id";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                sendResponse(true, "Trunk found", $result->fetch_assoc());
            } else {
                sendResponse(false, "Trunk not found");
            }

        } elseif (isset($_GET['action']) && $_GET['action'] === 'stats') {
            // Get trunk statistics
            $query = "SELECT 
                COUNT(*) as total_trunks,
                COALESCE(SUM(CASE WHEN trunk_active = 'Y' THEN 1 ELSE 0 END), 0) as active_trunks,
                COALESCE(SUM(CASE WHEN trunk_active = 'N' THEN 1 ELSE 0 END), 0) as inactive_trunks,
                COALESCE(SUM(CASE WHEN trunk_type = 'PSTN' THEN 1 ELSE 0 END), 0) as pstn_trunks,
                COALESCE(SUM(CASE WHEN trunk_type = 'VOIP' THEN 1 ELSE 0 END), 0) as voip_trunks,
                COALESCE(SUM(CASE WHEN trunk_type = 'Direct-IP' THEN 1 ELSE 0 END), 0) as direct_ip_trunks
                FROM trunks";
            $result = $conn->query($query);
            
            if ($result) {
                $stats = $result->fetch_assoc();
                $stats['total_trunks'] = (int)$stats['total_trunks'];
                $stats['active_trunks'] = (int)$stats['active_trunks'];
                $stats['inactive_trunks'] = (int)$stats['inactive_trunks'];
                $stats['pstn_trunks'] = (int)$stats['pstn_trunks'];
                $stats['voip_trunks'] = (int)$stats['voip_trunks'];
                $stats['direct_ip_trunks'] = (int)$stats['direct_ip_trunks'];
                sendResponse(true, "Statistics fetched", $stats);
            } else {
                sendResponse(false, "Failed to fetch statistics: " . $conn->error);
            }

        } else {
            // Get all trunks
            $query = "SELECT * FROM trunks ORDER BY trunk_id DESC";
            $result = $conn->query($query);

            if ($result) {
                $trunks = [];
                while ($row = $result->fetch_assoc()) {
                    $trunks[] = $row;
                }
                sendResponse(true, "Trunks fetched", $trunks);
            } else {
                sendResponse(false, "Failed to fetch trunks: " . $conn->error);
            }
        }
        break;


    // ========================
    // POST - Create or update trunk
    // ========================
    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true);

        if (!$input) {
            sendResponse(false, "Invalid input");
        }

        // Sanitize input data
        $input = sanitize($input);

        // Validate required fields
        if (!isset($input['trunk_name']) || empty($input['trunk_name'])) {
            sendResponse(false, "Trunk Name is required");
        }

        // Extract and sanitize data
        $trunk_name = $conn->real_escape_string($input['trunk_name']);
        $trunk_description = isset($input['trunk_description']) ? $conn->real_escape_string($input['trunk_description']) : '';
        $trunk_active = isset($input['trunk_active']) ? $conn->real_escape_string($input['trunk_active']) : 'Y';
        $trunk_type = isset($input['trunk_type']) ? $conn->real_escape_string($input['trunk_type']) : 'PSTN';
        $channels = isset($input['channels']) ? intval($input['channels']) : 0;
        
        // Type-specific fields
        $direct_ip_address = isset($input['direct_ip_address']) ? $conn->real_escape_string($input['direct_ip_address']) : '';
        $pstn_technology = isset($input['pstn_technology']) ? $conn->real_escape_string($input['pstn_technology']) : 'dahdi';
        $pstn_zap_dahdi_id = isset($input['pstn_zap_dahdi_id']) ? $conn->real_escape_string($input['pstn_zap_dahdi_id']) : '';
        $voip_custom_settings = isset($input['voip_custom_settings']) ? $conn->real_escape_string($input['voip_custom_settings']) : 'N';
        $voip_account_id = isset($input['voip_account_id']) ? $conn->real_escape_string($input['voip_account_id']) : '';
        $voip_password = isset($input['voip_password']) ? $conn->real_escape_string($input['voip_password']) : '';
        $voip_host_ip_address = isset($input['voip_host_ip_address']) ? $conn->real_escape_string($input['voip_host_ip_address']) : '';
        $voip_type = isset($input['voip_type']) ? $conn->real_escape_string($input['voip_type']) : 'peer';
        $voip_context = isset($input['voip_context']) ? $conn->real_escape_string($input['voip_context']) : '';
        $voip_account_details = isset($input['voip_account_details']) ? $conn->real_escape_string($input['voip_account_details']) : '';

        // Update trunk
        if (isset($input['trunk_id']) && !empty($input['trunk_id'])) {
            $trunk_id = intval($input['trunk_id']);
            
            $query = "UPDATE trunks SET 
                trunk_name = '$trunk_name', 
                trunk_description = '$trunk_description', 
                trunk_active = '$trunk_active', 
                trunk_type = '$trunk_type', 
                direct_ip_address = '$direct_ip_address', 
                pstn_technology = '$pstn_technology', 
                pstn_zap_dahdi_id = '$pstn_zap_dahdi_id', 
                voip_custom_settings = '$voip_custom_settings', 
                voip_account_id = '$voip_account_id', 
                voip_password = '$voip_password', 
                voip_host_ip_address = '$voip_host_ip_address', 
                voip_type = '$voip_type', 
                voip_context = '$voip_context', 
                voip_account_details = '$voip_account_details', 
                channels = $channels
                WHERE trunk_id = $trunk_id";
            
            if ($conn->query($query)) {
                sendResponse(true, "Trunk updated successfully");
            } else {
                sendResponse(false, "Failed to update trunk: " . $conn->error);
            }

        } else {
            // Create trunk
            $query = "INSERT INTO trunks (
                trunk_name, trunk_description, trunk_active, trunk_type, 
                direct_ip_address, pstn_technology, pstn_zap_dahdi_id, 
                voip_custom_settings, voip_account_id, voip_password, 
                voip_host_ip_address, voip_type, voip_context, 
                voip_account_details, channels
            ) VALUES (
                '$trunk_name', '$trunk_description', '$trunk_active', '$trunk_type',
                '$direct_ip_address', '$pstn_technology', '$pstn_zap_dahdi_id',
                '$voip_custom_settings', '$voip_account_id', '$voip_password',
                '$voip_host_ip_address', '$voip_type', '$voip_context',
                '$voip_account_details', $channels
            )";

            if ($conn->query($query)) {
                sendResponse(true, "Trunk created successfully", ["trunk_id" => $conn->insert_id]);
            } else {
                sendResponse(false, "Failed to create trunk: " . $conn->error);
            }
        }
        break;


    // ========================
    // DELETE - Delete trunk
    // ========================
    case 'DELETE':
        $input = json_decode(file_get_contents("php://input"), true);
        
        if (!$input || !isset($input['id'])) {
            sendResponse(false, "Missing trunk ID");
        }

        $id = intval($input['id']);
        $query = "DELETE FROM trunks WHERE trunk_id = $id";
        
        if ($conn->query($query)) {
            if ($conn->affected_rows > 0) {
                sendResponse(true, "Trunk deleted successfully");
            } else {
                sendResponse(false, "Trunk not found");
            }
        } else {
            sendResponse(false, "Failed to delete trunk: " . $conn->error);
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