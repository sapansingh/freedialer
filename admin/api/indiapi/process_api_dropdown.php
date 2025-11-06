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

// Get distinct processes from process_statuses table
$sql = "SELECT DISTINCT process FROM process_statuses WHERE process != '' ORDER BY process ASC";
$result = mysqli_query($conn, $sql);

if ($result) {
    $processes = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $processes[] = $row['process'];
    }
    
    echo json_encode([
        'success' => true,
        'data' => $processes
    ]);
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Error fetching processes'
    ]);
}

mysqli_close($conn);
?>