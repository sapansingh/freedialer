<?php
// api.php - Complete IVR API
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Database configuration
include('../../config/config.php');


class IVRAPI {
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
        $input = json_decode(file_get_contents('php://input'), true);
        
        // Get endpoint from query string or path
        $endpoint = $_GET['action'] ?? '';
        $id = $_GET['id'] ?? null;

        switch ($method) {
            case 'GET':
                return $this->handleGetRequest($endpoint, $id);
            case 'POST':
                return $this->handlePostRequest($endpoint, $input, $id);
            case 'PUT':
                return $this->handlePutRequest($id, $input);
            case 'DELETE':
                return $this->handleDeleteRequest($id);
            default:
                return $this->response(['success' => false, 'message' => 'Method not allowed'], 405);
        }
    }

    private function handleGetRequest($endpoint, $id) {
        switch ($endpoint) {
            case 'ivrs':
                if ($id) {
                    return $this->getIVR($id);
                } else {
                    return $this->getAllIVRs();
                }
            case 'processes':
                return $this->getAllProcesses();
            case 'queues':
                return $this->getAllQueues();
            case 'voicefiles':
                return $this->getAllVoiceFiles();
            case 'ivrs_dropdown':
                return $this->getIVRsForDropdown();
            default:
                return $this->getAPIInfo();
        }
    }

    private function handlePostRequest($endpoint, $input, $id) {
        switch ($endpoint) {
            case 'ivrs':
                if ($id && isset($_GET['test'])) {
                    return $this->testIVR($id);
                } else {
                    return $this->createIVR($input);
                }
            default:
                return $this->response(['success' => false, 'message' => 'Invalid endpoint'], 404);
        }
    }

    private function handlePutRequest($id, $input) {
        if ($id) {
            return $this->updateIVR($id, $input);
        } else {
            return $this->response(['success' => false, 'message' => 'ID required for update'], 400);
        }
    }

    private function handleDeleteRequest($id) {
        if ($id) {
            return $this->deleteIVR($id);
        } else {
            return $this->response(['success' => false, 'message' => 'ID required for deletion'], 400);
        }
    }

    // Get all IVRs
    private function getAllIVRs() {
        $query = "SELECT * FROM xpress_ivr ORDER BY ivr_id DESC";
        $result = $this->conn->query($query);
        
        if (!$result) {
            return $this->response(['success' => false, 'message' => 'Database error: ' . $this->conn->error], 500);
        }
        
        $ivrs = array();
        while ($row = $result->fetch_assoc()) {
            // Get options for each IVR
            $options = $this->getIVROptions($row['ivr_id']);
            $row['options'] = $options;
            $ivrs[] = $row;
        }
        
        return $this->response(['success' => true, 'data' => $ivrs]);
    }

    // Get single IVR
    private function getIVR($id) {
        $query = "SELECT * FROM xpress_ivr WHERE ivr_id = " . intval($id);
        $result = $this->conn->query($query);
        
        if (!$result) {
            return $this->response(['success' => false, 'message' => 'Database error: ' . $this->conn->error], 500);
        }
        
        if ($result->num_rows > 0) {
            $ivr = $result->fetch_assoc();
            $ivr['options'] = $this->getIVROptions($id);
            return $this->response(['success' => true, 'data' => $ivr]);
        } else {
            return $this->response(['success' => false, 'message' => 'IVR not found'], 404);
        }
    }

    // Get IVR options
    private function getIVROptions($ivr_id) {
        $query = "SELECT * FROM xpress_ivroption WHERE ivr_id = " . intval($ivr_id);
        $result = $this->conn->query($query);
        
        $options = array();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $options[] = $row;
            }
        }
        return $options;
    }

    // Create IVR
    private function createIVR($data) {
        // Validate required fields
        if (empty($data['ivr_name']) || empty($data['voice_file']) || empty($data['seconds_to_wait'])) {
            return $this->response(['success' => false, 'message' => 'Required fields missing'], 400);
        }
        
        // Escape input data
        $ivr_name = $this->conn->real_escape_string($data['ivr_name']);
        $ivr_description = $this->conn->real_escape_string($data['ivr_description'] ?? '');
        $voice_file = intval($data['voice_file']);
        $seconds_to_wait = intval($data['seconds_to_wait']);
        $repeats = intval($data['repeats'] ?? 0);
        $direct_call = $this->conn->real_escape_string($data['direct_call'] ?? 'no');
        
        // Insert IVR
        $query = "INSERT INTO xpress_ivr (ivr_name, ivr_description, voice_file, seconds_to_wait, repeats, direct_call) 
                  VALUES ('$ivr_name', '$ivr_description', $voice_file, $seconds_to_wait, $repeats, '$direct_call')";
        
        if ($this->conn->query($query)) {
            $ivr_id = $this->conn->insert_id;
            
            // Insert options
            if (isset($data['options']) && is_array($data['options'])) {
                foreach ($data['options'] as $option) {
                    $this->createIVROption($ivr_id, $option);
                }
            }
            
            return $this->response([
                'success' => true, 
                'message' => 'IVR created successfully',
                'data' => ['id' => $ivr_id]
            ], 201);
        } else {
            return $this->response(['success' => false, 'message' => 'Failed to create IVR: ' . $this->conn->error], 500);
        }
    }

    // Create IVR option
    private function createIVROption($ivr_id, $option) {
        $option_num = intval($option['option_num']);
        $option_key = $this->conn->real_escape_string($option['option_key']);
        $destination = $this->conn->real_escape_string($option['destination']);
        
        $query = "INSERT INTO xpress_ivroption (ivr_id, option_num, option_key, destination) 
                  VALUES ($ivr_id, $option_num, '$option_key', '$destination')";
        return $this->conn->query($query);
    }

    // Update IVR
    private function updateIVR($id, $data) {
        // Validate required fields
        if (empty($data['ivr_name']) || empty($data['voice_file']) || empty($data['seconds_to_wait'])) {
            return $this->response(['success' => false, 'message' => 'Required fields missing'], 400);
        }
        
        // Escape input data
        $ivr_name = $this->conn->real_escape_string($data['ivr_name']);
        $ivr_description = $this->conn->real_escape_string($data['ivr_description'] ?? '');
        $voice_file = intval($data['voice_file']);
        $seconds_to_wait = intval($data['seconds_to_wait']);
        $repeats = intval($data['repeats'] ?? 0);
        $direct_call = $this->conn->real_escape_string($data['direct_call'] ?? 'no');
        
        // Update IVR
        $query = "UPDATE xpress_ivr SET 
                  ivr_name = '$ivr_name',
                  ivr_description = '$ivr_description',
                  voice_file = $voice_file,
                  seconds_to_wait = $seconds_to_wait,
                  repeats = $repeats,
                  direct_call = '$direct_call'
                  WHERE ivr_id = " . intval($id);
        
        if ($this->conn->query($query)) {
            // Delete existing options
            $this->conn->query("DELETE FROM xpress_ivroption WHERE ivr_id = " . intval($id));
            
            // Insert new options
            if (isset($data['options']) && is_array($data['options'])) {
                foreach ($data['options'] as $option) {
                    $this->createIVROption($id, $option);
                }
            }
            
            return $this->response(['success' => true, 'message' => 'IVR updated successfully']);
        } else {
            return $this->response(['success' => false, 'message' => 'Failed to update IVR: ' . $this->conn->error], 500);
        }
    }

    // Delete IVR
    private function deleteIVR($id) {
        // Delete options first
        $this->conn->query("DELETE FROM xpress_ivroption WHERE ivr_id = " . intval($id));
        
        // Delete IVR
        $query = "DELETE FROM xpress_ivr WHERE ivr_id = " . intval($id);
        
        if ($this->conn->query($query)) {
            return $this->response(['success' => true, 'message' => 'IVR deleted successfully']);
        } else {
            return $this->response(['success' => false, 'message' => 'Failed to delete IVR: ' . $this->conn->error], 500);
        }
    }

    // Test IVR
    private function testIVR($id) {
        // This would integrate with your Asterisk system
        return $this->response([
            'success' => true, 
            'message' => 'IVR test initiated successfully'
        ]);
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

    // Get all queues from process_details table
    private function getAllQueues() {
        $query = "SELECT sno as id, process as name FROM process_details 
                  WHERE active = 'Y' AND process_type IN ('inbound', 'blended') 
                  ORDER BY process";
        $result = $this->conn->query($query);
        
        if (!$result) {
            return $this->response(['success' => false, 'message' => 'Database error: ' . $this->conn->error], 500);
        }
        
        $queues = array();
        while ($row = $result->fetch_assoc()) {
            $queues[] = $row;
        }
        
        return $this->response(['success' => true, 'data' => $queues]);
    }

    // Get all voice files from xpress_files table
    private function getAllVoiceFiles() {
        $query = "SELECT File_id as id, File_Name as name FROM xpress_files ORDER BY File_Name";
        $result = $this->conn->query($query);
        
        if (!$result) {
            return $this->response(['success' => false, 'message' => 'Database error: ' . $this->conn->error], 500);
        }
        
        $voiceFiles = array();
        while ($row = $result->fetch_assoc()) {
            $voiceFiles[] = $row;
        }
        
        return $this->response(['success' => true, 'data' => $voiceFiles]);
    }

    // Get IVRs for dropdown from xpress_ivr table
    private function getIVRsForDropdown() {
        $query = "SELECT ivr_id as id, ivr_name as name FROM xpress_ivr ORDER BY ivr_name";
        $result = $this->conn->query($query);
        
        if (!$result) {
            return $this->response(['success' => false, 'message' => 'Database error: ' . $this->conn->error], 500);
        }
        
        $ivrs = array();
        while ($row = $result->fetch_assoc()) {
            $ivrs[] = $row;
        }
        
        return $this->response(['success' => true, 'data' => $ivrs]);
    }

    // Get API information
    private function getAPIInfo() {
        $info = [
            'success' => true,
            'message' => 'IVR Management API',
            'endpoints' => [
                'GET' => [
                    '?action=ivrs' => 'Get all IVRs',
                    '?action=ivrs&id=1' => 'Get single IVR',
                    '?action=processes' => 'Get all processes',
                    '?action=queues' => 'Get all queues',
                    '?action=voicefiles' => 'Get all voice files',
                    '?action=ivrs_dropdown' => 'Get IVRs for dropdown'
                ],
                'POST' => [
                    '?action=ivrs' => 'Create new IVR',
                    '?action=ivrs&id=1&test=true' => 'Test IVR'
                ],
                'PUT' => [
                    '?action=ivrs&id=1' => 'Update IVR'
                ],
                'DELETE' => [
                    '?action=ivrs&id=1' => 'Delete IVR'
                ]
            ]
        ];
        
        return $this->response($info);
    }

    // Helper function to send JSON response
    private function response($data, $status_code = 200) {
        http_response_code($status_code);
        return json_encode($data);
    }
}

// Create API instance and handle request
$api = new IVRAPI();
echo $api->handleRequest();
?>