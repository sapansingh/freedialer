<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration
include('../../config/config.php');

// Create connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (!$conn) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . mysqli_connect_error()]));
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
        case 'getStats':
            getServerStats($conn);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}

mysqli_close($conn);

function getAllServers($conn) {
    $sql = "SELECT server_id, server_ip, port, server_description, active 
            FROM web_servers 
            ORDER BY server_id DESC";
    
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $servers = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $servers[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $servers]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching servers: ' . mysqli_error($conn)]);
    }
}

function getServer($conn, $id) {
    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'Server ID is required']);
        return;
    }

    $id = (int)$id;
    $sql = "SELECT server_id, server_ip, port, server_description, active 
            FROM web_servers 
            WHERE server_id = $id";
    
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $server = mysqli_fetch_assoc($result);
        echo json_encode(['success' => true, 'data' => $server]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Server not found']);
    }
}

function createServer($conn) {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $required = ['server_ip', 'port', 'server_description', 'active'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            echo json_encode(['success' => false, 'message' => "Field '$field' is required"]);
            return;
        }
    }

    $server_ip = mysqli_real_escape_string($conn, $input['server_ip']);
    $port = mysqli_real_escape_string($conn, $input['port']);
    $server_description = mysqli_real_escape_string($conn, $input['server_description']);
    $active = mysqli_real_escape_string($conn, $input['active']);

    // Check if server with same IP and port already exists
    $check_sql = "SELECT server_id FROM web_servers WHERE server_ip = '$server_ip' AND port = '$port'";
    $check_result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo json_encode(['success' => false, 'message' => 'Server with this IP and port already exists']);
        return;
    }

    $sql = "INSERT INTO web_servers (server_ip, port, server_description, active) 
            VALUES ('$server_ip', '$port', '$server_description', '$active')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Server created successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error creating server: ' . mysqli_error($conn)]);
    }
}

function updateServer($conn) {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (empty($input['server_id'])) {
        echo json_encode(['success' => false, 'message' => 'Server ID is required for update']);
        return;
    }

    $required = ['server_ip', 'port', 'server_description', 'active'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            echo json_encode(['success' => false, 'message' => "Field '$field' is required"]);
            return;
        }
    }

    $server_id = (int)$input['server_id'];
    $server_ip = mysqli_real_escape_string($conn, $input['server_ip']);
    $port = mysqli_real_escape_string($conn, $input['port']);
    $server_description = mysqli_real_escape_string($conn, $input['server_description']);
    $active = mysqli_real_escape_string($conn, $input['active']);

    // Check if server with same IP and port already exists (excluding current server)
    $check_sql = "SELECT server_id FROM web_servers WHERE server_ip = '$server_ip' AND port = '$port' AND server_id != $server_id";
    $check_result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo json_encode(['success' => false, 'message' => 'Server with this IP and port already exists']);
        return;
    }

    $sql = "UPDATE web_servers SET
                server_ip = '$server_ip',
                port = '$port',
                server_description = '$server_description',
                active = '$active'
            WHERE server_id = $server_id";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Server updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating server: ' . mysqli_error($conn)]);
    }
}

function deleteServer($conn) {
    $input = json_decode(file_get_contents('php://input'), true);

    if (empty($input['server_id'])) {
        echo json_encode(['success' => false, 'message' => 'Server ID is required for deletion']);
        return;
    }

    $server_id = (int)$input['server_id'];
    $sql = "DELETE FROM web_servers WHERE server_id = $server_id";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Server deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting server: ' . mysqli_error($conn)]);
    }
}

function getServerStats($conn) {
    $stats = [];
    
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM web_servers");
    $row = mysqli_fetch_assoc($result);
    $stats['totalServers'] = $row['total'];

    $result = mysqli_query($conn, "SELECT COUNT(*) as active FROM web_servers WHERE active = 'Y'");
    $row = mysqli_fetch_assoc($result);
    $stats['activeServers'] = $row['active'];

    $result = mysqli_query($conn, "SELECT COUNT(*) as inactive FROM web_servers WHERE active = 'N'");
    $row = mysqli_fetch_assoc($result);
    $stats['inactiveServers'] = $row['inactive'];

    echo json_encode(['success' => true, 'data' => $stats]);
}
?>