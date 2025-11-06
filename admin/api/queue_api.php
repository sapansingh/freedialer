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
            getAllQueues($conn);
            break;
        case 'get':
            $id = $_GET['id'] ?? 0;
            getQueue($conn, $id);
            break;
        case 'create':
            createQueue($conn);
            break;
        case 'update':
            updateQueue($conn);
            break;
        case 'delete':
            deleteQueue($conn);
            break;
        case 'getStats':
            getQueueStats($conn);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}

mysqli_close($conn);

function getAllQueues($conn) {
    $sql = "SELECT 
                queue_id, queue_name, queue_type, queue_did, greeting_file_id,
                call_queue_file_id, queue_drop_time, queue_drop_action, 
                queue_drop_value, queue_assigned_process, queue_length,
                queue_selected, queue_over_flow, play_queue_no, queue_no_file,
                play_hold_durn, hold_durn_file, playback_freq, ivr_id
            FROM queues 
            ORDER BY queue_id DESC";
    
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $queues = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $queues[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $queues]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching queues: ' . mysqli_error($conn)]);
    }
}

function getQueue($conn, $id) {
    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'Queue ID is required']);
        return;
    }

    $id = (int)$id;
    $sql = "SELECT 
                queue_id, queue_name, queue_type, queue_did, greeting_file_id,
                call_queue_file_id, queue_drop_time, queue_drop_action, 
                queue_drop_value, queue_assigned_process, queue_length,
                queue_selected, queue_over_flow, play_queue_no, queue_no_file,
                play_hold_durn, hold_durn_file, playback_freq, ivr_id
            FROM queues 
            WHERE queue_id = $id";
    
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $queue = mysqli_fetch_assoc($result);
        echo json_encode(['success' => true, 'data' => $queue]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Queue not found']);
    }
}

function createQueue($conn) {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $required = ['queue_name', 'greeting_file_id', 'call_queue_file_id', 'queue_drop_time', 'queue_length', 'queue_assigned_process'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            echo json_encode(['success' => false, 'message' => "Field '$field' is required"]);
            return;
        }
    }

    // Escape all input values
    $queue_name = mysqli_real_escape_string($conn, $input['queue_name']);
    $queue_type = mysqli_real_escape_string($conn, $input['queue_type'] ?? 'executive');
    $queue_did = mysqli_real_escape_string($conn, $input['queue_did'] ?? '');
    $greeting_file_id = (int)($input['greeting_file_id'] ?? 0);
    $call_queue_file_id = (int)($input['call_queue_file_id'] ?? 0);
    $queue_drop_time = (int)($input['queue_drop_time'] ?? 0);
    $queue_drop_action = mysqli_real_escape_string($conn, $input['queue_drop_action'] ?? 'play');
    $queue_drop_value = mysqli_real_escape_string($conn, $input['queue_drop_value'] ?? '');
    $queue_assigned_process = mysqli_real_escape_string($conn, $input['queue_assigned_process'] ?? '');
    $queue_length = (int)($input['queue_length'] ?? 1);
    $queue_selected = mysqli_real_escape_string($conn, $input['queue_selected'] ?? 'Y');
    $queue_over_flow = mysqli_real_escape_string($conn, $input['queue_over_flow'] ?? '');
    $play_queue_no = mysqli_real_escape_string($conn, $input['play_queue_no'] ?? 'N');
    $queue_no_file = mysqli_real_escape_string($conn, $input['queue_no_file'] ?? '0');
    $play_hold_durn = mysqli_real_escape_string($conn, $input['play_hold_durn'] ?? 'N');
    $hold_durn_file = mysqli_real_escape_string($conn, $input['hold_durn_file'] ?? '0');
    $playback_freq = (int)($input['playback_freq'] ?? 0);
    $ivr_id = (int)($input['ivr_id'] ?? 0);

    // Check if queue name already exists
    $check_sql = "SELECT queue_id FROM queues WHERE queue_name = '$queue_name'";
    $check_result = mysqli_query($conn, $check_sql);
    if (mysqli_num_rows($check_result) > 0) {
        echo json_encode(['success' => false, 'message' => 'Queue name already exists']);
        return;
    }

    $sql = "INSERT INTO queues (
                queue_name, queue_type, queue_did, greeting_file_id,
                call_queue_file_id, queue_drop_time, queue_drop_action, 
                queue_drop_value, queue_assigned_process, queue_length,
                queue_selected, queue_over_flow, play_queue_no, queue_no_file,
                play_hold_durn, hold_durn_file, playback_freq, ivr_id
            ) VALUES (
                '$queue_name', '$queue_type', '$queue_did', $greeting_file_id,
                $call_queue_file_id, $queue_drop_time, '$queue_drop_action',
                '$queue_drop_value', '$queue_assigned_process', $queue_length,
                '$queue_selected', '$queue_over_flow', '$play_queue_no', '$queue_no_file',
                '$play_hold_durn', '$hold_durn_file', $playback_freq, $ivr_id
            )";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Queue created successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error creating queue: ' . mysqli_error($conn)]);
    }
}

function updateQueue($conn) {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (empty($input['queue_id'])) {
        echo json_encode(['success' => false, 'message' => 'Queue ID is required for update']);
        return;
    }

    $required = ['queue_name', 'greeting_file_id', 'call_queue_file_id', 'queue_drop_time', 'queue_length', 'queue_assigned_process'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            echo json_encode(['success' => false, 'message' => "Field '$field' is required"]);
            return;
        }
    }

    $queue_id = (int)$input['queue_id'];
    $queue_name = mysqli_real_escape_string($conn, $input['queue_name']);
    $queue_type = mysqli_real_escape_string($conn, $input['queue_type'] ?? 'executive');
    $queue_did = mysqli_real_escape_string($conn, $input['queue_did'] ?? '');
    $greeting_file_id = (int)($input['greeting_file_id'] ?? 0);
    $call_queue_file_id = (int)($input['call_queue_file_id'] ?? 0);
    $queue_drop_time = (int)($input['queue_drop_time'] ?? 0);
    $queue_drop_action = mysqli_real_escape_string($conn, $input['queue_drop_action'] ?? 'play');
    $queue_drop_value = mysqli_real_escape_string($conn, $input['queue_drop_value'] ?? '');
    $queue_assigned_process = mysqli_real_escape_string($conn, $input['queue_assigned_process'] ?? '');
    $queue_length = (int)($input['queue_length'] ?? 1);
    $queue_selected = mysqli_real_escape_string($conn, $input['queue_selected'] ?? 'Y');
    $queue_over_flow = mysqli_real_escape_string($conn, $input['queue_over_flow'] ?? '');
    $play_queue_no = mysqli_real_escape_string($conn, $input['play_queue_no'] ?? 'N');
    $queue_no_file = mysqli_real_escape_string($conn, $input['queue_no_file'] ?? '0');
    $play_hold_durn = mysqli_real_escape_string($conn, $input['play_hold_durn'] ?? 'N');
    $hold_durn_file = mysqli_real_escape_string($conn, $input['hold_durn_file'] ?? '0');
    $playback_freq = (int)($input['playback_freq'] ?? 0);
    $ivr_id = (int)($input['ivr_id'] ?? 0);

    // Check if queue name already exists (excluding current queue)
    $check_sql = "SELECT queue_id FROM queues WHERE queue_name = '$queue_name' AND queue_id != $queue_id";
    $check_result = mysqli_query($conn, $check_sql);
    if (mysqli_num_rows($check_result) > 0) {
        echo json_encode(['success' => false, 'message' => 'Queue name already exists']);
        return;
    }

    $sql = "UPDATE queues SET
                queue_name = '$queue_name',
                queue_type = '$queue_type',
                queue_did = '$queue_did',
                greeting_file_id = $greeting_file_id,
                call_queue_file_id = $call_queue_file_id,
                queue_drop_time = $queue_drop_time,
                queue_drop_action = '$queue_drop_action',
                queue_drop_value = '$queue_drop_value',
                queue_assigned_process = '$queue_assigned_process',
                queue_length = $queue_length,
                queue_selected = '$queue_selected',
                queue_over_flow = '$queue_over_flow',
                play_queue_no = '$play_queue_no',
                queue_no_file = '$queue_no_file',
                play_hold_durn = '$play_hold_durn',
                hold_durn_file = '$hold_durn_file',
                playback_freq = $playback_freq,
                ivr_id = $ivr_id
            WHERE queue_id = $queue_id";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Queue updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating queue: ' . mysqli_error($conn)]);
    }
}

function deleteQueue($conn) {
    $input = json_decode(file_get_contents('php://input'), true);

    if (empty($input['queue_id'])) {
        echo json_encode(['success' => false, 'message' => 'Queue ID is required for deletion']);
        return;
    }

    $queue_id = (int)$input['queue_id'];
    $sql = "DELETE FROM queues WHERE queue_id = $queue_id";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Queue deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting queue: ' . mysqli_error($conn)]);
    }
}

function getQueueStats($conn) {
    $stats = [];
    
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM queues");
    $row = mysqli_fetch_assoc($result);
    $stats['totalQueues'] = $row['total'];

    $result = mysqli_query($conn, "SELECT COUNT(*) as executive FROM queues WHERE queue_type = 'executive'");
    $row = mysqli_fetch_assoc($result);
    $stats['executiveQueues'] = $row['executive'];

    $result = mysqli_query($conn, "SELECT COUNT(*) as verifier FROM queues WHERE queue_type = 'verifier'");
    $row = mysqli_fetch_assoc($result);
    $stats['verifierQueues'] = $row['verifier'];

    $result = mysqli_query($conn, "SELECT COUNT(*) as active FROM queues WHERE queue_selected = 'Y'");
    $row = mysqli_fetch_assoc($result);
    $stats['activeQueues'] = $row['active'];

    echo json_encode(['success' => true, 'data' => $stats]);
}
?>