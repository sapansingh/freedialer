<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Management - Call Queues</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --info-color: #4895ef;
            --warning-color: #f72585;
            --danger-color: #e63946;
            --executive-color: #7209b7;
            --verifier-color: #f72585;
            --light-bg: #f8f9fa;
            --dark-bg: #212529;
            --glass-bg: rgba(255, 255, 255, 0.95);
            --glass-border: rgba(255, 255, 255, 0.2);
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-bottom: 2rem;
        }
        
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--glass-border);
            padding: 30px;
            margin-bottom: 25px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--success-color));
        }
        
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .page-header {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 25px 30px;
            margin-bottom: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--glass-border);
        }
        
        .nav-tabs {
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 25px;
        }
        
        .nav-tabs .nav-link {
            border: none;
            padding: 12px 25px;
            font-weight: 600;
            color: #6c757d;
            border-radius: 10px 10px 0 0;
            margin-right: 5px;
            transition: all 0.3s ease;
        }
        
        .nav-tabs .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .nav-tabs .nav-link:hover:not(.active) {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }
        
        .form-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid rgba(67, 97, 238, 0.2);
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 10px;
            font-size: 1.3rem;
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e1e5e9;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }
        
        .required-field::after {
            content: ' *';
            color: var(--warning-color);
        }
        
        .btn {
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.4);
        }
        
        .btn-action {
            padding: 8px 12px;
            border-radius: 8px;
            margin: 0 3px;
            transition: all 0.2s ease;
        }
        
        .btn-action:hover {
            transform: scale(1.1);
        }
        
        .status-badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .queue-type-badge {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
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
        
        .stat-card {
            text-align: center;
            padding: 25px 20px;
            border-radius: 15px;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--glass-border);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        
        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 1.8rem;
            color: white;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
            font-weight: 600;
        }
        
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        
        .search-box {
            position: relative;
        }
        
        .search-box .input-group-text {
            background: white;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }
        
        .search-box .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }
        
        .filter-section {
            background: rgba(255, 255, 255, 0.7);
            border-radius: 10px;
            padding: 15px;
        }
        
        .table-responsive {
            border-radius: 15px;
            overflow: hidden;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 15px 12px;
            font-weight: 600;
        }
        
        .table tbody td {
            padding: 12px;
            vertical-align: middle;
            border-color: #f1f3f4;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }
        
        .queue-visual {
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            margin-bottom: 20px;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .queue-visual::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L100,100 Z" fill="rgba(255,255,255,0.1)"/></svg>');
            background-size: cover;
        }
        
        .feature-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 15px;
            background: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 10px;
            border-left: 4px solid var(--primary-color);
        }
        
        .feature-toggle label {
            margin-bottom: 0;
            font-weight: 600;
        }
        
        .config-preview {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            border-left: 4px solid var(--primary-color);
        }
        
        .preview-title {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        
        .preview-content {
            font-family: 'Courier New', monospace;
            background: white;
            padding: 15px;
            border-radius: 8px;
            font-size: 0.9rem;
            max-height: 300px;
            overflow-y: auto;
        }
        
        .drop-action-config {
            background: #e9ecef;
            padding: 15px;
            border-radius: 10px;
            margin-top: 10px;
            border-left: 4px solid var(--info-color);
        }
        
        @media (max-width: 768px) {
            .glass-card {
                padding: 20px;
            }
            
            .btn-action {
                margin-bottom: 5px;
                display: block;
                width: 100%;
            }
            
            .table-responsive {
                font-size: 0.85rem;
            }
        }
        
        .select2-container--default .select2-selection--single {
            border-radius: 10px;
            padding: 10px;
            border: 1px solid #e1e5e9;
            height: auto;
        }
        
        .connection-line {
            position: relative;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-color), var(--success-color));
            margin: 30px 0;
            border-radius: 2px;
        }
        
        .connection-line::before, .connection-line::after {
            content: '';
            position: absolute;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--primary-color);
            top: -5px;
        }
        
        .connection-line::before {
            left: 0;
        }
        
        .connection-line::after {
            right: 0;
            background: var(--success-color);
        }
        
        .file-upload-box {
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            background: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .file-upload-box:hover {
            border-color: var(--primary-color);
            background: #e9ecef;
        }
        
        .file-upload-box i {
            font-size: 2rem;
            color: #6c757d;
            margin-bottom: 10px;
        }
        
        .queue-health {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .health-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        .health-good { background: var(--success-color); }
        .health-warning { background: var(--warning-color); }
        .health-critical { background: var(--danger-color); }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                <div>
                    <h1 class="h3 mb-1"><i class="fas fa-project-diagram me-2 text-primary"></i>Process Management</h1>
                    <p class="text-muted mb-0">Manage call queues and process workflows</p>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#queueModal">
                    <i class="fas fa-plus me-1"></i> Add New Queue
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4361ee, #3a0ca3);">
                        <i class="fas fa-list-alt"></i>
                    </div>
                    <div class="stat-number text-primary" id="totalQueues">0</div>
                    <div class="stat-label">Total Queues</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4cc9f0, #4895ef);">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="stat-number text-info" id="executiveQueues">0</div>
                    <div class="stat-label">Executive Queues</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f72585, #b5179e);">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stat-number text-warning" id="verifierQueues">0</div>
                    <div class="stat-label">Verifier Queues</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #7209b7, #560bad);">
                        <i class="fas fa-play-circle"></i>
                    </div>
                    <div class="stat-number text-secondary" id="activeQueues">0</div>
                    <div class="stat-label">Active Queues</div>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="glass-card">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <div class="search-box">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Search queues...">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="filter-section">
                        <label class="form-label small fw-bold">Queue Type</label>
                        <select id="typeFilter" class="form-select form-select-sm">
                            <option value="">All Types</option>
                            <option value="executive">Executive</option>
                            <option value="verifier">Verifier</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="filter-section">
                        <label class="form-label small fw-bold">Status</label>
                        <select id="statusFilter" class="form-select form-select-sm">
                            <option value="">All Status</option>
                            <option value="Y">Active</option>
                            <option value="N">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100 mt-4" onclick="resetFilters()">
                        <i class="fas fa-redo me-1"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- DataTable -->
        <div class="glass-card">
            <div class="table-responsive">
                <table id="queuesTable" class="table table-sm table-hover w-100">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Queue Name</th>
                            <th>Type</th>
                            <th>DID</th>
                            <th>Process</th>
                            <th>Length</th>
                            <th>Drop Time</th>
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

    <!-- Queue Modal Form -->
    <div class="modal fade" id="queueModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTitle"><i class="fas fa-plus-circle me-2"></i>Add New Queue</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="queueTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">
                                <i class="fas fa-info-circle me-1"></i> Basic Settings
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="audio-tab" data-bs-toggle="tab" data-bs-target="#audio" type="button" role="tab">
                                <i class="fas fa-volume-up me-1"></i> Audio Settings
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="advanced-tab" data-bs-toggle="tab" data-bs-target="#advanced" type="button" role="tab">
                                <i class="fas fa-cogs me-1"></i> Advanced
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="preview-tab" data-bs-toggle="tab" data-bs-target="#preview" type="button" role="tab">
                                <i class="fas fa-eye me-1"></i> Preview
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content mt-4" id="queueTabsContent">
                        <div class="tab-pane fade show active" id="basic" role="tabpanel">
                            <form id="queueForm">
                                <input type="hidden" id="queue_id" name="queue_id">
                                
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-section">
                                            <div class="section-title">
                                                <i class="fas fa-signature"></i> Queue Identification
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="queue_name" class="form-label required-field">Queue Name</label>
                                                        <input type="text" class="form-control" id="queue_name" name="queue_name" required maxlength="30" placeholder="e.g., Sales-Queue">
                                                        <small class="form-text text-muted">Unique name for the queue</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="queue_type" class="form-label required-field">Queue Type</label>
                                                        <select class="form-select" id="queue_type" name="queue_type" required>
                                                            <option value="executive">Executive</option>
                                                            <option value="verifier">Verifier</option>
                                                        </select>
                                                        <small class="form-text text-muted">Type of queue</small>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row g-3 mt-2">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="queue_did" class="form-label">DID Number</label>
                                                        <input type="text" class="form-control" id="queue_did" name="queue_did" maxlength="20" placeholder="e.g., +1-555-0100">
                                                        <small class="form-text text-muted">Direct Inward Dial number</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="queue_assigned_process" class="form-label">Assigned Process</label>
                                                        <input type="text" class="form-control" id="queue_assigned_process" name="queue_assigned_process" maxlength="50" placeholder="e.g., Sales Process">
                                                        <small class="form-text text-muted">Process assigned to this queue</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-section">
                                            <div class="section-title">
                                                <i class="fas fa-sliders-h"></i> Queue Configuration
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="queue_length" class="form-label">Queue Length</label>
                                                        <input type="number" class="form-control" id="queue_length" name="queue_length" value="1" min="1" max="100">
                                                        <small class="form-text text-muted">Maximum queue length</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="queue_drop_time" class="form-label">Drop Time (seconds)</label>
                                                        <input type="number" class="form-control" id="queue_drop_time" name="queue_drop_time" value="0" min="0" max="3600">
                                                        <small class="form-text text-muted">Time before call is dropped from queue</small>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row g-3 mt-2">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="queue_selected" class="form-label">Queue Status</label>
                                                        <select class="form-select" id="queue_selected" name="queue_selected">
                                                            <option value="N">Inactive</option>
                                                            <option value="Y">Active</option>
                                                        </select>
                                                        <small class="form-text text-muted">Queue activation status</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="queue_over_flow" class="form-label">Overflow Queue</label>
                                                        <input type="text" class="form-control" id="queue_over_flow" name="queue_over_flow" maxlength="30" placeholder="e.g., Overflow-Queue">
                                                        <small class="form-text text-muted">Queue for overflow calls</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="queue-visual">
                                            <div class="text-center">
                                                <i class="fas fa-phone-alt fa-3x mb-2"></i>
                                                <div>Queue Preview</div>
                                                <small id="queueVisualType">Executive Queue</small>
                                            </div>
                                        </div>
                                        
                                        <div class="config-preview">
                                            <div class="preview-title">
                                                <i class="fas fa-info-circle me-2"></i>Queue Summary
                                            </div>
                                            <div class="preview-content">
                                                <div><strong>Name:</strong> <span id="previewName">Sales-Queue</span></div>
                                                <div><strong>Type:</strong> <span id="previewType">Executive</span></div>
                                                <div><strong>DID:</strong> <span id="previewDid">+1-555-0100</span></div>
                                                <div><strong>Status:</strong> <span id="previewStatus" class="badge bg-success">Active</span></div>
                                                <div><strong>Length:</strong> <span id="previewLength">1</span></div>
                                                <div><strong>Drop Time:</strong> <span id="previewDropTime">0s</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <div class="tab-pane fade" id="audio" role="tabpanel">
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-music"></i> Audio Files
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="greeting_file_id" class="form-label">Greeting File ID</label>
                                            <input type="number" class="form-control" id="greeting_file_id" name="greeting_file_id" value="0" min="0">
                                            <small class="form-text text-muted">ID of the greeting audio file</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="call_queue_file_id" class="form-label">Queue File ID</label>
                                            <input type="number" class="form-control" id="call_queue_file_id" name="call_queue_file_id" value="0" min="0">
                                            <small class="form-text text-muted">ID of the queue announcement file</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="connection-line"></div>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="file-upload-box" onclick="document.getElementById('queue_no_file').click()">
                                            <i class="fas fa-upload"></i>
                                            <div>Upload Queue Number File</div>
                                            <small class="text-muted">Click to upload or select file ID</small>
                                            <input type="file" id="queue_no_file_upload" class="d-none" accept="audio/*">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="queue_no_file" class="form-label">Queue Number File</label>
                                            <input type="text" class="form-control" id="queue_no_file" name="queue_no_file" maxlength="100" placeholder="e.g., queue_number.wav">
                                            <small class="form-text text-muted">File for queue number announcement</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="file-upload-box" onclick="document.getElementById('hold_durn_file').click()">
                                            <i class="fas fa-upload"></i>
                                            <div>Upload Hold Duration File</div>
                                            <small class="text-muted">Click to upload or select file ID</small>
                                            <input type="file" id="hold_durn_file_upload" class="d-none" accept="audio/*">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="hold_durn_file" class="form-label">Hold Duration File</label>
                                            <input type="text" class="form-control" id="hold_durn_file" name="hold_durn_file" maxlength="100" placeholder="e.g., hold_music.wav">
                                            <small class="form-text text-muted">File for hold duration announcement</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-play-circle"></i> Playback Settings
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="feature-toggle">
                                            <label for="play_queue_no" class="form-label">Play Queue No</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="play_queue_no" name="play_queue_no" value="Y">
                                            </div>
                                        </div>
                                        <small class="text-muted">Play queue position to caller</small>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="feature-toggle">
                                            <label for="play_hold_durn" class="form-label">Play Hold Duration</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="play_hold_durn" name="play_hold_durn" value="Y">
                                            </div>
                                        </div>
                                        <small class="text-muted">Play hold duration to caller</small>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="playback_freq" class="form-label">Playback Frequency</label>
                                            <input type="number" class="form-control" id="playback_freq" name="playback_freq" value="0" min="0" max="3600">
                                            <small class="form-text text-muted">Frequency of playback announcements (seconds)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="advanced" role="tabpanel">
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-random"></i> Drop Action Configuration
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="queue_drop_action" class="form-label">Drop Action</label>
                                            <select class="form-select" id="queue_drop_action" name="queue_drop_action" onchange="toggleDropActionConfig()">
                                                <option value="">Select Action</option>
                                                <option value="callforward">Call Forward</option>
                                                <option value="voicemail">Voicemail</option>
                                                <option value="queue">Another Queue</option>
                                                <option value="extension">Extension</option>
                                                <option value="ip">IP Address</option>
                                                <option value="play">Play Message</option>
                                                <option value="IVR">IVR</option>
                                            </select>
                                            <small class="form-text text-muted">Action when call is dropped from queue</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="queue_drop_value" class="form-label">Drop Value</label>
                                            <input type="text" class="form-control" id="queue_drop_value" name="queue_drop_value" maxlength="250" placeholder="Value based on selected action">
                                            <small class="form-text text-muted">Value for the drop action</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="dropActionConfig" class="drop-action-config" style="display: none;">
                                    <div class="preview-title">
                                        <i class="fas fa-cog me-2"></i>Drop Action Configuration
                                    </div>
                                    <div id="dropActionHelp" class="text-muted">
                                        Configure the specific settings for the selected drop action.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-sitemap"></i> IVR Integration
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="ivr_id" class="form-label">IVR ID</label>
                                            <input type="number" class="form-control" id="ivr_id" name="ivr_id" value="0" min="0">
                                            <small class="form-text text-muted">ID of the IVR system to integrate with</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="preview" role="tabpanel">
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-code"></i> Configuration Preview
                                </div>
                                
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    This is a preview of the Asterisk configuration that will be generated for this queue.
                                </div>
                                
                                <div class="config-preview">
                                    <div class="preview-title">
                                        <i class="fas fa-file-code me-2"></i>Generated Configuration
                                    </div>
                                    <div class="preview-content" id="configPreview">
                                        <!-- Configuration preview will be generated here -->
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <button type="button" class="btn btn-outline-primary" onclick="generateConfigPreview()">
                                        <i class="fas fa-sync me-1"></i> Refresh Preview
                                    </button>
                                    <button type="button" class="btn btn-outline-success" onclick="copyConfigToClipboard()">
                                        <i class="fas fa-copy me-1"></i> Copy to Clipboard
                                    </button>
                                    <button type="button" class="btn btn-outline-warning" onclick="testQueueConfig()">
                                        <i class="fas fa-play me-1"></i> Test Configuration
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveQueue()">
                        <i class="fas fa-save me-1"></i> Save Queue
                    </button>
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
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // API Configuration
        const API_BASE_URL = 'api/queues/'; // Adjust this to your API endpoint
        
        // Sample data for demonstration
        let sampleQueues = [
            {
                queue_id: 1,
                queue_name: 'Sales-Queue',
                queue_type: 'executive',
                queue_did: '+1-555-0100',
                greeting_file_id: 101,
                call_queue_file_id: 102,
                queue_drop_time: 300,
                queue_drop_action: 'voicemail',
                queue_drop_value: '1001',
                queue_assigned_process: 'Sales Process',
                queue_length: 10,
                queue_selected: 'Y',
                queue_over_flow: 'Overflow-Queue',
                play_queue_no: 'Y',
                queue_no_file: 'queue_position.wav',
                play_hold_durn: 'N',
                hold_durn_file: 'hold_music.wav',
                playback_freq: 60,
                ivr_id: 5
            },
            {
                queue_id: 2,
                queue_name: 'Support-Queue',
                queue_type: 'verifier',
                queue_did: '+1-555-0101',
                greeting_file_id: 103,
                call_queue_file_id: 104,
                queue_drop_time: 180,
                queue_drop_action: 'extension',
                queue_drop_value: '2001',
                queue_assigned_process: 'Support Process',
                queue_length: 5,
                queue_selected: 'Y',
                queue_over_flow: 'Backup-Queue',
                play_queue_no: 'Y',
                queue_no_file: 'support_queue.wav',
                play_hold_durn: 'Y',
                hold_durn_file: 'support_hold.wav',
                playback_freq: 45,
                ivr_id: 3
            },
            {
                queue_id: 3,
                queue_name: 'Billing-Queue',
                queue_type: 'executive',
                queue_did: '+1-555-0102',
                greeting_file_id: 105,
                call_queue_file_id: 106,
                queue_drop_time: 240,
                queue_drop_action: 'IVR',
                queue_drop_value: 'billing_menu',
                queue_assigned_process: 'Billing Process',
                queue_length: 8,
                queue_selected: 'N',
                queue_over_flow: '',
                play_queue_no: 'N',
                queue_no_file: '',
                play_hold_durn: 'N',
                hold_durn_file: '',
                playback_freq: 0,
                ivr_id: 7
            }
        ];

        // Initialize DataTable
        let queuesTable;
        $(document).ready(function() {
            // Initialize Select2
            $('.form-select').select2({
                width: '100%',
                theme: 'bootstrap-5'
            });
            
            queuesTable = $('#queuesTable').DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search queues..."
                },
                columns: [
                    { data: 'queue_id' },
                    { data: 'queue_name' },
                    { 
                        data: 'queue_type',
                        render: function(data, type, row) {
                            let badgeClass = data === 'executive' ? 'bg-primary' : 'bg-warning';
                            let displayText = data === 'executive' ? 'Executive' : 'Verifier';
                            return `<span class="queue-type-badge ${badgeClass}">${displayText}</span>`;
                        }
                    },
                    { data: 'queue_did' },
                    { data: 'queue_assigned_process' },
                    { data: 'queue_length' },
                    { 
                        data: 'queue_drop_time',
                        render: function(data, type, row) {
                            return data > 0 ? `${data}s` : 'No Drop';
                        }
                    },
                    { 
                        data: 'queue_selected',
                        render: function(data, type, row) {
                            return data === 'Y' 
                                ? '<span class="status-badge bg-success">Active</span>' 
                                : '<span class="status-badge bg-secondary">Inactive</span>';
                        }
                    },
                    { 
                        data: null,
                        render: function(data, type, row) {
                            // Simple health calculation based on queue configuration
                            let health = 'good';
                            let healthText = 'Good';
                            
                            if (!row.queue_drop_action && row.queue_drop_time > 0) {
                                health = 'warning';
                                healthText = 'Warning';
                            }
                            
                            if (row.queue_length <= 0) {
                                health = 'critical';
                                healthText = 'Critical';
                            }
                            
                            return `
                                <div class="queue-health">
                                    <span class="health-indicator health-${health}"></span>
                                    <span>${healthText}</span>
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'queue_id',
                        render: function(data, type, row) {
                            return `
                                <div class="btn-group" role="group">
                                    <button class="btn btn-outline-primary btn-action" onclick="editQueue(${data})" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-info btn-action" onclick="viewQueue(${data})" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-success btn-action" onclick="testQueue(${data})" title="Test">
                                        <i class="fas fa-play"></i>
                                    </button>
                                    <button class="btn btn-outline-warning btn-action" onclick="toggleQueueStatus(${data})" title="Toggle Status">
                                        <i class="fas fa-power-off"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-action" onclick="deleteQueue(${data})" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            `;
                        },
                        orderable: false
                    }
                ]
            });

            // Load initial data
            loadQueues();
            
            // Initialize form event listeners
            initializeFormListeners();
        });

        // Initialize form event listeners for real-time updates
        function initializeFormListeners() {
            // Update preview when form fields change
            $('#queue_name, #queue_type, #queue_did, #queue_selected, #queue_length, #queue_drop_time').on('input change', function() {
                updateQueuePreview();
            });
            
            // Initialize drop action configuration
            toggleDropActionConfig();
        }

        // Toggle drop action configuration based on selected action
        function toggleDropActionConfig() {
            const dropAction = $('#queue_drop_action').val();
            const configDiv = $('#dropActionConfig');
            const helpDiv = $('#dropActionHelp');
            
            if (!dropAction) {
                configDiv.hide();
                return;
            }
            
            let helpText = '';
            let placeholder = '';
            
            switch(dropAction) {
                case 'callforward':
                    helpText = 'Forward call to another number. Enter the destination number.';
                    placeholder = 'e.g., +1-555-0123';
                    break;
                case 'voicemail':
                    helpText = 'Send call to voicemail. Enter the voicemail extension.';
                    placeholder = 'e.g., 1001';
                    break;
                case 'queue':
                    helpText = 'Transfer call to another queue. Enter the queue name.';
                    placeholder = 'e.g., Backup-Queue';
                    break;
                case 'extension':
                    helpText = 'Transfer call to an extension. Enter the extension number.';
                    placeholder = 'e.g., 2001';
                    break;
                case 'ip':
                    helpText = 'Transfer call to an IP address. Enter the IP and port.';
                    placeholder = 'e.g., 192.168.1.100:5060';
                    break;
                case 'play':
                    helpText = 'Play a message to the caller. Enter the audio file name.';
                    placeholder = 'e.g., goodbye_message.wav';
                    break;
                case 'IVR':
                    helpText = 'Transfer call to IVR. Enter the IVR menu name.';
                    placeholder = 'e.g., main_menu';
                    break;
            }
            
            $('#queue_drop_value').attr('placeholder', placeholder);
            helpDiv.html(helpText);
            configDiv.show();
        }

        // Update queue preview
        function updateQueuePreview() {
            const name = $('#queue_name').val() || 'Queue Name';
            const type = $('#queue_type').val() === 'executive' ? 'Executive' : 'Verifier';
            const did = $('#queue_did').val() || 'Not set';
            const status = $('#queue_selected').val() === 'Y' ? 'Active' : 'Inactive';
            const statusClass = $('#queue_selected').val() === 'Y' ? 'bg-success' : 'bg-secondary';
            const length = $('#queue_length').val() || '1';
            const dropTime = $('#queue_drop_time').val() || '0';
            
            // Update visual
            $('#queueVisualType').text(`${type} Queue`);
            
            // Update preview text
            $('#previewName').text(name);
            $('#previewType').text(type);
            $('#previewDid').text(did);
            $('#previewStatus').text(status).removeClass('bg-success bg-secondary').addClass(statusClass);
            $('#previewLength').text(length);
            $('#previewDropTime').text(`${dropTime}s`);
        }

        // Generate configuration preview
        function generateConfigPreview() {
            const formData = new FormData(document.getElementById('queueForm'));
            const data = Object.fromEntries(formData);
            
            // Add checkbox values
            $('.form-check-input').each(function() {
                data[this.name] = this.checked ? 'Y' : 'N';
            });
            
            let config = `; Queue Configuration for: ${data.queue_name}\n`;
            config += `; Generated on: ${new Date().toLocaleString()}\n\n`;
            
            config += `[${data.queue_name}]\n`;
            config += `strategy = ringall\n`;
            config += `timeout = ${data.queue_drop_time || 0}\n`;
            config += `maxlen = ${data.queue_length || 1}\n`;
            
            if (data.queue_did) {
                config += `did = ${data.queue_did}\n`;
            }
            
            if (data.greeting_file_id > 0) {
                config += `announce = ${data.greeting_file_id}\n`;
            }
            
            if (data.play_queue_no === 'Y' && data.queue_no_file) {
                config += `queue_announce = ${data.queue_no_file}\n`;
            }
            
            if (data.play_hold_durn === 'Y' && data.hold_durn_file) {
                config += `hold_file = ${data.hold_durn_file}\n`;
            }
            
            if (data.playback_freq > 0) {
                config += `announce_frequency = ${data.playback_freq}\n`;
            }
            
            if (data.queue_drop_action && data.queue_drop_value) {
                config += `timeout_priority = app\n`;
                switch(data.queue_drop_action) {
                    case 'callforward':
                        config += `timeout_app = Dial\n`;
                        config += `timeout_data = SIP/${data.queue_drop_value}\n`;
                        break;
                    case 'voicemail':
                        config += `timeout_app = Voicemail\n`;
                        config += `timeout_data = ${data.queue_drop_value}\n`;
                        break;
                    case 'queue':
                        config += `timeout_app = Queue\n`;
                        config += `timeout_data = ${data.queue_drop_value}\n`;
                        break;
                    case 'extension':
                        config += `timeout_app = Dial\n`;
                        config += `timeout_data = SIP/${data.queue_drop_value}\n`;
                        break;
                    case 'ip':
                        config += `timeout_app = Dial\n`;
                        config += `timeout_data = SIP/${data.queue_drop_value}\n`;
                        break;
                    case 'play':
                        config += `timeout_app = Playback\n`;
                        config += `timeout_data = ${data.queue_drop_value}\n`;
                        break;
                    case 'IVR':
                        config += `timeout_app = Goto\n`;
                        config += `timeout_data = ivr-${data.queue_drop_value},s,1\n`;
                        break;
                }
            }
            
            if (data.ivr_id > 0) {
                config += `\n; IVR Integration\n`;
                config += `ivr_id = ${data.ivr_id}\n`;
            }
            
            document.getElementById('configPreview').textContent = config;
        }

        // Copy configuration to clipboard
        function copyConfigToClipboard() {
            const configText = document.getElementById('configPreview').textContent;
            navigator.clipboard.writeText(configText).then(function() {
                showNotification('Configuration copied to clipboard!', 'success');
            }, function(err) {
                showNotification('Failed to copy configuration', 'danger');
            });
        }

        // Show/Hide loading overlay
        function showLoading(show) {
            document.getElementById('loadingOverlay').style.display = show ? 'flex' : 'none';
        }

        // API Functions
        async function loadQueues() {
            showLoading(true);
            try {
                // In a real application, you would fetch from your API
                // const response = await fetch(`${API_BASE_URL}queues.php?action=getAll`);
                // const result = await response.json();
                
                // For demonstration, we're using sample data
                const result = { success: true, data: sampleQueues };
                
                if (result.success) {
                    queuesTable.clear().rows.add(result.data).draw();
                    updateStatistics(result.data);
                } else {
                    showNotification('Failed to load queues: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('Error loading queues:', error);
                showNotification('Error loading queues. Please check console.', 'danger');
            } finally {
                showLoading(false);
            }
        }

        async function getQueue(id) {
            showLoading(true);
            try {
                // In a real application, you would fetch from your API
                // const response = await fetch(`${API_BASE_URL}queues.php?action=get&id=${id}`);
                // const result = await response.json();
                
                // For demonstration, we're using sample data
                const queue = sampleQueues.find(q => q.queue_id == id);
                const result = { success: !!queue, data: queue };
                
                if (result.success) {
                    return result.data;
                } else {
                    showNotification('Failed to load queue: ' + result.message, 'danger');
                    return null;
                }
            } catch (error) {
                console.error('Error loading queue:', error);
                showNotification('Error loading queue. Please check console.', 'danger');
                return null;
            } finally {
                showLoading(false);
            }
        }

        async function saveQueue() {
            const formData = new FormData(document.getElementById('queueForm'));
            const data = Object.fromEntries(formData);
            
            // Add checkbox values
            $('.form-check-input').each(function() {
                data[this.name] = this.checked ? 'Y' : 'N';
            });
            
            // Validation
            if (!data.queue_name.trim()) {
                alert('Please enter a queue name');
                return;
            }
            
            if (!data.queue_type) {
                alert('Please select a queue type');
                return;
            }

            showLoading(true);
            try {
                const action = data.queue_id ? 'update' : 'create';
                
                // In a real application, you would send to your API
                // const response = await fetch(`${API_BASE_URL}queues.php?action=${action}`, {
                //     method: 'POST',
                //     headers: {
                //         'Content-Type': 'application/json'
                //     },
                //     body: JSON.stringify(data)
                // });
                // const result = await response.json();
                
                // For demonstration, we're simulating API response
                let result;
                if (action === 'create') {
                    const newId = Math.max(...sampleQueues.map(q => q.queue_id)) + 1;
                    data.queue_id = newId;
                    sampleQueues.push(data);
                    result = { success: true, message: 'Queue created successfully' };
                } else {
                    const index = sampleQueues.findIndex(q => q.queue_id == data.queue_id);
                    if (index !== -1) {
                        sampleQueues[index] = data;
                        result = { success: true, message: 'Queue updated successfully' };
                    } else {
                        result = { success: false, message: 'Queue not found' };
                    }
                }
                
                if (result.success) {
                    showNotification(`Queue ${data.queue_id ? 'updated' : 'created'} successfully!`, 'success');
                    loadQueues();
                    
                    // Close modal
                    bootstrap.Modal.getInstance(document.getElementById('queueModal')).hide();
                } else {
                    showNotification('Failed to save queue: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('Error saving queue:', error);
                showNotification('Error saving queue. Please check console.', 'danger');
            } finally {
                showLoading(false);
            }
        }

        async function deleteQueue(id) {
            if (!confirm('Are you sure you want to delete this queue?')) {
                return;
            }

            showLoading(true);
            try {
                // In a real application, you would send to your API
                // const response = await fetch(`${API_BASE_URL}queues.php?action=delete`, {
                //     method: 'POST',
                //     headers: {
                //         'Content-Type': 'application/json'
                //     },
                //     body: JSON.stringify({ queue_id: id })
                // });
                // const result = await response.json();
                
                // For demonstration, we're simulating API response
                const index = sampleQueues.findIndex(q => q.queue_id == id);
                let result;
                if (index !== -1) {
                    sampleQueues.splice(index, 1);
                    result = { success: true, message: 'Queue deleted successfully' };
                } else {
                    result = { success: false, message: 'Queue not found' };
                }
                
                if (result.success) {
                    showNotification('Queue deleted successfully!', 'success');
                    loadQueues();
                } else {
                    showNotification('Failed to delete queue: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('Error deleting queue:', error);
                showNotification('Error deleting queue. Please check console.', 'danger');
            } finally {
                showLoading(false);
            }
        }

        // UI Functions
        async function editQueue(id) {
            const queue = await getQueue(id);
            if (!queue) return;

            // Populate form
            Object.keys(queue).forEach(key => {
                const element = document.getElementById(key);
                if (element) {
                    if (element.type === 'checkbox') {
                        element.checked = queue[key] === 'Y';
                    } else {
                        element.value = queue[key];
                    }
                }
            });

            // Update modal title
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit me-2"></i>Edit Queue';
            
            // Update preview and configurations
            updateQueuePreview();
            toggleDropActionConfig();
            generateConfigPreview();

            // Show modal and activate first tab
            const modal = new bootstrap.Modal(document.getElementById('queueModal'));
            modal.show();
            const firstTab = new bootstrap.Tab(document.getElementById('basic-tab'));
            firstTab.show();
        }

        async function viewQueue(id) {
            const queue = await getQueue(id);
            if (!queue) return;

            // Create a detailed view modal
            let detailsHtml = `
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Basic Information</h6>
                        <p><strong>Queue Name:</strong> ${queue.queue_name}</p>
                        <p><strong>Type:</strong> <span class="badge ${queue.queue_type === 'executive' ? 'bg-primary' : 'bg-warning'}">${queue.queue_type === 'executive' ? 'Executive' : 'Verifier'}</span></p>
                        <p><strong>DID:</strong> ${queue.queue_did || 'Not set'}</p>
                        <p><strong>Process:</strong> ${queue.queue_assigned_process || 'Not set'}</p>
                        <p><strong>Status:</strong> <span class="badge ${queue.queue_selected === 'Y' ? 'bg-success' : 'bg-secondary'}">${queue.queue_selected === 'Y' ? 'Active' : 'Inactive'}</span></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Configuration</h6>
                        <p><strong>Queue Length:</strong> ${queue.queue_length}</p>
                        <p><strong>Drop Time:</strong> ${queue.queue_drop_time}s</p>
                        <p><strong>Drop Action:</strong> ${queue.queue_drop_action || 'None'}</p>
                        <p><strong>Overflow Queue:</strong> ${queue.queue_over_flow || 'None'}</p>
                        <p><strong>IVR ID:</strong> ${queue.ivr_id || 'None'}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="text-primary mb-3">Audio Settings</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Greeting File:</strong> ${queue.greeting_file_id || 'Not set'}</p>
                                <p><strong>Queue File:</strong> ${queue.call_queue_file_id || 'Not set'}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Play Queue No:</strong> <span class="badge ${queue.play_queue_no === 'Y' ? 'bg-success' : 'bg-secondary'}">${queue.play_queue_no === 'Y' ? 'Yes' : 'No'}</span></p>
                                <p><strong>Play Hold Duration:</strong> <span class="badge ${queue.play_hold_durn === 'Y' ? 'bg-success' : 'bg-secondary'}">${queue.play_hold_durn === 'Y' ? 'Yes' : 'No'}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            const viewModal = `
                <div class="modal fade" id="viewModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title">Queue Details - ${queue.queue_name}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                ${detailsHtml}
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" onclick="editQueue(${queue.queue_id}); bootstrap.Modal.getInstance(document.getElementById('viewModal')).hide();">
                                    <i class="fas fa-edit me-2"></i>Edit Queue
                                </button>
                                <button class="btn btn-success" onclick="testQueue(${queue.queue_id})">
                                    <i class="fas fa-play me-2"></i>Test Queue
                                </button>
                                <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i>Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Remove existing modal if any
            const existingModal = document.getElementById('viewModal');
            if (existingModal) existingModal.remove();

            // Add modal to DOM and show it
            document.body.insertAdjacentHTML('beforeend', viewModal);
            new bootstrap.Modal(document.getElementById('viewModal')).show();
        }

        function testQueue(id) {
            showLoading(true);
            // Simulate queue testing
            setTimeout(() => {
                showLoading(false);
                showNotification('Queue test completed successfully!', 'success');
            }, 2000);
        }

        function testQueueConfig() {
            showLoading(true);
            // Simulate configuration testing
            setTimeout(() => {
                showLoading(false);
                showNotification('Configuration test completed! No errors found.', 'success');
            }, 1500);
        }

        function toggleQueueStatus(id) {
            if (confirm('Are you sure you want to toggle the queue status?')) {
                showLoading(true);
                // Simulate status toggle
                setTimeout(() => {
                    showLoading(false);
                    showNotification('Queue status updated successfully!', 'success');
                    loadQueues();
                }, 1000);
            }
        }

        function updateStatistics(queues) {
            const total = queues.length;
            const executive = queues.filter(q => q.queue_type === 'executive').length;
            const verifier = queues.filter(q => q.queue_type === 'verifier').length;
            const active = queues.filter(q => q.queue_selected === 'Y').length;
            
            document.getElementById('totalQueues').textContent = total;
            document.getElementById('executiveQueues').textContent = executive;
            document.getElementById('verifierQueues').textContent = verifier;
            document.getElementById('activeQueues').textContent = active;
        }

        // Search functionality
        $('#searchInput').on('keyup', function() {
            queuesTable.search(this.value).draw();
        });

        // Filter by type
        $('#typeFilter').on('change', function() {
            queuesTable.column(2).search(this.value).draw();
        });

        // Filter by status
        $('#statusFilter').on('change', function() {
            queuesTable.column(7).search(this.value).draw();
        });

        function resetFilters() {
            $('#searchInput').val('');
            $('#typeFilter').val('');
            $('#statusFilter').val('');
            queuesTable.search('').columns().search('').draw();
        }

        function showNotification(message, type = 'info') {
            // Create toast notification
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-bg-${type === 'success' ? 'success' : type === 'danger' ? 'danger' : 'primary'} border-0`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'danger' ? 'fa-exclamation-circle' : 'fa-info-circle'} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;
            
            document.getElementById('toastContainer').appendChild(toast);
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            
            // Remove after hide
            toast.addEventListener('hidden.bs.toast', () => {
                toast.remove();
            });
        }

        // Reset form when modal is hidden
        document.getElementById('queueModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('queueForm').reset();
            document.getElementById('queue_id').value = '';
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus-circle me-2"></i>Add New Queue';
            updateQueuePreview();
            toggleDropActionConfig();
        });
    </script>
</body>
</html>