<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Management</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --info-color: #4895ef;
            --warning-color: #f72585;
            --danger-color: #e63946;
            --light-bg: #f8f9fa;
        }
        
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 0.875rem;
            padding: 1rem;
        }
        
        .container-fluid {
            padding: 0;
        }
        
        /* Header */
        .page-header {
            background: white;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            border-left: 4px solid var(--primary-color);
        }
        
        .page-header h1 {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .page-header p {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 0;
        }
        
        /* Statistics Cards */
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 1rem;
            text-align: center;
            border-left: 4px solid var(--primary-color);
            transition: transform 0.2s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin: 0 auto 0.75rem;
            font-size: 1.2rem;
        }
        
        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        
        .stat-label {
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 500;
        }
        
        /* Glass Card */
        .glass-card {
            background: white;
            border-radius: 10px;
            padding: 1.25rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
        }
        
        /* Search and Filters */
        .search-box .input-group-text {
            background: white;
            border-right: none;
        }
        
        .search-box .form-control {
            border-left: none;
        }
        
        .filter-section label {
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: #495057;
        }
        
        /* Table */
        #processesTable th {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #6c757d;
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 0.75rem;
        }
        
        #processesTable td {
            font-size: 0.8rem;
            vertical-align: middle;
            padding: 0.75rem;
        }
        
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        
        /* Badges */
        .badge {
            font-size: 0.7rem;
            font-weight: 500;
            padding: 0.35em 0.65em;
        }
        
        /* Action Buttons */
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            border-radius: 6px;
        }
        
        .btn-action {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 2px;
        }
        
        /* Modal */
        .modal-header {
            padding: 1rem 1.25rem;
            background: var(--primary-color);
            color: white;
        }
        
        .modal-title {
            font-size: 1rem;
            font-weight: 600;
        }
        
        .modal-body {
            padding: 1.25rem;
        }
        
        .modal-footer {
            padding: 1rem 1.25rem;
        }
        
        /* Tabs */
        .nav-tabs {
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 1.25rem;
        }
        
        .nav-tabs .nav-link {
            font-size: 0.8rem;
            padding: 0.6rem 1rem;
            border: none;
            color: #6c757d;
            font-weight: 500;
            border-radius: 0;
        }
        
        .nav-tabs .nav-link.active {
            background: none;
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
        }
        
        /* Form Elements */
        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 0.4rem;
            color: #495057;
        }
        
        .form-control, .form-select {
            font-size: 0.8rem;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            border: 1px solid #ced4da;
        }
        
        .form-text {
            font-size: 0.7rem;
        }
        
        .required-field::after {
            content: " *";
            color: var(--danger-color);
        }
        
        /* Form Sections */
        .form-section {
            margin-bottom: 1.5rem;
        }
        
        .section-title {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--primary-color);
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e9ecef;
        }
        
        /* Process Visual */
        .process-visual {
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            margin-bottom: 1rem;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            display: none;
        }
        
        /* Toast Container */
        .toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 9999;
        }
        
        /* Confirmation Modal */
        .confirmation-modal .modal-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #f8d7da;
            color: var(--danger-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin: 0 auto 0.75rem;
        }
        
        /* Health Indicator */
        .health-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
        
        .health-good { background: var(--success-color); }
        .health-warning { background: var(--warning-color); }
        .health-critical { background: var(--danger-color); }
        
        /* Validation Error */
        .validation-error {
            color: var(--danger-color);
            font-size: 0.7rem;
            margin-top: 0.25rem;
            display: none;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .btn-action {
                margin-bottom: 0.25rem;
            }
            
            .stat-card {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-light" role="status" style="width: 2rem; height: 2rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <div class="container-fluid">
        <!-- Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1"><i class="fas fa-cogs me-2 text-primary"></i>Process Management</h1>
                    <p class="text-muted mb-0">Configure and manage call center processes</p>
                </div>
                <button class="btn btn-primary btn-sm" onclick="openAddModal()">
                    <i class="fas fa-plus me-1"></i> Add Process
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-3">
            <div class="col-md-3 col-6 mb-2">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4361ee, #3a0ca3);">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <div class="stat-number text-primary" id="totalProcesses">0</div>
                    <div class="stat-label">Total Processes</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4cc9f0, #4895ef);">
                        <i class="fas fa-sign-in-alt"></i>
                    </div>
                    <div class="stat-number text-info" id="inboundProcesses">0</div>
                    <div class="stat-label">Inbound</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f72585, #b5179e);">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <div class="stat-number text-warning" id="outboundProcesses">0</div>
                    <div class="stat-label">Outbound</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #7209b7, #560bad);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-number text-secondary" id="activeProcesses">0</div>
                    <div class="stat-label">Active</div>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="glass-card">
            <div class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="search-box">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Search processes...">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="filter-section">
                        <label class="form-label">Type</label>
                        <select id="typeFilter" class="form-select form-select-sm">
                            <option value="">All Types</option>
                            <option value="inbound">Inbound</option>
                            <option value="outbound">Outbound</option>
                            <option value="blended">Blended</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="filter-section">
                        <label class="form-label">Status</label>
                        <select id="statusFilter" class="form-select form-select-sm">
                            <option value="">All Status</option>
                            <option value="Y">Active</option>
                            <option value="N">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary btn-sm w-100 mt-3" onclick="resetFilters()">
                        <i class="fas fa-redo me-1"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- DataTable -->
        <div class="glass-card">
            <div class="table-responsive">
                <table id="processesTable" class="table table-sm table-hover w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Process Name</th>
                            <th>Type</th>
                            <th>Caller ID</th>
                            <th>Channels</th>
                            <th>Status</th>
                            <th>Health</th>
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

    <!-- Process Modal Form -->
    <div class="modal fade" id="processModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"><i class="fas fa-plus-circle me-2"></i>Add New Process</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="processTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">
                                <i class="fas fa-info-circle me-1"></i> Basic
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="outbound-tab" data-bs-toggle="tab" data-bs-target="#outbound" type="button" role="tab">
                                <i class="fas fa-sign-out-alt me-1"></i> Outbound
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="inbound-tab" data-bs-toggle="tab" data-bs-target="#inbound" type="button" role="tab">
                                <i class="fas fa-sign-in-alt me-1"></i> Inbound
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="breaks-tab" data-bs-toggle="tab" data-bs-target="#breaks" type="button" role="tab">
                                <i class="fas fa-clock me-1"></i> Breaks
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content mt-3" id="processTabsContent">
                        <div class="tab-pane fade show active" id="basic" role="tabpanel">
                            <form id="processForm">
                                <input type="hidden" id="sno" name="sno">
                                
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-section">
                                            <div class="section-title">
                                                <i class="fas fa-signature"></i> Process Info
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <label for="process" class="form-label required-field">Process Name</label>
                                                        <input type="text" class="form-control form-control-sm" id="process" name="process" required maxlength="50" placeholder="e.g., Sales-Campaign">
                                                        <div class="validation-error" id="processError">Process name is required</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <label for="process_type" class="form-label required-field">Process Type</label>
                                                        <select class="form-select form-select-sm" id="process_type" name="process_type" required onchange="toggleProcessConfig()">
                                                            <option value="inbound">Inbound</option>
                                                            <option value="outbound">Outbound</option>
                                                            <option value="blended">Blended</option>
                                                        </select>
                                                        <div class="validation-error" id="processTypeError">Process type is required</div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row g-2">
                                                <div class="col-md-12">
                                                    <div class="mb-2">
                                                        <label for="process_description" class="form-label">Description</label>
                                                        <textarea class="form-control form-control-sm" id="process_description" name="process_description" maxlength="250" rows="2" placeholder="Process description"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-section">
                                            <div class="section-title">
                                                <i class="fas fa-sliders-h"></i> Configuration
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <label for="callerid" class="form-label">Caller ID</label>
                                                        <input type="text" class="form-control form-control-sm" id="callerid" name="callerid" maxlength="30" placeholder="e.g., +1-555-0100">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <label for="channels" class="form-label">Channels</label>
                                                        <input type="number" class="form-control form-control-sm" id="channels" name="channels" value="0" min="0" max="100">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <label for="extension" class="form-label">Extension</label>
                                                        <input type="text" class="form-control form-control-sm" id="extension" name="extension" maxlength="10" placeholder="e.g., 1001">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <label for="active" class="form-label">Status</label>
                                                        <select class="form-select form-select-sm" id="active" name="active">
                                                            <option value="N">Inactive</option>
                                                            <option value="Y">Active</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="process-visual">
                                            <div class="text-center">
                                                <i class="fas fa-project-diagram fa-2x mb-1"></i>
                                                <div>Process Preview</div>
                                                <small id="processVisualType">Inbound</small>
                                            </div>
                                        </div>
                                        
                                        <div class="small">
                                            <div><strong>Name:</strong> <span id="previewName">-</span></div>
                                            <div><strong>Type:</strong> <span id="previewType">-</span></div>
                                            <div><strong>Caller ID:</strong> <span id="previewCallerId">-</span></div>
                                            <div><strong>Status:</strong> <span id="previewStatus" class="badge bg-secondary">Inactive</span></div>
                                            <div><strong>Channels:</strong> <span id="previewChannels">0</span></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Outbound Settings Tab -->
                        <div class="tab-pane fade" id="outbound" role="tabpanel">
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-bullhorn"></i> Outbound Settings
                                </div>
                                
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label for="outbound_type" class="form-label">Outbound Type</label>
                                            <select class="form-select form-select-sm" id="outbound_type" name="outbound_type">
                                                <option value="broadcast">Broadcast</option>
                                                <option value="preview">Preview</option>
                                                <option value="predictive">Predictive</option>
                                                <option value="progressive">Progressive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label for="outbound_broadcast_action" class="form-label">Broadcast Action</label>
                                            <select class="form-select form-select-sm" id="outbound_broadcast_action" name="outbound_broadcast_action">
                                                <option value="PFAH">PFAH</option>
                                                <option value="PFACD">PFACD</option>
                                                <option value="PFADTQ">PFADTQ</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Inbound Settings Tab -->
                        <div class="tab-pane fade" id="inbound" role="tabpanel">
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-phone-volume"></i> Inbound Settings
                                </div>
                                
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label for="inbound_did" class="form-label">DID Number</label>
                                            <input type="text" class="form-control form-control-sm" id="inbound_did" name="inbound_did" maxlength="20" placeholder="e.g., +1-555-0100">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label for="inbound_type" class="form-label">Inbound Type</label>
                                            <select class="form-select form-select-sm" id="inbound_type" name="inbound_type">
                                                <option value="direct-transfer">Direct Transfer</option>
                                                <option value="ivr">IVR</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Breaks Tab -->
                        <div class="tab-pane fade" id="breaks" role="tabpanel">
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-clock"></i> Break Configuration
                                </div>
                                
                                <div class="mb-3">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addBreakRow()">
                                        <i class="fas fa-plus me-1"></i> Add Break
                                    </button>
                                </div>
                                
                                <div id="breaksContainer">
                                    <!-- Break rows will be added here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="saveProcess()">
                        <i class="fas fa-save me-1"></i> Save Process
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Validation Error Modal -->
    <div class="modal fade" id="validationErrorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Validation Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="validationErrorMessage">Please check the form for errors.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade confirmation-modal" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center py-4">
                    <div class="modal-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h6 class="mb-2">Confirm Delete</h6>
                    <p class="text-muted mb-3 small" id="deleteConfirmText">Are you sure you want to delete this process?</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger btn-sm" id="confirmDeleteBtn">Delete</button>
                    </div>
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
        let currentEditingId = null;
        let processesData = [];
        let processesTable;
        let breaksData = [];

        // Initialize DataTable
        $(document).ready(function() {
            processesTable = $('#processesTable').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50],
                order: [[0, 'desc']],
                language: {
                    search: "",
                    searchPlaceholder: "Search processes...",
                    lengthMenu: "_MENU_"
                },
                initComplete: function() {
                    $('.dataTables_length select').addClass('form-select form-select-sm');
                    $('.dataTables_filter input').addClass('form-control form-control-sm');
                }
            });

            // Update preview when form fields change
            $('#process, #process_type, #callerid, #active, #channels').on('input change', updatePreview);
            
            // Load initial data
            loadProcesses();
            loadBreaks();
        });

        // Load processes from API
        function loadProcesses() {
            showLoading(true);
            
            // Fetch data from API
            fetch('../api/processes.php?action=get')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        processesData = data.processes;
                        populateProcessesTable(processesData);
                        updateStatistics(processesData);
                    } else {
                        showToast('Failed to load processes: ' + data.message, 'error');
                    }
                    showLoading(false);
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Error loading processes', 'error');
                    showLoading(false);
                });
        }

        // Load breaks from API
        function loadBreaks() {
            fetch('../api/breaks.php?action=get')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        breaksData = data.breaks;
                    }
                })
                .catch(error => {
                    console.error('Error loading breaks:', error);
                });
        }

        // Populate processes table
        function populateProcessesTable(processes) {
            const table = $('#processesTable').DataTable();
            table.clear();
            
            processes.forEach(process => {
                const statusBadge = process.active === 'Y' ? 
                    '<span class="badge bg-success">Active</span>' : 
                    '<span class="badge bg-secondary">Inactive</span>';
                
                const typeBadge = process.process_type === 'inbound' ? 'bg-primary' : 
                                process.process_type === 'outbound' ? 'bg-warning' : 'bg-info';
                
                const typeText = process.process_type === 'inbound' ? 'Inbound' : 
                               process.process_type === 'outbound' ? 'Outbound' : 'Blended';
                
                // Simple health calculation
                let health = 'good';
                let healthText = 'Good';
                if (process.channels === 0 && process.active === 'Y') {
                    health = 'warning';
                    healthText = 'Warning';
                }
                if (!process.process_description && process.active === 'Y') {
                    health = 'critical';
                    healthText = 'Critical';
                }
                
                table.row.add([
                    process.sno,
                    `<div class="fw-bold">${process.process}</div>
                     <small class="text-muted">${process.process_description || 'No description'}</small>`,
                    `<span class="badge ${typeBadge}">${typeText}</span>`,
                    process.callerid || '-',
                    process.channels,
                    statusBadge,
                    `<span class="health-indicator health-${health}"></span>${healthText}`,
                    `<div class="btn-group">
                        <button class="btn btn-outline-primary btn-action" onclick="editProcess(${process.sno})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline-success btn-action" onclick="testProcess(${process.sno})" title="Test">
                            <i class="fas fa-play"></i>
                        </button>
                        <button class="btn btn-outline-danger btn-action" onclick="confirmDelete(${process.sno}, '${process.process}')" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>`
                ]).draw(false);
            });
        }

        // Update statistics
        function updateStatistics(processes) {
            $('#totalProcesses').text(processes.length);
            $('#inboundProcesses').text(processes.filter(p => p.process_type === 'inbound').length);
            $('#outboundProcesses').text(processes.filter(p => p.process_type === 'outbound').length);
            $('#activeProcesses').text(processes.filter(p => p.active === 'Y').length);
        }

        // Open add modal
        function openAddModal() {
            currentEditingId = null;
            $('#modalTitle').html('<i class="fas fa-plus-circle me-2"></i>Add New Process');
            $('#processForm')[0].reset();
            $('#sno').val('');
            updatePreview();
            toggleProcessConfig();
            clearBreaksContainer();
            $('#processModal').modal('show');
        }

        // Edit process
        function editProcess(processId) {
            const process = processesData.find(p => p.sno === processId);
            if (!process) return;

            currentEditingId = processId;
            $('#modalTitle').html('<i class="fas fa-edit me-2"></i>Edit Process');
            
            // Fill form with process data
            $('#sno').val(process.sno);
            $('#process').val(process.process);
            $('#process_description').val(process.process_description);
            $('#process_type').val(process.process_type);
            $('#callerid').val(process.callerid);
            $('#channels').val(process.channels);
            $('#extension').val(process.extension);
            $('#active').val(process.active);
            $('#outbound_type').val(process.outbound_type);
            $('#outbound_broadcast_action').val(process.outbound_broadcast_action);
            $('#inbound_did').val(process.inbound_did);
            $('#inbound_type').val(process.inbound_type);

            updatePreview();
            loadProcessBreaks(processId);
            $('#processModal').modal('show');
        }

        // Load breaks for a specific process
        function loadProcessBreaks(processId) {
            clearBreaksContainer();
            
            // Filter breaks for this process
            const processBreaks = breaksData.filter(breakItem => breakItem.process_id == processId);
            
            if (processBreaks.length === 0) {
                addBreakRow(); // Add one empty row if no breaks exist
            } else {
                processBreaks.forEach(breakItem => {
                    addBreakRow(breakItem);
                });
            }
        }

        // Add a break row
        function addBreakRow(breakData = null) {
            const breakId = breakData ? breakData.break_id : 'new_' + Date.now();
            const breakName = breakData ? breakData.break : '';
            const breakDescription = breakData ? breakData.description : '';
            const breakTime = breakData ? breakData.break_time : '';
            
            const breakRow = `
                <div class="break-row mb-2 p-2 border rounded" data-break-id="${breakId}">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="form-label">Break Name</label>
                            <input type="text" class="form-control form-control-sm break-name" value="${breakName}" placeholder="e.g., Lunch">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Description</label>
                            <input type="text" class="form-control form-control-sm break-description" value="${breakDescription}" placeholder="Break description">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Time</label>
                            <input type="time" class="form-control form-control-sm break-time" value="${breakTime}">
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeBreakRow('${breakId}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            $('#breaksContainer').append(breakRow);
        }

        // Remove a break row
        function removeBreakRow(breakId) {
            $(`[data-break-id="${breakId}"]`).remove();
        }

        // Clear breaks container
        function clearBreaksContainer() {
            $('#breaksContainer').empty();
        }

        // Confirm delete
        function confirmDelete(processId, processName) {
            $('#deleteConfirmText').text(`Delete process "${processName}"? This action cannot be undone.`);
            $('#confirmDeleteBtn').off('click').on('click', function() {
                deleteProcess(processId);
            });
            $('#deleteConfirmModal').modal('show');
        }

        // Delete process
        function deleteProcess(processId) {
            $('#deleteConfirmModal').modal('hide');
            showLoading(true);

            // API call to delete process
            fetch('../api/processes.php?action=delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ sno: processId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    processesData = processesData.filter(p => p.sno !== processId);
                    populateProcessesTable(processesData);
                    updateStatistics(processesData);
                    showToast('Process deleted successfully!', 'success');
                } else {
                    showToast('Failed to delete process: ' + data.message, 'error');
                }
                showLoading(false);
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error deleting process', 'error');
                showLoading(false);
            });
        }

        // Save process
        function saveProcess() {
            // Validate form
            if (!validateForm()) {
                showValidationError('Please fill in all required fields');
                return;
            }

            const formData = new FormData(document.getElementById('processForm'));
            const data = Object.fromEntries(formData.entries());
            
            // Collect breaks data
            const breaks = [];
            $('.break-row').each(function() {
                const breakId = $(this).data('break-id');
                const breakName = $(this).find('.break-name').val();
                const breakDescription = $(this).find('.break-description').val();
                const breakTime = $(this).find('.break-time').val();
                
                if (breakName && breakTime) {
                    breaks.push({
                        break_id: breakId,
                        break: breakName,
                        description: breakDescription,
                        break_time: breakTime
                    });
                }
            });

            data.breaks = breaks;
            data.action = currentEditingId ? 'update' : 'create';

            showLoading(true);

            // API call to save process
            fetch('../api/processes.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadProcesses(); // Reload data from server
                    showToast(
                        currentEditingId ? 'Process updated successfully!' : 'Process created successfully!', 
                        'success'
                    );
                    $('#processModal').modal('hide');
                } else {
                    showToast('Failed to save process: ' + data.message, 'error');
                }
                showLoading(false);
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error saving process', 'error');
                showLoading(false);
            });
        }

        // Validate form
        function validateForm() {
            let isValid = true;
            
            // Reset error states
            $('.validation-error').hide();
            $('.form-control, .form-select').removeClass('is-invalid');
            
            // Check required fields
            if (!$('#process').val().trim()) {
                $('#processError').show();
                $('#process').addClass('is-invalid');
                isValid = false;
            }
            
            if (!$('#process_type').val()) {
                $('#processTypeError').show();
                $('#process_type').addClass('is-invalid');
                isValid = false;
            }
            
            return isValid;
        }

        // Show validation error modal
        function showValidationError(message) {
            $('#validationErrorMessage').text(message);
            $('#validationErrorModal').modal('show');
        }

        // Toggle process configuration
        function toggleProcessConfig() {
            const processType = $('#process_type').val();
            
            // Update visual
            let displayText = 'Inbound';
            if (processType === 'outbound') displayText = 'Outbound';
            else if (processType === 'blended') displayText = 'Blended';
            
            $('#processVisualType').text(displayText);
        }

        // Update process preview
        function updatePreview() {
            const name = $('#process').val() || 'Process Name';
            const type = $('#process_type').val();
            let displayType = 'Inbound';
            if (type === 'outbound') displayType = 'Outbound';
            else if (type === 'blended') displayType = 'Blended';
            
            const callerId = $('#callerid').val() || '-';
            const status = $('#active').val() === 'Y' ? 'Active' : 'Inactive';
            const statusClass = $('#active').val() === 'Y' ? 'bg-success' : 'bg-secondary';
            const channels = $('#channels').val() || '0';
            
            // Update preview text
            $('#previewName').text(name);
            $('#previewType').text(displayType);
            $('#previewCallerId').text(callerId);
            $('#previewStatus').text(status).removeClass('bg-success bg-secondary').addClass(statusClass);
            $('#previewChannels').text(channels);
        }

        // Test process
        function testProcess(processId) {
            showLoading(true);
            // Simulate process testing
            setTimeout(() => {
                showLoading(false);
                showToast('Process test completed successfully!', 'success');
            }, 2000);
        }

        // Function to reset filters
        function resetFilters() {
            $('#searchInput').val('');
            $('#typeFilter').val('');
            $('#statusFilter').val('');
            
            // Reset DataTable search and filters
            const table = $('#processesTable').DataTable();
            table.search('').columns().search('').draw();
        }

        // Function to show toast messages
        function showToast(message, type = 'info') {
            const toastContainer = $('#toastContainer');
            const toastId = 'toast-' + Date.now();
            
            const bgClass = type === 'success' ? 'bg-success' : 
                           type === 'error' ? 'bg-danger' : 'bg-info';
            
            const icon = type === 'success' ? 'check-circle' : 
                        type === 'error' ? 'exclamation-circle' : 'info-circle';
            
            const toastHtml = `
                <div id="${toastId}" class="toast align-items-center text-white ${bgClass} border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-${icon} me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;
            
            toastContainer.append(toastHtml);
            const toastElement = $('#' + toastId);
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
            
            // Remove toast from DOM after it's hidden
            toastElement.on('hidden.bs.toast', function() {
                $(this).remove();
            });
        }

        // Show/Hide loading overlay
        function showLoading(show) {
            document.getElementById('loadingOverlay').style.display = show ? 'flex' : 'none';
        }
    </script>
</body>
</html>