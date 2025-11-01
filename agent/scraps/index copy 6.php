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
            --shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
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
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: var(--shadow);
        }
        
        .navbar {
            background: var(--gradient);
            box-shadow: 0 2px 12px rgba(139, 95, 191, 0.2);
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.3rem;
            letter-spacing: -0.5px;
        }
        
        .agent-status {
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            letter-spacing: 0.3px;
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
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .phone-input {
            font-size: 0.95rem;
            font-weight: 500;
            height: 42px;
            border-radius: 8px;
            border: 1px solid #E6E9F0;
            padding: 0 0.8rem;
            background: white;
            letter-spacing: 0.5px;
        }
        
        .phone-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(139, 95, 191, 0.1);
        }
        
        .call-btn {
            height: 42px;
            font-weight: 600;
            border-radius: 8px;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            letter-spacing: 0.3px;
            white-space: nowrap;
            padding: 0 1rem;
            border: none;
        }
        
        .btn-call {
            background: var(--gradient-success);
            color: white;
        }
        
        .btn-end {
            background: var(--gradient-secondary);
            color: white;
        }
        
        .btn-break {
            background: rgba(255, 209, 102, 0.15);
            border: 1px solid rgba(255, 209, 102, 0.3);
            color: #E6A700;
            font-weight: 600;
            height: 42px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            white-space: nowrap;
            padding: 0 1rem;
        }
        
        .btn-transfer {
            background: var(--primary);
            color: white;
            font-weight: 600;
            height: 42px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            white-space: nowrap;
            padding: 0 1rem;
            border: none;
        }
        
        .crm-frame {
            height: calc(100vh - 160px);
            border-radius: 12px;
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
            font-size: 3.5rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }
        
        .section-title {
            font-weight: 600;
            color: var(--dark);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
            margin: 0;
        }
        
        .fade-in {
            animation: fadeIn 0.4s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .status-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 4px;
        }
        
        .indicator-available {
            background: var(--success);
        }
        
        .indicator-busy {
            background: var(--secondary);
        }
        
        .indicator-break {
            background: var(--warning);
        }
        
        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
        }
        
        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: var(--secondary);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            font-weight: 700;
        }
        
        .inline-dial-form {
            display: flex;
            align-items: end;
            gap: 0.8rem;
            flex-wrap: wrap;
        }
        
        .form-group-inline {
            flex: 1;
            min-width: 180px;
        }
        
        .btn-group-inline {
            display: flex;
            gap: 0.6rem;
            flex-wrap: wrap;
        }
        
        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 0.3rem;
            color: var(--dark);
        }
        
        .transfer-section {
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .transfer-form {
            display: flex;
            align-items: end;
            gap: 0.8rem;
            flex-wrap: wrap;
        }
        
        .transfer-group {
            flex: 1;
            min-width: 200px;
        }
        
        .form-select {
            height: 42px;
            font-size: 0.85rem;
            border-radius: 8px;
            border: 1px solid #E6E9F0;
        }
        
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(139, 95, 191, 0.1);
        }
        
        @media (max-width: 768px) {
            .inline-dial-form,
            .transfer-form {
                flex-direction: column;
                align-items: stretch;
            }
            
            .form-group-inline,
            .transfer-group {
                min-width: 100%;
            }
            
            .btn-group-inline {
                width: 100%;
            }
            
            .btn-group-inline .btn {
                flex: 1;
            }
            
            .crm-frame {
                height: calc(100vh - 240px);
            }
        }
        
        .crm-placeholder h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .crm-placeholder p {
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        
        .crm-placeholder .btn {
            font-size: 0.8rem;
            padding: 0.5rem 1.2rem;
        }
        
        .agent-option {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .agent-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .agent-info {
            display: flex;
            flex-direction: column;
        }
        
        .agent-name {
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .agent-status-small {
            font-size: 0.7rem;
            color: #6c757d;
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
                            <span class="fw-semibold" style="font-size: 0.85rem;">Alex Morgan</span>
                            <small class="opacity-75" style="font-size: 0.7rem;">Senior Agent</small>
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

    <div class="container-fluid py-2">
        <!-- Top Section: Inline Quick Dial -->
        <div class="row mb-2">
            <div class="col-12">
                <div class="glass-card dial-section fade-in">
                    <div class="inline-dial-form">
                        <!-- Title -->
                        <div class="section-title">
                            <i class="fas fa-phone-alt"></i>
                            Quick Dial
                        </div>
                        
                        <!-- Phone Input -->
                        <div class="form-group-inline">
                            <label for="phoneNumber" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control phone-input" id="phoneNumber" placeholder="+1 (555) 123-4567" required>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="btn-group-inline">
                            <button type="submit" class="btn btn-call call-btn" id="callBtn">
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
                    </div>
                </div>
            </div>
        </div>

        <!-- Call Transfer Section -->
        <div class="row mb-2">
            <div class="col-12">
                <div class="glass-card transfer-section fade-in">
                    <div class="transfer-form">
                        <!-- Title -->
                        <div class="section-title">
                            <i class="fas fa-share"></i>
                            Transfer Call
                        </div>
                        
                        <!-- Agent Selection -->
                        <div class="transfer-group">
                            <label for="agentSelect" class="form-label">Transfer to Agent</label>
                            <select class="form-select" id="agentSelect">
                                <option value="">Select an agent...</option>
                                <option value="sarah">
                                    <div class="agent-option">
                                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" class="agent-avatar">
                                        <div class="agent-info">
                                            <span class="agent-name">Sarah Johnson</span>
                                            <span class="agent-status-small">Available</span>
                                        </div>
                                    </div>
                                </option>
                                <option value="mike">Mike Chen - Busy</option>
                                <option value="emma">Emma Davis - Available</option>
                                <option value="david">David Wilson - On Break</option>
                                <option value="lisa">Lisa Brown - Available</option>
                            </select>
                        </div>
                        
                        <!-- Queue Selection -->
                        <div class="transfer-group">
                            <label for="queueSelect" class="form-label">Transfer to Queue</label>
                            <select class="form-select" id="queueSelect">
                                <option value="">Select a queue...</option>
                                <option value="sales">Sales Queue (5 waiting)</option>
                                <option value="support">Support Queue (3 waiting)</option>
                                <option value="billing">Billing Queue (2 waiting)</option>
                                <option value="technical">Technical Queue (8 waiting)</option>
                            </select>
                        </div>
                        
                        <!-- Transfer Button -->
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
        
        <!-- Bottom Section: CRM Integration -->
        <div class="row">
            <div class="col-12">
                <div class="crm-frame fade-in">
                    <!-- In a real implementation, you would replace this with your CRM iframe -->
                    <div class="crm-placeholder">
                        <i class="fas fa-desktop"></i>
                        <h3>CRM Integration Area</h3>
                        <p class="my-3">This area would display your integrated CRM system.<br>Replace this placeholder with your actual CRM iframe.</p>
                        <div class="mt-3">
                            <button class="btn btn-light me-2 px-3 py-2 rounded-pill" id="loadCrmBtn">
                                <i class="fas fa-sync me-2"></i>Load CRM
                            </button>
                            <button class="btn btn-outline-light px-3 py-2 rounded-pill">
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
            const phoneInput = document.getElementById('phoneNumber');
            const callBtn = document.getElementById('callBtn');
            const endCallBtn = document.getElementById('endCallBtn');
            const loadCrmBtn = document.getElementById('loadCrmBtn');
            const breakBtn = document.getElementById('breakBtn');
            const transferBtn = document.getElementById('transferBtn');
            const agentSelect = document.getElementById('agentSelect');
            const queueSelect = document.getElementById('queueSelect');
            
            let callInterval;
            let callSeconds = 0;
            let isOnBreak = false;
            let isCallActive = false;
            
            // Format phone number as user types
            phoneInput.addEventListener('input', function() {
                this.value = formatPhoneNumber(this.value);
            });
            
            // Call button
            callBtn.addEventListener('click', function() {
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
            
            // Break button
            breakBtn.addEventListener('click', function() {
                isOnBreak = !isOnBreak;
                if (isOnBreak) {
                    this.innerHTML = '<i class="fas fa-play"></i> End Break';
                    this.classList.remove('btn-break');
                    this.classList.add('btn-success');
                    showNotification('You are now on break.', 'info');
                    
                    // Update status in navbar
                    const statusElement = document.querySelector('.agent-status');
                    statusElement.innerHTML = '<span class="status-indicator indicator-break"></span>On Break';
                    statusElement.className = 'agent-status status-break';
                    
                    // Disable call buttons during break
                    callBtn.disabled = true;
                    if (isCallActive) {
                        endCallBtn.disabled = false;
                    }
                } else {
                    this.innerHTML = '<i class="fas fa-coffee"></i> Break';
                    this.classList.remove('btn-success');
                    this.classList.add('btn-break');
                    showNotification('Break ended. You are now available.', 'success');
                    
                    // Update status in navbar
                    const statusElement = document.querySelector('.agent-status');
                    statusElement.innerHTML = '<span class="status-indicator indicator-available"></span>Available';
                    statusElement.className = 'agent-status status-available';
                    
                    // Enable call buttons
                    callBtn.disabled = false;
                }
            });
            
            // Transfer button
            transferBtn.addEventListener('click', function() {
                const selectedAgent = agentSelect.value;
                const selectedQueue = queueSelect.value;
                
                if (!selectedAgent && !selectedQueue) {
                    showNotification('Please select an agent or queue to transfer the call.', 'warning');
                    return;
                }
                
                if (selectedAgent && selectedQueue) {
                    showNotification('Please select either an agent OR a queue, not both.', 'warning');
                    return;
                }
                
                if (selectedAgent) {
                    showNotification(`Transferring call to agent: ${agentSelect.options[agentSelect.selectedIndex].text}`, 'info');
                    // Transfer logic to agent would go here
                }
                
                if (selectedQueue) {
                    showNotification(`Transferring call to queue: ${queueSelect.options[queueSelect.selectedIndex].text}`, 'info');
                    // Transfer logic to queue would go here
                }
                
                // Reset selections
                agentSelect.value = '';
                queueSelect.value = '';
            });
            
            // Load CRM button (demo functionality)
            loadCrmBtn.addEventListener('click', function() {
                showNotification('CRM system loading...', 'info');
                 document.getElementById('crmIframe').src = 'https://github.com/asterisk/node-ari-client';
            });
            
            // Simulate a call
            function simulateCall(phoneNumber) {
                showNotification(`Calling ${phoneNumber}...`, 'info');
                isCallActive = true;
                
                // Update UI to show active call
                endCallBtn.disabled = false;
                callBtn.disabled = true;
                
                // Start call timer
                callSeconds = 0;
                callInterval = setInterval(updateCallTimer, 1000);
                
                // Disable phone input during call
                phoneInput.disabled = true;
                
                // Update status in navbar
                const statusElement = document.querySelector('.agent-status');
                statusElement.innerHTML = '<span class="status-indicator indicator-busy"></span>Busy';
                statusElement.className = 'agent-status status-busy';
            }
            
            // End the call
            function endCall() {
                isCallActive = false;
                
                // Reset UI
                endCallBtn.disabled = true;
                callBtn.disabled = false;
                phoneInput.disabled = false;
                
                // Stop call timer
                clearInterval(callInterval);
                
                // Update status in navbar if not on break
                if (!isOnBreak) {
                    const statusElement = document.querySelector('.agent-status');
                    statusElement.innerHTML = '<span class="status-indicator indicator-available"></span>Available';
                    statusElement.className = 'agent-status status-available';
                }
            }
            
            // Update call timer
            function updateCallTimer() {
                callSeconds++;
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
            
            // Show notification
            function showNotification(message, type) {
                // Create notification element
                const notification = document.createElement('div');
                notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
                notification.style.top = '15px';
                notification.style.right = '15px';
                notification.style.zIndex = '9999';
                notification.style.minWidth = '280px';
                notification.style.borderRadius = '8px';
                notification.style.fontSize = '0.8rem';
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