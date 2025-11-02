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
            getAllUsers($conn);
            break;
        case 'get':
            $id = $_GET['id'] ?? 0;
            getUser($conn, $id);
            break;
        case 'create':
            createUser($conn);
            break;
        case 'update':
            updateUser($conn);
            break;
        case 'delete':
            deleteUser($conn);
            break;
        case 'getStats':
            getUserStats($conn);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}

mysqli_close($conn);

function getAllUsers($conn) {
    $sql = "SELECT sno, agent_id, agent_name, password, 
                   user_access, user_type, process, active, call_priority, 
                   server_ip, assigned_queues, call_mode, allow_manual_dial, 
                   agent_only_callbacks, allow_anyone_callbacks, allow_auto_callbacks, 
                   show_recent_calls, click_to_call, edit_record, manual_outbound, 
                   call_allowed, allow_transfer, entry_date, allow_offline_crm, 
                   allow_remotelogin, phone_number, remote_server_ip
            FROM agent_details 
            ORDER BY sno DESC";
    
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $users = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $users]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching users: ' . mysqli_error($conn)]);
    }
}

function getUser($conn, $id) {
    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'User ID is required']);
        return;
    }

    $id = (int)$id;
    $sql = "SELECT sno, agent_id, agent_name, password, 
                   user_access, user_type, process, active, call_priority, 
                   server_ip, assigned_queues, call_mode, allow_manual_dial, 
                   agent_only_callbacks, allow_anyone_callbacks, allow_auto_callbacks, 
                   show_recent_calls, click_to_call, edit_record, manual_outbound, 
                   call_allowed, allow_transfer, entry_date, allow_offline_crm, 
                   allow_remotelogin, phone_number, remote_server_ip
            FROM agent_details 
            WHERE sno = $id";
    
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        echo json_encode(['success' => true, 'data' => $user]);
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found']);
    }
}

function createUser($conn) {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $required = ['agent_id', 'agent_name', 'password', 'user_type', 'active'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            echo json_encode(['success' => false, 'message' => "Field '$field' is required"]);
            return;
        }
    }

    $agent_id = mysqli_real_escape_string($conn, $input['agent_id']);
    $check_sql = "SELECT sno FROM agent_details WHERE agent_id = '$agent_id'";
    $check_result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo json_encode(['success' => false, 'message' => 'Agent ID already exists']);
        return;
    }

    $agent_name = mysqli_real_escape_string($conn, $input['agent_name']);
    $password = mysqli_real_escape_string($conn, $input['password']);
    // $extension = mysqli_real_escape_string($conn, $input['extension']);
    // $groups = mysqli_real_escape_string($conn, $input['groups'] ?? '');
    $user_access = mysqli_real_escape_string($conn, $input['user_access'] ?? '');
    $user_type = mysqli_real_escape_string($conn, $input['user_type']);
    $process = mysqli_real_escape_string($conn, $input['process'] ?? '');
    $active = mysqli_real_escape_string($conn, $input['active']);
    $call_priority = (int)($input['call_priority'] ?? 0);
    $server_ip = mysqli_real_escape_string($conn, $input['server_ip'] ?? '');
    $assigned_queues = mysqli_real_escape_string($conn, $input['assigned_queues'] ?? '');
    $call_mode = mysqli_real_escape_string($conn, $input['call_mode'] ?? 'processmode');
    $allow_manual_dial = mysqli_real_escape_string($conn, $input['allow_manual_dial'] ?? 'N');
    $agent_only_callbacks = mysqli_real_escape_string($conn, $input['agent_only_callbacks'] ?? 'Y');
    $allow_anyone_callbacks = mysqli_real_escape_string($conn, $input['allow_anyone_callbacks'] ?? 'N');
    $allow_auto_callbacks = mysqli_real_escape_string($conn, $input['allow_auto_callbacks'] ?? 'N');
    $show_recent_calls = mysqli_real_escape_string($conn, $input['show_recent_calls'] ?? 'Y');
    $click_to_call = mysqli_real_escape_string($conn, $input['click_to_call'] ?? 'Y');
    $edit_record = mysqli_real_escape_string($conn, $input['edit_record'] ?? 'Y');
    $manual_outbound = mysqli_real_escape_string($conn, $input['manual_outbound'] ?? 'N');
    $call_allowed = mysqli_real_escape_string($conn, $input['call_allowed'] ?? 'Local');
    $allow_transfer = mysqli_real_escape_string($conn, $input['allow_transfer'] ?? 'N');
    $allow_offline_crm = mysqli_real_escape_string($conn, $input['allow_offline_crm'] ?? 'N');
    $allow_remotelogin = mysqli_real_escape_string($conn, $input['allow_remotelogin'] ?? 'N');
    $phone_number = mysqli_real_escape_string($conn, $input['phone_number'] ?? '');
    $remote_server_ip = mysqli_real_escape_string($conn, $input['remote_server_ip'] ?? '');

    $sql = "INSERT INTO agent_details (
                agent_id, agent_name, password, user_access, 
                user_type, process, active, call_priority, server_ip, assigned_queues, 
                call_mode, allow_manual_dial, agent_only_callbacks, allow_anyone_callbacks, 
                allow_auto_callbacks, show_recent_calls, click_to_call, edit_record, 
                manual_outbound, call_allowed, allow_transfer, allow_offline_crm, 
                allow_remotelogin, phone_number, remote_server_ip, entry_date
            ) VALUES (
                '$agent_id', '$agent_name', '$password', '$user_access',
                '$user_type', '$process', '$active', $call_priority, '$server_ip', '$assigned_queues',
                '$call_mode', '$allow_manual_dial', '$agent_only_callbacks', '$allow_anyone_callbacks',
                '$allow_auto_callbacks', '$show_recent_calls', '$click_to_call', '$edit_record',
                '$manual_outbound', '$call_allowed', '$allow_transfer', '$allow_offline_crm',
                '$allow_remotelogin', '$phone_number', '$remote_server_ip', NOW()
            )";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'User created successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error creating user: ' . mysqli_error($conn)]);
    }
}

function updateUser($conn) {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (empty($input['sno'])) {
        echo json_encode(['success' => false, 'message' => 'User ID is required for update']);
        return;
    }

    $required = ['agent_id', 'agent_name', 'password', 'user_type', 'active'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            echo json_encode(['success' => false, 'message' => "Field '$field' is required"]);
            return;
        }
    }

    $sno = (int)$input['sno'];
    $agent_id = mysqli_real_escape_string($conn, $input['agent_id']);
    $check_sql = "SELECT sno FROM agent_details WHERE agent_id = '$agent_id' AND sno != $sno";
    $check_result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo json_encode(['success' => false, 'message' => 'Agent ID already exists']);
        return;
    }

    $agent_name = mysqli_real_escape_string($conn, $input['agent_name']);
    $password = mysqli_real_escape_string($conn, $input['password']);
    // $extension = mysqli_real_escape_string($conn, $input['extension']);
    // $groups = mysqli_real_escape_string($conn, $input['groups'] ?? '');
    $user_access = mysqli_real_escape_string($conn, $input['user_access'] ?? '');
    $user_type = mysqli_real_escape_string($conn, $input['user_type']);
    $process = mysqli_real_escape_string($conn, $input['process'] ?? '');
    $active = mysqli_real_escape_string($conn, $input['active']);
    $call_priority = (int)($input['call_priority'] ?? 0);
    $server_ip = mysqli_real_escape_string($conn, $input['server_ip'] ?? '');
    $assigned_queues = mysqli_real_escape_string($conn, $input['assigned_queues'] ?? '');
    $call_mode = mysqli_real_escape_string($conn, $input['call_mode'] ?? 'processmode');
    $allow_manual_dial = mysqli_real_escape_string($conn, $input['allow_manual_dial'] ?? 'N');
    $agent_only_callbacks = mysqli_real_escape_string($conn, $input['agent_only_callbacks'] ?? 'Y');
    $allow_anyone_callbacks = mysqli_real_escape_string($conn, $input['allow_anyone_callbacks'] ?? 'N');
    $allow_auto_callbacks = mysqli_real_escape_string($conn, $input['allow_auto_callbacks'] ?? 'N');
    $show_recent_calls = mysqli_real_escape_string($conn, $input['show_recent_calls'] ?? 'Y');
    $click_to_call = mysqli_real_escape_string($conn, $input['click_to_call'] ?? 'Y');
    $edit_record = mysqli_real_escape_string($conn, $input['edit_record'] ?? 'Y');
    $manual_outbound = mysqli_real_escape_string($conn, $input['manual_outbound'] ?? 'N');
    $call_allowed = mysqli_real_escape_string($conn, $input['call_allowed'] ?? 'Local');
    $allow_transfer = mysqli_real_escape_string($conn, $input['allow_transfer'] ?? 'N');
    $allow_offline_crm = mysqli_real_escape_string($conn, $input['allow_offline_crm'] ?? 'N');
    $allow_remotelogin = mysqli_real_escape_string($conn, $input['allow_remotelogin'] ?? 'N');
    $phone_number = mysqli_real_escape_string($conn, $input['phone_number'] ?? '');
    $remote_server_ip = mysqli_real_escape_string($conn, $input['remote_server_ip'] ?? '');

    $sql = "UPDATE agent_details SET
                agent_id = '$agent_id',
                agent_name = '$agent_name',
                password = '$password',
                user_access = '$user_access',
                user_type = '$user_type',
                process = '$process',
                active = '$active',
                call_priority = $call_priority,
                server_ip = '$server_ip',
                assigned_queues = '$assigned_queues',
                call_mode = '$call_mode',
                allow_manual_dial = '$allow_manual_dial',
                agent_only_callbacks = '$agent_only_callbacks',
                allow_anyone_callbacks = '$allow_anyone_callbacks',
                allow_auto_callbacks = '$allow_auto_callbacks',
                show_recent_calls = '$show_recent_calls',
                click_to_call = '$click_to_call',
                edit_record = '$edit_record',
                manual_outbound = '$manual_outbound',
                call_allowed = '$call_allowed',
                allow_transfer = '$allow_transfer',
                allow_offline_crm = '$allow_offline_crm',
                allow_remotelogin = '$allow_remotelogin',
                phone_number = '$phone_number',
                remote_server_ip = '$remote_server_ip'
            WHERE sno = $sno";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'User updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating user: ' . mysqli_error($conn)]);
    }
}

function deleteUser($conn) {
    $input = json_decode(file_get_contents('php://input'), true);

    if (empty($input['sno'])) {
        echo json_encode(['success' => false, 'message' => 'User ID is required for deletion']);
        return;
    }

    $sno = (int)$input['sno'];
    $sql = "DELETE FROM agent_details WHERE sno = $sno";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'User deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting user: ' . mysqli_error($conn)]);
    }
}

function getUserStats($conn) {
    $stats = [];
    
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM agent_details");
    $row = mysqli_fetch_assoc($result);
    $stats['totalUsers'] = $row['total'];

    $result = mysqli_query($conn, "SELECT COUNT(*) as active FROM agent_details WHERE active = 'Y' AND user_type = 'AGENT'");
    $row = mysqli_fetch_assoc($result);
    $stats['activeAgents'] = $row['active'];

    $result = mysqli_query($conn, "SELECT COUNT(*) as supervisors FROM agent_details WHERE user_type = 'SUPERVISOR'");
    $row = mysqli_fetch_assoc($result);
    $stats['supervisors'] = $row['supervisors'];

    $result = mysqli_query($conn, "SELECT COUNT(*) as admins FROM agent_details WHERE user_type = 'ADMIN'");
    $row = mysqli_fetch_assoc($result);
    $stats['admins'] = $row['admins'];

    echo json_encode(['success' => true, 'data' => $stats]);
}
?>