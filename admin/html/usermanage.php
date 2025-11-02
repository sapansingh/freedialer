<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
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
            --dark-color: #212529;
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
        #usersTable th {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #6c757d;
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 0.75rem;
        }
        
        #usersTable td {
            font-size: 0.8rem;
            vertical-align: middle;
            padding: 0.75rem;
        }
        
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        
        /* User Avatar */
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 600;
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
        
        /* Permission Grid */
        .permission-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 0.75rem;
            margin-top: 0.75rem;
        }
        
        .permission-item {
            background: #f8f9fa;
            padding: 0.75rem;
            border-radius: 6px;
            border-left: 3px solid var(--primary-color);
        }
        
        .form-check-label {
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        /* User Profile Preview */
        .user-profile-preview {
            text-align: center;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            color: white;
            margin-bottom: 1rem;
        }
        
        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.75rem;
            font-size: 1.2rem;
            border: 2px solid white;
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
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #f8d7da;
            color: var(--danger-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
        }
        
        /* Queue Management */
        .queue-management {
            border: 2px solid #6BCBCA;
            border-radius: 15px;
            padding: 1rem;
            background-color: #f8f9fa;
        }
        
        .queue-select-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        
        .queue-select {
            width: 150px;
            height: 120px;
            border-radius: 10px;
            border: 1px solid #ced4da;
            padding: 0.25rem;
        }
        
        .queue-controls {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }
        
        .queue-position-controls {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .queue-search {
            margin-bottom: 1rem;
        }
        
        .queue-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
            padding: 0.5rem;
            background-color: #e9ecef;
            border-radius: 6px;
        }
        
        /* Process Badge */
        .process-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 500;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .permission-grid {
                grid-template-columns: 1fr;
            }
            
            .btn-action {
                margin-bottom: 0.25rem;
            }
            
            .stat-card {
                margin-bottom: 1rem;
            }
            
            .queue-select-container {
                flex-direction: column;
                gap: 1rem;
            }
            
            .queue-controls {
                flex-direction: row;
            }
            
            .queue-position-controls {
                flex-direction: row;
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
                    <h1 class="h3 mb-1"><i class="fas fa-users-cog me-2 text-primary"></i>User Management</h1>
                    <p class="text-muted mb-0">Manage agents, supervisors, and administrators</p>
                </div>
                <button class="btn btn-primary btn-sm" id="addUserBtn">
                    <i class="fas fa-user-plus me-1"></i> Add User
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-3">
            <div class="col-md-3 col-6 mb-2">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4361ee, #3a0ca3);">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number text-primary" id="totalUsers">0</div>
                    <div class="stat-label">Total Users</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4cc9f0, #4895ef);">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="stat-number text-info" id="activeAgents">0</div>
                    <div class="stat-label">Active Agents</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f72585, #b5179e);">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="stat-number text-warning" id="supervisors">0</div>
                    <div class="stat-label">Supervisors</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #7209b7, #560bad);">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="stat-number text-secondary" id="admins">0</div>
                    <div class="stat-label">Administrators</div>
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
                            <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Search users...">
                        </div>
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
                <div class="col-md-3">
                    <div class="filter-section">
                        <label class="form-label">User Type</label>
                        <select id="typeFilter" class="form-select form-select-sm">
                            <option value="">All Types</option>
                            <option value="ADMIN">Administrator</option>
                            <option value="SUPERVISOR">Supervisor</option>
                            <option value="MIS">MIS</option>
                            <option value="AGENT">Agent</option>
                            <option value="SUPPORT">Support</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary btn-sm w-100 mt-3" id="resetFiltersBtn">
                        <i class="fas fa-redo me-1"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- DataTable -->
        <div class="glass-card">
            <div class="table-responsive">
                <table id="usersTable" class="table table-sm table-hover w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Agent ID</th>
                            <th>Type</th>
                            <th>Process</th>
                            <th>Status</th>
                            <th>Call Mode</th>
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

    <!-- User Modal Form -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"><i class="fas fa-user-plus me-2"></i>Add New User</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="userTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">
                                <i class="fas fa-user me-1"></i> Basic
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="permissions-tab" data-bs-toggle="tab" data-bs-target="#permissions" type="button" role="tab">
                                <i class="fas fa-shield-alt me-1"></i> Permissions
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="call-settings-tab" data-bs-toggle="tab" data-bs-target="#call-settings" type="button" role="tab">
                                <i class="fas fa-phone me-1"></i> Call
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="queues-tab" data-bs-toggle="tab" data-bs-target="#queues" type="button" role="tab">
                                <i class="fas fa-list me-1"></i> Queues
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content mt-3" id="userTabsContent">
                        <div class="tab-pane fade show active" id="basic" role="tabpanel">
                            <form id="userForm">
                                <input type="hidden" id="sno" name="sno">
                                
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-section">
                                            <div class="section-title">
                                                <i class="fas fa-id-card"></i> User Identification
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <label for="agent_id" class="form-label required-field">Agent ID</label>
                                                        <input type="text" class="form-control form-control-sm" id="agent_id" name="agent_id" required maxlength="15" placeholder="e.g., AG001">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <label for="agent_name" class="form-label required-field">Full Name</label>
                                                        <input type="text" class="form-control form-control-sm" id="agent_name" name="agent_name" required maxlength="50" placeholder="e.g., John Smith">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <label for="password" class="form-label required-field">Password</label>
                                                        <input type="password" class="form-control form-control-sm" id="password" name="password" required maxlength="20" placeholder="Enter password">
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <label for="extension" class="form-label">Extension</label>
                                                        <input type="text" class="form-control form-control-sm" id="extension" name="extension" maxlength="10" placeholder="e.g., 1001">
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>
                                        
                                        <div class="form-section">
                                            <div class="section-title">
                                                <i class="fas fa-users"></i> Access
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <label for="process" class="form-label">Process</label>
                                                        <select class="form-select form-select-sm" id="process" name="process">
                                                            <option value="">Select a Process</option>
                                                            <!-- Processes will be populated by JavaScript -->
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <label for="user_type" class="form-label required-field">User Type</label>
                                                        <select class="form-select form-select-sm" id="user_type" name="user_type" required onchange="togglePermissions()">
                                                            <option value="AGENT">Agent</option>
                                                            <option value="SUPERVISOR">Supervisor</option>
                                                            <option value="ADMIN">Administrator</option>
                                                            <option value="MIS">MIS</option>
                                                            <option value="SUPPORT">Support</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="user-profile-preview">
                                            <div class="avatar" id="userAvatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <h6 id="previewName">User Name</h6>
                                            <div class="badge bg-light text-dark mb-2" id="previewType">AGENT</div>
                                            <div class="small">
                                                <div>ID: <span id="previewId">AG001</span></div>
                                                <div>Ext: <span id="previewExt">1001</span></div>
                                                <div>Status: <span id="previewStatus" class="badge bg-success">Active</span></div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-section">
                                            <div class="section-title">
                                                <i class="fas fa-server"></i> System Settings
                                            </div>
                                            <div class="mb-2">
                                                <label for="active" class="form-label required-field">Status</label>
                                                <select class="form-select form-select-sm" id="active" name="active" required>
                                                    <option value="Y">Active</option>
                                                    <option value="N">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <div class="tab-pane fade" id="permissions" role="tabpanel">
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-user-shield"></i> Access Permissions
                                </div>
                                
                                <div class="permission-grid">
                                    <div class="permission-item">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="allow_manual_dial" name="allow_manual_dial" value="Y">
                                            <label class="form-check-label" for="allow_manual_dial">Manual Dial</label>
                                        </div>
                                    </div>
                                    
                                    <div class="permission-item">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="allow_transfer" name="allow_transfer" value="Y">
                                            <label class="form-check-label" for="allow_transfer">Call Transfer</label>
                                        </div>
                                    </div>
                                    
                                    <div class="permission-item">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="click_to_call" name="click_to_call" value="Y" checked>
                                            <label class="form-check-label" for="click_to_call">Click to Call</label>
                                        </div>
                                    </div>
                                    
                                    <div class="permission-item">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="edit_record" name="edit_record" value="Y" checked>
                                            <label class="form-check-label" for="edit_record">Edit Records</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="call-settings" role="tabpanel">
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-sliders-h"></i> Call Settings
                                </div>
                                
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label for="call_mode" class="form-label required-field">Call Mode</label>
                                            <select class="form-select form-select-sm" id="call_mode" name="call_mode" required>
                                                <option value="processmode">Process Mode</option>
                                                <option value="inbound">Inbound</option>
                                                <option value="outbound">Outbound</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label for="call_allowed" class="form-label">Call Types</label>
                                            <select class="form-select form-select-sm" id="call_allowed" name="call_allowed">
                                                <option value="Local">Local Only</option>
                                                <option value="STD">STD</option>
                                                <option value="All">All Calls</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="queues" role="tabpanel">
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-list"></i> Queue Assignment
                                </div>
                                
                                <div class="alert alert-info" role="alert">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Select a process first to load available queues for assignment.
                                </div>
                                
                                <div class="queue-management">
                                    <div class="queue-search">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            <input type="text" id="queueSearch" class="form-control" placeholder="Search queues..." onkeyup="filterQueues()">
                                        </div>
                                    </div>
                                    
                                    <div class="queue-select-container">
                                        <div>
                                            <label class="form-label">Available Queues</label>
                                            <select multiple class="queue-select" id="queue_from">
                                                <!-- Queues will be populated by JavaScript -->
                                            </select>
                                        </div>
                                        
                                        <div class="queue-controls">
                                            <button type="button" class="btn btn-primary btn-sm" onclick="moveRight()">
                                                <i class="fas fa-chevron-right"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary btn-sm" onclick="moveLeft()">
                                                <i class="fas fa-chevron-left"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="moveAllRight()">
                                                <i class="fas fa-angle-double-right"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="moveAllLeft()">
                                                <i class="fas fa-angle-double-left"></i>
                                            </button>
                                        </div>
                                        
                                        <div>
                                            <label class="form-label">Selected Queues</label>
                                            <select multiple class="queue-select" id="selected_queues">
                                                <!-- Selected queues will be populated by JavaScript -->
                                            </select>
                                        </div>
                                        
                                        <div class="queue-position-controls">
                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="moveTop()">
                                                <i class="fas fa-angle-double-up"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="moveUp()">
                                                <i class="fas fa-chevron-up"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="moveDown()">
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="moveBottom()">
                                                <i class="fas fa-angle-double-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="queue-info">
                                        <div>
                                            <span id="selectedCount">0</span> queues selected
                                        </div>
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="clearAll()">
                                            <i class="fas fa-trash me-1"></i> Clear All
                                        </button>
                                    </div>
                                    
                                    <input type="hidden" id="assigned_queues" name="assigned_queues">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm" id="saveUserBtn">
                        <i class="fas fa-save me-1"></i> Save User
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
                    <p class="text-muted mb-3 small" id="deleteConfirmText">Are you sure you want to delete this user?</p>
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
        const API_BASE_URL = '../api/'; // Adjust to your API path
        const PROCESS_API_URL = '../api/indiapi/Process_list.php';
        const QUEUES_API_URL = '../api/indiapi/Queues_list.php';
        
        let currentEditingId = null;
        let usersData = [];
        let usersTable;
        let processes = [];
        let queues = [];

        // Initialize DataTable and event listeners
        $(document).ready(function() {
            // Initialize DataTable
            usersTable = $('#usersTable').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50],
                order: [[0, 'desc']],
                language: {
                    search: "",
                    searchPlaceholder: "Search users...",
                    lengthMenu: "_MENU_"
                },
                initComplete: function() {
                    $('.dataTables_length select').addClass('form-select form-select-sm');
                    $('.dataTables_filter input').addClass('form-control form-control-sm');
                }
            });

            // Add event listeners
            document.getElementById('addUserBtn').addEventListener('click', openAddModal);
            document.getElementById('resetFiltersBtn').addEventListener('click', resetFilters);
            document.getElementById('saveUserBtn').addEventListener('click', saveUser);
            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                if (currentEditingId) {
                    deleteUser(currentEditingId);
                }
            });

            // Update preview when form fields change
            $('#agent_id, #agent_name, #extension, #user_type, #active').on('input change', updatePreview);
            
            // Process change event
            document.getElementById('process').addEventListener('change', loadQueuesForProcess);
            
            // Load initial data
            loadUsers();
            loadProcesses();
        });

        // Load users from API
        async function loadUsers() {
            showLoading(true);
            
            try {
                const response = await fetch(API_BASE_URL + 'users.php?action=getAll');
                const result = await response.json();
                
                if (result.success) {
                    usersData = result.data;
                    populateUsersTable(usersData);
                    updateStatistics(usersData);
                } else {
                    showToast('Error loading users: ' + result.message, 'error');
                }
            } catch (error) {
                console.error('Error loading users:', error);
                showToast('Failed to load users. Please check console.', 'error');
            } finally {
                showLoading(false);
            }
        }

        // Load processes from API
        async function loadProcesses() {
            try {
                const response = await fetch(PROCESS_API_URL);
                const result = await response.json();
                
                if (result.success) {
                    processes = result.data;
                    populateProcessDropdown();
                    showToast(`Loaded ${result.count} processes successfully`, 'success');
                } else {
                    showToast('Error loading processes: ' + result.message, 'error');
                }
            } catch (error) {
                console.error('Error loading processes:', error);
                // Use mock data for demonstration
                processes = [];
                populateProcessDropdown();
                showToast('Using demo process data', 'info');
            }
        }

        // Populate process dropdown
        function populateProcessDropdown() {
            const processSelect = document.getElementById('process');
            processSelect.innerHTML = '<option value="">Select a Process</option>';
            
            processes.forEach(process => {
                const option = document.createElement('option');
                option.value = process;
                option.textContent = process;
                processSelect.appendChild(option);
            });
        }

        // Load queues for selected process
        async function loadQueuesForProcess() {
            const processSelect = document.getElementById('process');
            const selectedProcess = processSelect.value;
            const queueFrom = document.getElementById('queue_from');
            const selectedQueues = document.getElementById('selected_queues');
            
            // Clear existing queues
            queueFrom.innerHTML = '';
            selectedQueues.innerHTML = '';
            document.getElementById('assigned_queues').value = '';
            document.getElementById('selectedCount').textContent = '0';
            document.getElementById('queueSearch').value = '';
            
            if (!selectedProcess) {
                return;
            }
            
            showLoading(true);
            
            try {
                const response = await fetch(QUEUES_API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ process_name: selectedProcess })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    queues = result.data;
                    // Populate available queues
                    queues.forEach(queue => {
                        const option = document.createElement('option');
                        option.value = queue.queue_name;
                        option.textContent = queue.queue_name;
                        queueFrom.appendChild(option);
                    });
                    showToast(`Loaded queues for ${selectedProcess}`, 'success');
                } else {
                    showToast('Error loading queues: ' + result.message, 'error');
                }
            } catch (error) {
                console.error('Error loading queues:', error);
                // Use mock queue data for demonstration
                const mockQueues = [
                    { queue_name: `${selectedProcess}_Queue1` },
                    { queue_name: `${selectedProcess}_Queue2` },
                    { queue_name: `${selectedProcess}_Queue3` },
                    { queue_name: `${selectedProcess}_Queue4` }
                ];
                queues = mockQueues;
                
                mockQueues.forEach(queue => {
                    const option = document.createElement('option');
                    option.value = queue.queue_name;
                    option.textContent = queue.queue_name;
                    queueFrom.appendChild(option);
                });
                showToast('Using demo queue data', 'info');
            } finally {
                showLoading(false);
            }
        }

        // Queue movement functions
        function moveRight() {
            const fromSelect = document.getElementById('queue_from');
            const toSelect = document.getElementById('selected_queues');
            
            for (let i = 0; i < fromSelect.options.length; i++) {
                if (fromSelect.options[i].selected) {
                    toSelect.appendChild(fromSelect.options[i]);
                    i--; // Adjust index after removal
                }
            }
            updateAssignedQueues();
        }

        function moveLeft() {
            const fromSelect = document.getElementById('selected_queues');
            const toSelect = document.getElementById('queue_from');
            
            for (let i = 0; i < fromSelect.options.length; i++) {
                if (fromSelect.options[i].selected) {
                    toSelect.appendChild(fromSelect.options[i]);
                    i--; // Adjust index after removal
                }
            }
            updateAssignedQueues();
        }

        function moveAllRight() {
            const fromSelect = document.getElementById('queue_from');
            const toSelect = document.getElementById('selected_queues');
            
            while (fromSelect.options.length > 0) {
                toSelect.appendChild(fromSelect.options[0]);
            }
            updateAssignedQueues();
        }

        function moveAllLeft() {
            const fromSelect = document.getElementById('selected_queues');
            const toSelect = document.getElementById('queue_from');
            
            while (fromSelect.options.length > 0) {
                toSelect.appendChild(fromSelect.options[0]);
            }
            updateAssignedQueues();
        }

        function moveTop() {
            const select = document.getElementById('selected_queues');
            for (let i = 0; i < select.options.length; i++) {
                if (select.options[i].selected) {
                    select.insertBefore(select.options[i], select.firstChild);
                }
            }
            updateAssignedQueues();
        }

        function moveUp() {
            const select = document.getElementById('selected_queues');
            for (let i = 1; i < select.options.length; i++) {
                if (select.options[i].selected && !select.options[i-1].selected) {
                    select.insertBefore(select.options[i], select.options[i-1]);
                }
            }
            updateAssignedQueues();
        }

        function moveDown() {
            const select = document.getElementById('selected_queues');
            for (let i = select.options.length - 2; i >= 0; i--) {
                if (select.options[i].selected && !select.options[i+1].selected) {
                    select.insertBefore(select.options[i+1], select.options[i]);
                }
            }
            updateAssignedQueues();
        }

        function moveBottom() {
            const select = document.getElementById('selected_queues');
            for (let i = 0; i < select.options.length - 1; i++) {
                if (select.options[i].selected) {
                    select.appendChild(select.options[i]);
                    i--; // Adjust index after removal
                }
            }
            updateAssignedQueues();
        }

        function clearAll() {
            const fromSelect = document.getElementById('selected_queues');
            const toSelect = document.getElementById('queue_from');
            
            while (fromSelect.options.length > 0) {
                toSelect.appendChild(fromSelect.options[0]);
            }
            updateAssignedQueues();
        }

        function filterQueues() {
            const input = document.getElementById('queueSearch');
            const filter = input.value.toLowerCase();
            const select = document.getElementById('queue_from');
            
            for (let i = 0; i < select.options.length; i++) {
                const option = select.options[i];
                const text = option.text.toLowerCase();
                option.style.display = text.includes(filter) ? '' : 'none';
            }
        }

        function updateAssignedQueues() {
            const selectedQueues = document.getElementById('selected_queues');
            const queues = [];
            for (let i = 0; i < selectedQueues.options.length; i++) {
                queues.push(selectedQueues.options[i].value);
            }
            document.getElementById('assigned_queues').value = queues.join(', ');
            document.getElementById('selectedCount').textContent = queues.length;
        }

        // Populate users table
        function populateUsersTable(users) {
            const table = $('#usersTable').DataTable();
            table.clear();
            
            users.forEach(user => {
                const statusBadge = user.active === 'Y' ? 
                    '<span class="badge bg-success">Active</span>' : 
                    '<span class="badge bg-danger">Inactive</span>';
                
                const userTypeBadge = user.user_type === 'AGENT' ? 'bg-primary' : 
                                    user.user_type === 'SUPERVISOR' ? 'bg-warning' : 
                                    user.user_type === 'ADMIN' ? 'bg-danger' : 'bg-info';
                
                const initials = user.agent_name.split(' ').map(n => n[0]).join('').toUpperCase();
                const processBadge = user.process ? `<span class="process-badge">${user.process}</span>` : '<span class="badge bg-secondary">No Process</span>';
                
                table.row.add([
                    user.sno,
                    `<div class="d-flex align-items-center">
                        <div class="user-avatar me-2">${initials}</div>
                        <div>${user.agent_name}</div>
                    </div>`,
                    user.agent_id,
                    `<span class="badge ${userTypeBadge}">${user.user_type}</span>`,
                    processBadge,
                    statusBadge,
                    user.call_mode,
                    `<div class="btn-group">
                        <button class="btn btn-outline-primary btn-action" onclick="editUser(${user.sno})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline-danger btn-action" onclick="confirmDelete(${user.sno}, '${user.agent_name}')" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>`
                ]).draw(false);
            });
        }

        // Update statistics
        function updateStatistics(users) {
            $('#totalUsers').text(users.length);
            $('#activeAgents').text(users.filter(u => u.active === 'Y' && u.user_type === 'AGENT').length);
            $('#supervisors').text(users.filter(u => u.user_type === 'SUPERVISOR').length);
            $('#admins').text(users.filter(u => u.user_type === 'ADMIN').length);
        }

        // Open add modal
        function openAddModal() {
            currentEditingId = null;
            $('#modalTitle').html('<i class="fas fa-user-plus me-2"></i>Add New User');
            $('#userForm')[0].reset();
            $('#sno').val('');
            
            // Reset queues
            document.getElementById('process').value = '';
            document.getElementById('queue_from').innerHTML = '';
            document.getElementById('selected_queues').innerHTML = '';
            document.getElementById('assigned_queues').value = '';
            document.getElementById('selectedCount').textContent = '0';
            document.getElementById('queueSearch').value = '';
            
            updatePreview();
            togglePermissions();
            
            // Show the modal using Bootstrap
            const userModal = new bootstrap.Modal(document.getElementById('userModal'));
            userModal.show();
        }

        // Edit user
        async function editUser(userId) {
            showLoading(true);
            
            try {
                const response = await fetch(API_BASE_URL + 'users.php?action=get&id=' + userId);
                const result = await response.json();
                
                if (result.success) {
                    const user = result.data;
                    currentEditingId = userId;
                    $('#modalTitle').html('<i class="fas fa-edit me-2"></i>Edit User');
                    
                    // Fill form with user data
                    $('#sno').val(user.sno);
                    $('#agent_id').val(user.agent_id);
                    $('#agent_name').val(user.agent_name);
                    $('#password').val(user.password);
                    $('#extension').val(user.extension);
                    $('#user_type').val(user.user_type);
                    $('#active').val(user.active);
                    $('#call_mode').val(user.call_mode);
                    $('#call_allowed').val(user.call_allowed);

                    // Set process
                    if (user.process) {
                        $('#process').val(user.process);
                        await loadQueuesForProcess();
                        
                        // Set selected queues after a short delay to allow queues to load
                        setTimeout(() => {
                            if (user.assigned_queues) {
                                const assignedQueues = user.assigned_queues.split(',').map(q => q.trim());
                                const queueFrom = document.getElementById('queue_from');
                                const selectedQueues = document.getElementById('selected_queues');
                                
                                // Move assigned queues to selected side
                                for (let i = 0; i < queueFrom.options.length; i++) {
                                    const option = queueFrom.options[i];
                                    if (assignedQueues.includes(option.value)) {
                                        selectedQueues.appendChild(option);
                                        i--; // Adjust index after removal
                                    }
                                }
                                updateAssignedQueues();
                            }
                        }, 500);
                    }

                    // Set permission checkboxes
                    $('#allow_manual_dial').prop('checked', user.allow_manual_dial === 'Y');
                    $('#allow_transfer').prop('checked', user.allow_transfer === 'Y');
                    $('#click_to_call').prop('checked', user.click_to_call === 'Y');
                    $('#edit_record').prop('checked', user.edit_record === 'Y');

                    updatePreview();
                    
                    // Show the modal using Bootstrap
                    const userModal = new bootstrap.Modal(document.getElementById('userModal'));
                    userModal.show();
                } else {
                    showToast('Error loading user: ' + result.message, 'error');
                }
            } catch (error) {
                console.error('Error loading user:', error);
                showToast('Failed to load user. Please check console.', 'error');
            } finally {
                showLoading(false);
            }
        }

        // Confirm delete
        function confirmDelete(userId, userName) {
            $('#deleteConfirmText').text(`Delete user "${userName}"? This action cannot be undone.`);
            $('#confirmDeleteBtn').off('click').on('click', function() {
                deleteUser(userId);
            });
            
            // Show the modal using Bootstrap
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            deleteModal.show();
        }

        // Delete user
        async function deleteUser(userId) {
            $('#deleteConfirmModal').modal('hide');
            showLoading(true);

            try {
                const response = await fetch(API_BASE_URL + 'users.php?action=delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ sno: userId })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showToast('User deleted successfully!', 'success');
                    loadUsers(); // Reload the user list
                } else {
                    showToast('Error deleting user: ' + result.message, 'error');
                }
            } catch (error) {
                console.error('Error deleting user:', error);
                showToast('Failed to delete user. Please check console.', 'error');
            } finally {
                showLoading(false);
            }
        }

        // Save user
        async function saveUser() {
            const formData = new FormData(document.getElementById('userForm'));
            const data = Object.fromEntries(formData.entries());

            // Get selected queues
            const selectedQueues = document.getElementById('selected_queues');
            const queues = [];
            for (let i = 0; i < selectedQueues.options.length; i++) {
                queues.push(selectedQueues.options[i].value);
            }
            data.assigned_queues = queues.join(', ');

            // Get process value
            data.process = document.getElementById('process').value;

            // Get checkbox values
            data.allow_manual_dial = $('#allow_manual_dial').is(':checked') ? 'Y' : 'N';
            data.allow_transfer = $('#allow_transfer').is(':checked') ? 'Y' : 'N';
            data.click_to_call = $('#click_to_call').is(':checked') ? 'Y' : 'N';
            data.edit_record = $('#edit_record').is(':checked') ? 'Y' : 'N';

            showLoading(true);

            try {
                const action = currentEditingId ? 'update' : 'create';
                const response = await fetch(API_BASE_URL + 'users.php?action=' + action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showToast(result.message, 'success');
                    loadUsers(); // Reload the user list
                    
                    // Hide the modal using Bootstrap
                    const userModal = bootstrap.Modal.getInstance(document.getElementById('userModal'));
                    userModal.hide();
                } else {
                    showToast('Error saving user: ' + result.message, 'error');
                }
            } catch (error) {
                console.error('Error saving user:', error);
                showToast('Failed to save user. Please check console.', 'error');
            } finally {
                showLoading(false);
            }
        }

        // Function to update user preview
        function updatePreview() {
            const agentId = $('#agent_id').val() || 'AG001';
            const agentName = $('#agent_name').val() || 'User Name';
            const extension = $('#extension').val() || '1001';
            const userType = $('#user_type').val() || 'AGENT';
            const status = $('#active').val() === 'Y' ? 'Active' : 'Inactive';
            const statusClass = $('#active').val() === 'Y' ? 'bg-success' : 'bg-danger';

            // Update preview elements
            $('#previewId').text(agentId);
            $('#previewName').text(agentName);
            $('#previewExt').text(extension);
            $('#previewType').text(userType);
            $('#previewStatus').text(status).removeClass('bg-success bg-danger').addClass(statusClass);
            
            // Update avatar with initials
            const initials = agentName.split(' ').map(n => n[0]).join('').toUpperCase();
            $('#userAvatar').html(initials || '<i class="fas fa-user"></i>');
        }

        // Function to toggle permissions based on user type
        function togglePermissions() {
            const userType = $('#user_type').val();
            
            // Reset all permissions to default
            $('.form-check-input').prop('checked', false);
            $('#click_to_call, #edit_record').prop('checked', true);
            
            // Set permissions based on user type
            switch(userType) {
                case 'ADMIN':
                    $('.form-check-input').prop('checked', true);
                    break;
                case 'SUPERVISOR':
                    $('.form-check-input').prop('checked', true);
                    break;
                // AGENT has default permissions
            }
        }

        // Function to reset filters
        function resetFilters() {
            $('#searchInput').val('');
            $('#statusFilter').val('');
            $('#typeFilter').val('');
            
            // Reset DataTable search and filters
            const table = $('#usersTable').DataTable();
            table.search('').columns().search('').draw();
        }

        // Function to show toast messages
        function showToast(message, type = 'info') {
            const toastContainer = $('#toastContainer');
            const toastId = 'toast-' + Date.now();
            
            const toastHtml = `
                <div id="${toastId}" class="toast align-items-center text-white bg-${type === 'error' ? 'danger' : type} border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
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