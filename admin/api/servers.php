<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration
include ('../../../config/config.php');

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]));
}

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// Get the action parameter
$action = $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'getAll':
            getAllServers($conn);
            break;
        case 'get':
            $id = $_GET['id'] ?? 0;
            getServer($conn, $id);
            break;
        case 'create':
            createServer($conn);
            break;
        case 'update':
            updateServer($conn);
            break;
        case 'delete':
            deleteServer($conn);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}

$conn->close();

function getAllServers($conn) {
    $sql = "SELECT * FROM servers ORDER BY server_id DESC";
    $result = $conn->query($sql);
    
    if ($result) {
        $servers = [];
        while ($row = $result->fetch_assoc()) {
            $servers[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $servers]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching servers: ' . $conn->error]);
    }
}

function getServer($conn, $id) {
    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'Server ID is required']);
        return;
    }

    $id = (int)$id; // Prevent SQL injection
    $sql = "SELECT * FROM servers WHERE server_id = $id";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $server = $result->fetch_assoc();
        echo json_encode(['success' => true, 'data' => $server]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Server not found']);
    }
}

function createServer($conn) {
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Validate required fields
    if (empty($input['server_description']) || empty($input['server_ip'])) {
        echo json_encode(['success' => false, 'message' => 'Server description and IP are required']);
        return;
    }

    // Escape inputs
    foreach ($input as $key => $val) {
        $input[$key] = $conn->real_escape_string($val);
    }

    $sql = "INSERT INTO servers (
        server_description, server_ip, active, telnet_host, telnet_port,
        user_manager, secret_manager, update_manager, listen_manager, send_manager,
        sys_perf_log, vd_server_logs, agi_output, voice_web_port, db_web_port
    ) VALUES (
        '{$input['server_description']}', '{$input['server_ip']}', '{$input['active']}',
        '{$input['telnet_host']}', '{$input['telnet_port']}',
        '{$input['user_manager']}', '{$input['secret_manager']}',
        '{$input['update_manager']}', '{$input['listen_manager']}',
        '{$input['send_manager'] }', '{$input['sys_perf_log']}',
        '{$input['vd_server_logs']}', '{$input['agi_output']}',
        '{$input['voice_web_port']}', '{$input['db_web_port']}'
    )";

    if ($conn->query($sql)) {
        echo json_encode(['success' => true, 'message' => 'Server created successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error creating server: ' . $conn->error]);
    }
}

function updateServer($conn) {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (empty($input['server_id'])) {
        echo json_encode(['success' => false, 'message' => 'Server ID is required for update']);
        return;
    }

    if (empty($input['server_description']) || empty($input['server_ip'])) {
        echo json_encode(['success' => false, 'message' => 'Server description and IP are required']);
        return;
    }

    foreach ($input as $key => $val) {
        $input[$key] = $conn->real_escape_string($val);
    }

    $sql = "UPDATE servers SET
        server_description = '{$input['server_description']}',
        server_ip = '{$input['server_ip']}',
        active = '{$input['active']}',
        telnet_host = '{$input['telnet_host']}',
        telnet_port = '{$input['telnet_port']}',
        user_manager = '{$input['user_manager'] }',
        secret_manager = '{$input['secret_manager']}',
        update_manager = '{$input['update_manager'] }',
        listen_manager = '{$input['listen_manager']}',
        send_manager = '{$input['send_manager']}',
        sys_perf_log = '{$input['sys_perf_log']}',
        vd_server_logs = '{$input['vd_server_logs']}',
        agi_output = '{$input['agi_output'] }',
        voice_web_port = '{$input['voice_web_port'] }',
        db_web_port = '{$input['db_web_port'] }'
        WHERE server_id = '{$input['server_id']}'";

    if ($conn->query($sql)) {
        echo json_encode(['success' => true, 'message' => 'Server updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating server: ' . $conn->error]);
    }
}

function deleteServer($conn) {
    $input = json_decode(file_get_contents('php://input'), true);

    if (empty($input['server_id'])) {
        echo json_encode(['success' => false, 'message' => 'Server ID is required for deletion']);
        return;
    }

    $id = (int)$input['server_id'];
    $sql = "DELETE FROM servers WHERE server_id = $id";

    if ($conn->query($sql)) {
        echo json_encode(['success' => true, 'message' => 'Server deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting server: ' . $conn->error]);
    }
}
?>
