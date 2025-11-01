<?php
session_start();
header('Content-Type: application/json');

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

// --- Input ---
$role = $_POST['role'] ?? '';
$user = $_POST['username'] ?? '';
$pass = $_POST['password'] ?? '';

if (empty($user) || empty($pass) || empty($role)) {
    echo json_encode(["status" => "error", "message" => "Please fill all fields."]);
    exit;
}

// --- Escape inputs to prevent SQL injection ---
$user_safe = $conn->real_escape_string($user);
$role_safe = $conn->real_escape_string($role);

// --- Verify user ---
$sql = "SELECT * FROM users WHERE username='$user_safe' AND role='$role_safe' AND active=1";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "Invalid username or role."]);
    $conn->close();
    exit;
}

$row = $result->fetch_assoc();

// --- Verify password ---
if (!password_verify($pass, $row['password'])) {
    echo json_encode(["status" => "error", "message" => "Incorrect password."]);
    $conn->close();
    exit;
}

// --- Start session ---
$_SESSION['user_id'] = $row['id'];
$_SESSION['username'] = $row['username'];
$_SESSION['role'] = $row['role'];
$_SESSION['process'] = $row['process'];

// --- Assign WebRTC channel if agent ---
$station = null;
$station_user = null;
$station_pass = null;
$server_ip = $_SERVER['SERVER_ADDR'] ?? null;

if ($role === 'agent') {
    $channelSql = "SELECT * FROM webrtc_channels WHERE station_status='logged_out' LIMIT 1";
    $channelResult = $conn->query($channelSql);

    if ($channelResult && $channelResult->num_rows > 0) {
        $channel = $channelResult->fetch_assoc();
        $station = $channel['extension'];
        $station_user = $channel['username'];
        $station_pass = $channel['password'];
        $station_ip = $channel['server_ip'];

        // Update station status
        $updateSql = "UPDATE webrtc_channels SET station_status='logged_in' WHERE extension=" . intval($channel['extension']);
        $conn->query($updateSql);

        // Insert into agent_status
        $insertSql = "INSERT INTO agent_status (username, station, server_ip, status) VALUES ('$user_safe', '$station', '$server_ip', 'idle')";
        $conn->query($insertSql);

        $_SESSION['station_status'] = 'idle';
        $_SESSION['station'] = $station;
        $_SESSION['server_ip'] = $server_ip;
        $_SESSION['station_ip'] = $station_ip;
        $_SESSION['webrtc_user'] = $station_user;
        $_SESSION['webrtc_pass'] = $station_pass;
    } else {
        echo json_encode(["status" => "error", "message" => "No free WebRTC stations available."]);
        $conn->close();
        exit;
    }
}

// --- Redirect URL based on role ---
switch ($row['role']) {
    case 'admin':
        $redirect = 'admin_dashboard.php';
        break;
    case 'supervisor':
        $redirect = 'supervisor_dashboard.php';
        break;
    default:
        $redirect = '/freedialer/agentpageas/';
        break;
}

// --- Response ---
$response = [
    "status" => "success",
    "message" => "Welcome, {$row['username']}!",
    "redirect" => $redirect,
    "station_assigned" => $station,
    "webrtc_user" => $station_user,
    "webrtc_pass" => $station_pass,
    "server_ip" => $server_ip
];

echo json_encode($response);
$conn->close();
?>
