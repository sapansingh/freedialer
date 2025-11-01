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
                <div class="glass-card dial-section fade-in" id="dialSection">
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

        <!-- Break Release Section (Shown during break) -->
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
        
        <!-- Bottom Section: CRM Integration / Transfer Display -->
        <div class="row">
            <div class="col-12">
                <div class="crm-frame fade-in">
                    <!-- CRM Iframe (hidden by default) -->
                    <iframe 
                        src="" 
                        class="crm-iframe" 
                        id="crmIframe"
                        allow="fullscreen">
                    </iframe>
                    
                    <!-- CRM Placeholder (shown by default) -->
                    <div class="crm-placeholder" id="crmPlaceholder">
                        <i class="fas fa-desktop"></i>
                        <h3>CRM Integration Area</h3>
                        <p class="my-3">This area would display your integrated CRM system.<br>Replace this placeholder with your actual CRM iframe.</p>
                        
                        <!-- CRM URL Input Section -->
                        <div class="crm-url-section">
                            <div class="mb-3">
                                <label for="crmUrl" class="form-label fw-semibold">CRM URL (Optional)</label>
                                <div class="input-group">
                                    <input type="url" class="form-control crm-url-input" id="crmUrl" placeholder="https://your-crm-system.com" value="https://github.com/asterisk/node-ari-client">
                                    <button class="btn btn-primary" type="button" id="loadCrmUrlBtn">
                                        <i class="fas fa-external-link-alt"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Enter your CRM URL to load it in the iframe below</small>
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
                    
                    <!-- Transfer Display (shown when transfer button is clicked) -->
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
        document.addEventListener('DOMContentLoaded', function() {
            const phoneInput = document.getElementById('phoneNumber');
            const callBtn = document.getElementById('callBtn');
            const endCallBtn = document.getElementById('endCallBtn');
            const loadCrmBtn = document.getElementById('loadCrmBtn');
            const breakBtn = document.getElementById('breakBtn');
            const breakReleaseBtn = document.getElementById('breakReleaseBtn');
            const showTransferBtn = document.getElementById('showTransferBtn');
            const backToCrmBtn = document.getElementById('backToCrmBtn');
            const transferToAgentBtn = document.getElementById('transferToAgentBtn');
            const transferToQueueBtn = document.getElementById('transferToQueueBtn');
            const breakModal = document.getElementById('breakModal');
            const cancelBreakBtn = document.getElementById('cancelBreakBtn');
            const confirmBreakBtn = document.getElementById('confirmBreakBtn');
            const dialSection = document.getElementById('dialSection');
            const breakReleaseSection = document.getElementById('breakReleaseSection');
            const breakTypeText = document.getElementById('breakTypeText');
            const crmPlaceholder = document.getElementById('crmPlaceholder');
            const transferDisplay = document.getElementById('transferDisplay');
            const crmUrlInput = document.getElementById('crmUrl');
            const loadCrmUrlBtn = document.getElementById('loadCrmUrlBtn');
            const crmIframe = document.getElementById('crmIframe');
            
            let callInterval;
            let callSeconds = 0;
            let isOnBreak = false;
            let isCallActive = false;
            let selectedBreakType = null;
            let selectedBreakDesc = null;
            let selectedAgent = null;
            let selectedQueue = null;
            
            // Format phone number as user types
            phoneInput.addEventListener('input', function() {
                this.value = formatPhoneNumber(this.value);
            });
            
            // Call button
            callBtn.addEventListener('click', function() {
                const phoneNumber = phoneInput.value.trim();
                
                if (phoneNumber) {
                    simulateCall(phoneNumber);
                } else {
                    showNotification('Please enter a phone number.', 'warning');
                }
            });
            
            // End call button
            endCallBtn.addEventListener('click', function() {
                endCall();
                showNotification('Call ended successfully.', 'success');
            });
            
            // Break button
            breakBtn.addEventListener('click', function() {
                breakModal.classList.remove('d-none');
            });
            
            // Break release button
            breakReleaseBtn.addEventListener('click', function() {
                endBreak();
            });
            
            // Show transfer display
            showTransferBtn.addEventListener('click', function() {
                crmPlaceholder.classList.add('d-none');
                transferDisplay.classList.remove('d-none');
                crmIframe.style.display = 'none';
            });
            
            // Back to CRM
            backToCrmBtn.addEventListener('click', function() {
                transferDisplay.classList.add('d-none');
                crmPlaceholder.classList.remove('d-none');
                crmIframe.style.display = 'none';
            });
            
            // Load CRM URL
            loadCrmUrlBtn.addEventListener('click', function() {
                const url = crmUrlInput.value.trim();
                if (url) {
                    loadCrmIframe(url);
                } else {
                    showNotification('Please enter a valid CRM URL', 'warning');
                }
            });
            
            // Load CRM button
            loadCrmBtn.addEventListener('click', function() {
                const url = crmUrlInput.value.trim() || 'https://github.com/asterisk/node-ari-client';
                loadCrmIframe(url);
            });
            
            // Function to load CRM iframe
            function loadCrmIframe(url) {
                showNotification('CRM system loading...', 'info');
                crmIframe.src = url;
                crmIframe.style.display = 'block';
                crmPlaceholder.classList.add('d-none');
                transferDisplay.classList.add('d-none');
                
                // Handle iframe load event
                crmIframe.onload = function() {
                    showNotification('CRM loaded successfully!', 'success');
                };
                
                // Handle iframe error event
                crmIframe.onerror = function() {
                    showNotification('Failed to load CRM. Please check the URL.', 'danger');
                    crmIframe.style.display = 'none';
                    crmPlaceholder.classList.remove('d-none');
                };
            }
            
            // Break selection
            document.querySelectorAll('.break-option').forEach(option => {
                option.addEventListener('click', function() {
                    document.querySelectorAll('.break-option').forEach(opt => {
                        opt.classList.remove('selected');
                    });
                    this.classList.add('selected');
                    selectedBreakType = this.getAttribute('data-break-type');
                    selectedBreakDesc = this.getAttribute('data-break-desc');
                    confirmBreakBtn.disabled = false;
                });
            });
            
            // Cancel break
            cancelBreakBtn.addEventListener('click', function() {
                breakModal.classList.add('d-none');
                selectedBreakType = null;
                selectedBreakDesc = null;
                confirmBreakBtn.disabled = true;
            });
            
            // Confirm break
            confirmBreakBtn.addEventListener('click', function() {
                if (selectedBreakType) {
                    startBreak(selectedBreakType, selectedBreakDesc);
                    breakModal.classList.add('d-none');
                    selectedBreakType = null;
                    selectedBreakDesc = null;
                    confirmBreakBtn.disabled = true;
                }
            });
            
            // Agent selection
            document.querySelectorAll('.agent-item').forEach(item => {
                item.addEventListener('click', function() {
                    document.querySelectorAll('.agent-item').forEach(i => {
                        i.style.background = '';
                    });
                    this.style.background = 'rgba(139, 95, 191, 0.1)';
                    selectedAgent = this.getAttribute('data-agent');
                });
            });
            
            // Queue selection
            document.querySelectorAll('.queue-item').forEach(item => {
                item.addEventListener('click', function() {
                    document.querySelectorAll('.queue-item').forEach(i => {
                        i.style.background = '';
                    });
                    this.style.background = 'rgba(139, 95, 191, 0.1)';
                    selectedQueue = this.getAttribute('data-queue');
                });
            });
            
            // Transfer to agent
            transferToAgentBtn.addEventListener('click', function() {
                if (!selectedAgent) {
                    showNotification('Please select an agent to transfer the call.', 'warning');
                    return;
                }
                
                const agentName = document.querySelector(`.agent-item[data-agent="${selectedAgent}"] .fw-semibold`).textContent;
                showNotification(`Transferring call to ${agentName}`, 'info');
                
                // Reset selection
                document.querySelectorAll('.agent-item').forEach(i => {
                    i.style.background = '';
                });
                selectedAgent = null;
            });
            
            // Transfer to queue
            transferToQueueBtn.addEventListener('click', function() {
                if (!selectedQueue) {
                    showNotification('Please select a queue to transfer the call.', 'warning');
                    return;
                }
                
                const queueName = document.querySelector(`.queue-item[data-queue="${selectedQueue}"] .fw-semibold`).textContent;
                showNotification(`Transferring call to ${queueName}`, 'info');
                
                // Reset selection
                document.querySelectorAll('.queue-item').forEach(i => {
                    i.style.background = '';
                });
                selectedQueue = null;
            });
            
            // Start break function
            function startBreak(breakType, breakDesc) {
                isOnBreak = true;
                
                // Hide dial section and show break release section
                dialSection.classList.add('d-none');
                breakReleaseSection.classList.remove('d-none');
                breakTypeText.textContent = breakDesc;
                
                // Update status in navbar
                const statusElement = document.querySelector('.agent-status');
                statusElement.innerHTML = `<span class="status-indicator indicator-break"></span>On Break (${breakType})`;
                statusElement.className = 'agent-status status-break';
                
                showNotification(`You are now on ${breakType} break.`, 'info');
                
                // Disable call buttons during break
                callBtn.disabled = true;
                if (isCallActive) {
                    endCallBtn.disabled = false;
                }
            }
            
            // End break function
            function endBreak() {
                isOnBreak = false;
                
                // Show dial section and hide break release section
                dialSection.classList.remove('d-none');
                breakReleaseSection.classList.add('d-none');
                
                // Update status in navbar
                const statusElement = document.querySelector('.agent-status');
                statusElement.innerHTML = '<span class="status-indicator indicator-available"></span>Available';
                statusElement.className = 'agent-status status-available';
                
                showNotification('Break ended. You are now available.', 'success');
                
                // Enable call buttons
                callBtn.disabled = false;
            }
            
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

        // Add this to your existing dashboard JavaScript
class CallHubWebSocket {
    constructor() {
        this.ws = null;
        this.agentId = 1; // This should come from your PHP authentication
        this.reconnectAttempts = 0;
        this.maxReconnectAttempts = 5;
    }

    connect() {
        try {
            this.ws = new WebSocket('ws://localhost:3001');
            
            this.ws.onopen = () => {
                console.log('✅ Connected to call server');
                this.reconnectAttempts = 0;
                this.registerAgent();
            };
            
            this.ws.onmessage = (event) => {
                this.handleMessage(JSON.parse(event.data));
            };
            
            this.ws.onclose = () => {
                console.log('🔌 Disconnected from call server');
                this.handleReconnect();
            };
            
            this.ws.onerror = (error) => {
                console.error('WebSocket error:', error);
            };
            
        } catch (error) {
            console.error('Failed to connect to WebSocket:', error);
        }
    }

    registerAgent() {
        this.send({
            type: 'register_agent',
            data: { agentId: this.agentId }
        });
    }

    send(message) {
        if (this.ws && this.ws.readyState === WebSocket.OPEN) {
            this.ws.send(JSON.stringify(message));
        } else {
            console.error('WebSocket not connected');
        }
    }

    handleMessage(message) {
        console.log('Received message:', message);
        
        switch (message.type) {
            case 'agent_registered':
                console.log('Agent registered successfully');
                break;
                
            case 'call_connected':
                this.handleCallConnected(message);
                break;
                
            case 'call_ended':
                this.handleCallEnded(message);
                break;
                
            case 'call_updated':
                this.handleCallUpdated(message);
                break;
                
            case 'inbound_call':
                this.handleInboundCall(message);
                break;
                
            case 'agent_status_update':
                this.handleAgentStatusUpdate(message);
                break;
                
            case 'make_call_result':
                this.handleMakeCallResult(message);
                break;
                
            case 'call_control_result':
                this.handleCallControlResult(message);
                break;
        }
    }

    handleCallConnected(message) {
        // Update UI to show active call
        document.getElementById('endCallBtn').disabled = false;
        document.getElementById('callBtn').disabled = true;
        document.getElementById('phoneNumber').disabled = true;
        
        // Show call info
        showNotification(`Call connected to ${message.callInfo.destination}`, 'success');
    }

    handleCallEnded(message) {
        // Reset UI
        document.getElementById('endCallBtn').disabled = true;
        document.getElementById('callBtn').disabled = false;
        document.getElementById('phoneNumber').disabled = false;
        
        showNotification('Call ended', 'info');
    }

    handleCallUpdated(message) {
        showNotification(`Call ${message.action}`, 'info');
    }

    handleInboundCall(message) {
        // Show inbound call notification
        showNotification(`Inbound call from ${message.callerId}`, 'info');
    }

    handleAgentStatusUpdate(message) {
        // Update status display
        const statusElement = document.querySelector('.agent-status');
        statusElement.textContent = message.status.charAt(0).toUpperCase() + message.status.slice(1);
        statusElement.className = `agent-status status-${message.status}`;
    }

    handleMakeCallResult(message) {
        if (message.result.success) {
            showNotification('Call initiated successfully', 'success');
        } else {
            showNotification(`Call failed: ${message.result.error}`, 'danger');
        }
    }

    handleCallControlResult(message) {
        if (message.result.success) {
            showNotification('Action completed successfully', 'success');
        } else {
            showNotification(`Action failed: ${message.result.error}`, 'danger');
        }
    }

    handleReconnect() {
        if (this.reconnectAttempts < this.maxReconnectAttempts) {
            this.reconnectAttempts++;
            console.log(`Attempting to reconnect... (${this.reconnectAttempts}/${this.maxReconnectAttempts})`);
            setTimeout(() => this.connect(), 3000);
        }
    }

    // Public methods for UI integration
    makeCall(destination, callerId) {
        this.send({
            type: 'make_call',
            data: {
                agentId: this.agentId,
                destination: destination,
                callerId: callerId || 'Agent'
            }
        });
    }

    callControl(action, channelId, data = {}) {
        this.send({
            type: 'call_control',
            data: {
                agentId: this.agentId,
                action: action,
                channelId: channelId,
                data: data
            }
        });
    }

    updateStatus(status) {
        this.send({
            type: 'agent_status_update',
            data: {
                agentId: this.agentId,
                status: status,
                stationId: 'desktop'
            }
        });
    }
}

// Initialize WebSocket connection
const callHub = new CallHubWebSocket();

// Update your existing event listeners to use the WebSocket
document.addEventListener('DOMContentLoaded', function() {
    // Initialize WebSocket
    callHub.connect();

    // Update call button to use WebSocket
    callBtn.addEventListener('click', function() {
        const phoneNumber = phoneInput.value.trim().replace(/\D/g, '');
        if (phoneNumber) {
            callHub.makeCall(phoneNumber);
        } else {
            showNotification('Please enter a phone number.', 'warning');
        }
    });

    // Update end call button
    endCallBtn.addEventListener('click', function() {
        // You'll need to track the current channel ID
        callHub.callControl('disconnect', 'current-channel-id');
    });

    // Update status dropdown
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function() {
            const status = this.textContent.trim().toLowerCase();
            callHub.updateStatus(status);
        });
    });

    // Add transfer functionality
    transferBtn.addEventListener('click', function() {
        const agentSelect = document.getElementById('agentSelect');
        const queueSelect = document.getElementById('queueSelect');
        
        if (agentSelect.value) {
            callHub.callControl('transfer', 'current-channel-id', {
                destination: agentSelect.value
            });
        } else if (queueSelect.value) {
            callHub.callControl('transfer', 'current-channel-id', {
                destination: queueSelect.value
            });
        } else {
            showNotification('Please select an agent or queue to transfer to.', 'warning');
        }
    });
});
    </script>
</body>
</html>