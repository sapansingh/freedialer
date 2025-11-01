<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IVRS Management System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <style>
        :root {
            --primary-color: #e74c3c;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #c0392b;
            --info-color: #3498db;
            --light-bg: #f5f7fb;
        }
        
        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        }
        
        .header-section {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 8px 32px rgba(231, 76, 60, 0.3);
        }
        
        .stat-card {
            text-align: center;
            padding: 20px 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: scale(1.03);
        }
        
        .stat-card.total {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
        }
        
        .stat-card.active {
            background: linear-gradient(135deg, #27ae60, #229954);
            color: white;
        }
        
        .stat-card.inactive {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
        }
        
        .stat-card.queues {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.4);
        }
        
        .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            margin: 0 2px;
            border-radius: 6px;
        }
        
        .status-badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.65rem;
            border-radius: 50px;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(231, 76, 60, 0.05);
        }
        
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
        }
        
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
        
        .section-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #e74c3c;
            margin-bottom: 0.8rem;
            padding-bottom: 0.3rem;
            border-bottom: 2px solid #e9ecef;
        }
        
        .required-field::after {
            content: ' *';
            color: #e74c3c;
        }
        
        .search-box {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 8px 15px;
            transition: all 0.3s ease;
        }
        
        .search-box:focus {
            border-color: #e74c3c;
            box-shadow: 0 0 0 0.2rem rgba(231, 76, 60, 0.25);
        }
        
        .filter-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 8px 15px;
            transition: all 0.3s ease;
        }
        
        .filter-select:focus {
            border-color: #e74c3c;
            box-shadow: 0 0 0 0.2rem rgba(231, 76, 60, 0.25);
        }
        
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        
        .toast {
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .pagination .page-link {
            border-radius: 6px;
            margin: 0 3px;
            border: 1px solid #e0e0e0;
            color: #e74c3c;
        }
        
        .pagination .page-item.active .page-link {
            background-color: #e74c3c;
            border-color: #e74c3c;
        }
        
        .queue-transfer-item {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            background-color: #f8f9fa;
        }
        
        .digit-input {
            max-width: 80px;
        }
        
        .nav-tabs .nav-link {
            color: #6c757d;
            font-weight: 500;
        }
        
        .nav-tabs .nav-link.active {
            color: #e74c3c;
            border-color: #e74c3c #e74c3c #fff;
        }
        
        .voice-file-preview {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 10px;
            margin-top: 10px;
        }
        
        .audio-player-small {
            width: 100%;
            height: 40px;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <!-- Toast Container -->
    <div class="toast-container"></div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="header-section">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h3 mb-1"><i class="fas fa-phone-volume me-2"></i>IVRS Management System</h1>
                    <p class="mb-0 opacity-75">Manage Interactive Voice Response Systems and Queue Transfers</p>
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#ivrModal">
                        <i class="fas fa-plus me-1"></i> Add New IVRS
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card total">
                    <h6 class="text-white-50 mb-1">Total IVRS</h6>
                    <h3 class="text-white" id="totalIvr">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card active">
                    <h6 class="text-white-50 mb-1">Active IVRS</h6>
                    <h3 class="text-white" id="activeIvr">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card inactive">
                    <h6 class="text-white-50 mb-1">Inactive IVRS</h6>
                    <h3 class="text-white" id="inactiveIvr">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card queues">
                    <h6 class="text-white-50 mb-1">Queue Transfers</h6>
                    <h3 class="text-white" id="queueTransfers">0</h3>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="glass-card mb-3">
            <div class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search"></i></span>
                        <input type="text" id="searchInput" class="form-control search-box border-start-0" placeholder="Search IVRS...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select id="statusFilter" class="form-select filter-select">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="typeFilter" class="form-select filter-select">
                        <option value="">All Types</option>
                        <option value="main">Main Menu</option>
                        <option value="sub">Sub Menu</option>
                        <option value="service">Service</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                        <i class="fas fa-redo me-1"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- DataTable -->
        <div class="glass-card">
            <div class="table-responsive">
                <table id="ivrsTable" class="table table-sm table-hover w-100">
                    <thead class="table-light">
                        <tr>
                            <th>SNO</th>
                            <th>IVRS Name</th>
                            <th>Description</th>
                            <th>Voice File</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- IVR Modal Form -->
    <div class="modal fade" id="ivrModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"><i class="fas fa-phone-volume me-2"></i>Create New IVRS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="ivrForm">
                        <input type="hidden" id="ivr_id" name="ivr_id">
                        
                        <!-- Basic Information Tab -->
                        <ul class="nav nav-tabs mb-4" id="ivrTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">
                                    <i class="fas fa-info-circle me-1"></i> Basic Information
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="queue-tab" data-bs-toggle="tab" data-bs-target="#queue" type="button" role="tab">
                                    <i class="fas fa-exchange-alt me-1"></i> Queue Transfer Settings
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="advanced-tab" data-bs-toggle="tab" data-bs-target="#advanced" type="button" role="tab">
                                    <i class="fas fa-cog me-1"></i> Advanced Settings
                                </button>
                            </li>
                        </ul>
                        
                        <div class="tab-content" id="ivrTabsContent">
                            <!-- Basic Information Tab -->
                            <div class="tab-pane fade show active" id="basic" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="ivr_name" class="form-label required-field">IVRS Name</label>
                                            <input type="text" class="form-control" id="ivr_name" name="ivr_name" required placeholder="e.g., emri_ivr">
                                            <div class="form-text">Unique identifier for this IVRS</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="ivr_description" class="form-label required-field">Description</label>
                                            <input type="text" class="form-control" id="ivr_description" name="ivr_description" required placeholder="e.g., Emergency IVR System">
                                            <div class="form-text">Brief description of this IVRS</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="voice_file" class="form-label required-field">Voice File</label>
                                            <select class="form-select" id="voice_file" name="voice_file" required>
                                                <option value="">Select Voice File</option>
                                                <option value="welcome_message">Welcome Message</option>
                                                <option value="main_menu">Main Menu</option>
                                                <option value="thank_you">Thank You</option>
                                                <option value="newivesystem">New IVE System</option>
                                                <option value="custom">Custom Upload...</option>
                                            </select>
                                            <div class="form-text">Select the voice prompt for this IVRS</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="ivr_status" class="form-label required-field">Status</label>
                                            <select class="form-select" id="ivr_status" name="ivr_status" required>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                            <div class="form-text">Set the IVRS status</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Voice File Preview -->
                                <div id="voiceFilePreview" class="voice-file-preview" style="display: none;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1" id="previewFileName">File Name</h6>
                                            <p class="mb-0 text-muted" id="previewFileInfo">File information</p>
                                        </div>
                                        <audio id="audioPreview" class="audio-player-small" controls>
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>
                                </div>
                                
                                <!-- Custom Upload Section -->
                                <div id="customUploadSection" style="display: none;">
                                    <div class="section-title mt-3">Custom Voice File Upload</div>
                                    <div class="row g-3">
                                        <div class="col-md-8">
                                            <input type="file" class="form-control" id="custom_voice_file" name="custom_voice_file" accept=".gsm,.wav,.mp3">
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-outline-primary w-100">
                                                <i class="fas fa-upload me-1"></i> Upload
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Queue Transfer Settings Tab -->
                            <div class="tab-pane fade" id="queue" role="tabpanel">
                                <div class="section-title">Queue Transfer Configuration</div>
                                <p class="text-muted mb-3">Configure digit-based queue transfers for this IVRS</p>
                                
                                <div id="queueTransfersContainer">
                                    <!-- Queue transfer items will be added here dynamically -->
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addQueueTransfer()">
                                        <i class="fas fa-plus me-1"></i> Add Queue Transfer
                                    </button>
                                    <span class="text-muted">Maximum 10 queue transfers</span>
                                </div>
                                
                                <div class="section-title mt-4">Default Transfer</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="default_action" class="form-label">Default Action</label>
                                            <select class="form-select" id="default_action" name="default_action">
                                                <option value="repeat">Repeat Menu</option>
                                                <option value="hangup">Hang Up</option>
                                                <option value="operator">Transfer to Operator</option>
                                                <option value="voicemail">Transfer to Voicemail</option>
                                            </select>
                                            <div class="form-text">Action when no valid digit is pressed</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="timeout" class="form-label">Timeout (seconds)</label>
                                            <input type="number" class="form-control" id="timeout" name="timeout" value="10" min="5" max="60">
                                            <div class="form-text">Time to wait for digit input</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Advanced Settings Tab -->
                            <div class="tab-pane fade" id="advanced" role="tabpanel">
                                <div class="section-title">Advanced IVRS Settings</div>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="max_attempts" class="form-label">Max Attempts</label>
                                            <input type="number" class="form-control" id="max_attempts" name="max_attempts" value="3" min="1" max="10">
                                            <div class="form-text">Maximum invalid attempts before default action</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="invalid_prompt" class="form-label">Invalid Input Prompt</label>
                                            <select class="form-select" id="invalid_prompt" name="invalid_prompt">
                                                <option value="default">Default Invalid Prompt</option>
                                                <option value="custom">Custom Prompt</option>
                                            </select>
                                            <div class="form-text">Voice prompt for invalid input</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" id="enable_voicemail" name="enable_voicemail">
                                            <label class="form-check-label" for="enable_voicemail">Enable Voicemail</label>
                                            <div class="form-text">Allow callers to leave voicemail</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" id="enable_callback" name="enable_callback">
                                            <label class="form-check-label" for="enable_callback">Enable Callback</label>
                                            <div class="form-text">Allow callers to request a callback</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="section-title mt-3">Call Routing</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="business_hours" class="form-label">Business Hours Routing</label>
                                            <select class="form-select" id="business_hours" name="business_hours">
                                                <option value="standard">Standard IVRS</option>
                                                <option value="operator">Direct to Operator</option>
                                                <option value="voicemail">Direct to Voicemail</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="after_hours" class="form-label">After Hours Routing</label>
                                            <select class="form-select" id="after_hours" name="after_hours">
                                                <option value="voicemail">Voicemail</option>
                                                <option value="emergency">Emergency Services</option>
                                                <option value="hangup">Hang Up</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary-custom" onclick="saveIvr()">
                        <i class="fas fa-save me-1"></i> Save IVRS
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- View IVR Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">IVRS Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="viewModalBody">
                    <!-- Content will be populated by JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        // API Configuration
        const API_BASE_URL = '../api/ivrs/'; // Adjust this to your API endpoint
        
        // Queue transfer counter
        let queueTransferCount = 0;

        // Initialize DataTable
        let ivrsTable;
        $(document).ready(function() {
            ivrsTable = $('#ivrsTable').DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search IVRS...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                columns: [
                    { data: 'sno' },
                    { data: 'ivr_name' },
                    { data: 'ivr_description' },
                    { 
                        data: 'voice_file',
                        render: function(data, type, row) {
                            return `<span class="badge bg-info">${data}</span>`;
                        }
                    },
                    { 
                        data: 'status',
                        render: function(data, type, row) {
                            return data === 'active' 
                                ? '<span class="badge bg-success status-badge"><i class="fas fa-check-circle me-1"></i>Active</span>' 
                                : '<span class="badge bg-warning status-badge"><i class="fas fa-times-circle me-1"></i>Inactive</span>';
                        }
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-outline-primary btn-action" onclick="editIvr(${data})" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-outline-info btn-action" onclick="viewIvr(${data})" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-success btn-action" onclick="testIvr(${data})" title="Test">
                                    <i class="fas fa-play"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-action" onclick="deleteIvr(${data})" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            `;
                        },
                        orderable: false
                    }
                ]
            });

            // Load initial data
            loadIvrs();
            
            // Setup event listeners
            setupEventListeners();
            
            // Add initial queue transfer
            addQueueTransfer();
        });

        // Show/Hide loading overlay
        function showLoading(show) {
            document.getElementById('loadingOverlay').style.display = show ? 'flex' : 'none';
        }

        // Setup event listeners
        function setupEventListeners() {
            // Voice file selection change
            document.getElementById('voice_file').addEventListener('change', function() {
                const selectedValue = this.value;
                const previewSection = document.getElementById('voiceFilePreview');
                const customUploadSection = document.getElementById('customUploadSection');
                
                if (selectedValue === 'custom') {
                    previewSection.style.display = 'none';
                    customUploadSection.style.display = 'block';
                } else if (selectedValue) {
                    previewSection.style.display = 'block';
                    customUploadSection.style.display = 'none';
                    
                    // Update preview
                    document.getElementById('previewFileName').textContent = selectedValue.replace(/_/g, ' ').toUpperCase();
                    document.getElementById('previewFileInfo').textContent = 'GSM Format • 8 kHz';
                    
                    // In a real implementation, you would set the actual audio source
                    // document.getElementById('audioPreview').src = `/audio/${selectedValue}.gsm`;
                } else {
                    previewSection.style.display = 'none';
                    customUploadSection.style.display = 'none';
                }
            });
        }

        // Add queue transfer item
        function addQueueTransfer() {
            if (queueTransferCount >= 10) {
                showNotification('Maximum 10 queue transfers allowed', 'warning');
                return;
            }
            
            queueTransferCount++;
            const transferId = `transfer_${queueTransferCount}`;
            
            const transferHtml = `
                <div class="queue-transfer-item" id="${transferId}">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-1">
                            <label class="form-label">Digit</label>
                            <input type="text" class="form-control digit-input" maxlength="1" placeholder="1" name="transfer_digit[]">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Description</label>
                            <input type="text" class="form-control" placeholder="e.g., Sales Department" name="transfer_description[]">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Transfer To</label>
                            <select class="form-select" name="transfer_target[]">
                                <option value="queue">Queue</option>
                                <option value="extension">Extension</option>
                                <option value="ivr">Another IVRS</option>
                                <option value="voicemail">Voicemail</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Target Name/Number</label>
                            <input type="text" class="form-control" placeholder="e.g., sales_queue or 1001" name="transfer_value[]">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-outline-danger w-100" onclick="removeQueueTransfer('${transferId}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('queueTransfersContainer').insertAdjacentHTML('beforeend', transferHtml);
        }

        // Remove queue transfer item
        function removeQueueTransfer(id) {
            const element = document.getElementById(id);
            if (element) {
                element.remove();
                queueTransferCount--;
            }
        }

        // API Functions
        async function loadIvrs() {
            showLoading(true);
            try {
                // In a real implementation, this would fetch from your API
                // For demo purposes, we'll use mock data
                const mockData = {
                    success: true,
                    data: [
                        {
                            id: 1,
                            sno: 1,
                            ivr_name: 'emri_ivr',
                            ivr_description: 'Emergency IVR System',
                            voice_file: 'newivesystem',
                            status: 'active',
                            queue_transfers: 4
                        },
                        {
                            id: 2,
                            sno: 2,
                            ivr_name: 'sales_ivr',
                            ivr_description: 'Sales Department IVR',
                            voice_file: 'welcome_message',
                            status: 'active',
                            queue_transfers: 3
                        },
                        {
                            id: 3,
                            sno: 3,
                            ivr_name: 'support_ivr',
                            ivr_description: 'Customer Support IVR',
                            voice_file: 'main_menu',
                            status: 'inactive',
                            queue_transfers: 5
                        },
                        {
                            id: 4,
                            sno: 4,
                            ivr_name: 'billing_ivr',
                            ivr_description: 'Billing Information IVR',
                            voice_file: 'thank_you',
                            status: 'active',
                            queue_transfers: 2
                        }
                    ]
                };
                
                // Simulate API delay
                setTimeout(() => {
                    if (mockData.success) {
                        ivrsTable.clear().rows.add(mockData.data).draw();
                        updateStatistics(mockData.data);
                    } else {
                        showNotification('Failed to load IVRS', 'danger');
                    }
                    showLoading(false);
                }, 800);
                
            } catch (error) {
                console.error('Error loading IVRS:', error);
                showNotification('Error loading IVRS. Please check console.', 'danger');
                showLoading(false);
            }
        }

        async function getIvr(id) {
            showLoading(true);
            try {
                // In a real implementation, this would fetch from your API
                // For demo purposes, we'll use mock data
                const mockData = {
                    success: true,
                    data: {
                        id: id,
                        ivr_name: 'emri_ivr',
                        ivr_description: 'Emergency IVR System',
                        voice_file: 'newivesystem',
                        status: 'active',
                        queue_transfers: [
                            { digit: '1', description: 'Emergency Services', target: 'queue', value: 'emergency_queue' },
                            { digit: '2', description: 'Medical Assistance', target: 'extension', value: '1001' },
                            { digit: '3', description: 'Fire Department', target: 'queue', value: 'fire_queue' },
                            { digit: '0', description: 'Operator', target: 'extension', value: '1000' }
                        ],
                        default_action: 'repeat',
                        timeout: 10,
                        max_attempts: 3,
                        enable_voicemail: true,
                        enable_callback: false,
                        business_hours: 'standard',
                        after_hours: 'emergency'
                    }
                };
                
                // Simulate API delay
                return new Promise(resolve => {
                    setTimeout(() => {
                        showLoading(false);
                        if (mockData.success) {
                            resolve(mockData.data);
                        } else {
                            showNotification('Failed to load IVR', 'danger');
                            resolve(null);
                        }
                    }, 500);
                });
            } catch (error) {
                console.error('Error loading IVR:', error);
                showNotification('Error loading IVR. Please check console.', 'danger');
                showLoading(false);
                return null;
            }
        }

        async function saveIvr() {
            const formData = new FormData(document.getElementById('ivrForm'));
            const data = Object.fromEntries(formData);
            
            // Validation
            if (!data.ivr_name.trim()) {
                showNotification('Please enter an IVRS name', 'danger');
                return;
            }
            
            if (!data.ivr_description.trim()) {
                showNotification('Please enter a description', 'danger');
                return;
            }
            
            if (!data.voice_file) {
                showNotification('Please select a voice file', 'danger');
                return;
            }

            showLoading(true);
            try {
                // In a real implementation, this would send to your API
                // For demo purposes, we'll simulate a successful response
                const mockResponse = {
                    success: true,
                    message: `IVRS ${data.ivr_id ? 'updated' : 'created'} successfully!`
                };
                
                // Simulate API delay
                setTimeout(() => {
                    showLoading(false);
                    if (mockResponse.success) {
                        showNotification(mockResponse.message, 'success');
                        loadIvrs();
                        
                        // Close modal
                        bootstrap.Modal.getInstance(document.getElementById('ivrModal')).hide();
                        resetIvrForm();
                    } else {
                        showNotification('Failed to save IVRS', 'danger');
                    }
                }, 800);
            } catch (error) {
                console.error('Error saving IVRS:', error);
                showNotification('Error saving IVRS. Please check console.', 'danger');
                showLoading(false);
            }
        }

        async function deleteIvr(id) {
            if (!confirm('Are you sure you want to delete this IVRS?')) {
                return;
            }

            showLoading(true);
            try {
                // In a real implementation, this would send to your API
                // For demo purposes, we'll simulate a successful response
                const mockResponse = {
                    success: true,
                    message: 'IVRS deleted successfully!'
                };
                
                // Simulate API delay
                setTimeout(() => {
                    showLoading(false);
                    if (mockResponse.success) {
                        showNotification(mockResponse.message, 'success');
                        loadIvrs();
                    } else {
                        showNotification('Failed to delete IVRS', 'danger');
                    }
                }, 800);
            } catch (error) {
                console.error('Error deleting IVRS:', error);
                showNotification('Error deleting IVRS. Please check console.', 'danger');
                showLoading(false);
            }
        }

        // UI Functions
        async function editIvr(id) {
            const ivr = await getIvr(id);
            if (!ivr) return;

            // Populate form
            Object.keys(ivr).forEach(key => {
                const element = document.getElementById(key);
                if (element) {
                    if (element.type === 'checkbox') {
                        element.checked = ivr[key] === true || ivr[key] === 'true';
                    } else {
                        element.value = ivr[key];
                    }
                }
            });

            // Update modal title
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit me-2"></i>Edit IVRS';

            // Populate queue transfers
            document.getElementById('queueTransfersContainer').innerHTML = '';
            queueTransferCount = 0;
            
            if (ivr.queue_transfers && ivr.queue_transfers.length > 0) {
                ivr.queue_transfers.forEach(transfer => {
                    addQueueTransfer();
                    // In a real implementation, you would populate the transfer fields
                });
            } else {
                addQueueTransfer();
            }

            // Show modal
            new bootstrap.Modal(document.getElementById('ivrModal')).show();
        }

        async function viewIvr(id) {
            const ivr = await getIvr(id);
            if (!ivr) return;

            // Create queue transfers HTML
            let queueTransfersHtml = '';
            if (ivr.queue_transfers && ivr.queue_transfers.length > 0) {
                queueTransfersHtml = `
                    <div class="section-title mt-3">Queue Transfers</div>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Digit</th>
                                    <th>Description</th>
                                    <th>Transfer To</th>
                                    <th>Target</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${ivr.queue_transfers.map(transfer => `
                                    <tr>
                                        <td><span class="badge bg-primary">${transfer.digit}</span></td>
                                        <td>${transfer.description}</td>
                                        <td>${transfer.target}</td>
                                        <td>${transfer.value}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                `;
            }

            // Create details HTML
            const detailsHtml = `
                <div class="row">
                    <div class="col-12 mb-3">
                        <h6 class="text-muted">IVRS Information</h6>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>IVRS ID:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${ivr.id}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>IVRS Name:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${ivr.ivr_name}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Description:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${ivr.ivr_description}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Voice File:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        <span class="badge bg-info">${ivr.voice_file}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Status:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${ivr.status === 'active' 
                            ? '<span class="badge bg-success">Active</span>' 
                            : '<span class="badge bg-warning">Inactive</span>'}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Default Action:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${ivr.default_action}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Timeout:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${ivr.timeout} seconds
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Max Attempts:</strong>
                    </div>
                    <div class="col-md-6 mb-2">
                        ${ivr.max_attempts}
                    </div>
                </div>
                ${queueTransfersHtml}
                <div class="mt-3 text-center">
                    <button class="btn btn-primary-custom me-2" onclick="testIvr(${ivr.id})">
                        <i class="fas fa-play me-1"></i> Test IVRS
                    </button>
                    <button class="btn btn-outline-primary" onclick="editIvr(${ivr.id})">
                        <i class="fas fa-edit me-1"></i> Edit IVRS
                    </button>
                </div>
            `;

            // Populate modal body
            document.getElementById('viewModalBody').innerHTML = detailsHtml;

            // Show modal
            new bootstrap.Modal(document.getElementById('viewModal')).show();
        }

        function testIvr(id) {
            // In a real implementation, this would test the IVRS
            showNotification('Testing IVRS... This would connect to the telephony system in production.', 'info');
        }

        function updateStatistics(ivrs) {
            const total = ivrs.length;
            const active = ivrs.filter(i => i.status === 'active').length;
            const inactive = total - active;
            const queueTransfers = ivrs.reduce((sum, ivr) => sum + (ivr.queue_transfers || 0), 0);
            
            document.getElementById('totalIvr').textContent = total;
            document.getElementById('activeIvr').textContent = active;
            document.getElementById('inactiveIvr').textContent = inactive;
            document.getElementById('queueTransfers').textContent = queueTransfers;
        }

        function resetIvrForm() {
            document.getElementById('ivrForm').reset();
            document.getElementById('queueTransfersContainer').innerHTML = '';
            queueTransferCount = 0;
            addQueueTransfer();
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus me-2"></i>Create New IVRS';
        }

        // Search functionality
        $('#searchInput').on('keyup', function() {
            ivrsTable.search(this.value).draw();
        });

        // Filter by status
        $('#statusFilter').on('change', function() {
            ivrsTable.column(4).search(this.value).draw();
        });

        // Filter by type
        $('#typeFilter').on('change', function() {
            // This would need custom filtering logic based on IVR types
            ivrsTable.draw();
        });

        function resetFilters() {
            $('#searchInput').val('');
            $('#statusFilter').val('');
            $('#typeFilter').val('');
            ivrsTable.search('').columns().search('').draw();
        }

        function showNotification(message, type = 'info') {
            const toastContainer = document.querySelector('.toast-container');
            
            // Create toast
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'danger' ? 'danger' : 'primary'} border-0`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'danger' ? 'fa-exclamation-circle' : 'fa-info-circle'} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;
            
            toastContainer.appendChild(toast);
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            
            // Remove after hide
            toast.addEventListener('hidden.bs.toast', () => {
                toast.remove();
            });
        }

        // Reset form when modal is hidden
        document.getElementById('ivrModal').addEventListener('hidden.bs.modal', function() {
            resetIvrForm();
        });
    </script>
</body>
</html>