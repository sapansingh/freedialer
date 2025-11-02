<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>WebRTC SIP Test - JsSIP + Asterisk</title>
  <!-- ✅ Use working JsSIP version -->
  <script src="jssip.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 30px;
      background: #f4f4f4;
      color: #333;
    }
    button {
      margin: 5px;
      padding: 10px 15px;
      font-size: 16px;
      cursor: pointer;
    }
    #log {
      background: #111;
      color: #0f0;
      padding: 10px;
      height: 250px;
      overflow-y: scroll;
      font-family: monospace;
    }
  </style>
</head>
<body>
  <h2>WebRTC SIP Test</h2>
  <p><b>Status:</b> <span id="status">Not connected</span></p>

  <button id="callBtn">Call 6001</button>
  <button id="hangupBtn">Hangup</button>

  <h3>Logs:</h3>
  <div id="log"></div>

  <audio id="remoteAudio" autoplay></audio>

  <script>
    // --- Setup logger ---
    const logBox = document.getElementById('log');
    const statusText = document.getElementById('status');
    const log = (msg) => {
      console.log(msg);
      logBox.innerHTML += msg + '<br>';
      logBox.scrollTop = logBox.scrollHeight;
    };

    // Enable JsSIP internal debugging
    JsSIP.debug.enable('JsSIP:*');

    // --- JsSIP Configuration ---
    const socket = new JsSIP.WebSocketInterface('ws://192.168.29.72:8088/ws');
    const configuration = {
      sockets: [socket],
      uri: 'sip:7001@192.168.29.72',
      password: '7001'
    };

    const ua = new JsSIP.UA(configuration);

    // --- UA Events ---
    ua.on('connected', () => {
      log('✅ WebSocket connected');
      statusText.textContent = 'WebSocket connected';
    });

    ua.on('disconnected', () => {
      log('❌ WebSocket disconnected');
      statusText.textContent = 'Disconnected';
    });

    ua.on('registered', () => {
      log('✅ SIP Registered successfully as 7001');
      statusText.textContent = 'Registered';
    });

    ua.on('registrationFailed', (e) => {
      log('❌ Registration failed: ' + e.cause);
      statusText.textContent = 'Registration failed';
    });

    ua.on('newRTCSession', (e) => {
      const session = e.session;

      if (e.originator === 'remote') {
        log('📞 Incoming call from ' + session.remote_identity.uri.toString());
        session.answer({ mediaConstraints: { audio: true, video: false } });
      }

      session.on('accepted', () => {
        log('✅ Call accepted');
        statusText.textContent = 'Call active';
      });

      session.on('ended', () => {
        log('📴 Call ended');
        statusText.textContent = 'Idle';
      });

      session.on('failed', (e) => {
        log('❌ Call failed: ' + e.cause);
        statusText.textContent = 'Call failed';
      });

      session.on('peerconnection', (e) => {
        const pc = e.peerconnection;
        pc.ontrack = (event) => {
          log('🎧 Remote audio stream received');
          document.getElementById('remoteAudio').srcObject = event.streams[0];
        };
      });
    });

    // --- Start the UA ---
    ua.start();
    log('🚀 JsSIP UA started, connecting...');

    // --- Outgoing Call ---
    let session;
    document.getElementById('callBtn').onclick = () => {
      log('📞 Trying to call sip:6001@192.168.29.72 ...');
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
  </script>
</body>
</html>
