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
            border-bottom: none;
        }
        
        .modal-title {
            font-size: 1rem;
            font-weight: 600;
        }
        
        .modal-body {
            padding: 0;
        }
        
        .modal-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid #dee2e6;
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

        /* Rich Modify Form Styles */
        .modify-form-container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        .form-section-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1rem 1.5rem;
            margin-bottom: 0;
            font-size: 1rem;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-section-body {
            padding: 1.5rem;
            background: #f8f9fa;
        }

        .form-card {
            background: white;
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border: 1px solid #e9ecef;
        }

        .form-card-header {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .form-group-enhanced {
            margin-bottom: 1rem;
        }

        .form-group-enhanced label {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-weight: 600;
            margin-bottom: 0.4rem;
        }

        .required-star {
            color: var(--danger-color);
        }

        .form-control-enhanced {
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 0.6rem 0.75rem;
            font-size: 0.8rem;
            transition: all 0.2s ease;
            background: white;
        }

        .form-control-enhanced:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.15);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .checkbox-group label {
            margin-bottom: 0;
            font-weight: normal;
        }

        .timeout-input {
            width: 80px;
            display: inline-block;
            margin-left: 0.5rem;
        }

        .range-text {
            font-size: 0.7rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }

        .settings-tabs {
            background: white;
            border-bottom: 1px solid #dee2e6;
            padding: 0 1.5rem;
        }

        .settings-tabs .nav-link {
            font-size: 0.8rem;
            padding: 0.75rem 1rem;
            border: none;
            color: #6c757d;
            font-weight: 500;
            border-radius: 0;
            background: none;
        }

        .settings-tabs .nav-link.active {
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
            background: none;
        }

        .tab-content {
            padding: 1.5rem;
        }

        .dual-select-container {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 1rem;
            align-items: start;
        }

        .select-box {
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 0.75rem;
            background: white;
        }

        .select-box-header {
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }

        .select-list {
            height: 200px;
            width: 100%;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            padding: 0.5rem;
            font-size: 0.8rem;
        }

        .transfer-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            justify-content: center;
            height: 200px;
        }

        .section-divider {
            border: none;
            height: 1px;
            background: linear-gradient(90deg, transparent, #dee2e6, transparent);
            margin: 1.5rem 0;
        }

        .advanced-toggle {
            background: none;
            border: none;
            color: var(--primary-color);
            font-size: 0.8rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0;
        }

        .advanced-settings {
            background: #f8f9fa;
            border-radius: 6px;
            padding: 1rem;
            margin-top: 1rem;
            border-left: 3px solid var(--primary-color);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .btn-action {
                margin-bottom: 0.25rem;
            }
            
            .stat-card {
                margin-bottom: 1rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .dual-select-container {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }

            .transfer-buttons {
                flex-direction: row;
                height: auto;
                justify-content: center;
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
                            <th>Description</th>
                            <th>Type</th>
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

    <!-- Add Process Modal (Simple Form) -->
    <div class="modal fade" id="addProcessModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Add New Process</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addProcessForm" style="padding: 10px;">
                        <div class="mb-3">
                            <label for="new_process" class="form-label required-field">Process Name</label>
                            <input type="text" class="form-control form-control-sm" id="new_process" name="process" required maxlength="50" placeholder="e.g., Sales-Campaign">
                            <div class="validation-error" id="processError">Process name is required</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="new_process_description" class="form-label">Process Description</label>
                            <textarea class="form-control form-control-sm" id="new_process_description" name="process_description" maxlength="250" rows="3" placeholder="Process description"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="new_active" class="form-label">Status</label>
                            <select class="form-select form-select-sm" id="new_active" name="active">
                                <option value="Y">Active</option>
                                <option value="N">Inactive</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="createProcess()">
                        <i class="fas fa-save me-1"></i> Create Process
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modify Process Modal (Rich Form) -->
    <div class="modal fade" id="modifyProcessModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content modify-form-container">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Modify Process</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="settings-tabs">
                    <ul class="nav nav-tabs" id="modifyTabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#basic-settings">
                                <i class="fas fa-cog me-1"></i>Basic Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#outbound-settings">
                                <i class="fas fa-sign-out-alt me-1"></i>Outbound
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#inbound-settings">
                                <i class="fas fa-sign-in-alt me-1"></i>Inbound
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#advanced-settings">
                                <i class="fas fa-sliders-h me-1"></i>Advanced
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content">
                    <!-- Basic Settings Tab -->
                    <div class="tab-pane fade show active" id="basic-settings">
                        <div class="form-card">
                            <div class="form-card-header">
                                <i class="fas fa-info-circle"></i>Process Information
                            </div>
                            <div class="form-grid">
                                <div class="form-group-enhanced">
                                    <label>Process Name <span class="required-star">*</span></label>
                                    <input type="text" class="form-control-enhanced" id="modify_process" readonly>
                                </div>
                                <div class="form-group-enhanced">
                                    <label>Inbound DID <span class="required-star">*</span></label>
                                    <input type="text" class="form-control-enhanced" id="modify_inbound_did" value="101">
                                </div>
                                <div class="form-group-enhanced">
                                    <label>Status</label>
                                    <select class="form-control-enhanced" id="modify_active">
                                        <option value="Y">Active</option>
                                        <option value="N">Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group-enhanced">
                                    <label>Process Type <span class="required-star">*</span></label>
                                    <select class="form-control-enhanced" id="modify_process_type">
                                        <optgroup label="InComing">
                                            <option value="Inbound">Inbound & Manual Out Dial</option>
                                        </optgroup>
                                        <optgroup label="Only Outgoing">
                                            <option value="O_Predictive">Outbound - Predictive</option>
                                            <option value="O_Preview">Outbound - Preview</option>
                                            <option value="O_Progressive">Outbound - Progressive</option>
                                        </optgroup>
                                        <optgroup label="Blended">
                                            <option value="B_Predictive">Blended - Predictive</option>
                                            <option value="B_Preview">Blended - Preview</option>
                                            <option value="B_Progressive">Blended - Progressive</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group-enhanced">
                                <label>Process Description</label>
                                <textarea class="form-control-enhanced" id="modify_process_description" rows="3" placeholder="Enter process description"></textarea>
                            </div>
                        </div>

                        <div class="form-card">
                            <div class="form-card-header">
                                <i class="fas fa-wrench"></i>Configuration
                            </div>
                            <div class="form-grid">
                                <div class="form-group-enhanced">
                                    <label>Channels</label>
                                    <input type="number" class="form-control-enhanced" id="modify_channels" value="30" min="1" max="120">
                                    <div class="range-text">Range: 1-120</div>
                                </div>
                                <div class="form-group-enhanced">
                                    <label>CRM</label>
                                    <select class="form-control-enhanced" id="modify_crm_id">
                                        <option value="">Select CRM</option>
                                        <option value="1001">ConVox CRM</option>
                                        <option value="1002">SalesForce</option>
                                        <option value="1003">HubSpot</option>
                                    </select>
                                </div>
                                <div class="form-group-enhanced">
                                    <label>Script</label>
                                    <select class="form-control-enhanced" id="modify_process_script">
                                        <option value="">-- Select Script --</option>
                                        <option value="sales">Sales Script</option>
                                        <option value="support">Support Script</option>
                                        <option value="collections">Collections Script</option>
                                    </select>
                                </div>
                                <div class="form-group-enhanced">
                                    <label>Web Form Type</label>
                                    <select class="form-control-enhanced" id="modify_webform_type">
                                        <option value="SHOW">SHOW</option>
                                        <option value="SHOW_WITH_ENDCALL">SHOW WITH ENDCALL</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Outbound Settings Tab -->
                    <div class="tab-pane fade" id="outbound-settings">
                        <div class="form-card">
                            <div class="form-card-header">
                                <i class="fas fa-bullhorn"></i>Outbound Configuration
                            </div>
                            <div class="form-grid">
                                <div class="form-group-enhanced">
                                    <label>Dial Prefix</label>
                                    <input type="text" class="form-control-enhanced" id="modify_dial_prefix" value="3301" maxlength="4">
                                    <div class="range-text">Strictly 4 digits</div>
                                </div>
                                <div class="form-group-enhanced">
                                    <label>Caller ID</label>
                                    <input type="text" class="form-control-enhanced" id="modify_callerid" value="1234">
                                </div>
                                <div class="form-group-enhanced">
                                    <label>Buffer Level</label>
                                    <input type="number" class="form-control-enhanced" id="modify_buffer_level" value="1" min="0" max="100">
                                </div>
                                <div class="form-group-enhanced">
                                    <label>Lead Order</label>
                                    <select class="form-control-enhanced" id="modify_lead_order">
                                        <option value="leads_by_asc">Lead By Ascending</option>
                                        <option value="leads_by_desc">Lead By Descending</option>
                                        <option value="random">Random</option>
                                        <option value="first_dial_least_called">First Dial Least Called</option>
                                        <option value="first_dial_max_called">First Dial Max Called</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Inbound Settings Tab -->
                    <div class="tab-pane fade" id="inbound-settings">
                        <div class="form-card">
                            <div class="form-card-header">
                                <i class="fas fa-phone-volume"></i>Inbound Configuration
                            </div>
                            <div class="form-grid">
                                <div class="form-group-enhanced">
                                    <label>Greeting File</label>
                                    <select class="form-control-enhanced" id="modify_greeting_file">
                                        <option value="">Select Greeting File</option>
                                        <option value="welcome">Welcome Message</option>
                                        <option value="support">Support Greeting</option>
                                        <option value="sales">Sales Greeting</option>
                                    </select>
                                </div>
                                <div class="form-group-enhanced">
                                    <label>Accept Input Greeting</label>
                                    <select class="form-control-enhanced" id="modify_greeting_accept">
                                        <option value="Y">Yes</option>
                                        <option value="N">No</option>
                                    </select>
                                </div>
                                <div class="form-group-enhanced">
                                    <label>Time Out (seconds)</label>
                                    <input type="number" class="form-control-enhanced" id="modify_time_out" value="1" min="1" max="60">
                                </div>
                                <div class="form-group-enhanced">
                                    <label>Retries</label>
                                    <select class="form-control-enhanced" id="modify_retries">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Advanced Settings Tab -->
                    <div class="tab-pane fade" id="advanced-settings">
                        <div class="form-card">
                            <div class="form-card-header">
                                <i class="fas fa-clock"></i>Auto Settings
                            </div>
                            <div class="form-grid">
                                <div class="form-group-enhanced">
                                    <div class="checkbox-group">
                                        <input type="checkbox" id="modify_auto_wp" checked>
                                        <label>Auto Wrapup</label>
                                    </div>
                                    <input type="number" class="form-control-enhanced timeout-input" id="modify_wp_time" value="10" min="5" max="600">
                                    <div class="range-text">Range: 5-600 seconds</div>
                                </div>
                                <div class="form-group-enhanced">
                                    <div class="checkbox-group">
                                        <input type="checkbox" id="modify_auto_mp" checked>
                                        <label>Auto Missed</label>
                                    </div>
                                    <input type="number" class="form-control-enhanced timeout-input" id="modify_mp_time" value="10" min="5" max="600">
                                    <div class="range-text">Range: 5-600 seconds</div>
                                </div>
                                <div class="form-group-enhanced">
                                    <div class="checkbox-group">
                                        <input type="checkbox" id="modify_auto_op" checked>
                                        <label>Auto Outbound</label>
                                    </div>
                                    <input type="number" class="form-control-enhanced timeout-input" id="modify_op_time" value="15" min="5" max="600">
                                    <div class="range-text">Range: 5-600 seconds</div>
                                </div>
                                <div class="form-group-enhanced">
                                    <div class="checkbox-group">
                                        <input type="checkbox" id="modify_auto_fp" checked>
                                        <label>Auto FirstLogin</label>
                                    </div>
                                    <input type="number" class="form-control-enhanced timeout-input" id="modify_fp_time" value="15" min="5" max="600">
                                    <div class="range-text">Range: 5-600 seconds</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-card">
                            <div class="form-card-header">
                                <i class="fas fa-shield-alt"></i>Security & Compliance
                            </div>
                            <div class="form-grid">
                                <div class="form-group-enhanced">
                                    <label>DNC Enable</label>
                                    <select class="form-control-enhanced" id="modify_dnc_enable">
                                        <option value="Y">Yes</option>
                                        <option value="N">No</option>
                                    </select>
                                </div>
                                <div class="form-group-enhanced">
                                    <label>Number Masking</label>
                                    <select class="form-control-enhanced" id="modify_num_masking">
                                        <option value="Y">Yes</option>
                                        <option value="N">No</option>
                                    </select>
                                </div>
                                <div class="form-group-enhanced">
                                    <label>Agent Wise Dialing</label>
                                    <select class="form-control-enhanced" id="modify_agent_wise_dialing">
                                        <option value="Y">Yes</option>
                                        <option value="N">No</option>
                                    </select>
                                </div>
                                <div class="form-group-enhanced">
                                    <label>List Selection</label>
                                    <select class="form-control-enhanced" id="modify_list_select">
                                        <option value="SERIAL">Serial</option>
                                        <option value="SHUFFLE">Shuffle</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="saveModifiedProcess()">
                        <i class="fas fa-save me-1"></i> Save Changes
                    </button>
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

            // Load initial data
            loadProcesses();
        });

        // Load processes from API
        function loadProcesses() {
            showLoading(true);
            
            // Simulate API call - replace with actual API endpoint
            setTimeout(() => {
                // Mock data - replace with actual API response
                processesData = [
                    {
                        sno: 1,
                        process: "Sales-Campaign",
                        process_description: "Outbound sales campaign for new customers",
                        process_type: "outbound",
                        active: "Y",
                        channels: 30,
                        inbound_did: "101",
                        crm_id: "1001",
                        webform_type: "SHOW",
                        dial_prefix: "3301",
                        callerid: "1234",
                        buffer_level: 1,
                        lead_order: "leads_by_asc",
                        greeting_file: "welcome",
                        greeting_accept: "N",
                        time_out: 1,
                        retries: 2,
                        auto_wp: true,
                        wp_time: 10,
                        auto_mp: true,
                        mp_time: 10,
                        auto_op: true,
                        op_time: 15,
                        auto_fp: true,
                        fp_time: 15,
                        dnc_enable: "Y",
                        num_masking: "N",
                        agent_wise_dialing: "N",
                        list_select: "SERIAL"
                    },
                    {
                        sno: 2,
                        process: "Customer-Support",
                        process_description: "Inbound customer support process",
                        process_type: "inbound",
                        active: "Y",
                        channels: 25,
                        inbound_did: "102",
                        crm_id: "1001",
                        webform_type: "SHOW",
                        dial_prefix: "3302",
                        callerid: "1235",
                        buffer_level: 1,
                        lead_order: "leads_by_asc",
                        greeting_file: "support",
                        greeting_accept: "Y",
                        time_out: 2,
                        retries: 3,
                        auto_wp: true,
                        wp_time: 15,
                        auto_mp: true,
                        mp_time: 15,
                        auto_op: false,
                        op_time: 10,
                        auto_fp: true,
                        fp_time: 20,
                        dnc_enable: "Y",
                        num_masking: "Y",
                        agent_wise_dialing: "Y",
                        list_select: "SERIAL"
                    }
                ];
                
                populateProcessesTable(processesData);
                updateStatistics(processesData);
                showLoading(false);
            }, 1000);
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
                    `<div class="fw-bold">${process.process}</div>`,
                    process.process_description || 'No description',
                    `<span class="badge ${typeBadge}">${typeText}</span>`,
                    statusBadge,
                    `<span class="health-indicator health-${health}"></span>${healthText}`,
                    `<div class="btn-group">
                        <button class="btn btn-outline-primary btn-action" onclick="openModifyModal(${process.sno})" title="Modify">
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

        // Open add modal (simple form)
        function openAddModal() {
            $('#addProcessForm')[0].reset();
            $('#addProcessModal').modal('show');
        }

        // Create new process
        function createProcess() {
            const processName = $('#new_process').val().trim();
            const processDescription = $('#new_process_description').val().trim();
            const activeStatus = $('#new_active').val();

            if (!processName) {
                showToast('Process name is required', 'error');
                return;
            }

            showLoading(true);

            // Simulate API call to create process
            setTimeout(() => {
                const newProcess = {
                    sno: processesData.length + 1,
                    process: processName,
                    process_description: processDescription,
                    process_type: 'inbound',
                    active: activeStatus,
                    channels: 30,
                    inbound_did: (100 + processesData.length + 1).toString(),
                    crm_id: "1001",
                    webform_type: "SHOW",
                    dial_prefix: "3301",
                    callerid: "1234",
                    buffer_level: 1,
                    lead_order: "leads_by_asc",
                    greeting_file: "welcome",
                    greeting_accept: "N",
                    time_out: 1,
                    retries: 2,
                    auto_wp: true,
                    wp_time: 10,
                    auto_mp: true,
                    mp_time: 10,
                    auto_op: true,
                    op_time: 15,
                    auto_fp: true,
                    fp_time: 15,
                    dnc_enable: "Y",
                    num_masking: "N",
                    agent_wise_dialing: "N",
                    list_select: "SERIAL"
                };

                processesData.unshift(newProcess);
                populateProcessesTable(processesData);
                updateStatistics(processesData);
                
                $('#addProcessModal').modal('hide');
                showToast('Process created successfully!', 'success');
                showLoading(false);

                // Auto-open modify modal for the new process
                setTimeout(() => {
                    openModifyModal(newProcess.sno);
                }, 500);
            }, 1000);
        }

        // Open modify modal (rich form)
        function openModifyModal(processId) {
            const process = processesData.find(p => p.sno === processId);
            if (!process) return;

            currentEditingId = processId;

            // Fill the modify form with process data
            $('#modify_process').val(process.process);
            $('#modify_inbound_did').val(process.inbound_did);
            $('#modify_active').val(process.active);
            $('#modify_process_description').val(process.process_description);
            $('#modify_process_type').val(process.process_type === 'inbound' ? 'Inbound' : 
                                         process.process_type === 'outbound' ? 'O_Predictive' : 'B_Progressive');
            $('#modify_channels').val(process.channels);
            $('#modify_crm_id').val(process.crm_id);
            $('#modify_webform_type').val(process.webform_type);
            $('#modify_dial_prefix').val(process.dial_prefix);
            $('#modify_callerid').val(process.callerid);
            $('#modify_buffer_level').val(process.buffer_level);
            $('#modify_lead_order').val(process.lead_order);
            $('#modify_greeting_file').val(process.greeting_file);
            $('#modify_greeting_accept').val(process.greeting_accept);
            $('#modify_time_out').val(process.time_out);
            $('#modify_retries').val(process.retries);
            $('#modify_auto_wp').prop('checked', process.auto_wp);
            $('#modify_wp_time').val(process.wp_time);
            $('#modify_auto_mp').prop('checked', process.auto_mp);
            $('#modify_mp_time').val(process.mp_time);
            $('#modify_auto_op').prop('checked', process.auto_op);
            $('#modify_op_time').val(process.op_time);
            $('#modify_auto_fp').prop('checked', process.auto_fp);
            $('#modify_fp_time').val(process.fp_time);
            $('#modify_dnc_enable').val(process.dnc_enable);
            $('#modify_num_masking').val(process.num_masking);
            $('#modify_agent_wise_dialing').val(process.agent_wise_dialing);
            $('#modify_list_select').val(process.list_select);

            // Reset to first tab
            $('#modifyTabs a:first').tab('show');

            $('#modifyProcessModal').modal('show');
        }

        // Save modified process
        function saveModifiedProcess() {
            if (!currentEditingId) return;

            showLoading(true);

            // Simulate API call to update process
            setTimeout(() => {
                const processIndex = processesData.findIndex(p => p.sno === currentEditingId);
                if (processIndex !== -1) {
                    // Update process data with all form values
                    processesData[processIndex].process_description = $('#modify_process_description').val();
                    processesData[processIndex].active = $('#modify_active').val();
                    processesData[processIndex].channels = parseInt($('#modify_channels').val()) || 0;
                    processesData[processIndex].inbound_did = $('#modify_inbound_did').val();
                    processesData[processIndex].crm_id = $('#modify_crm_id').val();
                    processesData[processIndex].webform_type = $('#modify_webform_type').val();
                    processesData[processIndex].dial_prefix = $('#modify_dial_prefix').val();
                    processesData[processIndex].callerid = $('#modify_callerid').val();
                    processesData[processIndex].buffer_level = parseInt($('#modify_buffer_level').val()) || 0;
                    processesData[processIndex].lead_order = $('#modify_lead_order').val();
                    processesData[processIndex].greeting_file = $('#modify_greeting_file').val();
                    processesData[processIndex].greeting_accept = $('#modify_greeting_accept').val();
                    processesData[processIndex].time_out = parseInt($('#modify_time_out').val()) || 1;
                    processesData[processIndex].retries = $('#modify_retries').val();
                    processesData[processIndex].auto_wp = $('#modify_auto_wp').is(':checked');
                    processesData[processIndex].wp_time = parseInt($('#modify_wp_time').val()) || 10;
                    processesData[processIndex].auto_mp = $('#modify_auto_mp').is(':checked');
                    processesData[processIndex].mp_time = parseInt($('#modify_mp_time').val()) || 10;
                    processesData[processIndex].auto_op = $('#modify_auto_op').is(':checked');
                    processesData[processIndex].op_time = parseInt($('#modify_op_time').val()) || 15;
                    processesData[processIndex].auto_fp = $('#modify_auto_fp').is(':checked');
                    processesData[processIndex].fp_time = parseInt($('#modify_fp_time').val()) || 15;
                    processesData[processIndex].dnc_enable = $('#modify_dnc_enable').val();
                    processesData[processIndex].num_masking = $('#modify_num_masking').val();
                    processesData[processIndex].agent_wise_dialing = $('#modify_agent_wise_dialing').val();
                    processesData[processIndex].list_select = $('#modify_list_select').val();

                    // Update process type based on selection
                    const processType = $('#modify_process_type').val();
                    if (processType === 'Inbound') {
                        processesData[processIndex].process_type = 'inbound';
                    } else if (processType.startsWith('O_')) {
                        processesData[processIndex].process_type = 'outbound';
                    } else if (processType.startsWith('B_')) {
                        processesData[processIndex].process_type = 'blended';
                    }

                    populateProcessesTable(processesData);
                    updateStatistics(processesData);
                    
                    $('#modifyProcessModal').modal('hide');
                    showToast('Process updated successfully!', 'success');
                }
                showLoading(false);
            }, 1000);
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

            // Simulate API call to delete process
            setTimeout(() => {
                processesData = processesData.filter(p => p.sno !== processId);
                populateProcessesTable(processesData);
                updateStatistics(processesData);
                showToast('Process deleted successfully!', 'success');
                showLoading(false);
            }, 1000);
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