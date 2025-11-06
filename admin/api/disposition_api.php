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
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        handleGetRequest($conn);
        break;
    case 'POST':
        handlePostRequest($conn, $input);
        break;
    case 'PUT':
        handlePutRequest($conn, $input);
        break;
    case 'DELETE':
        handleDeleteRequest($conn, $input);
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        break;
}

function handleGetRequest($conn) {
    $id = $_GET['id'] ?? null;
    $process = $_GET['process'] ?? null;
    
    if ($id) {
        // Get single disposition
        $sql = "SELECT * FROM process_statuses WHERE sno = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($result)) {
            echo json_encode(['success' => true, 'data' => $row]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Disposition not found']);
        }
    } else {
        // Get all dispositions with optional process filter
        if ($process) {
            $sql = "SELECT * FROM process_statuses WHERE process = ? ORDER BY status_name ASC";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 's', $process);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        } else {
            $sql = "SELECT * FROM process_statuses ORDER BY process, status_name ASC";
            $result = mysqli_query($conn, $sql);
        }
        
        $dispositions = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $dispositions[] = $row;
        }
        
        echo json_encode(['success' => true, 'data' => $dispositions]);
    }
}

function handlePostRequest($conn, $input) {
    // Check if it's an update (has sno) or create
    if (isset($input['sno'])) {
        // Update existing disposition
        $sql = "UPDATE process_statuses SET status = ?, status_name = ?, selectable = ?, process = ? WHERE sno = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ssssi', 
            $input['status'], 
            $input['status_name'], 
            $input['selectable'], 
            $input['process'], 
            $input['sno']
        );
    } else {
        // Create new disposition
        $sql = "INSERT INTO process_statuses (status, status_name, selectable, process) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ssss', 
            $input['status'], 
            $input['status_name'], 
            $input['selectable'], 
            $input['process']
        );
    }
    
    if (mysqli_stmt_execute($stmt)) {
        $sno = isset($input['sno']) ? $input['sno'] : mysqli_insert_id($conn);
        echo json_encode([
            'success' => true, 
            'message' => isset($input['sno']) ? 'Disposition updated successfully' : 'Disposition created successfully',
            'id' => $sno
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save disposition: ' . mysqli_error($conn)]);
    }
}

function handlePutRequest($conn, $input) {
    // Similar to POST for update
    handlePostRequest($conn, $input);
}

function handleDeleteRequest($conn, $input) {
    $id = $input['id'] ?? null;
    
    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'ID is required for deletion']);
        return;
    }
    
    $sql = "DELETE FROM process_statuses WHERE sno = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => 'Disposition deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete disposition: ' . mysqli_error($conn)]);
    }
}

mysqli_close($conn);
?>