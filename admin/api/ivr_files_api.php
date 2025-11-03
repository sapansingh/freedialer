<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('../../config/config.php');

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed: " . $conn->connect_error
    ]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

// Utility: send JSON response
function sendResponse($success, $message = "", $data = null) {
    echo json_encode([
        "success" => $success,
        "message" => $message,
        "data" => $data
    ]);
    exit;
}

// Sanitize input data
function sanitize($data) {
    if (is_array($data)) {
        return array_map('sanitize', $data);
    }
    return htmlspecialchars(stripslashes(trim($data)));
}

// File upload configuration
$uploadDir = "../../uploads/ivr_audio/";
$allowedExtensions = ['wav', 'mp3', 'gsm', 'ulaw', 'alaw'];
$maxFileSize = 10 * 1024 * 1024; // 10MB

// Create upload directory if it doesn't exist
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

switch ($method) {

    // ========================
    // GET - Get all files / single file / stats
    // ========================
    case 'GET':
        if (isset($_GET['id'])) {
            // Get single file
            $id = intval($_GET['id']);
            $query = "SELECT * FROM xpress_files WHERE File_id = $id";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                sendResponse(true, "File found", $result->fetch_assoc());
            } else {
                sendResponse(false, "File not found");
            }

        } elseif (isset($_GET['action']) && $_GET['action'] === 'stats') {
            // Get file statistics
            $query = "SELECT 
                COUNT(*) as total_files,
                COALESCE(SUM(CASE WHEN File_Size != '' THEN 1 ELSE 0 END), 0) as uploaded_files,
                COALESCE(SUM(CASE WHEN File_Location LIKE '%.wav%' THEN 1 ELSE 0 END), 0) as wav_files,
                COALESCE(SUM(CASE WHEN File_Location LIKE '%.mp3%' THEN 1 ELSE 0 END), 0) as mp3_files
                FROM xpress_files";
            $result = $conn->query($query);
            
            if ($result) {
                $stats = $result->fetch_assoc();
                $stats['total_files'] = (int)$stats['total_files'];
                $stats['uploaded_files'] = (int)$stats['uploaded_files'];
                $stats['wav_files'] = (int)$stats['wav_files'];
                $stats['mp3_files'] = (int)$stats['mp3_files'];
                sendResponse(true, "Statistics fetched", $stats);
            } else {
                sendResponse(false, "Failed to fetch statistics: " . $conn->error);
            }

        } else {
            // Get all files
            $query = "SELECT * FROM xpress_files ORDER BY File_id DESC";
            $result = $conn->query($query);

            if ($result) {
                $files = [];
                while ($row = $result->fetch_assoc()) {
                    $files[] = $row;
                }
                sendResponse(true, "Files fetched", $files);
            } else {
                sendResponse(false, "Failed to fetch files: " . $conn->error);
            }
        }
        break;


    // ========================
    // POST - Upload file or update file info
    // ========================
    case 'POST':
        // Check if it's a file upload
        if (isset($_FILES['audio_file']) && $_FILES['audio_file']['error'] === UPLOAD_ERR_OK) {
            $fileName = sanitize($_POST['file_name'] ?? '');
            $uploadedFile = $_FILES['audio_file'];
            
            // Validate file name
            if (empty($fileName)) {
                sendResponse(false, "File name is required");
            }
            
            // Validate file
            $fileExtension = strtolower(pathinfo($uploadedFile['name'], PATHINFO_EXTENSION));
            $fileSize = $uploadedFile['size'];
            
            if (!in_array($fileExtension, $allowedExtensions)) {
                sendResponse(false, "Invalid file type. Allowed types: " . implode(', ', $allowedExtensions));
            }
            
            if ($fileSize > $maxFileSize) {
                sendResponse(false, "File too large. Maximum size: 10MB");
            }
            
            // Generate unique filename
            $uniqueFileName = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $uploadedFile['name']);
            $filePath = $uploadDir . $uniqueFileName;
            
            // Move uploaded file
            if (move_uploaded_file($uploadedFile['tmp_name'], $filePath)) {
                // Format file size for display
                $formattedSize = formatFileSize($fileSize);
                
                // Insert into database
                $fileName = $conn->real_escape_string($fileName);
                $fileLocation = $conn->real_escape_string($filePath);
                $fileSizeStr = $conn->real_escape_string($formattedSize);
                
                $query = "INSERT INTO xpress_files (File_Name, File_Location, File_Size) 
                         VALUES ('$fileName', '$fileLocation', '$fileSizeStr')";
                
                if ($conn->query($query)) {
                    sendResponse(true, "File uploaded successfully", [
                        "file_id" => $conn->insert_id,
                        "file_name" => $fileName,
                        "file_location" => $filePath,
                        "file_size" => $formattedSize
                    ]);
                } else {
                    // Delete uploaded file if database insert fails
                    unlink($filePath);
                    sendResponse(false, "Failed to save file info: " . $conn->error);
                }
            } else {
                sendResponse(false, "Failed to upload file");
            }
            
        } else {
            // Handle JSON data for updates
            $input = json_decode(file_get_contents("php://input"), true);
            
            if (!$input) {
                sendResponse(false, "Invalid input");
            }
            
            // Update file info (name only)
            if (isset($input['file_id']) && !empty($input['file_id'])) {
                $fileId = intval($input['file_id']);
                $fileName = $conn->real_escape_string(sanitize($input['file_name']));
                
                $query = "UPDATE xpress_files SET File_Name = '$fileName' WHERE File_id = $fileId";
                
                if ($conn->query($query)) {
                    sendResponse(true, "File updated successfully");
                } else {
                    sendResponse(false, "Failed to update file: " . $conn->error);
                }
            } else {
                sendResponse(false, "File ID is required for update");
            }
        }
        break;


    // ========================
    // DELETE - Delete file
    // ========================
    case 'DELETE':
        $input = json_decode(file_get_contents("php://input"), true);
        
        if (!$input || !isset($input['id'])) {
            sendResponse(false, "Missing file ID");
        }

        $id = intval($input['id']);
        
        // First get file info to delete physical file
        $query = "SELECT File_Location FROM xpress_files WHERE File_id = $id";
        $result = $conn->query($query);
        
        if ($result && $result->num_rows > 0) {
            $file = $result->fetch_assoc();
            $filePath = $file['File_Location'];
            
            // Delete physical file if it exists
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            // Delete database record
            $query = "DELETE FROM xpress_files WHERE File_id = $id";
            
            if ($conn->query($query)) {
                if ($conn->affected_rows > 0) {
                    sendResponse(true, "File deleted successfully");
                } else {
                    sendResponse(false, "File not found");
                }
            } else {
                sendResponse(false, "Failed to delete file: " . $conn->error);
            }
        } else {
            sendResponse(false, "File not found");
        }
        break;


    // ========================
    // OPTIONS - Preflight request
    // ========================
    case 'OPTIONS':
        sendResponse(true, "OK");
        break;


    // ========================
    // Default
    // ========================
    default:
        sendResponse(false, "Method not allowed");
        break;
}

// Helper function to format file size
function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}

// Close connection
$conn->close();
?>