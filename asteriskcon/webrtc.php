<?php
/**
 * Generate WebRTC PJSIP endpoints + insert into MySQL
 * Range: 7001–7060
 * Creates/Recreates table each time
 */

// === Database Settings ===
$host = "192.168.29.72";
$user = "asterisk";
$pass = "asterisk";
$dbname = "Synapse_cc";

// === Asterisk File Path ===
$outputFile = '/webrtc_channels.conf'; // Linux style

// === Extension Range ===
$start = 7001;
$end   = 7060;

// === Connect to MySQL ===
$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("❌ DB connection failed: " . $conn->connect_error);
}

// Create DB if not exists
$conn->query("CREATE DATABASE IF NOT EXISTS `$dbname`");
$conn->select_db($dbname);

// Drop + recreate table
$conn->query("DROP TABLE IF EXISTS webrtc_channels");
$createTable = "
CREATE TABLE webrtc_channels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    extension VARCHAR(10) NOT NULL,
    server_ip VARCHAR(15) NOT NULL,
    username VARCHAR(50),
    password VARCHAR(50),
    context VARCHAR(50),
    transport VARCHAR(50),
    webrtc TINYINT(1) DEFAULT 1,
    direct_media TINYINT(1) DEFAULT 0,
    station_status VARCHAR(20) DEFAULT 'logged_out',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)";
if (!$conn->query($createTable)) {
    die('❌ Error creating table: ' . $conn->error);
}
echo "✅ MySQL table created successfully.\n";

// === Build config content ===
$config  = "; Auto-generated WebRTC PJSIP endpoints\n";
$config .= "; Generated on " . date('Y-m-d H:i:s') . "\n\n";

// === Loop through extensions ===
$stmt = $conn->prepare("
    INSERT INTO webrtc_channels (extension, username, password, context, transport, webrtc, direct_media)
    VALUES (?, ?, ?, 'internal', 'transport-ws', 1, 0)
");

for ($i = $start; $i <= $end; $i++) {
    // Build config for file
    $config .= "[$i]\n";
    $config .= "type=endpoint\n";
    $config .= "context=internal\n";
    $config .= "disallow=all\n";
    $config .= "allow=ulaw\n";
    $config .= "transport=transport-ws\n";
    $config .= "auth=auth{$i}\n";
    $config .= "aors={$i}\n";
    $config .= "webrtc=yes\n";
    $config .= "direct_media=no\n\n";

    $config .= "[auth{$i}]\n";
    $config .= "type=auth\n";
    $config .= "auth_type=userpass\n";
    $config .= "password={$i}\n";
    $config .= "username={$i}\n\n";

    $config .= "[{$i}]\n";
    $config .= "type=aor\n";
    $config .= "max_contacts=5\n\n";

    // Insert record in DB
    $stmt->bind_param('sss', $i, $i, $i);
    $stmt->execute();
}

$stmt->close();
$conn->close();

// === Write config file ===
if (file_put_contents($outputFile, $config) !== false) {
    echo "✅ Config file created: $outputFile\n";
} else {
    die("❌ Error writing config file.\n");
}

// === Reload Asterisk PJSIP (Linux) ===
echo "♻ Reloading PJSIP...\n";
$output = shell_exec("sudo asterisk -rx 'pjsip reload'");
echo $output;

echo "✅ Done.\n";
?>
