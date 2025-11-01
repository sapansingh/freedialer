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
    

</body>
</html>