<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trunks Configuration - Asterisk PBX</title>
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
            --light-bg: #f8f9fa;
            --dark-bg: #212529;
            --glass-bg: rgba(255, 255, 255, 0.9);
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
            transform: translateY(-10px);
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
        
        .trunk-type-badge {
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
        
        .trunk-config-preview {
            background: rgba(255, 255, 255, 0.8);
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
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            font-size: 0.9rem;
            max-height: 300px;
            overflow-y: auto;
        }
        
        .trunk-visual {
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 15px;
            margin-bottom: 20px;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .trunk-visual::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L100,100 Z" fill="rgba(255,255,255,0.1)"/></svg>');
            background-size: cover;
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
        
        .delete-modal-content {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }
        
        .delete-modal-header {
            background: linear-gradient(135deg, #f72585, #b5179e);
            color: white;
            padding: 25px 30px;
        }
        
        .delete-modal-body {
            padding: 30px;
            text-align: center;
        }
        
        .delete-icon {
            font-size: 4rem;
            color: #f72585;
            margin-bottom: 20px;
        }
        
        .delete-modal-footer {
            padding: 20px 30px;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: center;
            gap: 15px;
        }
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
                    <h1 class="h3 mb-1"><i class="fas fa-satellite-dish me-2 text-primary"></i>Trunks Configuration</h1>
                    <p class="text-muted mb-0">Manage your telephony trunks and connectivity</p>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#trunkModal">
                    <i class="fas fa-plus me-1"></i> Add New Trunk
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4361ee, #3a0ca3);">
                        <i class="fas fa-satellite-dish"></i>
                    </div>
                    <div class="stat-number text-primary" id="totalTrunks">0</div>
                    <div class="stat-label">Total Trunks</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4cc9f0, #4895ef);">
                        <i class="fas fa-wifi"></i>
                    </div>
                    <div class="stat-number text-info" id="voipTrunks">0</div>
                    <div class="stat-label">VoIP Trunks</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f72585, #b5179e);">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="stat-number text-warning" id="pstnTrunks">0</div>
                    <div class="stat-label">PSTN Trunks</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #7209b7, #560bad);">
                        <i class="fas fa-server"></i>
                    </div>
                    <div class="stat-number text-secondary" id="directIpTrunks">0</div>
                    <div class="stat-label">Direct IP Trunks</div>
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
                            <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Search trunks...">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="filter-section">
                        <label class="form-label small fw-bold">Status Filter</label>
                        <select id="statusFilter" class="form-select form-select-sm">
                            <option value="">All Status</option>
                            <option value="Y">Active</option>
                            <option value="N">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="filter-section">
                        <label class="form-label small fw-bold">Type Filter</label>
                        <select id="typeFilter" class="form-select form-select-sm">
                            <option value="">All Types</option>
                            <option value="PSTN">PSTN</option>
                            <option value="VOIP">VoIP</option>
                            <option value="Direct-IP">Direct IP</option>
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
                <table id="trunksTable" class="table table-sm table-hover w-100">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Channels</th>
                            <th>Technology</th>
                            <th>Connection</th>
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

    <!-- Trunk Modal Form -->
    <div class="modal fade" id="trunkModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTitle"><i class="fas fa-satellite-dish me-2"></i>Add New Trunk</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="trunkTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">
                                <i class="fas fa-info-circle me-1"></i> Basic Info
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="configuration-tab" data-bs-toggle="tab" data-bs-target="#configuration" type="button" role="tab">
                                <i class="fas fa-cog me-1"></i> Configuration
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="advanced-tab" data-bs-toggle="tab" data-bs-target="#advanced" type="button" role="tab">
                                <i class="fas fa-sliders-h me-1"></i> Advanced
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="preview-tab" data-bs-toggle="tab" data-bs-target="#preview" type="button" role="tab">
                                <i class="fas fa-eye me-1"></i> Preview
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content mt-4" id="trunkTabsContent">
                        <div class="tab-pane fade show active" id="basic" role="tabpanel">
                            <form id="trunkForm" class="compact-form">
                                <input type="hidden" id="trunk_id" name="trunk_id">
                                
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-section">
                                            <div class="section-title">
                                                <i class="fas fa-info-circle"></i> Basic Information
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="trunk_name" class="form-label required-field">Trunk Name</label>
                                                        <input type="text" class="form-control" id="trunk_name" name="trunk_name" required maxlength="100" placeholder="e.g., Primary-VoIP-Trunk">
                                                        <small class="form-text text-muted">Unique identifier for this trunk</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="trunk_description" class="form-label">Description</label>
                                                        <input type="text" class="form-control" id="trunk_description" name="trunk_description" maxlength="100" placeholder="e.g., Main VoIP connection to provider">
                                                        <small class="form-text text-muted">Short description of this trunk</small>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row g-3 mt-2">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="trunk_active" class="form-label required-field">Status</label>
                                                        <select class="form-select" id="trunk_active" name="trunk_active" required>
                                                            <option value="Y">Active</option>
                                                            <option value="N">Inactive</option>
                                                        </select>
                                                        <small class="form-text text-muted">Set trunk active status</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="channels" class="form-label required-field">Channels</label>
                                                        <input type="number" class="form-control" id="channels" name="channels" value="1" min="1" max="100" required>
                                                        <small class="form-text text-muted">Number of simultaneous channels</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-section">
                                            <div class="section-title">
                                                <i class="fas fa-network-wired"></i> Trunk Type
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="trunk_type" class="form-label required-field">Connection Type</label>
                                                        <select class="form-select" id="trunk_type" name="trunk_type" required onchange="toggleTrunkConfig()">
                                                            <option value="PSTN">PSTN (Traditional Phone Line)</option>
                                                            <option value="VOIP">VoIP (Voice over IP)</option>
                                                            <option value="Direct-IP">Direct IP Connection</option>
                                                        </select>
                                                        <small class="form-text text-muted">Select the type of trunk connection</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="trunk-visual">
                                            <div class="text-center">
                                                <i class="fas fa-satellite-dish fa-3x mb-2"></i>
                                                <div>Trunk Preview</div>
                                                <small id="trunkVisualType">PSTN Connection</small>
                                            </div>
                                        </div>
                                        
                                        <div class="trunk-config-preview">
                                            <div class="preview-title">
                                                <i class="fas fa-bolt me-2"></i>Quick Stats
                                            </div>
                                            <div class="preview-content">
                                                <div><strong>Type:</strong> <span id="previewType">PSTN</span></div>
                                                <div><strong>Status:</strong> <span id="previewStatus" class="badge bg-success">Active</span></div>
                                                <div><strong>Channels:</strong> <span id="previewChannels">1</span></div>
                                                <div><strong>Technology:</strong> <span id="previewTech">dahdi</span></div>
                                                <div><strong>Connection:</strong> <span id="previewConnection">Ready</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <div class="tab-pane fade" id="configuration" role="tabpanel">
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-cog"></i> Connection Configuration
                                </div>
                                
                                <!-- PSTN Configuration -->
                                <div id="pstnConfig" class="trunk-config-section">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pstn_technology" class="form-label required-field">PSTN Technology</label>
                                                <select class="form-select" id="pstn_technology" name="pstn_technology">
                                                    <option value="dahdi">DAHDI</option>
                                                    <option value="zap">Zap</option>
                                                </select>
                                                <small class="form-text text-muted">Select the PSTN technology</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pstn_zap_dahdi_id" class="form-label required-field">DAHDI/Zap ID</label>
                                                <input type="text" class="form-control" id="pstn_zap_dahdi_id" name="pstn_zap_dahdi_id" maxlength="20" placeholder="e.g., g0">
                                                <small class="form-text text-muted">Enter the DAHDI or Zap identifier</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- VoIP Configuration -->
                                <div id="voipConfig" class="trunk-config-section" style="display: none;">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="voip_custom_settings" class="form-label">Custom Settings</label>
                                                <select class="form-select" id="voip_custom_settings" name="voip_custom_settings">
                                                    <option value="N">Use Default Settings</option>
                                                    <option value="Y">Use Custom Settings</option>
                                                </select>
                                                <small class="form-text text-muted">Enable custom VoIP configuration</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="voip_type" class="form-label">VoIP Type</label>
                                                <select class="form-select" id="voip_type" name="voip_type">
                                                    <option value="peer">Peer</option>
                                                    <option value="friend">Friend</option>
                                                </select>
                                                <small class="form-text text-muted">Select the VoIP connection type</small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="connection-line"></div>
                                    
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="voip_account_id" class="form-label">Account ID</label>
                                                <input type="text" class="form-control" id="voip_account_id" name="voip_account_id" maxlength="20" placeholder="e.g., myvoipaccount">
                                                <small class="form-text text-muted">VoIP provider account ID</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="voip_password" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="voip_password" name="voip_password" maxlength="20" placeholder="VoIP account password">
                                                <small class="form-text text-muted">VoIP provider password</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="voip_host_ip_address" class="form-label">Host IP</label>
                                                <input type="text" class="form-control" id="voip_host_ip_address" name="voip_host_ip_address" maxlength="20" placeholder="e.g., 192.168.1.100">
                                                <small class="form-text text-muted">VoIP provider server IP</small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row g-3 mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="voip_context" class="form-label">Context</label>
                                                <input type="text" class="form-control" id="voip_context" name="voip_context" maxlength="20" placeholder="e.g., from-voip-provider">
                                                <small class="form-text text-muted">Dialplan context for this trunk</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Direct IP Configuration -->
                                <div id="directIpConfig" class="trunk-config-section" style="display: none;">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="direct_ip_address" class="form-label required-field">IP Address</label>
                                                <input type="text" class="form-control" id="direct_ip_address" name="direct_ip_address" maxlength="20" placeholder="e.g., 192.168.1.50">
                                                <small class="form-text text-muted">Direct IP address of the remote system</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="advanced" role="tabpanel">
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-sliders-h"></i> Advanced Settings
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="voip_account_details" class="form-label">Custom Account Details</label>
                                            <textarea class="form-control" id="voip_account_details" name="voip_account_details" rows="8" placeholder="Enter custom SIP configuration..."></textarea>
                                            <small class="form-text text-muted">Additional SIP configuration parameters (optional)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="preview" role="tabpanel">
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-eye"></i> Configuration Preview
                                </div>
                                
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    This is a preview of how your trunk configuration will appear in the system.
                                </div>
                                
                                <div class="trunk-config-preview">
                                    <div class="preview-title">
                                        <i class="fas fa-code me-2"></i>Generated Configuration
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveTrunk()">
                        <i class="fas fa-save me-1"></i> Save Trunk
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content delete-modal-content">
                <div class="delete-modal-header">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="delete-modal-body">
                    <div class="delete-icon">
                        <i class="fas fa-trash-alt"></i>
                    </div>
                    <h4 class="mb-3">Delete Trunk</h4>
                    <p>Are you sure you want to delete the trunk <strong id="trunkToDeleteName">[Trunk Name]</strong>?</p>
                    <p class="text-danger"><small>This action cannot be undone. All configuration associated with this trunk will be permanently removed.</small></p>
                </div>
                <div class="delete-modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash me-1"></i> Delete Trunk
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
        const API_BASE_URL = 'api/trunks/'; // Adjust this to your API endpoint
        
        // Sample data for demonstration
        let sampleTrunks = [
            {
                trunk_id: 1,
                trunk_name: 'Primary-VoIP',
                trunk_description: 'Main VoIP connection to provider',
                trunk_active: 'Y',
                trunk_type: 'VOIP',
                direct_ip_address: '',
                pstn_technology: 'dahdi',
                pstn_zap_dahdi_id: '',
                voip_custom_settings: 'N',
                voip_account_id: 'myvoipaccount',
                voip_password: 'secret123',
                voip_host_ip_address: '192.168.1.100',
                voip_type: 'peer',
                voip_context: 'from-voip-provider',
                voip_account_details: 'qualify=yes\ncanreinvite=no',
                channels: 5
            },
            {
                trunk_id: 2,
                trunk_name: 'Backup-PSTN',
                trunk_description: 'Backup PSTN connection',
                trunk_active: 'Y',
                trunk_type: 'PSTN',
                direct_ip_address: '',
                pstn_technology: 'dahdi',
                pstn_zap_dahdi_id: 'g0',
                voip_custom_settings: 'N',
                voip_account_id: '',
                voip_password: '',
                voip_host_ip_address: '',
                voip_type: 'peer',
                voip_context: '',
                voip_account_details: '',
                channels: 2
            },
            {
                trunk_id: 3,
                trunk_name: 'Direct-Connection',
                trunk_description: 'Direct IP to branch office',
                trunk_active: 'N',
                trunk_type: 'Direct-IP',
                direct_ip_address: '10.0.1.50',
                pstn_technology: 'dahdi',
                pstn_zap_dahdi_id: '',
                voip_custom_settings: 'N',
                voip_account_id: '',
                voip_password: '',
                voip_host_ip_address: '',
                voip_type: 'peer',
                voip_context: '',
                voip_account_details: '',
                channels: 1
            }
        ];

        // Global variable to track trunk to delete
        let trunkToDelete = null;

        // Initialize DataTable
        let trunksTable;
        $(document).ready(function() {
            // Initialize Select2
            $('.form-select').select2({
                width: '100%',
                theme: 'bootstrap-5'
            });
            
            trunksTable = $('#trunksTable').DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search trunks..."
                },
                columns: [
                    { data: 'trunk_id' },
                    { data: 'trunk_name' },
                    { data: 'trunk_description' },
                    { 
                        data: 'trunk_type',
                        render: function(data, type, row) {
                            let badgeClass = 'bg-primary';
                            if (data === 'VOIP') badgeClass = 'bg-info';
                            if (data === 'PSTN') badgeClass = 'bg-warning';
                            if (data === 'Direct-IP') badgeClass = 'bg-secondary';
                            
                            return `<span class="trunk-type-badge ${badgeClass}">${data}</span>`;
                        }
                    },
                    { 
                        data: 'trunk_active',
                        render: function(data, type, row) {
                            return data === 'Y' 
                                ? '<span class="status-badge bg-success">Active</span>' 
                                : '<span class="status-badge bg-danger">Inactive</span>';
                        }
                    },
                    { data: 'channels' },
                    { 
                        data: 'pstn_technology',
                        render: function(data, type, row) {
                            if (row.trunk_type === 'PSTN') {
                                return data === 'dahdi' ? 'DAHDI' : 'Zap';
                            }
                            return '-';
                        }
                    },
                    { 
                        data: 'trunk_type',
                        render: function(data, type, row) {
                            if (data === 'VOIP') return row.voip_host_ip_address;
                            if (data === 'PSTN') return row.pstn_zap_dahdi_id;
                            if (data === 'Direct-IP') return row.direct_ip_address;
                            return '-';
                        }
                    },
                    {
                        data: 'trunk_id',
                        render: function(data, type, row) {
                            return `
                                <div class="btn-group" role="group">
                                    <button class="btn btn-outline-primary btn-action" onclick="editTrunk(${data})" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-info btn-action" onclick="viewTrunk(${data})" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-success btn-action" onclick="testTrunk(${data})" title="Test">
                                        <i class="fas fa-play"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-action" onclick="deleteTrunk(${data})" title="Delete">
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
            loadTrunks();
            
            // Initialize trunk type configuration
            toggleTrunkConfig();
            
            // Set up delete confirmation handler
            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                if (!trunkToDelete) return;
                
                // Close the confirmation modal
                bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal')).hide();
                
                // Proceed with deletion
                performDeleteTrunk(trunkToDelete);
                trunkToDelete = null;
            });
        });

        // Show/Hide loading overlay
        function showLoading(show) {
            document.getElementById('loadingOverlay').style.display = show ? 'flex' : 'none';
        }

        // Toggle trunk configuration based on type
        function toggleTrunkConfig() {
            const trunkType = document.getElementById('trunk_type').value;
            
            // Hide all config sections
            document.getElementById('pstnConfig').style.display = 'none';
            document.getElementById('voipConfig').style.display = 'none';
            document.getElementById('directIpConfig').style.display = 'none';
            
            // Show relevant config section
            if (trunkType === 'PSTN') {
                document.getElementById('pstnConfig').style.display = 'block';
                document.getElementById('trunkVisualType').textContent = 'PSTN Connection';
            } else if (trunkType === 'VOIP') {
                document.getElementById('voipConfig').style.display = 'block';
                document.getElementById('trunkVisualType').textContent = 'VoIP Connection';
            } else if (trunkType === 'Direct-IP') {
                document.getElementById('directIpConfig').style.display = 'block';
                document.getElementById('trunkVisualType').textContent = 'Direct IP Connection';
            }
            
            // Update preview
            updatePreview();
        }

        // Update preview information
        function updatePreview() {
            document.getElementById('previewType').textContent = document.getElementById('trunk_type').value;
            document.getElementById('previewStatus').textContent = document.getElementById('trunk_active').value === 'Y' ? 'Active' : 'Inactive';
            document.getElementById('previewStatus').className = document.getElementById('trunk_active').value === 'Y' ? 'badge bg-success' : 'badge bg-danger';
            document.getElementById('previewChannels').textContent = document.getElementById('channels').value;
            
            const trunkType = document.getElementById('trunk_type').value;
            if (trunkType === 'PSTN') {
                document.getElementById('previewTech').textContent = document.getElementById('pstn_technology').value;
                document.getElementById('previewConnection').textContent = document.getElementById('pstn_zap_dahdi_id').value || 'Not set';
            } else if (trunkType === 'VOIP') {
                document.getElementById('previewTech').textContent = 'SIP';
                document.getElementById('previewConnection').textContent = document.getElementById('voip_host_ip_address').value || 'Not set';
            } else {
                document.getElementById('previewTech').textContent = 'IP';
                document.getElementById('previewConnection').textContent = document.getElementById('direct_ip_address').value || 'Not set';
            }
        }

        // Generate configuration preview
        function generateConfigPreview() {
            const formData = new FormData(document.getElementById('trunkForm'));
            const data = Object.fromEntries(formData);
            
            let config = `; Trunk Configuration for: ${data.trunk_name}\n`;
            config += `; Generated on: ${new Date().toLocaleString()}\n\n`;
            
            if (data.trunk_type === 'PSTN') {
                config += `[${data.trunk_name}]\n`;
                config += `type = pstn\n`;
                config += `technology = ${data.pstn_technology}\n`;
                config += `channel = ${data.pstn_zap_dahdi_id}\n`;
                config += `context = from-pstn\n`;
                config += `channels = ${data.channels}\n`;
            } else if (data.trunk_type === 'VOIP') {
                config += `[${data.trunk_name}]\n`;
                config += `type = friend\n`;
                config += `host = ${data.voip_host_ip_address}\n`;
                config += `username = ${data.voip_account_id}\n`;
                config += `secret = ${data.voip_password}\n`;
                config += `context = ${data.voip_context}\n`;
                config += `qualify = yes\n`;
                config += `canreinvite = no\n`;
                
                if (data.voip_account_details) {
                    config += `\n; Custom settings\n`;
                    config += data.voip_account_details;
                }
            } else if (data.trunk_type === 'Direct-IP') {
                config += `[${data.trunk_name}]\n`;
                config += `type = peer\n`;
                config += `host = ${data.direct_ip_address}\n`;
                config += `context = from-direct\n`;
                config += `directmedia = no\n`;
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

        // API Functions
        async function loadTrunks() {
            showLoading(true);
            try {
                // In a real application, you would fetch from your API
                // const response = await fetch(`${API_BASE_URL}trunks.php?action=getAll`);
                // const result = await response.json();
                
                // For demonstration, we're using sample data
                const result = { success: true, data: sampleTrunks };
                
                if (result.success) {
                    trunksTable.clear().rows.add(result.data).draw();
                    updateStatistics(result.data);
                } else {
                    showNotification('Failed to load trunks: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('Error loading trunks:', error);
                showNotification('Error loading trunks. Please check console.', 'danger');
            } finally {
                showLoading(false);
            }
        }

        async function getTrunk(id) {
            showLoading(true);
            try {
                // In a real application, you would fetch from your API
                // const response = await fetch(`${API_BASE_URL}trunks.php?action=get&id=${id}`);
                // const result = await response.json();
                
                // For demonstration, we're using sample data
                const trunk = sampleTrunks.find(t => t.trunk_id == id);
                const result = { success: !!trunk, data: trunk };
                
                if (result.success) {
                    return result.data;
                } else {
                    showNotification('Failed to load trunk: ' + result.message, 'danger');
                    return null;
                }
            } catch (error) {
                console.error('Error loading trunk:', error);
                showNotification('Error loading trunk. Please check console.', 'danger');
                return null;
            } finally {
                showLoading(false);
            }
        }

        async function saveTrunk() {
            const formData = new FormData(document.getElementById('trunkForm'));
            const data = Object.fromEntries(formData);
            
            // Validation
            if (!data.trunk_name.trim()) {
                alert('Please enter a trunk name');
                return;
            }
            
            if (!data.trunk_type) {
                alert('Please select a trunk type');
                return;
            }

            showLoading(true);
            try {
                const action = data.trunk_id ? 'update' : 'create';
                
                // In a real application, you would send to your API
                // const response = await fetch(`${API_BASE_URL}trunks.php?action=${action}`, {
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
                    const newId = Math.max(...sampleTrunks.map(t => t.trunk_id)) + 1;
                    data.trunk_id = newId;
                    sampleTrunks.push(data);
                    result = { success: true, message: 'Trunk created successfully' };
                } else {
                    const index = sampleTrunks.findIndex(t => t.trunk_id == data.trunk_id);
                    if (index !== -1) {
                        sampleTrunks[index] = data;
                        result = { success: true, message: 'Trunk updated successfully' };
                    } else {
                        result = { success: false, message: 'Trunk not found' };
                    }
                }
                
                if (result.success) {
                    showNotification(`Trunk ${data.trunk_id ? 'updated' : 'created'} successfully!`, 'success');
                    loadTrunks();
                    
                    // Close modal
                    bootstrap.Modal.getInstance(document.getElementById('trunkModal')).hide();
                } else {
                    showNotification('Failed to save trunk: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('Error saving trunk:', error);
                showNotification('Error saving trunk. Please check console.', 'danger');
            } finally {
                showLoading(false);
            }
        }

        // Enhanced delete function with confirmation modal
        function deleteTrunk(id) {
            const trunk = sampleTrunks.find(t => t.trunk_id == id);
            if (!trunk) return;
            
            trunkToDelete = id;
            document.getElementById('trunkToDeleteName').textContent = trunk.trunk_name;
            
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            deleteModal.show();
        }

        // Perform the actual deletion
        async function performDeleteTrunk(id) {
            showLoading(true);
            try {
                // In a real application, you would send to your API
                // const response = await fetch(`${API_BASE_URL}trunks.php?action=delete`, {
                //     method: 'POST',
                //     headers: {
                //         'Content-Type': 'application/json'
                //     },
                //     body: JSON.stringify({ trunk_id: id })
                // });
                // const result = await response.json();
                
                // For demonstration, we're simulating API response
                const index = sampleTrunks.findIndex(t => t.trunk_id == id);
                let result;
                if (index !== -1) {
                    const trunkName = sampleTrunks[index].trunk_name;
                    sampleTrunks.splice(index, 1);
                    result = { success: true, message: 'Trunk deleted successfully' };
                    
                    showNotification(`Trunk "${trunkName}" deleted successfully!`, 'success');
                } else {
                    result = { success: false, message: 'Trunk not found' };
                    showNotification('Failed to delete trunk: ' + result.message, 'danger');
                }
                
                if (result.success) {
                    loadTrunks();
                }
            } catch (error) {
                console.error('Error deleting trunk:', error);
                showNotification('Error deleting trunk. Please check console.', 'danger');
            } finally {
                showLoading(false);
            }
        }

        // UI Functions
        async function editTrunk(id) {
            const trunk = await getTrunk(id);
            if (!trunk) return;

            // Populate form
            Object.keys(trunk).forEach(key => {
                const element = document.getElementById(key);
                if (element) element.value = trunk[key];
            });

            // Update modal title
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit me-2"></i>Edit Trunk';
            
            // Update trunk type configuration
            toggleTrunkConfig();
            
            // Update preview
            updatePreview();
            generateConfigPreview();

            // Show modal and activate first tab
            const modal = new bootstrap.Modal(document.getElementById('trunkModal'));
            modal.show();
            const firstTab = new bootstrap.Tab(document.getElementById('basic-tab'));
            firstTab.show();
        }

        async function viewTrunk(id) {
            const trunk = await getTrunk(id);
            if (!trunk) return;

            // Create a simple view modal
            let detailsHtml = '';
            Object.keys(trunk).forEach(key => {
                if (key !== 'trunk_id') {
                    const formattedKey = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                    let value = trunk[key];
                    
                    // Format status and type
                    if (key === 'trunk_active') {
                        value = value === 'Y' ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                    }
                    if (key === 'trunk_type') {
                        let badgeClass = 'bg-primary';
                        if (value === 'VOIP') badgeClass = 'bg-info';
                        if (value === 'PSTN') badgeClass = 'bg-warning';
                        value = `<span class="badge ${badgeClass}">${value}</span>`;
                    }
                    
                    detailsHtml += `<p><strong>${formattedKey}:</strong> ${value}</p>`;
                }
            });

            const viewModal = `
                <div class="modal fade" id="viewModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title">Trunk Details - ID: ${trunk.trunk_id}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        ${detailsHtml}
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">Quick Actions</h6>
                                            </div>
                                            <div class="card-body">
                                                <button class="btn btn-primary w-100 mb-2" onclick="editTrunk(${trunk.trunk_id}); bootstrap.Modal.getInstance(document.getElementById('viewModal')).hide();">
                                                    <i class="fas fa-edit me-2"></i>Edit Trunk
                                                </button>
                                                <button class="btn btn-success w-100 mb-2" onclick="testTrunk(${trunk.trunk_id});">
                                                    <i class="fas fa-play me-2"></i>Test Connection
                                                </button>
                                                <button class="btn btn-outline-secondary w-100" data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-2"></i>Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

        function testTrunk(id) {
            showLoading(true);
            // Simulate testing
            setTimeout(() => {
                showLoading(false);
                showNotification('Trunk connection test completed successfully!', 'success');
            }, 2000);
        }

        function updateStatistics(trunks) {
            const total = trunks.length;
            const voip = trunks.filter(t => t.trunk_type === 'VOIP').length;
            const pstn = trunks.filter(t => t.trunk_type === 'PSTN').length;
            const directIp = trunks.filter(t => t.trunk_type === 'Direct-IP').length;
            
            document.getElementById('totalTrunks').textContent = total;
            document.getElementById('voipTrunks').textContent = voip;
            document.getElementById('pstnTrunks').textContent = pstn;
            document.getElementById('directIpTrunks').textContent = directIp;
        }

        // Search functionality
        $('#searchInput').on('keyup', function() {
            trunksTable.search(this.value).draw();
        });

        // Filter by status
        $('#statusFilter').on('change', function() {
            trunksTable.column(4).search(this.value).draw();
        });

        // Filter by type
        $('#typeFilter').on('change', function() {
            trunksTable.column(3).search(this.value).draw();
        });

        function resetFilters() {
            $('#searchInput').val('');
            $('#statusFilter').val('');
            $('#typeFilter').val('');
            trunksTable.search('').columns().search('').draw();
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

        // Event listeners for real-time preview updates
        document.getElementById('trunkForm').addEventListener('input', function() {
            updatePreview();
        });

        // Reset form when modal is hidden
        document.getElementById('trunkModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('trunkForm').reset();
            document.getElementById('trunk_id').value = '';
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus me-2"></i>Add New Trunk';
            toggleTrunkConfig();
        });
    </script>
</body>
</html>