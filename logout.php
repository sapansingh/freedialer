<?php
session_start();

// --- Database connection ---
$servername = "192.168.29.72";
$username = "asterisk";
$password = "asterisk";
$dbname = "Synapse_cc";

$conn = new mysqli($servername, $username, $password, $dbname);

// --- Check connection ---
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

// --- Ensure user is logged in ---
if (!isset($_SESSION['username'])) {
    echo json_encode(["status" => "error", "message" => "Not logged in."]);
    $conn->close();
    exit;
}

$user = $_SESSION['username'];

// --- Remove agent record from agent_status table ---
$deleteStatus = $conn->prepare("DELETE FROM agent_status WHERE username = ?");
$deleteStatus->bind_param("s", $user);

if ($deleteStatus->execute()) {
    $response = ["status" => "success", "message" => "Agent logged out successfully."];
} else {
    $response = ["status" => "error", "message" => "Failed to remove agent status."];
}

$deleteStatus->close();

// --- Destroy session ---
session_unset();
session_destroy();

$conn->close();

// --- Return response ---
echo json_encode($response);
header("Location: login.php");

?>
