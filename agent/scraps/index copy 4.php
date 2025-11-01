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
    <style>
        :root {
            --primary: #8B5FBF;
            --primary-light: #9D72D4;
            --secondary: #FF6B6B;
            --success: #4ECDC4;
            --warning: #FFD166;
            --info: #6A8EAE;
            --dark: #2D3047;
            --light: #F7F9FC;
            --gradient: linear-gradient(135deg, #8B5FBF 0%, #6A8EAE 100%);
            --gradient-secondary: linear-gradient(135deg, #FF6B6B 0%, #FF9E7D 100%);
            --gradient-success: linear-gradient(135deg, #4ECDC4 0%, #67DCA1 100%);
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.12);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            background: linear-gradient(135deg, #F0F4F8 0%, #E8EEF5 100%);
            color: var(--dark);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: var(--shadow);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .glass-card:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-8px);
        }
        
        .navbar {
            background: var(--gradient);
            box-shadow: 0 4px 20px rgba(139, 95, 191, 0.2);
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }
        
        .agent-status {
            padding: 0.5rem 1.2rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            letter-spacing: 0.5px;
        }
        
        .status-available {
            background: rgba(78, 205, 196, 0.15);
            color: #4ECDC4;
            border: 1px solid rgba(78, 205, 196, 0.3);
        }
        
        .status-busy {
            background: rgba(255, 107, 107, 0.15);
            color: var(--secondary);
            border: 1px solid rgba(255, 107, 107, 0.3);
        }
        
        .status-break {
            background: rgba(255, 209, 102, 0.15);
            color: #E6A700;
            border: 1px solid rgba(255, 209, 102, 0.3);
        }
        
        .dial-section {
            padding: 1.8rem;
            margin-bottom: 1.5rem;
        }
        
        .phone-input {
            font-size: 1.3rem;
            font-weight: 600;
            height: 65px;
            border-radius: 14px;
            border: 2px solid #E6E9F0;
            padding: 0 1.2rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.7);
            letter-spacing: 1px;
        }
        
        .phone-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(139, 95, 191, 0.15);
            background: white;
        }
        
        .call-btn {
            height: 65px;
            font-weight: 700;
            border-radius: 14px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            letter-spacing: 0.5px;
        }
        
        .btn-call {
            background: var(--gradient-success);
            border: none;
            color: white;
        }
        
        .btn-call:hover {
            background: linear-gradient(135deg, #3DC4BC 0%, #5BD497 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(78, 205, 196, 0.35);
            color: white;
        }
        
        .btn-end {
            background: var(--gradient-secondary);
            border: none;
            color: white;
        }
        
        .btn-end:hover {
            background: linear-gradient(135deg, #E55B5B 0%, #FF8E6A 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.35);
            color: white;
        }
        
        .crm-frame {
            height: calc(100vh - 220px);
            border-radius: 20px;
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
            padding: 2.5rem;
        }
        
        .crm-placeholder i {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }
        
        .quick-stats {
            padding: 1.8rem;
            margin-bottom: 1.5rem;
        }
        
        .stat-item {
            text-align: center;
            padding: 1.2rem 0.5rem;
            border-radius: 14px;
            transition: all 0.3s ease;
        }
        
        .stat-item:hover {
            background: rgba(139, 95, 191, 0.05);
            transform: translateY(-5px);
        }
        
        .stat-value {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
        }
        
        .stat-label {
            font-size: 0.75rem;
            color: #6c757d;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        .active-call {
            background: rgba(78, 205, 196, 0.1);
            border-left: 5px solid var(--success);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(78, 205, 196, 0.4); }
            70% { box-shadow: 0 0 0 12px rgba(78, 205, 196, 0); }
            100% { box-shadow: 0 0 0 0 rgba(78, 205, 196, 0); }
        }
        
        .customer-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }
        
        .action-buttons .btn {
            border-radius: 12px;
            font-weight: 600;
            padding: 0.6rem 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .quick-actions {
            display: flex;
            gap: 0.9rem;
            margin-top: 1.2rem;
        }
        
        .quick-action-btn {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.2rem 0.5rem;
            border-radius: 14px;
            background: rgba(139, 95, 191, 0.05);
            border: 1px solid rgba(139, 95, 191, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .quick-action-btn:hover {
            background: rgba(139, 95, 191, 0.1);
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(139, 95, 191, 0.15);
        }
        
        .quick-action-btn i {
            font-size: 1.4rem;
            margin-bottom: 0.6rem;
            color: var(--primary);
        }
        
        .section-title {
            font-weight: 700;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.7rem;
            color: var(--dark);
            font-size: 1.1rem;
        }
        
        .call-timer {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--success);
            font-family: 'Courier New', monospace;
            letter-spacing: 1px;
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }
        
        .indicator-available {
            background: var(--success);
            box-shadow: 0 0 12px var(--success);
        }
        
        .indicator-busy {
            background: var(--secondary);
            box-shadow: 0 0 12px var(--secondary);
        }
        
        .indicator-break {
            background: var(--warning);
            box-shadow: 0 0 12px var(--warning);
        }
        
        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }
        
        .notification-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: var(--secondary);
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 700;
        }
        
        .performance-ring {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: conic-gradient(var(--success) 78%, #E6E9F0 0%);
            margin: 0 auto 1rem;
            position: relative;
        }
        
        .performance-ring::before {
            content: '';
            position: absolute;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: white;
        }
        
        .performance-value {
            position: relative;
            z-index: 1;
            font-weight: 800;
            font-size: 1.8rem;
            color: var(--dark);
        }
        
        .floating-element {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .nav-tabs .nav-link {
            border: none;
            font-weight: 600;
            color: #6c757d;
            padding: 0.8rem 1.2rem;
        }
        
        .nav-tabs .nav-link.active {
            background: transparent;
            color: var(--primary);
            border-bottom: 3px solid var(--primary);
        }
        
        .metric-card {
            padding: 1.5rem;
            border-radius: 14px;
            background: white;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .metric-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }
        
        .metric-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .bg-purple-light {
            background: rgba(139, 95, 191, 0.1);
            color: var(--primary);
        }
        
        .bg-teal-light {
            background: rgba(78, 205, 196, 0.1);
            color: var(--success);
        }
        
        .bg-pink-light {
            background: rgba(255, 107, 107, 0.1);
            color: var(--secondary);
        }
        
        .bg-amber-light {
            background: rgba(255, 209, 102, 0.1);
            color: #E6A700;
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
                <div class="dropdown me-4">
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
                
                <div class="position-relative me-4">
                    <button class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-bell"></i>
                    </button>
                    <span class="notification-badge">5</span>
                </div>
                
                <div class="dropdown">
                    <a class="text-white dropdown-toggle text-decoration-none d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" class="user-avatar me-2">
                        <div class="d-flex flex-column">
                            <span class="fw-semibold">Alex Morgan</span>
                            <small class="opacity-75">Senior Agent</small>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-chart-line me-2"></i>Performance</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <div class="row">
            <!-- Left Column - Dialer & Stats -->
            <div class="col-md-4 col-lg-3">
                <!-- Performance Ring -->
                <div class="glass-card quick-stats text-center fade-in">
                    <div class="performance-ring floating-element">
                        <div class="performance-value">78%</div>
                    </div>
                    <h5 class="fw-bold">Success Rate</h5>
                    <p class="text-muted small">Today's Performance</p>
                </div>
                
                <!-- Dial Section -->
                <div class="glass-card dial-section fade-in">
                    <h5 class="section-title"><i class="fas fa-phone-alt me-2"></i>Quick Dial</h5>
                    
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
                    </div>
                </div>
                
                <!-- Active Call Info -->
                <div class="glass-card quick-stats active-call d-none fade-in" id="activeCallInfo">
                    <h5 class="section-title"><i class="fas fa-user me-2"></i>Active Call</h5>
                    
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" alt="Customer" class="customer-avatar me-3">
                        <div>
                            <div class="fw-bold">Sarah Johnson</div>
                            <div class="text-muted small">Premium Customer • Account #A-8923</div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-muted">Call Duration</div>
                            <div class="call-timer" id="callTimer">00:00</div>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted">Phone</div>
                            <div class="fw-semibold">+1 (555) 673-8921</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Middle Column - Metrics -->
            <div class="col-md-4 col-lg-3">
                <div class="glass-card quick-stats fade-in h-100">
                    <h5 class="section-title"><i class="fas fa-chart-pie me-2"></i>Today's Metrics</h5>
                    
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="metric-card">
                                <div class="metric-icon bg-purple-light">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="stat-value text-primary">24</div>
                                <div class="stat-label">Calls Handled</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="metric-card">
                                <div class="metric-icon bg-teal-light">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="stat-value text-success">12.4m</div>
                                <div class="stat-label">Avg. Call Time</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="metric-card">
                                <div class="metric-icon bg-pink-light">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="stat-value text-info">78%</div>
                                <div class="stat-label">Success Rate</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="metric-card">
                                <div class="metric-icon bg-amber-light">
                                    <i class="fas fa-user-clock"></i>
                                </div>
                                <div class="stat-value text-warning">5.2m</div>
                                <div class="stat-label">Avg. Wait Time</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Performance Chart Placeholder -->
                    <div class="mt-4 pt-3 border-top">
                        <h6 class="fw-semibold mb-3">Performance Trend</h6>
                        <div class="bg-light rounded p-3 text-center">
                            <i class="fas fa-chart-line text-muted mb-2"></i>
                            <p class="small text-muted mb-0">Weekly performance chart would appear here</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - CRM Integration -->
            <div class="col-md-4 col-lg-6">
                <div class="crm-frame fade-in">
                    <!-- In a real implementation, you would replace this with your CRM iframe -->
                    <div class="crm-placeholder">
                        <i class="fas fa-desktop pulse"></i>
                        <h3>CRM Integration Area</h3>
                        <p class="my-3">This area would display your integrated CRM system.<br>Replace this placeholder with your actual CRM iframe.</p>
                        <div class="mt-3">
                            <button class="btn btn-light me-2 px-4 py-2 rounded-pill" id="loadCrmBtn">
                                <i class="fas fa-sync me-2"></i>Load CRM
                            </button>
                            <button class="btn btn-outline-light px-4 py-2 rounded-pill">
                                <i class="fas fa-expand me-2"></i>Fullscreen
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
            
            let callInterval;
            let callSeconds = 0;
            let isMuted = false;
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
                isOnHold = false;
                
                holdBtn.classList.remove('bg-warning');
                holdBtn.querySelector('span').textContent = 'Hold';
                
                muteBtn.classList.remove('bg-danger');
                muteBtn.querySelector('span').textContent = 'Mute';
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
                notification.style.borderRadius = '12px';
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