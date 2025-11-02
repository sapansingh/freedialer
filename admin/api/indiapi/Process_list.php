<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Database configuration
include('../../../config/config.php');

// Create connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . mysqli_connect_error()]);
    exit;
}

// Fetch only the process names
$sql = "SELECT process FROM process_details WHERE active = 'Y' ORDER BY process ASC";
$result = mysqli_query($conn, $sql);

if ($result) {
    $processes = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $processes[] = $row['process'];
    }

    echo json_encode([
        'success' => true,
        'count' => count($processes),
        'data' => $processes
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error fetching processes: ' . mysqli_error($conn)]);
}

mysqli_close($conn);
?>
