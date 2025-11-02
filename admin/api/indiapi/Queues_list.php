<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration
include('../../../config/config.php');

// Create DB connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . mysqli_connect_error()]);
    exit;
}

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Get process name (from GET or POST)
$input = json_decode(file_get_contents('php://input'), true);
$process_name = $_GET['process_name'] ?? ($input['process_name'] ?? '');

if (empty($process_name)) {
    echo json_encode(['success' => false, 'message' => 'Process name is required']);
    exit;
}

// Sanitize
$process_name = mysqli_real_escape_string($conn, $process_name);

// Query queues assigned to the process
$sql = "
    SELECT queue_id, queue_name
    FROM queues
    WHERE queue_assigned_process = '$process_name'
    ORDER BY queue_name ASC
";

$result = mysqli_query($conn, $sql);

if ($result) {
    $queues = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $queues[] = [
            'queue_id' => $row['queue_id'],
            'queue_name' => $row['queue_name']
        ];
    }

    echo json_encode([
        'success' => true,
        'process_name' => $process_name,
        'count' => count($queues),
        'data' => $queues
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching queues: ' . mysqli_error($conn)
    ]);
}

mysqli_close($conn);
?>
