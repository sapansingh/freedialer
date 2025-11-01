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
        
        .btn-break-release {
            background: var(--success);
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
            position: relative;
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
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 10;
        }
        
        .crm-iframe {
            width: 100%;
            height: 100%;
            border: none;
            display: none;
        }
        
        .crm-placeholder i {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }
        
        .transfer-display {
            height: 100%;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: white;
            z-index: 20;
        }
        
        .transfer-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .transfer-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            flex: 1;
        }
        
        .transfer-card {
            background: var(--light);
            border-radius: 10px;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .transfer-card h5 {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0;
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
        
        .break-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1050;
        }
        
        .break-form {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .break-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.8rem;
            margin: 1.5rem 0;
        }
        
        .break-option {
            padding: 1rem;
            border: 2px solid #E6E9F0;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .break-option:hover {
            border-color: var(--primary);
            background: rgba(139, 95, 191, 0.05);
        }
        
        .break-option.selected {
            border-color: var(--primary);
            background: rgba(139, 95, 191, 0.1);
        }
        
        .break-option i {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .agent-list {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #E6E9F0;
            border-radius: 8px;
            margin-top: 0.5rem;
        }
        
        .agent-item {
            padding: 0.8rem;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        
        .agent-item:hover {
            background: #f8f9fa;
        }
        
        .agent-item:last-child {
            border-bottom: none;
        }
        
        .agent-avatar-small {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .queue-item {
            padding: 0.8rem;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .queue-item:hover {
            background: #f8f9fa;
        }
        
        .queue-item:last-child {
            border-bottom: none;
        }
        
        .waiting-count {
            background: var(--primary);
            color: white;
            padding: 0.2rem 0.6rem;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
        }
        
        .crm-url-section {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
            width: 100%;
            max-width: 500px;
        }
        
        .crm-url-input {
            font-size: 0.85rem;
            height: 40px;
            border-radius: 6px;
        }
        
        .break-release-section {
            background: rgba(255, 209, 102, 0.1);
            border: 1px solid rgba(255, 209, 102, 0.3);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            margin: 1rem 0;
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
            
            .transfer-options {
                grid-template-columns: 1fr;
            }
            
            .break-options {
                grid-template-columns: 1fr;
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
        
        .d-none {
            display: none !important;
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
    </script>
</body>
</html>