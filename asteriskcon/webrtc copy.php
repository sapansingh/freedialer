<?php
/**
 * Generate WebRTC PJSIP endpoints for testing (Windows)
 * Range: 7001–7060
 * Output: webrtc_channels.conf (in same folder as script)
 */

// === Config ===
$start = 7001;
$end   = 7060;
$outputFile = __DIR__ . '\\webrtc_channels.conf';  // Windows path

// === Start content ===
$config  = "; Auto-generated WebRTC PJSIP endpoints for test\n";
$config .= "; Generated on " . date('Y-m-d H:i:s') . "\n\n";

// === Create endpoint definitions ===
for ($i = $start; $i <= $end; $i++) {
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
    $config .= "max_contacts=1\n\n";
}

// === Write file ===
if (file_put_contents($outputFile, $config) !== false) {
    echo "✅ Successfully created: " . $outputFile . PHP_EOL;
} else {
    echo "❌ Error: Could not write to file: " . $outputFile . PHP_EOL;
}

// === Optional: If testing with remote Asterisk, skip reload on Windows ===
// You can manually copy the generated `webrtc_channels.conf` file
// to your Asterisk server and include it in `pjsip.conf` like this:
// #include webrtc_channels.conf

?>
