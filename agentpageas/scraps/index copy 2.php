<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Call Center Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --light-bg: #f8f9fa;
        }
        
        body {
            font-size: 0.875rem;
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            overflow: hidden;
        }
        
        .navbar-brand {
            font-weight: 600;
        }
        
        .agent-status {
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-available {
            background-color: rgba(46, 204, 113, 0.2);
            color: var(--success-color);
        }
        
        .status-busy {
            background-color: rgba(231, 76, 60, 0.2);
            color: var(--danger-color);
        }
        
        .dial-section {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .phone-input {
            font-size: 1.25rem;
            font-weight: 500;
            height: 50px;
        }
        
        .call-btn {
            height: 50px;
            font-weight: 600;
        }
        
        .crm-frame {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            height: calc(100vh - 220px);
            overflow: hidden;
        }
        
        .crm-placeholder {
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ed 100%);
            color: #6c757d;
        }
        
        .crm-placeholder i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        .quick-stats {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .stat-item {
            text-align: center;
            padding: 0.5rem;
        }
        
        .stat-value {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        
        .stat-label {
            font-size: 0.75rem;
            color: #6c757d;
            text-transform: uppercase;
        }
        
        .active-call {
            background-color: rgba(46, 204, 113, 0.1);
            border-left: 4px solid var(--success-color);
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-2">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-headset me-2"></i>CallCenter Pro
            </a>
            
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <span class="agent-status status-available">
                        <i class="fas fa-circle me-1"></i>Available
                    </span>
                </div>
                
                <div class="dropdown">
                    <a class="text-white dropdown-toggle text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i> John Doe
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
                <div class="dial-section">
                    <h5 class="mb-3"><i class="fas fa-phone me-2"></i>Quick Dial</h5>
                    
                    <form id="dialForm">
                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control phone-input" id="phoneNumber" placeholder="+1 (555) 123-4567" required>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success call-btn">
                                <i class="fas fa-phone me-2"></i>Call
                            </button>
                            <button type="button" class="btn btn-danger call-btn" id="endCallBtn" disabled>
                                <i class="fas fa-phone-slash me-2"></i>End Call
                            </button>
                        </div>
                    </form>
                    
                    <!-- Quick Actions -->
                    <div class="mt-3">
                        <div class="btn-group w-100" role="group">
                            <button type="button" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-pause me-1"></i>Hold
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-volume-up me-1"></i>Mute
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-share me-1"></i>Transfer
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Stats -->
                <div class="quick-stats">
                    <h6 class="mb-3"><i class="fas fa-chart-bar me-2"></i>Today's Stats</h6>
                    
                    <div class="row text-center">
                        <div class="col-6 stat-item">
                            <div class="stat-value text-primary">24</div>
                            <div class="stat-label">Calls</div>
                        </div>
                        <div class="col-6 stat-item">
                            <div class="stat-value text-success">78%</div>
                            <div class="stat-label">Success</div>
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
                <div class="quick-stats active-call d-none" id="activeCallInfo">
                    <h6 class="mb-3"><i class="fas fa-user me-2"></i>Active Call</h6>
                    
                    <div class="d-flex align-items-center mb-2">
                        <img src="https://via.placeholder.com/40" alt="Customer" class="rounded-circle me-2">
                        <div>
                            <div class="fw-bold">Robert Johnson</div>
                            <div class="text-muted small">+1 (555) 123-4567</div>
                        </div>
                    </div>
                    
                    <div class="small">
                        <div class="mb-1"><strong>Duration:</strong> <span id="callTimer">00:00</span></div>
                        <div><strong>Account:</strong> #A-7842</div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - CRM Integration -->
            <div class="col-md-9">
                <div class="crm-frame">
                    <!-- In a real implementation, you would replace this with your CRM iframe -->
                    <div class="crm-placeholder">
                        <i class="fas fa-desktop"></i>
                        <h4>CRM Integration Area</h4>
                        <p class="text-center px-4">This area would display your integrated CRM system.<br>Replace this placeholder with your actual CRM iframe.</p>
                        <div class="mt-3">
                            <button class="btn btn-primary me-2" id="loadCrmBtn">
                                <i class="fas fa-sync me-1"></i>Load CRM
                            </button>
                            <button class="btn btn-outline-secondary">
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
            
            let callInterval;
            let callSeconds = 0;
            
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
                    alert(`Calling ${phoneNumber}...`);
                    
                    // Update UI to show active call
                    endCallBtn.disabled = false;
                    activeCallInfo.classList.remove('d-none');
                    
                    // Start call timer
                    callSeconds = 0;
                    updateCallTimer();
                    callInterval = setInterval(updateCallTimer, 1000);
                    
                    // Disable phone input during call
                    phoneInput.disabled = true;
                } else {
                    alert('Please enter a phone number.');
                }
            });
            
            // End call button
            endCallBtn.addEventListener('click', function() {
                // In a real application, you would end the call via telephony API
                alert('Call ended.');
                
                // Reset UI
                endCallBtn.disabled = true;
                activeCallInfo.classList.add('d-none');
                phoneInput.disabled = false;
                
                // Stop call timer
                clearInterval(callInterval);
            });
            
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
            
            // Load CRM button (demo functionality)
            loadCrmBtn.addEventListener('click', function() {
                alert('In a real implementation, this would load your CRM system in the iframe.');
                // Example: document.getElementById('crmIframe').src = 'https://your-crm-url.com';
            });
        });
    </script>
</body>
</html>