<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Call Center Pro | Agent Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #4895ef;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
            --info: #4895ef;
            --dark: #2b2d42;
            --light: #f8f9fa;
            --gradient: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            --gradient-light: linear-gradient(135deg, #4895ef 0%, #4361ee 100%);
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.12);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 0.875rem;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ed 100%);
            color: var(--dark);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }
        
        .glass-card:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-5px);
        }
        
        .navbar {
            background: var(--gradient);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .agent-status {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .status-available {
            background: rgba(76, 201, 240, 0.2);
            color: #4cc9f0;
            border: 1px solid rgba(76, 201, 240, 0.3);
        }
        
        .status-busy {
            background: rgba(247, 37, 133, 0.2);
            color: var(--danger);
            border: 1px solid rgba(247, 37, 133, 0.3);
        }
        
        .status-break {
            background: rgba(248, 150, 30, 0.2);
            color: var(--warning);
            border: 1px solid rgba(248, 150, 30, 0.3);
        }
        
        .dial-section {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .phone-input {
            font-size: 1.25rem;
            font-weight: 500;
            height: 60px;
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 0 1rem;
            transition: all 0.3s ease;
        }
        
        .phone-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
        }
        
        .call-btn {
            height: 60px;
            font-weight: 600;
            border-radius: 12px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-call {
            background: var(--gradient);
            border: none;
        }
        
        .btn-call:hover {
            background: var(--gradient-light);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(67, 97, 238, 0.3);
        }
        
        .btn-end {
            background: var(--danger);
            border: none;
        }
        
        .btn-end:hover {
            background: #e11574;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(247, 37, 133, 0.3);
        }
        
        .crm-frame {
            height: calc(100vh - 220px);
            border-radius: 16px;
            overflow: hidden;
            background: white;
            box-shadow: var(--shadow);
        }
        
        .crm-placeholder {
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: var(--gradient);
            color: white;
            text-align: center;
            padding: 2rem;
        }
        
        .crm-placeholder i {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }
        
        .quick-stats {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .stat-item {
            text-align: center;
            padding: 1rem 0.5rem;
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        
        .stat-item:hover {
            background: rgba(67, 97, 238, 0.05);
        }
        
        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        
        .stat-label {
            font-size: 0.75rem;
            color: #6c757d;
            text-transform: uppercase;
            font-weight: 500;
        }
        
        .active-call {
            background: rgba(76, 201, 240, 0.1);
            border-left: 4px solid var(--success);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(76, 201, 240, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(76, 201, 240, 0); }
            100% { box-shadow: 0 0 0 0 rgba(76, 201, 240, 0); }
        }
        
        .customer-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .action-buttons .btn {
            border-radius: 10px;
            font-weight: 500;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .quick-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
        }
        
        .quick-action-btn {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1rem 0.5rem;
            border-radius: 12px;
            background: rgba(67, 97, 238, 0.05);
            border: 1px solid rgba(67, 97, 238, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .quick-action-btn:hover {
            background: rgba(67, 97, 238, 0.1);
            transform: translateY(-3px);
        }
        
        .quick-action-btn i {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
            color: var(--primary);
        }
        
        .section-title {
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--dark);
        }
        
        .call-timer {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--success);
            font-family: 'Courier New', monospace;
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        .status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
        
        .indicator-available {
            background: var(--success);
            box-shadow: 0 0 10px var(--success);
        }
        
        .indicator-busy {
            background: var(--danger);
            box-shadow: 0 0 10px var(--danger);
        }
        
        .indicator-break {
            background: var(--warning);
            box-shadow: 0 0 10px var(--warning);
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-headset me-2"></i>CallCenter Pro
            </a>
            
            <div class="d-flex align-items-center">
                <div class="dropdown me-3">
                    <a class="btn btn-light btn-sm dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <span class="status-indicator indicator-available"></span>
                        <span class="agent-status status-available">Available</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><span class="status-indicator indicator-available"></span>Available</a></li>
                        <li><a class="dropdown-item" href="#"><span class="status-indicator indicator-busy"></span>Busy</a></li>
                        <li><a class="dropdown-item" href="#"><span class="status-indicator indicator-break"></span>On Break</a></li>
                    </ul>
                </div>
                
                <div class="position-relative me-3">
                    <button class="btn btn-light btn-sm">
                        <i class="fas fa-bell"></i>
                    </button>
                    <span class="notification-badge">3</span>
                </div>
                
                <div class="dropdown">
                    <a class="text-white dropdown-toggle text-decoration-none d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                        <img src="https://i.pravatar.cc/40?img=12" class="user-avatar me-2">
                        <span>John Doe</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-3">
        <div class="row">
            <!-- Left Column - Dialer & Quick Stats -->
            <div class="col-md-3">
                <!-- Dial Section -->
                <div class="glass-card dial-section fade-in">
                    <h5 class="section-title"><i class="fas fa-phone me-2"></i>Quick Dial</h5>
                    
                    <form id="dialForm">
                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label fw-semibold">Phone Number</label>
                            <input type="tel" class="form-control phone-input" id="phoneNumber" placeholder="+1 (555) 123-4567" required>
                        </div>
                        
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-call call-btn">
                                <i class="fas fa-phone me-2"></i>Make Call
                            </button>
                            <button type="button" class="btn btn-end call-btn" id="endCallBtn" disabled>
                                <i class="fas fa-phone-slash me-2"></i>End Call
                            </button>
                        </div>
                    </form>
                    
                    <!-- Quick Actions -->
                    <div class="quick-actions">
                        <div class="quick-action-btn" id="holdBtn">
                            <i class="fas fa-pause"></i>
                            <span>Hold</span>
                        </div>
                        <div class="quick-action-btn" id="muteBtn">
                            <i class="fas fa-microphone-slash"></i>
                            <span>Mute</span>
                        </div>
                        <div class="quick-action-btn" id="transferBtn">
                            <i class="fas fa-share"></i>
                            <span>Transfer</span>
                        </div>
                        <div class="quick-action-btn" id="recordBtn">
                            <i class="fas fa-circle"></i>
                            <span>Record</span>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Stats -->
                <div class="glass-card quick-stats fade-in">
                    <h5 class="section-title"><i class="fas fa-chart-bar me-2"></i>Today's Performance</h5>
                    
                    <div class="row text-center">
                        <div class="col-6 stat-item">
                            <div class="stat-value text-primary">24</div>
                            <div class="stat-label">Calls</div>
                        </div>
                        <div class="col-6 stat-item">
                            <div class="stat-value text-success">78%</div>
                            <div class="stat-label">Success Rate</div>
                        </div>
                        <div class="col-6 stat-item">
                            <div class="stat-value text-info">12.4m</div>
                            <div class="stat-label">Avg Time</div>
                        </div>
                        <div class="col-6 stat-item">
                            <div class="stat-value text-warning">5.2m</div>
                            <div class="stat-label">Wait Time</div>
                        </div>
                    </div>
                </div>
                
                <!-- Active Call Info -->
                <div class="glass-card quick-stats active-call d-none fade-in" id="activeCallInfo">
                    <h5 class="section-title"><i class="fas fa-user me-2"></i>Active Call</h5>
                    
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://i.pravatar.cc/50?img=5" alt="Customer" class="customer-avatar me-3">
                        <div>
                            <div class="fw-bold">Robert Johnson</div>
                            <div class="text-muted small">Premium Customer • Account #A-7842</div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-muted">Call Duration</div>
                            <div class="call-timer" id="callTimer">00:00</div>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted">Phone</div>
                            <div class="fw-semibold">+1 (555) 123-4567</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - CRM Integration -->
            <div class="col-md-9">
                <div class="crm-frame fade-in">
                    <!-- In a real implementation, you would replace this with your CRM iframe -->
                    <div class="crm-placeholder">
                        <i class="fas fa-desktop pulse"></i>
                        <h3>CRM Integration Area</h3>
                        <p class="my-3">This area would display your integrated CRM system.<br>Replace this placeholder with your actual CRM iframe.</p>
                        <div class="mt-3">
                            <button class="btn btn-light me-2" id="loadCrmBtn">
                                <i class="fas fa-sync me-1"></i>Load CRM
                            </button>
                            <button class="btn btn-outline-light">
                                <i class="fas fa-expand me-1"></i>Fullscreen
                            </button>
                        </div>
                    </div>
                    
                    <!-- Example of how an iframe would be implemented -->
                    <!--
                    <iframe 
                        src="https://your-crm-system.com" 
                        width="100%" 
                        height="100%" 
                        frameborder="0" 
                        id="crmIframe">
                    </iframe>
                    -->
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dialForm = document.getElementById('dialForm');
            const phoneInput = document.getElementById('phoneNumber');
            const endCallBtn = document.getElementById('endCallBtn');
            const activeCallInfo = document.getElementById('activeCallInfo');
            const callTimer = document.getElementById('callTimer');
            const loadCrmBtn = document.getElementById('loadCrmBtn');
            const holdBtn = document.getElementById('holdBtn');
            const muteBtn = document.getElementById('muteBtn');
            const transferBtn = document.getElementById('transferBtn');
            const recordBtn = document.getElementById('recordBtn');
            
            let callInterval;
            let callSeconds = 0;
            let isMuted = false;
            let isRecording = false;
            let isOnHold = false;
            
            // Format phone number as user types
            phoneInput.addEventListener('input', function() {
                this.value = formatPhoneNumber(this.value);
            });
            
            // Dial form submission
            dialForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const phoneNumber = phoneInput.value.trim();
                
                if (phoneNumber) {
                    // In a real application, you would integrate with a telephony API here
                    simulateCall(phoneNumber);
                } else {
                    showNotification('Please enter a phone number.', 'warning');
                }
            });
            
            // End call button
            endCallBtn.addEventListener('click', function() {
                // In a real application, you would end the call via telephony API
                endCall();
                showNotification('Call ended successfully.', 'success');
            });
            
            // Quick action buttons
            holdBtn.addEventListener('click', function() {
                isOnHold = !isOnHold;
                this.classList.toggle('bg-warning', isOnHold);
                this.querySelector('span').textContent = isOnHold ? 'Resume' : 'Hold';
                showNotification(isOnHold ? 'Call placed on hold' : 'Call resumed', 'info');
            });
            
            muteBtn.addEventListener('click', function() {
                isMuted = !isMuted;
                this.classList.toggle('bg-danger', isMuted);
                this.querySelector('span').textContent = isMuted ? 'Unmute' : 'Mute';
                showNotification(isMuted ? 'Microphone muted' : 'Microphone unmuted', 'info');
            });
            
            transferBtn.addEventListener('click', function() {
                showNotification('Call transfer initiated', 'info');
                // Transfer logic would go here
            });
            
            recordBtn.addEventListener('click', function() {
                isRecording = !isRecording;
                this.classList.toggle('bg-danger', isRecording);
                this.querySelector('i').className = isRecording ? 'fas fa-stop' : 'fas fa-circle';
                this.querySelector('span').textContent = isRecording ? 'Stop' : 'Record';
                showNotification(isRecording ? 'Recording started' : 'Recording stopped', 'info');
            });
            
            // Load CRM button (demo functionality)
            loadCrmBtn.addEventListener('click', function() {
                showNotification('CRM system loading...', 'info');
                // Example: document.getElementById('crmIframe').src = 'https://your-crm-url.com';
            });
            
            // Simulate a call
            function simulateCall(phoneNumber) {
                showNotification(`Calling ${phoneNumber}...`, 'info');
                
                // Update UI to show active call
                endCallBtn.disabled = false;
                activeCallInfo.classList.remove('d-none');
                
                // Start call timer
                callSeconds = 0;
                updateCallTimer();
                callInterval = setInterval(updateCallTimer, 1000);
                
                // Disable phone input during call
                phoneInput.disabled = true;
            }
            
            // End the call
            function endCall() {
                // Reset UI
                endCallBtn.disabled = true;
                activeCallInfo.classList.add('d-none');
                phoneInput.disabled = false;
                
                // Stop call timer
                clearInterval(callInterval);
                
                // Reset quick action buttons
                resetQuickActions();
            }
            
            // Update call timer
            function updateCallTimer() {
                callSeconds++;
                const minutes = Math.floor(callSeconds / 60);
                const seconds = callSeconds % 60;
                callTimer.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }
            
            // Format phone number
            function formatPhoneNumber(number) {
                // Remove all non-digit characters
                const cleaned = number.replace(/\D/g, '');
                
                // Format based on length
                if (cleaned.length <= 3) {
                    return cleaned;
                } else if (cleaned.length <= 6) {
                    return `(${cleaned.substring(0, 3)}) ${cleaned.substring(3)}`;
                } else {
                    return `(${cleaned.substring(0, 3)}) ${cleaned.substring(3, 6)}-${cleaned.substring(6, 10)}`;
                }
            }
            
            // Reset quick action buttons
            function resetQuickActions() {
                isMuted = false;
                isRecording = false;
                isOnHold = false;
                
                holdBtn.classList.remove('bg-warning');
                holdBtn.querySelector('span').textContent = 'Hold';
                
                muteBtn.classList.remove('bg-danger');
                muteBtn.querySelector('span').textContent = 'Mute';
                
                recordBtn.classList.remove('bg-danger');
                recordBtn.querySelector('i').className = 'fas fa-circle';
                recordBtn.querySelector('span').textContent = 'Record';
            }
            
            // Show notification
            function showNotification(message, type) {
                // Create notification element
                const notification = document.createElement('div');
                notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
                notification.style.top = '20px';
                notification.style.right = '20px';
                notification.style.zIndex = '9999';
                notification.style.minWidth = '300px';
                notification.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                // Add to page
                document.body.appendChild(notification);
                
                // Remove after 3 seconds
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 3000);
            }
        });
    </script>
</body>
</html>