<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration
include('../../../config/config.php');

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

// Get all active queues
$sql = "SELECT queue_id, queue_name FROM queues ORDER BY queue_name ASC";

$result = mysqli_query($conn, $sql);

if ($result) {
    $queues = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $queues[] = [
            'queue_id' => (int)$row['queue_id'],
            'queue_name' => $row['queue_name']
        ];
    }
    
    echo json_encode([
        'success' => true,
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