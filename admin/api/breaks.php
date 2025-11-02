<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration
include('../../config/config.php');

// Create MySQLi connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Handle preflight (CORS) request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

// Get the action
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'getAll':
        getAllBreaks($conn);
        break;
    case 'create':
        createBreak($conn);
        break;
    case 'update':
        updateBreak($conn);
        break;
    case 'delete':
        deleteBreak($conn);
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}

// ------------------------- FUNCTIONS ------------------------- //

function getAllBreaks($conn) {
    $sql = "SELECT * FROM breaks ORDER BY break_time";
    $result = $conn->query($sql);

    if ($result) {
        $breaks = [];
        while ($row = $result->fetch_assoc()) {
            $breaks[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $breaks]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to fetch breaks: ' . $conn->error]);
    }
}

function createBreak($conn) {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!validateBreakData($input)) {
        echo json_encode(['success' => false, 'message' => 'Invalid break data']);
        return;
    }

    $stmt = $conn->prepare("INSERT INTO breaks (`break`, description, break_time, process) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $input['break'], $input['description'], $input['break_time'], $input['process']);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Break created successfully',
            'id' => $stmt->insert_id
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create break: ' . $stmt->error]);
    }

    $stmt->close();
}

function updateBreak($conn) {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['break_id']) || !validateBreakData($input)) {
        echo json_encode(['success' => false, 'message' => 'Invalid break data']);
        return;
    }

    $stmt = $conn->prepare("UPDATE breaks SET `break` = ?, description = ?, break_time = ?, process = ? WHERE break_id = ?");
    $stmt->bind_param("ssssi", $input['break'], $input['description'], $input['break_time'], $input['process'], $input['break_id']);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Break updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Break not found']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update break: ' . $stmt->error]);
    }

    $stmt->close();
}

function deleteBreak($conn) {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['break_id'])) {
        echo json_encode(['success' => false, 'message' => 'Break ID is required']);
        return;
    }

    $stmt = $conn->prepare("DELETE FROM breaks WHERE break_id = ?");
    $stmt->bind_param("i", $input['break_id']);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Break deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Break not found']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete break: ' . $stmt->error]);
    }

    $stmt->close();
}

function validateBreakData($data) {
    return isset($data['break']) &&
           isset($data['break_time']) &&
           isset($data['process']) &&
           strlen($data['break']) <= 20 &&
           strlen($data['description']) <= 100 &&
           strlen($data['process']) <= 50;
}

// Close connection
$conn->close();
?>
