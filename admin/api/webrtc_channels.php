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
            getAllChannels($conn);
            break;
        case 'get':
            $id = $_GET['id'] ?? 0;
            getChannel($conn, $id);
            break;
        case 'create':
            createChannel($conn);
            break;
        case 'update':
            updateChannel($conn);
            break;
        case 'delete':
            deleteChannel($conn);
            break;
        case 'getStats':
            getChannelStats($conn);
            break;
        case 'generateMultiple':
            generateMultipleChannels($conn);
            break;
        case 'checkExtensionRange':
            checkExtensionRange($conn);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}

mysqli_close($conn);

function getAllChannels($conn) {
    $sql = "SELECT id, server_ip, extension, username, password, context, 
                   transport, transport_type, webrtc, direct_media, station_status, created_at 
            FROM webrtc_channels 
            ORDER BY id DESC";
    
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $channels = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $channels[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $channels]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching channels: ' . mysqli_error($conn)]);
    }
}

function getChannel($conn, $id) {
    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'Channel ID is required']);
        return;
    }

    $id = (int)$id;
    $sql = "SELECT id, server_ip, extension, username, password, context, 
                   transport, transport_type, webrtc, direct_media, station_status, created_at 
            FROM webrtc_channels 
            WHERE id = $id";
    
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $channel = mysqli_fetch_assoc($result);
        echo json_encode(['success' => true, 'data' => $channel]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Channel not found']);
    }
}

function createChannel($conn) {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $required = ['extension'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            echo json_encode(['success' => false, 'message' => "Field '$field' is required"]);
            return;
        }
    }

    // Check if extension already exists
    $extension = mysqli_real_escape_string($conn, $input['extension']);
    $check_sql = "SELECT id FROM webrtc_channels WHERE extension = '$extension'";
    $check_result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo json_encode(['success' => false, 'message' => 'Extension already exists']);
        return;
    }

    // Auto-generate username and password
    $username = 'user' . $extension;
    $password = 'pass' . $extension;

    $server_ip = mysqli_real_escape_string($conn, $input['server_ip'] ?? '');
    $context = mysqli_real_escape_string($conn, $input['context'] ?? 'default');
    $transport = mysqli_real_escape_string($conn, $input['transport'] ?? 'udp');
    $transport_type = mysqli_real_escape_string($conn, $input['transport_type'] ?? 'webrtc');
    $webrtc = isset($input['webrtc']) ? (int)$input['webrtc'] : 1;
    $direct_media = isset($input['direct_media']) ? (int)$input['direct_media'] : 0;
    $station_status = mysqli_real_escape_string($conn, $input['station_status'] ?? 'logged_out');

    $sql = "INSERT INTO webrtc_channels (
                server_ip, extension, username, password, context, 
                transport, transport_type, webrtc, direct_media, station_status
            ) VALUES (
                '$server_ip', '$extension', '$username', '$password', '$context',
                '$transport', '$transport_type', $webrtc, $direct_media, '$station_status'
            )";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Channel created successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error creating channel: ' . mysqli_error($conn)]);
    }
}

function updateChannel($conn) {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (empty($input['id'])) {
        echo json_encode(['success' => false, 'message' => 'Channel ID is required for update']);
        return;
    }

    $required = ['extension'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            echo json_encode(['success' => false, 'message' => "Field '$field' is required"]);
            return;
        }
    }

    $id = (int)$input['id'];
    $extension = mysqli_real_escape_string($conn, $input['extension']);
    
    // Check if extension already exists (excluding current channel)
    $check_sql = "SELECT id FROM webrtc_channels WHERE extension = '$extension' AND id != $id";
    $check_result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo json_encode(['success' => false, 'message' => 'Extension already exists']);
        return;
    }

    $server_ip = mysqli_real_escape_string($conn, $input['server_ip'] ?? '');
    $context = mysqli_real_escape_string($conn, $input['context'] ?? 'default');
    $transport = mysqli_real_escape_string($conn, $input['transport'] ?? 'udp');
    $transport_type = mysqli_real_escape_string($conn, $input['transport_type'] ?? 'webrtc');
    $webrtc = isset($input['webrtc']) ? (int)$input['webrtc'] : 1;
    $direct_media = isset($input['direct_media']) ? (int)$input['direct_media'] : 0;
    $station_status = mysqli_real_escape_string($conn, $input['station_status'] ?? 'logged_out');

    $sql = "UPDATE webrtc_channels SET
                server_ip = '$server_ip',
                extension = '$extension',
                context = '$context',
                transport = '$transport',
                transport_type = '$transport_type',
                webrtc = $webrtc,
                direct_media = $direct_media,
                station_status = '$station_status'
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Channel updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating channel: ' . mysqli_error($conn)]);
    }
}

function deleteChannel($conn) {
    $input = json_decode(file_get_contents('php://input'), true);

    if (empty($input['id'])) {
        echo json_encode(['success' => false, 'message' => 'Channel ID is required for deletion']);
        return;
    }

    $id = (int)$input['id'];
    $sql = "DELETE FROM webrtc_channels WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Channel deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting channel: ' . mysqli_error($conn)]);
    }
}

function getChannelStats($conn) {
    $stats = [];
    
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM webrtc_channels");
    $row = mysqli_fetch_assoc($result);
    $stats['totalChannels'] = $row['total'];

    $result = mysqli_query($conn, "SELECT COUNT(*) as webrtc_enabled FROM webrtc_channels WHERE webrtc = 1");
    $row = mysqli_fetch_assoc($result);
    $stats['webrtcEnabled'] = $row['webrtc_enabled'];

    $result = mysqli_query($conn, "SELECT COUNT(*) as webrtc_disabled FROM webrtc_channels WHERE webrtc = 0");
    $row = mysqli_fetch_assoc($result);
    $stats['webrtcDisabled'] = $row['webrtc_disabled'];

    $result = mysqli_query($conn, "SELECT COUNT(*) as logged_in FROM webrtc_channels WHERE station_status = 'logged_in'");
    $row = mysqli_fetch_assoc($result);
    $stats['loggedIn'] = $row['logged_in'];

    echo json_encode(['success' => true, 'data' => $stats]);
}

function checkExtensionRange($conn) {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (empty($input['start_extension']) || empty($input['end_extension'])) {
        echo json_encode(['success' => false, 'message' => 'Start and end extensions are required']);
        return;
    }

    $start_extension = (int)$input['start_extension'];
    $end_extension = (int)$input['end_extension'];

    if ($start_extension > $end_extension) {
        echo json_encode(['success' => false, 'message' => 'Start extension must be less than or equal to end extension']);
        return;
    }

    // Check for existing extensions in the range
    $existing_extensions = [];
    for ($ext = $start_extension; $ext <= $end_extension; $ext++) {
        $check_sql = "SELECT extension FROM webrtc_channels WHERE extension = '$ext'";
        $check_result = mysqli_query($conn, $check_sql);
        
        if (mysqli_num_rows($check_result) > 0) {
            $existing_extensions[] = $ext;
        }
    }

    $total_extensions = ($end_extension - $start_extension) + 1;
    $available_extensions = $total_extensions - count($existing_extensions);

    echo json_encode([
        'success' => true,
        'data' => [
            'total_extensions' => $total_extensions,
            'existing_extensions' => $existing_extensions,
            'available_extensions' => $available_extensions,
            'can_generate' => $available_extensions > 0
        ]
    ]);
}

function generateMultipleChannels($conn) {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $required = ['start_extension', 'end_extension', 'server_ip'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            echo json_encode(['success' => false, 'message' => "Field '$field' is required"]);
            return;
        }
    }

    $start_extension = (int)$input['start_extension'];
    $end_extension = (int)$input['end_extension'];
    $server_ip = mysqli_real_escape_string($conn, $input['server_ip']);
    $context = mysqli_real_escape_string($conn, $input['context'] ?? 'default');
    $transport = mysqli_real_escape_string($conn, $input['transport'] ?? 'udp');
    $transport_type = mysqli_real_escape_string($conn, $input['transport_type'] ?? 'webrtc');
    $webrtc = isset($input['webrtc']) ? (int)$input['webrtc'] : 1;
    $direct_media = isset($input['direct_media']) ? (int)$input['direct_media'] : 0;

    if ($start_extension > $end_extension) {
        echo json_encode(['success' => false, 'message' => 'Start extension must be less than or equal to end extension']);
        return;
    }

    if (($end_extension - $start_extension) > 100) {
        echo json_encode(['success' => false, 'message' => 'Cannot generate more than 100 channels at once']);
        return;
    }

    $generated = 0;
    $errors = 0;
    $existing = 0;

    for ($extension = $start_extension; $extension <= $end_extension; $extension++) {
        // Check if extension already exists
        $check_sql = "SELECT id FROM webrtc_channels WHERE extension = '$extension'";
        $check_result = mysqli_query($conn, $check_sql);
        
        if (mysqli_num_rows($check_result) > 0) {
            $existing++;
            continue;
        }

        // Auto-generate username and password
        $username = 'user' . $extension;
        $password = 'pass' . $extension;

        $sql = "INSERT INTO webrtc_channels (
                    server_ip, extension, username, password, context, 
                    transport, transport_type, webrtc, direct_media, station_status
                ) VALUES (
                    '$server_ip', '$extension', '$username', '$password', '$context',
                    '$transport', '$transport_type', $webrtc, $direct_media, 'logged_out'
                )";

        if (mysqli_query($conn, $sql)) {
            $generated++;
        } else {
            $errors++;
        }
    }

    $message = "Successfully generated $generated channels";
    if ($existing > 0) {
        $message .= " ($existing extensions already existed)";
    }
    if ($errors > 0) {
        $message .= " ($errors errors occurred)";
    }

    echo json_encode([
        'success' => true, 
        'message' => $message,
        'generated' => $generated,
        'existing' => $existing,
        'errors' => $errors
    ]);
}
?>