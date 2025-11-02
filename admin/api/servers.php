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
    $sql = "SELECT 
                server_id, server_description, server_ip, active, telnet_host, 
                telnet_port, user_manager, secret_manager, update_manager, 
                listen_manager, send_manager, sys_perf_log, vd_server_logs, 
                agi_output, voice_web_port, db_web_port
            FROM servers 
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
    $sql = "SELECT 
                server_id, server_description, server_ip, active, telnet_host, 
                telnet_port, user_manager, secret_manager, update_manager, 
                listen_manager, send_manager, sys_perf_log, vd_server_logs, 
                agi_output, voice_web_port, db_web_port
            FROM servers 
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
    
    $required = ['server_description', 'server_ip', 'active'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            echo json_encode(['success' => false, 'message' => "Field '$field' is required"]);
            return;
        }
    }

    $server_description = mysqli_real_escape_string($conn, $input['server_description']);
    $server_ip = mysqli_real_escape_string($conn, $input['server_ip']);
    $active = mysqli_real_escape_string($conn, $input['active']);
    $telnet_host = mysqli_real_escape_string($conn, $input['telnet_host'] ?? 'localhost');
    $telnet_port = (int)($input['telnet_port'] ?? 5038);
    $user_manager = mysqli_real_escape_string($conn, $input['user_manager'] ?? 'convox');
    $secret_manager = mysqli_real_escape_string($conn, $input['secret_manager'] ?? 'convox');
    $update_manager = mysqli_real_escape_string($conn, $input['update_manager'] ?? 'updateconvox');
    $listen_manager = mysqli_real_escape_string($conn, $input['listen_manager'] ?? 'listenconvox');
    $send_manager = mysqli_real_escape_string($conn, $input['send_manager'] ?? 'sendconvox');
    $sys_perf_log = mysqli_real_escape_string($conn, $input['sys_perf_log'] ?? 'N');
    $vd_server_logs = mysqli_real_escape_string($conn, $input['vd_server_logs'] ?? 'N');
    $agi_output = mysqli_real_escape_string($conn, $input['agi_output'] ?? 'FILE');
    $voice_web_port = (int)($input['voice_web_port'] ?? 0);
    $db_web_port = (int)($input['db_web_port'] ?? 0);

    $sql = "INSERT INTO servers (
                server_description, server_ip, active, telnet_host, telnet_port, 
                user_manager, secret_manager, update_manager, listen_manager, 
                send_manager, sys_perf_log, vd_server_logs, agi_output, 
                voice_web_port, db_web_port
            ) VALUES (
                '$server_description', '$server_ip', '$active', '$telnet_host', $telnet_port,
                '$user_manager', '$secret_manager', '$update_manager', '$listen_manager',
                '$send_manager', '$sys_perf_log', '$vd_server_logs', '$agi_output',
                $voice_web_port, $db_web_port
            )";

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

    $required = ['server_description', 'server_ip', 'active'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            echo json_encode(['success' => false, 'message' => "Field '$field' is required"]);
            return;
        }
    }

    $server_id = (int)$input['server_id'];
    $server_description = mysqli_real_escape_string($conn, $input['server_description']);
    $server_ip = mysqli_real_escape_string($conn, $input['server_ip']);
    $active = mysqli_real_escape_string($conn, $input['active']);
    $telnet_host = mysqli_real_escape_string($conn, $input['telnet_host'] ?? 'localhost');
    $telnet_port = (int)($input['telnet_port'] ?? 5038);
    $user_manager = mysqli_real_escape_string($conn, $input['user_manager'] ?? 'convox');
    $secret_manager = mysqli_real_escape_string($conn, $input['secret_manager'] ?? 'convox');
    $update_manager = mysqli_real_escape_string($conn, $input['update_manager'] ?? 'updateconvox');
    $listen_manager = mysqli_real_escape_string($conn, $input['listen_manager'] ?? 'listenconvox');
    $send_manager = mysqli_real_escape_string($conn, $input['send_manager'] ?? 'sendconvox');
    $sys_perf_log = mysqli_real_escape_string($conn, $input['sys_perf_log'] ?? 'N');
    $vd_server_logs = mysqli_real_escape_string($conn, $input['vd_server_logs'] ?? 'N');
    $agi_output = mysqli_real_escape_string($conn, $input['agi_output'] ?? 'FILE');
    $voice_web_port = (int)($input['voice_web_port'] ?? 0);
    $db_web_port = (int)($input['db_web_port'] ?? 0);

    $sql = "UPDATE servers SET
                server_description = '$server_description',
                server_ip = '$server_ip',
                active = '$active',
                telnet_host = '$telnet_host',
                telnet_port = $telnet_port,
                user_manager = '$user_manager',
                secret_manager = '$secret_manager',
                update_manager = '$update_manager',
                listen_manager = '$listen_manager',
                send_manager = '$send_manager',
                sys_perf_log = '$sys_perf_log',
                vd_server_logs = '$vd_server_logs',
                agi_output = '$agi_output',
                voice_web_port = $voice_web_port,
                db_web_port = $db_web_port
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
    $sql = "DELETE FROM servers WHERE server_id = $server_id";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Server deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting server: ' . mysqli_error($conn)]);
    }
}

function getServerStats($conn) {
    $stats = [];
    
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM servers");
    $row = mysqli_fetch_assoc($result);
    $stats['totalServers'] = $row['total'];

    $result = mysqli_query($conn, "SELECT COUNT(*) as active FROM servers WHERE active = 'Y'");
    $row = mysqli_fetch_assoc($result);
    $stats['activeServers'] = $row['active'];

    $result = mysqli_query($conn, "SELECT COUNT(*) as inactive FROM servers WHERE active = 'N'");
    $row = mysqli_fetch_assoc($result);
    $stats['inactiveServers'] = $row['inactive'];

    echo json_encode(['success' => true, 'data' => $stats]);
}
?>