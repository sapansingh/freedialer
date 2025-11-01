<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>WebRTC SIP Client - JsSIP + Asterisk</title>
<script src="jssip.min.js"></script>
<style>
  body {
    font-family: Arial, sans-serif;
    background: #f0f2f5;
    margin: 0;
    padding: 0;
  }
  .container {
    max-width: 600px;
    margin: 40px auto;
    background: #fff;
    padding: 20px 30px;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
  }
  h2 {
    text-align: center;
    color: #333;
  }
  .status {
    margin: 15px 0;
    font-size: 18px;
    font-weight: bold;
    color: #555;
    text-align: center;
  }
  .buttons {
    display: flex;
    justify-content: center;
    margin-bottom: 15px;
  }
  button {
    margin: 0 10px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    border: none;
    transition: 0.2s;
  }
  button:hover { opacity: 0.9; }
  #callBtn { background: #4caf50; color: #fff; }
  #hangupBtn { background: #f44336; color: #fff; }
  #acceptBtn { background: #2196f3; color: #fff; display:none; }
  #rejectBtn { background: #ff9800; color: #fff; display:none; }

  #log {
    background: #111;
    color: #0f0;
    height: 200px;
    overflow-y: auto;
    padding: 10px;
    font-family: monospace;
    border-radius: 5px;
  }
  audio {
    width: 100%;
    margin-top: 10px;
  }
</style>
</head>
<body>
<div class="container">
  <h2>WebRTC SIP Client</h2>
  <div class="status"><span id="status">Not connected</span></div>

  <div class="buttons">
    <button id="callBtn">Call 6001</button>
    <button id="hangupBtn">Hangup</button>
    <button id="acceptBtn">Accept</button>
    <button id="rejectBtn">Reject</button>
  </div>

  <h3>Logs</h3>
  <div id="log"></div>

  <audio id="remoteAudio" autoplay></audio>
</div>

<script>
const logBox = document.getElementById('log');
const statusText = document.getElementById('status');
const acceptBtn = document.getElementById('acceptBtn');
const rejectBtn = document.getElementById('rejectBtn');

let session = null;
let incomingTimer = null;

const log = (msg) => {
  console.log(msg);
  logBox.innerHTML += msg + '<br>';
  logBox.scrollTop = logBox.scrollHeight;
};

// Enable JsSIP debug logs
JsSIP.debug.enable('JsSIP:*');

// --- JsSIP UA Configuration ---
const socket = new JsSIP.WebSocketInterface('ws://192.168.29.72:8088/ws');
const configuration = {
  sockets: [socket],
  uri: 'sip:7002@192.168.29.72',
  password: '7002',
  register: true
};

const ua = new JsSIP.UA(configuration);

// --- UA Event Handlers ---
ua.on('connected', () => {
  log('✅ WebSocket connected');
  statusText.textContent = 'WebSocket connected';
});

ua.on('disconnected', () => {
  log('❌ WebSocket disconnected');
  statusText.textContent = 'Disconnected';
});

ua.on('registered', () => {
  log('✅ SIP Registered as 7002');
  statusText.textContent = 'Registered';
});

ua.on('registrationFailed', (e) => {
  log('❌ Registration failed: ' + e.cause);
  statusText.textContent = 'Registration failed';
});

ua.on('newRTCSession', (e) => {
  session = e.session;

  if (e.originator === 'remote') {
    log('📞 Incoming call from ' + session.remote_identity.uri.toString());
    statusText.textContent = 'Incoming Call';
    acceptBtn.style.display = 'inline-block';
    rejectBtn.style.display = 'inline-block';

    // Start incoming call timer
    let seconds = 0;
    incomingTimer = setInterval(() => {
      seconds++;
      statusText.textContent = `Incoming Call (${seconds}s)`;
    }, 1000);
  }

  session.on('accepted', () => {
    log('✅ Call accepted');
    statusText.textContent = 'Call active';
    acceptBtn.style.display = 'none';
    rejectBtn.style.display = 'none';
    if (incomingTimer) clearInterval(incomingTimer);
  });

  session.on('ended', () => {
    log('📴 Call ended');
    statusText.textContent = 'Idle';
    acceptBtn.style.display = 'none';
    rejectBtn.style.display = 'none';
    if (incomingTimer) clearInterval(incomingTimer);
    session = null;
  });

  session.on('failed', (e) => {
    log('❌ Call failed: ' + e.cause);
    statusText.textContent = 'Call failed';
    acceptBtn.style.display = 'none';
    rejectBtn.style.display = 'none';
    if (incomingTimer) clearInterval(incomingTimer);
    session = null;
  });

  session.on('peerconnection', (e) => {
    const pc = e.peerconnection;
    pc.ontrack = (event) => {
      log('🎧 Remote audio stream received');
      document.getElementById('remoteAudio').srcObject = event.streams[0];
    };
  });
});

// --- Start UA ---
ua.start();
log('🚀 JsSIP UA started, connecting...');

// --- Outgoing Call ---
document.getElementById('callBtn').onclick = () => {
  if (session) {
    log('⚠️ Already in a session');
    return;
  }
  log('📞 Calling sip:6001@192.168.29.72 ...');
  session = ua.call('sip:6001@192.168.29.72', {
    mediaConstraints: { audio: true, video: false }
  });
};

// --- Hangup ---
document.getElementById('hangupBtn').onclick = () => {
  if (session) {
    log('📴 Hanging up...');
    session.terminate();
  } else {
    log('⚠️ No active session to hang up');
  }
};

// --- Accept incoming call ---
acceptBtn.onclick = () => {
  if (session) {
    log('📞 Answering incoming call...');
    session.answer({ mediaConstraints: { audio: true, video: false } });
  }
};

// --- Reject incoming call ---
rejectBtn.onclick = () => {
  if (session) {
    log('❌ Rejecting incoming call...');
    session.terminate();
  }
};
</script>
</body>
</html>
