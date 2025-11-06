<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration
include('../../../config/config.php');

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
            getAllVoiceFiles($conn);
            break;
        case 'get':
            $id = $_GET['id'] ?? 0;
            getVoiceFile($conn, $id);
            break;
        case 'getByName':
            $name = $_GET['name'] ?? '';
            getVoiceFileByName($conn, $name);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}

mysqli_close($conn);

function getAllVoiceFiles($conn) {
    $sql = "SELECT File_id as id, File_Name as name, File_Location, File_Size 
            FROM xpress_files 
            ORDER BY File_Name ASC";
    
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $files = [];
        while ($row = mysqli_fetch_assoc($result)) {
            // Format the data as requested: { id: X, name: 'FileName' }
            $files[] = [
                'id' => (int)$row['id'],
                'name' => $row['name']
            ];
        }
        echo json_encode(['success' => true, 'data' => $files]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching voice files: ' . mysqli_error($conn)]);
    }
}

function getVoiceFile($conn, $id) {
    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'File ID is required']);
        return;
    }

    $id = (int)$id;
    $sql = "SELECT File_id as id, File_Name as name, File_Location, File_Size 
            FROM xpress_files 
            WHERE File_id = $id";
    
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $file = mysqli_fetch_assoc($result);
        // Format the data as requested: { id: X, name: 'FileName' }
        $formattedFile = [
            'id' => (int)$file['id'],
            'name' => $file['name']
        ];
        echo json_encode(['success' => true, 'data' => $formattedFile]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Voice file not found']);
    }
}

function getVoiceFileByName($conn, $name) {
    if (empty($name)) {
        echo json_encode(['success' => false, 'message' => 'File name is required']);
        return;
    }

    $name = mysqli_real_escape_string($conn, $name);
    $sql = "SELECT File_id as id, File_Name as name, File_Location, File_Size 
            FROM xpress_files 
            WHERE File_Name = '$name'";
    
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $file = mysqli_fetch_assoc($result);
        // Format the data as requested: { id: X, name: 'FileName' }
        $formattedFile = [
            'id' => (int)$file['id'],
            'name' => $file['name']
        ];
        echo json_encode(['success' => true, 'data' => $formattedFile]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Voice file not found']);
    }
}

// Additional function to get voice files with full details if needed
function getAllVoiceFilesWithDetails($conn) {
    $sql = "SELECT File_id as id, File_Name as name, File_Location, File_Size 
            FROM xpress_files 
            ORDER BY File_Name ASC";
    
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $files = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $files[] = [
                'id' => (int)$row['id'],
                'name' => $row['name'],
                'location' => $row['File_Location'],
                'size' => $row['File_Size']
            ];
        }
        echo json_encode(['success' => true, 'data' => $files]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching voice files: ' . mysqli_error($conn)]);
    }
}
?>