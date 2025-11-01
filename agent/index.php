<?php
session_start();

// Check if user is logged in and is an agent
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'agent') {
    // Redirect to login page
    header("Location: login.php");
    exit;
}

  $station=$_SESSION['station'];
        $station_ip=$_SESSION['station_ip'];
       $webrtc_user= $_SESSION['webrtc_user'];
        $webrtc_pass= $_SESSION['webrtc_pass'];
// At this point, session is valid and agent can access the page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CallHub | Agent Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <!-- JsSIP -->
    <script src="jssip.min.js"></script>
    <style>
        .wrapup-section {
            background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        .btn-redial {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            border: none;
        }
        .btn-redial:hover {
            background: linear-gradient(135deg, #45a049 0%, #4CAF50 100%);
            color: white;
        }
        .wrapup-timer {
            font-size: 1.2rem;
            font-weight: bold;
            background: rgba(255,255,255,0.2);
            padding: 8px 15px;
            border-radius: 20px;
        }
        .call-controls {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-headset me-2"></i>CallHub
            </a>
            
            <div class="d-flex align-items-center">
                <!-- SIP Status Display -->
                <div class="me-3">
                    <span id="sipStatus" class="badge bg-secondary">SIP: Disconnected</span>
                </div>
                
                <div class="dropdown me-3">
                    <a class="btn btn-light btn-sm dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                        <span class="status-indicator indicator-available"></span>
                        <span class="agent-status status-available">Available</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item d-flex align-items-center" href="#"><span class="status-indicator indicator-available me-2"></span>Available</a></li>
                        <li><a class="dropdown-item d-flex align-items-center" href="#"><span class="status-indicator indicator-busy me-2"></span>Busy</a></li>
                        <li><a class="dropdown-item d-flex align-items-center" href="#"><span class="status-indicator indicator-break me-2"></span>On Break</a></li>
                    </ul>
                </div>
                
                <div class="position-relative me-3">
                    <button class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="fas fa-bell"></i>
                    </button>
                    <span class="notification-badge">3</span>
                </div>
                
                <div class="dropdown">
                    <a class="text-white dropdown-toggle text-decoration-none d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" class="user-avatar me-2">
                        <div class="d-flex flex-column">
                            <span class="fw-semibold" style="font-size: 0.85rem;" id="usernameDisplay">Loading...</span>
                            <small class="opacity-75" style="font-size: 0.7rem;" id="stationDisplay">Station: Loading...</small>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-chart-line me-2"></i>Performance</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-2">
        <!-- SIP Connection Status -->
        <div class="row mb-2">
            <div class="col-12">
                <div class="glass-card sip-status-section fade-in">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-phone-alt me-2"></i>
                            <span id="connectionStatus">Connecting to SIP server...</span>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary" id="registerBtn">
                                <i class="fas fa-plug"></i> Register
                            </button>
                            <button class="btn btn-sm btn-outline-danger" id="unregisterBtn">
                                <i class="fas fa-plug"></i> Unregister
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wrap-up Section (Shown after call ends) -->
        <div class="row mb-2 d-none" id="wrapupSection">
            <div class="col-12">
                <div class="wrapup-section fade-in">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clipboard-check text-white me-3 fs-4"></i>
                            <div>
                                <h5 class="mb-1">Wrap-up Time</h5>
                                <p class="mb-0">Please complete call notes before next call</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="wrapup-timer" id="wrapupTimer">00:30</div>
                            <button class="btn btn-light" id="endWrapupBtn">
                                <i class="fas fa-check me-2"></i>End Wrap-up
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Section: Inline Quick Dial -->
        <div class="row mb-2">
            <div class="col-12">
                <div class="glass-card dial-section fade-in" id="dialSection">
                    <div class="inline-dial-form">
                        <!-- Title -->
                        <div class="section-title">
                            <i class="fas fa-phone-alt"></i>
                            <span id="dialSectionTitle">Quick Dial</span>
                        </div>
                        
                        <!-- Phone Input -->
                        <div class="form-group-inline" id='dialpad'>
                            <label for="phoneNumber" class="form-label">Phone Number / Extension</label>
                            <input type="tel" class="form-control phone-input" id="phoneNumber" placeholder="e.g., 6001 or +15551234567" required>
                        </div>
                        
        <!-- Call Status Display -->
        <div class="row mb-2 d-none" id="callStatusSection">
            <div class="col-12">
                <div class="call-status-section fade-in">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-phone text-success me-3 fs-4"></i>
                            <div>
                                <h5 class="mb-1" id="callStatusText">Call in progress</h5>
                                <p class="mb-0 text-muted" id="callRemoteInfo">Connected to: Loading...</p>
                            </div>
                        </div>
                        <div class="call-timer" id="callTimer">00:00</div>
                    </div>
                </div>
            </div>
        </div>
                        <!-- Action Buttons -->
                        <div class="btn-group-inline call-controls" id="callControls">
                            <button type="button" class="btn btn-call call-btn" id="callBtn">
                                <i class="fas fa-phone"></i>
                                Call
                            </button>
                            <button type="button" class="btn btn-end call-btn" id="endCallBtn" disabled>
                                <i class="fas fa-phone-slash"></i>
                                End
                            </button>
                            <button class="btn btn-break" id="breakBtn">
                                <i class="fas fa-coffee"></i>
                                Break
                            </button>
                        </div>

                        <!-- Redial Button (Shown after call ends) -->
                        <div class="btn-group-inline d-none" id="redialControls">
                            <button type="button" class="btn btn-redial call-btn" id="redialBtn">
                                <i class="fas fa-redo"></i>
                                Redial
                            </button>
                            <button class="btn btn-break" id="breakBtn2">
                                <i class="fas fa-coffee"></i>
                                Break
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Incoming Call Alert -->
        <div class="row mb-2 d-none" id="incomingCallSection">
            <div class="col-12">
                <div class="incoming-call-section fade-in">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-phone-volume text-warning me-3 fs-4"></i>
                            <div>
                                <h5 class="mb-1">Incoming Call</h5>
                                <p class="mb-0 text-muted" id="incomingCallerInfo">Caller: Loading...</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-success" id="acceptCallBtn">
                                <i class="fas fa-phone me-2"></i>Accept
                            </button>
                            <button class="btn btn-danger" id="rejectCallBtn">
                                <i class="fas fa-phone-slash me-2"></i>Reject
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Break Release Section -->
        <div class="row mb-2 d-none" id="breakReleaseSection">
            <div class="col-12">
                <div class="break-release-section fade-in">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-coffee text-warning me-3 fs-4"></i>
                            <div>
                                <h5 class="mb-1">You are currently on break</h5>
                                <p class="mb-0 text-muted" id="breakTypeText">Short Break - 5-10 minutes</p>
                            </div>
                        </div>
                        <button class="btn btn-break-release" id="breakReleaseBtn">
                            <i class="fas fa-play me-2"></i>
                            Release Break
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom Section: CRM Integration -->
        <div class="row">
            <div class="col-12">
                <div class="crm-frame fade-in">
                    <!-- CRM Iframe -->
                    <iframe 
                        src="" 
                        class="crm-iframe" 
                        id="crmIframe"
                        allow="fullscreen">
                    </iframe>
                    
                    <!-- CRM Placeholder -->
                    <div class="crm-placeholder" id="crmPlaceholder">
                        <i class="fas fa-desktop"></i>
                        <h3>CRM Integration Area</h3>
                        <p class="my-3">This area would display your integrated CRM system.</p>
                        
                        <div class="crm-url-section">
                            <div class="mb-3">
                                <label for="crmUrl" class="form-label fw-semibold">CRM URL (Optional)</label>
                                <div class="input-group">
                                    <input type="url" class="form-control crm-url-input" id="crmUrl" placeholder="https://your-crm-system.com" value="https://github.com/asterisk/node-ari-client">
                                    <button class="btn btn-primary" type="button" id="loadCrmUrlBtn">
                                        <i class="fas fa-external-link-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <button class="btn btn-light me-2 px-3 py-2 rounded-pill" id="loadCrmBtn">
                                <i class="fas fa-sync me-2"></i>Load CRM
                            </button>
                            <button class="btn btn-outline-light px-3 py-2 rounded-pill" id="showTransferBtn">
                                <i class="fas fa-share me-2"></i>Show Transfer
                            </button>
                        </div>
                    </div>
                    
                    <!-- Transfer Display -->
                    <div class="transfer-display d-none" id="transferDisplay">
                        <div class="transfer-header">
                            <i class="fas fa-share text-primary"></i>
                            <h4 class="mb-0">Call Transfer</h4>
                        </div>
                        
                        <div class="transfer-options">
                            <div class="row mb-2">
                                <div class="col-12">
                                    <div class="glass-card transfer-section fade-in">
                                        <div class="transfer-form">
                                            <div class="section-title">
                                                <i class="fas fa-share"></i>
                                                Transfer Call
                                            </div>
                                            
                                            <div class="transfer-group">
                                                <label for="agentSelect" class="form-label">Transfer to Agent</label>
                                                <select class="form-select" id="agentSelect">
                                                    <option value="">Select an agent...</option>
                                                    <option value="6001">Sarah Johnson (6001)</option>
                                                    <option value="6002">Mike Chen (6002)</option>
                                                    <option value="6003">Emma Davis (6003)</option>
                                                </select>
                                            </div>
                                            
                                            <div class="transfer-group">
                                                <label for="queueSelect" class="form-label">Transfer to Queue</label>
                                                <select class="form-select" id="queueSelect">
                                                    <option value="">Select a queue...</option>
                                                    <option value="sales">Sales Queue</option>
                                                    <option value="support">Support Queue</option>
                                                    <option value="billing">Billing Queue</option>
                                                </select>
                                            </div>
                                            
                                            <div class="btn-group-inline">
                                                <button class="btn btn-transfer" id="transferBtn">
                                                    <i class="fas fa-paper-plane"></i>
                                                    Transfer Call
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <button class="btn btn-outline-secondary" id="backToCrmBtn">
                                <i class="fas fa-arrow-left me-2"></i>Back to CRM
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Audio Element for Remote Audio -->
    <audio id="remoteAudio" autoplay style="display: none;"></audio>

    <!-- Break Selection Modal -->
    <div class="break-modal d-none" id="breakModal">
        <div class="break-form">
            <h4 class="mb-3"><i class="fas fa-coffee me-2"></i>Select Break Type</h4>
            
            <div class="break-options">
                <div class="break-option" data-break-type="short" data-break-desc="Short Break - 5-10 minutes">
                    <i class="fas fa-clock text-primary"></i>
                    <div class="fw-semibold">Short Break</div>
                    <small>5-10 minutes</small>
                </div>
                <div class="break-option" data-break-type="lunch" data-break-desc="Lunch Break - 30-60 minutes">
                    <i class="fas fa-utensils text-warning"></i>
                    <div class="fw-semibold">Lunch</div>
                    <small>30-60 minutes</small>
                </div>
                <div class="break-option" data-break-type="tea" data-break-desc="Tea/Coffee Break - 10-15 minutes">
                    <i class="fas fa-mug-hot text-info"></i>
                    <div class="fw-semibold">Tea/Coffee</div>
                    <small>10-15 minutes</small>
                </div>
                <div class="break-option" data-break-type="others" data-break-desc="Other Break - Custom duration">
                    <i class="fas fa-ellipsis-h text-secondary"></i>
                    <div class="fw-semibold">Others</div>
                    <small>Custom break</small>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button class="btn btn-secondary flex-fill" id="cancelBreakBtn">Cancel</button>
                <button class="btn btn-primary flex-fill" id="confirmBreakBtn" disabled>Start Break</button>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  
    <script>
        // PHP Session Configuration
        const sipConfig = {
            server_ip: '<?php echo $station_ip; ?>',
            server_port: '8088',
            extension: '<?php echo  $station;?>',
            password: '<?php echo  $webrtc_pass ?>',
            username: '<?php echo $_SESSION["username"] ?? "agent"; ?>'
        };

        // Display user info
        document.getElementById('usernameDisplay').textContent = sipConfig.username;
        document.getElementById('stationDisplay').textContent = `Station: ${sipConfig.extension}`;

        // JsSIP Variables
        let ua = null;
        let currentSession = null;
        let callTimer = null;
        let callStartTime = null;
        let incomingCallTimer = null;
        let wrapupTimer = null;
        let wrapupTimeLeft = 30; // 30 seconds wrap-up time
        let lastDialedNumber = '';

        // Initialize JsSIP
        function initializeSIP() {
            const socket = new JsSIP.WebSocketInterface(`ws://${sipConfig.server_ip}:${sipConfig.server_port}/ws`);
            const configuration = {
                sockets: [socket],
                uri: `sip:${sipConfig.extension}@${sipConfig.server_ip}`,
                password: sipConfig.password,
                register: true
            };

            ua = new JsSIP.UA(configuration);

            // Event Handlers
            ua.on('connected', () => {
                updateConnectionStatus('Connected', 'success');
                logSIP('✅ WebSocket connected to SIP server');
            });

            ua.on('disconnected', () => {
                updateConnectionStatus('Disconnected', 'danger');
                logSIP('❌ WebSocket disconnected from SIP server');
            });

            ua.on('registered', () => {
                updateConnectionStatus('Registered', 'success');
                logSIP(`✅ SIP Registered as ${sipConfig.extension}`);
            });

            ua.on('registrationFailed', (e) => {
                updateConnectionStatus('Registration Failed', 'danger');
                logSIP(`❌ SIP Registration failed: ${e.cause}`);
            });

            ua.on('newRTCSession', (e) => {
                currentSession = e.session;

                if (e.originator === 'remote') {
                    // Incoming call
                    const caller = currentSession.remote_identity.uri.toString();
                    logSIP(`📞 Incoming call from ${caller}`);
                    showIncomingCall(caller);
                }

                // Session event handlers
                currentSession.on('accepted', () => {
                    logSIP('✅ Call accepted');
                    showCallStatus('Call Active', currentSession.remote_identity.uri.toString());
                    hideIncomingCall();
                    startCallTimer();
                    hidedialpad();
                    // Hide dial section during active call
                    document.getElementById('dialSection').style.opacity = '0.7';
                });

                currentSession.on('ended', (e) => {
                    logSIP('📴 Call ended');
                    const wasActiveCall = document.getElementById('callStatusSection').classList.contains('d-none') === false;
                    
                    hideCallStatus();
                    hideIncomingCall();
                    stopCallTimer();
                    
                    if (wasActiveCall) {
                        // Show wrap-up section for ended calls
                        showWrapupSection();
                    } else {
                        // For rejected calls, show redial immediately
                        showRedialOption();
                    }
                    
                    currentSession = null;
                    document.getElementById('dialSection').style.opacity = '1';
                });

                currentSession.on('failed', (e) => {
                    logSIP(`❌ Call failed: ${e.cause}`);
                    hideCallStatus();
                    hideIncomingCall();
                    stopCallTimer();
                    showRedialOption();
                    currentSession = null;
                    document.getElementById('dialSection').style.opacity = '1';
                });
             
                currentSession.on('peerconnection', (e) => {
                    const pc = e.peerconnection;
                    pc.ontrack = (event) => {
                        logSIP('🎧 Remote audio stream received');
                        document.getElementById('remoteAudio').srcObject = event.streams[0];
                    };
                });
            });

            // Start the user agent
            ua.start();
            logSIP('🚀 JsSIP UA started, connecting...');
        }
   function hidedialpad(){
                        $("#dialpad").hide();
                }
                  function showdialpad(){
                        $("#dialpad").show();
                }
        // UI Update Functions
        function updateConnectionStatus(status, type) {
            const statusElement = document.getElementById('connectionStatus');
            const sipStatusElement = document.getElementById('sipStatus');
            
            statusElement.textContent = status;
            statusElement.className = type === 'success' ? 'text-success' : 'text-danger';
            
            sipStatusElement.textContent = `SIP: ${status}`;
            sipStatusElement.className = `badge bg-${type}`;
        }

        function logSIP(message) {
            console.log(`[SIP] ${message}`);
        }

        function showIncomingCall(caller) {
            document.getElementById('incomingCallerInfo').textContent = `Caller: ${caller}`;
            document.getElementById('incomingCallSection').classList.remove('d-none');
            
            let seconds = 0;
            incomingCallTimer = setInterval(() => {
                seconds++;
                document.getElementById('incomingCallerInfo').textContent = `Caller: ${caller} (${seconds}s)`;
            }, 1000);
        }

        function hideIncomingCall() {
            document.getElementById('incomingCallSection').classList.add('d-none');
            if (incomingCallTimer) {
                clearInterval(incomingCallTimer);
                incomingCallTimer = null;
            }
        }

        function showCallStatus(status, remoteInfo) {
            
            document.getElementById('callStatusText').textContent = status;
            document.getElementById('callRemoteInfo').textContent = `Connected to: ${remoteInfo}`;
            document.getElementById('callStatusSection').classList.remove('d-none');
            document.getElementById('endCallBtn').disabled = false;
            document.getElementById('callBtn').disabled = true;
        }

        function hideCallStatus() {
            document.getElementById('callStatusSection').classList.add('d-none');
            document.getElementById('endCallBtn').disabled = true;
        }

        function showWrapupSection() {
            wrapupTimeLeft = 30;
            document.getElementById('wrapupTimer').textContent = '00:30';
            document.getElementById('wrapupSection').classList.remove('d-none');
            
            wrapupTimer = setInterval(() => {
                wrapupTimeLeft--;
                const minutes = Math.floor(wrapupTimeLeft / 60);
                const seconds = wrapupTimeLeft % 60;
                document.getElementById('wrapupTimer').textContent = 
                    `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                if (wrapupTimeLeft <= 0) {
                    endWrapup();
                }
            }, 1000);
        }

        function hideWrapupSection() {
            document.getElementById('wrapupSection').classList.add('d-none');
            if (wrapupTimer) {
                clearInterval(wrapupTimer);
                wrapupTimer = null;
            }
        }

        function showRedialOption() {
            document.getElementById('callControls').classList.add('d-none');
            document.getElementById('redialControls').classList.remove('d-none');
            document.getElementById('dialSectionTitle').textContent = 'Call Completed - Ready for Next Call';
            document.getElementById('callBtn').disabled = false;
        }

        function showDialOption() {
            document.getElementById('callControls').classList.remove('d-none');
            document.getElementById('redialControls').classList.add('d-none');
            document.getElementById('dialSectionTitle').textContent = 'Quick Dial';
        }

        function startCallTimer() {
            callStartTime = new Date();
            callTimer = setInterval(() => {
                const now = new Date();
                const diff = Math.floor((now - callStartTime) / 1000);
                const minutes = Math.floor(diff / 60);
                const seconds = diff % 60;
                document.getElementById('callTimer').textContent = 
                    `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }, 1000);
        }

        function stopCallTimer() {
            if (callTimer) {
                clearInterval(callTimer);
                callTimer = null;
            }
            document.getElementById('callTimer').textContent = '00:00';
        }

        function endWrapup() {
            hideWrapupSection();
            showRedialOption();
        }

        // Event Listeners
        document.getElementById('callBtn').addEventListener('click', () => {
            const phoneNumber = document.getElementById('phoneNumber').value.trim();
            if (!phoneNumber) {
                alert('Please enter a phone number or extension');
                return;
            }

            if (currentSession) {
                alert('Already in a call');
                return;
            }

            lastDialedNumber = phoneNumber;
            const target = phoneNumber.includes('@') ? phoneNumber : `sip:${phoneNumber}@${sipConfig.server_ip}`;
            logSIP(`📞 Calling ${target}...`);
            
            currentSession = ua.call(target, {
                mediaConstraints: { audio: true, video: false }
            });
            
            // Show call status immediately
            showCallStatus('Dialing...', phoneNumber);
        });

        document.getElementById('redialBtn').addEventListener('click', () => {
            if (lastDialedNumber) {
                document.getElementById('phoneNumber').value = lastDialedNumber;
                document.getElementById('callBtn').click();
                showDialOption(); // Switch back to normal dial view
            }
        });

        document.getElementById('endCallBtn').addEventListener('click', () => {
            if (currentSession) {
                logSIP('📴 Hanging up...');
                currentSession.terminate();
            }
        });

        document.getElementById('acceptCallBtn').addEventListener('click', () => {
            if (currentSession) {
                logSIP('📞 Answering incoming call...');
                currentSession.answer({ mediaConstraints: { audio: true, video: false } });
            }
        });

        document.getElementById('rejectCallBtn').addEventListener('click', () => {
            if (currentSession) {
                logSIP('❌ Rejecting incoming call...');
                currentSession.terminate();
            }
        });

        document.getElementById('endWrapupBtn').addEventListener('click', () => {
            endWrapup();
        });

        document.getElementById('registerBtn').addEventListener('click', () => {
            if (ua) {
                ua.register();
                logSIP('🔄 Attempting to register...');
            }
        });

        document.getElementById('unregisterBtn').addEventListener('click', () => {
            if (ua) {
                ua.unregister();
                logSIP('🔌 Unregistering from SIP server...');
            }
        });

        // CRM and Transfer functionality
        document.getElementById('loadCrmBtn').addEventListener('click', () => {
            const crmUrl = document.getElementById('crmUrl').value;
            if (crmUrl) {
                document.getElementById('crmIframe').src = crmUrl;
                document.getElementById('crmPlaceholder').classList.add('d-none');
            }
        });

        document.getElementById('showTransferBtn').addEventListener('click', () => {
            document.getElementById('crmPlaceholder').classList.add('d-none');
            document.getElementById('transferDisplay').classList.remove('d-none');
        });

        document.getElementById('backToCrmBtn').addEventListener('click', () => {
            document.getElementById('transferDisplay').classList.add('d-none');
            document.getElementById('crmPlaceholder').classList.remove('d-none');
        });

        document.getElementById('transferBtn').addEventListener('click', () => {
            const agentSelect = document.getElementById('agentSelect').value;
            const queueSelect = document.getElementById('queueSelect').value;
            
            if (agentSelect) {
                logSIP(`🔄 Transferring call to agent ${agentSelect}`);
                alert(`Transfer functionality would be implemented to transfer to ${agentSelect}`);
            } else if (queueSelect) {
                logSIP(`🔄 Transferring call to queue ${queueSelect}`);
                alert(`Transfer functionality would be implemented to transfer to ${queueSelect} queue`);
            } else {
                alert('Please select an agent or queue to transfer to');
            }
        });

        // Break functionality
        document.getElementById('breakBtn').addEventListener('click', () => {
            document.getElementById('breakModal').classList.remove('d-none');
        });

        document.getElementById('breakBtn2').addEventListener('click', () => {
            document.getElementById('breakModal').classList.remove('d-none');
        });

        document.getElementById('cancelBreakBtn').addEventListener('click', () => {
            document.getElementById('breakModal').classList.add('d-none');
        });

        // Break option selection
        document.querySelectorAll('.break-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.break-option').forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                document.getElementById('confirmBreakBtn').disabled = false;
            });
        });

        document.getElementById('confirmBreakBtn').addEventListener('click', () => {
            const selectedBreak = document.querySelector('.break-option.selected');
            if (selectedBreak) {
                const breakType = selectedBreak.getAttribute('data-break-type');
                const breakDesc = selectedBreak.getAttribute('data-break-desc');
                
                document.getElementById('breakTypeText').textContent = breakDesc;
                document.getElementById('breakReleaseSection').classList.remove('d-none');
                document.getElementById('breakModal').classList.add('d-none');
                
                logSIP(`☕ Agent went on ${breakType} break`);
            }
        });

        document.getElementById('breakReleaseBtn').addEventListener('click', () => {
            document.getElementById('breakReleaseSection').classList.add('d-none');
            logSIP('✅ Agent returned from break');
        });

        // Initialize SIP when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeSIP();
        });
    </script>
</body>
</html>