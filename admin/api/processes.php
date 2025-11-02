<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration
$host = 'localhost';
$dbname = 'your_database_name';
$username = 'your_username';
$password = 'your_password';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Handle preflight (CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

if ($method === 'GET' && $action === 'get') {
    // Get all processes
    $sql = "SELECT * FROM process_details ORDER BY sno DESC";
    $result = $conn->query($sql);

    if ($result) {
        $processes = [];
        while ($row = $result->fetch_assoc()) {
            $processes[] = $row;
        }
        echo json_encode(['success' => true, 'processes' => $processes]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to fetch processes: ' . $conn->error]);
    }

} elseif ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $action = $input['action'] ?? '';

    if ($action === 'create') {
        // ✅ Create new process
        $conn->begin_transaction();

        try {
            $stmt = $conn->prepare("
                INSERT INTO process_details (
                    process, process_description, process_type, active, callerid, outbound_type, 
                    outbound_broadcast_action, channels, extension, inbound_did, inbound_type
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->bind_param(
                "sssssssssss",
                $input['process'],
                $input['process_description'],
                $input['process_type'],
                $input['active'],
                $input['callerid'],
                $input['outbound_type'],
                $input['outbound_broadcast_action'],
                $input['channels'],
                $input['extension'],
                $input['inbound_did'],
                $input['inbound_type']
            );

            if (!$stmt->execute()) {
                throw new Exception("Failed to create process: " . $stmt->error);
            }

            $processId = $stmt->insert_id;
            $stmt->close();

            // Insert breaks if any
            if (isset($input['breaks']) && is_array($input['breaks'])) {
                $breakStmt = $conn->prepare("
                    INSERT INTO breaks (break, description, break_time, process_id) VALUES (?, ?, ?, ?)
                ");
                foreach ($input['breaks'] as $b) {
                    $breakStmt->bind_param("sssi", $b['break'], $b['description'], $b['break_time'], $processId);
                    if (!$breakStmt->execute()) {
                        throw new Exception("Failed to insert break: " . $breakStmt->error);
                    }
                }
                $breakStmt->close();
            }

            $conn->commit();
            echo json_encode(['success' => true, 'message' => 'Process created successfully', 'id' => $processId]);

        } catch (Exception $e) {
            $conn->rollback();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }

    } elseif ($action === 'update') {
        // ✅ Update existing process
        $conn->begin_transaction();

        try {
            $stmt = $conn->prepare("
                UPDATE process_details SET 
                    process = ?, process_description = ?, process_type = ?, active = ?, 
                    callerid = ?, outbound_type = ?, outbound_broadcast_action = ?, 
                    channels = ?, extension = ?, inbound_did = ?, inbound_type = ?
                WHERE sno = ?
            ");

            $stmt->bind_param(
                "sssssssssssi",
                $input['process'],
                $input['process_description'],
                $input['process_type'],
                $input['active'],
                $input['callerid'],
                $input['outbound_type'],
                $input['outbound_broadcast_action'],
                $input['channels'],
                $input['extension'],
                $input['inbound_did'],
                $input['inbound_type'],
                $input['sno']
            );

            if (!$stmt->execute()) {
                throw new Exception("Failed to update process: " . $stmt->error);
            }
            $stmt->close();

            // Delete existing breaks
            $delStmt = $conn->prepare("DELETE FROM breaks WHERE process_id = ?");
            $delStmt->bind_param("i", $input['sno']);
            if (!$delStmt->execute()) {
                throw new Exception("Failed to delete old breaks: " . $delStmt->error);
            }
            $delStmt->close();

            // Re-insert breaks
            if (isset($input['breaks']) && is_array($input['breaks'])) {
                $breakStmt = $conn->prepare("
                    INSERT INTO breaks (break, description, break_time, process_id) VALUES (?, ?, ?, ?)
                ");
                foreach ($input['breaks'] as $b) {
                    $breakStmt->bind_param("sssi", $b['break'], $b['description'], $b['break_time'], $input['sno']);
                    if (!$breakStmt->execute()) {
                        throw new Exception("Failed to insert break: " . $breakStmt->error);
                    }
                }
                $breakStmt->close();
            }

            $conn->commit();
            echo json_encode(['success' => true, 'message' => 'Process updated successfully']);

        } catch (Exception $e) {
            $conn->rollback();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }

    } elseif ($action === 'delete') {
        // ✅ Delete process
        $conn->begin_transaction();

        try {
            $delBreaks = $conn->prepare("DELETE FROM breaks WHERE process_id = ?");
            $delBreaks->bind_param("i", $input['sno']);
            if (!$delBreaks->execute()) {
                throw new Exception("Failed to delete breaks: " . $delBreaks->error);
            }
            $delBreaks->close();

            $delProcess = $conn->prepare("DELETE FROM process_details WHERE sno = ?");
            $delProcess->bind_param("i", $input['sno']);
            if (!$delProcess->execute()) {
                throw new Exception("Failed to delete process: " . $delProcess->error);
            }
            $delProcess->close();

            $conn->commit();
            echo json_encode(['success' => true, 'message' => 'Process deleted successfully']);

        } catch (Exception $e) {
            $conn->rollback();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }

    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>
